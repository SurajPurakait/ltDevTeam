<?php

Class Service extends CI_Model {

    public $id;
    public $category_id;
    public $description;
    public $retail_price;

    public function getService($id) {
        $sql = "SELECT s.id, s.category_id, c.name as category_name, c.description as category_description, s.description, s.ideas, s.tutorials, s.retail_price 
                FROM services s
                INNER JOIN category c on c.id = s.category_id
                where s.id = $id";
        $data = $this->db->query($sql)->result()[0];
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function getRelatedService($service_id) {
        $return_data = array();
        $sql = "select id, retail_price from services where id in 
                (select related_services_id from related_services where services_id = $service_id)
                and status = 1 order by description";
        $data = $this->db->query($sql)->result_array();
        foreach ($data as $each_service) {
            $return_data[$each_service['id']] = $each_service['retail_price'];
        }
        return $return_data;
    }

    public function getallRelatedService($service_id) {
        $return_data = array();
        $sql = "select * from services where id in 
                (select related_services_id from related_services where services_id = $service_id)
                and status = 1 order by description";
        $data = $this->db->query($sql)->result_array();

        return $data;
    }

    public function get_anual_report_data($order_id) {
        return $this->db->query("select * from annual_report_price where order_id='$order_id'")->row_array();
    }

    public function get_edit_data($id) {
        $sql = "select o.*,o.status as main_order_status,c.*,c.type as company_type,st.*,sr.*,indt.*,o.id as id from `order` o 
                inner join company c on c.id = o.reference_id 
                inner join staff st on st.id = o.staff_requested_service 
                inner join service_request sr on sr.order_id = o.id 
                inner join internal_data indt on indt.reference_id = o.reference_id where o.id='$id'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_payroll_by_id($order_id) {
        return $this->db->get_where('order', ['id' => $order_id])->row_array();
    }

    public function get_payroll_internal($id) {
        return $this->db->get_where('internal_data', ['reference_id' => $id])->row_array();
    }

    public function editgetRelatedService($order_id) {
        $sql = "select * from service_request where order_id='$order_id'";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function getSpecificServiceData($order_id, $service_id) {
        $sql = "select * from service_request where order_id='$order_id' and services_id='$service_id'";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function get_other_business_name($company_id) {
        $sql = "select * from new_company where company_id='$company_id'";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function get_related_services() {
        //$sql = "select s.*,(select name from category where id=s.category_id) AS catname from services s where status = 1";

        $sql = "select s.*,(select name from category where id=s.category_id) AS catname,td.start_days,td.end_days "
                . "from services s "
                . "inner join target_days td on(s.id=td.service_id)"
                . "where status = 1 group by s.id";

        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function check_if_name_exists($servicename, $rowid = null) {
        $sql = "select * from services where description='$servicename'";
        if ($rowid != null) {
            $sql .= ' AND id!=' . $rowid;
        }
        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function rel_service($servicerelated) {
        $sql = "select `related_services_id` from related_services where services_id='$servicerelated'";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function getCategory() {
        $sql = "select * from category";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function delete_related_services($id) {
        $sql = "delete from `services` where id='$id'";
        $result = $this->db->query($sql);
        $sql1 = "delete from `related_services` where related_services_id='$id'";
        $result1 = $this->db->query($sql1);
        $sql2 = "delete from `target_days` where service_id='$id'";
        $result2 = $this->db->query($sql2);
    }

    public function delete_fran($id) {
        $sql = "delete from `office_staff` where office_id='$id'";
        $result = $this->db->query($sql);
        $sql1 = "update `office` set status=2 where id='$id'";
        $result1 = $this->db->query($sql1);
    }

    public function get_main_service_retail_price($id) {
        $sql = "select * from services where id='$id'";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function get_services_days() {
        $sql = "select td.*,(select name from category where id=td.category_id) AS catname from target_days td";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function update_service_days($startdays, $enddays, $rowid, $cat) {
        $this->db->where('id', $rowid);
        $this->db->update('target_days', array('start_days' => $startdays, 'end_days' => $enddays, 'category_id' => $cat));
        return $rowid;
    }

    public function update_suborder_status($statusval, $suborderid) {
        $this->db->insert("tracking_logs", ["stuff_id" => $this->session->userdata("user_id"), "status_value" => $statusval, "section_id" => $suborderid, "related_table_name" => "service_request"]);
        $this->db->where('id', $suborderid);
        $this->db->update('service_request', array('status' => $statusval));
        if ($statusval == 0) {
            $this->db->where('id', $suborderid);
            $this->db->update('service_request', array('date_completed' => date('Y-m-d h:i:s'), 'status' => 0));
            $get_main_order_query = $this->db->query('select * from service_request where id="' . $suborderid . '"')->result_array();
            if (!empty($get_main_order_query)) {
                $suborder_order_id = $get_main_order_query[0]['order_id'];
            }
            $check_if_all_services_completed = $this->db->query('select * from service_request where order_id="' . $suborder_order_id . '"')->result_array();
            if (!empty($check_if_all_services_completed)) {
                $k = 0;
                $status_array = '';
                $len = count($check_if_all_services_completed);
                foreach ($check_if_all_services_completed as $val) {
                    if ($k == $len - 1) {
                        $status_array .= $val['status'];
                    } else {
                        $status_array .= $val['status'] . ', ';
                    }
                    $k++;
                }
            }
            $status_array_values = explode(",", $status_array);
            if (!in_array("1", $status_array_values) && !in_array("2", $status_array_values)) {
                $this->db->where('id', $suborder_order_id);
                $this->db->update('order', array('complete_date' => date('Y-m-d h:i:s'), 'status' => 0));
            } else {
                $this->db->where('id', $suborder_order_id);
                $this->db->update('order', array('start_date' => date('Y-m-d h:i:s'), 'status' => 1));
            }
        } elseif ($statusval == 1) {
            $get_main_order_query = $this->db->query('select * from service_request where id="' . $suborderid . '"')->result_array();
            if (!empty($get_main_order_query)) {
                $suborder_order_id = $get_main_order_query[0]['order_id'];
                $suborder_service_id = $get_main_order_query[0]['services_id'];
            }
            $get_service_end_days = $this->db->query("select * from target_days where service_id='" . $suborder_service_id . "'")->result_array();
            $end_days = $get_service_end_days[0]['end_days'];
            $end_date = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + ' . $end_days . ' days'));
            $this->db->where('id', $suborderid);
            $this->db->update('service_request', array('date_started' => date('Y-m-d h:i:s'), 'date_completed' => $end_date, 'status' => 1));
            $this->db->where('id', $suborder_order_id);
            $this->db->update('order', array('start_date' => date('Y-m-d h:i:s'), 'status' => 1));
        }
        return $suborderid;
    }

    public function updateLateStatus() {
        $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.start_date,o.complete_date,
                concat(st.last_name, ', ', st.first_name) as requested_staff
                from `order` o
                inner join company c on c.id = o.reference_id
                inner join staff st on st.id = o.staff_requested_service
                order by o.order_date desc";
        $all_ongoing_order = $this->db->query($sql)->result();
        foreach ($all_ongoing_order as $row) {
            $target_end_date = $row->complete_date;
            if (strtotime($target_end_date) < time()) {
                $this->db->query("update `order` set late_status= 1 where id = " . $row->id);
            }
        }
    }

    public function completed_orders($service_id = '', $office_id = '') {
        $user_info = staff_info();
        $usertype = $user_info['type'];
        $this->db->select("TRIM(c.name) AS name, c.*,c.id as reference_id");
        $this->db->from("company c");
        $this->db->join("internal_data ind", "c.id = ind.reference_id");
        if ($usertype == 3) {
            $this->db->where_in("ind.office", explode(',', $user_info['office']));
        }
        if ($office_id != '') {
            $this->db->where_in('ind.office', $office_id);
        }
        if ($service_id != '') {
            $this->db->where('o.service_id', $service_id);
        }
        $this->db->where("ind.reference", "company");
        $this->db->where("c.status", "1");
        $this->db->group_by('name');
        $this->db->order_by('name');
        $this->db->query('SET SQL_BIG_SELECTS=1');
        return $this->db->get()->result_array();
    }

    public function completed_orders_salestax($service_id = '') {
        $staff_info = staff_info();
        $sql = "SELECT o.*,c.*,o.id AS id "
                . "FROM `order` o "
                . "INNER JOIN company c ON c.id = o.reference_id ";
        if ($staff_info['type'] == 3) {
            $sql .= "INNER JOIN internal_data ind ON c.id = ind.reference_id WHERE ind.office IN (" . $staff_info['office'] . ") ";
            if ($service_id != '')
                $sql .= "AND o.service_id = $service_id ";
        } else {
            if ($service_id != '')
                $sql .= "WHERE o.service_id = $service_id ";
        }
        $sql .= " and o.status=0";
        $sql .= " GROUP BY c.name ORDER BY c.name";
        $this->db->query('SET SQL_BIG_SELECTS=1');
        $result = $this->db->query($sql)->result_array();
//        echo $this->db->last_query();exit;
        return $result;
    }

    public function get_county_by_state_name($county) {
        return $this->db->get_where("sales_tax_rate", ['state' => $county])->row();
    }

    public function get_state_name($id) {
        return $this->db->get_where("states", ['id' => $id])->row();
    }

    public function get_sources() {
        return $this->db->get_where("referred_by_source", ['status' => 1])->result_array();
    }

    public function add_referred_by_source($source_name) {
        $this->db->insert("referred_by_source", ['source' => $source_name, 'status' => 1]);
        return $this->db->insert_id();
    }

    public function update_referred_by_source($source_name, $source_id) {
        $this->db->where(['id' => $source_id]);
        $this->db->update("referred_by_source", ['source' => $source_name]);
        return $source_id;
    }

    public function delete_referred_by_source($source_id) {
        $this->db->where(['id' => $source_id]);
        $this->db->update("referred_by_source", ['status' => 0]);
        return $source_id;
    }

    public function get_related_service_newcorp_pdf($order_id) {
        $sql = "select sr.*,(select description from services where id=sr.services_id) as service_name from service_request sr where sr.order_id='$order_id'";
        $data = $this->db->query($sql)->result();
        return $data;
    }

    public function get_related_service_book_pdf($order_id) {
        $sql = "select sr.*,(select description from services where id=sr.services_id) as service_name from service_request sr where sr.order_id='$order_id'";
        $data = $this->db->query($sql)->result();
        return $data;
    }

    public function get_staff_by_id($staff_id) {
        return $this->db->get_where('staff', ['id' => $staff_id])->row_array();
    }

    public function get_service_details($serv_id) {
        $sql = "select * from services where id='$serv_id'";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function get_resp_dept($serv_id) {
        $sql = "select s.*,(select name from department where id=s.dept) as dept_name from services s where s.id='$serv_id'";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function get_tracking($serv_id) {
        $sql = "select * from service_request where services_id='$serv_id'";
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function getSecuirityDetails($id) {
        return $this->db->get_where("security_questions", ['financial_accounts_id' => $id])->result_array();
    }

}
