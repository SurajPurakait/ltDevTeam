<?php

class Service_model extends CI_Model {

    private $order_select;

    public function __construct() {
        parent::__construct();
        $this->load->model("system");
        $this->order_select[] = 'ord.id AS id';
        $this->order_select[] = 'cpn.id AS company_id';
        $this->order_select[] = 'ord.order_serial_id AS order_id';
        $this->order_select[] = 'ord.order_date AS create_date';
        $this->order_select[] = 'ord.start_date AS start_date';
        $this->order_select[] = 'ord.complete_date AS complete_date';
        $this->order_select[] = 'ord.target_start_date AS target_start_date';
        $this->order_select[] = 'ord.target_complete_date AS target_complete_date';
        $this->order_select[] = 'ord.total_of_order AS total_of_order';
        $this->order_select[] = 'ord.new_existing AS new_existing';
        $this->order_select[] = 'ord.staff_requested_service AS staff_requested_service';
        $this->order_select[] = '(SELECT CONCAT(staff.last_name, ", ",staff.first_name," ",staff.middle_name) FROM staff WHERE id = ord.staff_requested_service) AS requested_staff_name';
        $this->order_select[] = 'ord.invoice_id AS invoice_id';
        $this->order_select[] = 'ord.service_id AS service_id';
        $this->order_select[] = 'srv.description AS service_name';
        $this->order_select[] = 'ord.category_id AS category_id';
        $this->order_select[] = 'ctr.name AS service_category';
        $this->order_select[] = 'srv.ideas AS service_shortname';
        $this->order_select[] = 'srv.retail_price AS retail_price';
        $this->order_select[] = 'srv_rq.price_charged AS price_charged';
        $this->order_select[] = 'ord.status AS main_order_status';
        $this->order_select[] = 'ord.assign_user AS assign_user';
        $this->order_select[] = 'cpn.name AS company_name';
        $this->order_select[] = 'cpn.type AS company_type';
        $this->order_select[] = 'cpn.state_opened AS state_opened';
        $this->order_select[] = 'cpn.business_description AS business_description';
        $this->order_select[] = 'cpn.fye AS fiscal_year_end';
        $this->order_select[] = 'cpn.fein AS fein';
        $this->order_select[] = 'cpn.dba AS dba';
        $this->order_select[] = 'cpn.start_month_year AS start_month_year';
        $this->order_select[] = 'ord.status AS status';
    }

    public function get_staff_by_office_id($office_id) {
        $this->db->distinct('st.id');
        $this->db->select("st.id, concat(st.last_name, ', ',st.first_name,' ',st.middle_name) as name");
        $this->db->from('staff st');
        $this->db->join('office_staff ost', 'ost.staff_id = st.id');
        //$this->db->where(['st.status' => 1, 'ost.office_id' => $office_id]);
        $this->db->where(['ost.office_id' => $office_id, 'st.is_delete' => 'n', 'st.status' => '1']);
        $this->db->where('st.first_name is NOT NULL', NULL, FALSE);
        $this->db->where('st.middle_name is NOT NULL', NULL, FALSE);
        $this->db->where('st.last_name is NOT NULL', NULL, FALSE);
        return $this->db->get()->result_array();
    }

    public function change_due_date($data) {

        if ($data['state'] != "" && $data['type'] != "") {
            $state = $data['state'];
            $type = $data['type'];
            return $this->db->query("select date from renewal_dates where state='$state' and type='$type'")->row_array();
        }
    }

    public function change_annual_date($data) {
        $referance = $data['reference'];
        if ($referance != "") {
            $result = $this->db->query("select * from company where id='$referance'")->row_array();
            if (!empty($result)) {
                $type = $result['type'];
                $state = $result['state_opened'];
                return $this->db->query("select * from renewal_dates where state='$state' and type='$type'")->row_array();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function get_service_id($description) {
        $sql = "select id as service_id from services where description='$description'";
        return $this->db->query($sql)->row_array();
    }

    public function get_service_by_id($id) {
        $this->db->select("s.id, s.category_id, c.name as category_name, c.description as category_description, s.description, s.ideas, s.tutorials, s.dept AS service_department, s.retail_price");
        $this->db->from('services s');
        $this->db->join('category c', 'c.id = s.category_id');
        $this->db->where(['s.id' => $id]);
        return $this->db->get()->row_array();
    }

    public function get_service_by_shortcode($shortcode) {
        $this->db->select("s.id, s.category_id, c.name as category_name, c.description as category_description, s.description, s.ideas, s.tutorials, s.dept AS service_department, s.retail_price");
        $this->db->from('services s');
        $this->db->join('category c', 'c.id = s.category_id');
        $this->db->where(['s.ideas' => $shortcode]);
        return $this->db->get()->row_array();
    }

    public function get_related_service_by_service_id($service_id) {
        $return_data = array();
        $this->db->select("id, retail_price");
        $this->db->where_in(['id' => "SELECT related_services_id FROM related_services WHERE services_id = $service_id"]);
        $this->db->where(['status' => 1]);
        $this->db->order_by('description', 'asc');
        $data = $this->db->get('services')->result_array();
        foreach ($data as $each_service) {
            $return_data[$each_service['id']] = $each_service['retail_price'];
        }
        return $return_data;
    }

    public function get_related_service_list_by_service_id($service_id) {
        return $this->db->get_where('related_services', ['services_id' => $service_id])->result_array();
    }

    public function add_related_service($order_id, $data) {
        if (!empty($data)) {
            $department_id = sess('user_office_id');
            $user_id = sess('user_id');
            $i = 0;
            foreach ($data as $key => $value) {
                $insert_data[$i]["order_id"] = $order_id;
                $insert_data[$i]["service_id"] = $key;
                $insert_data[$i]["tracking"] = time();
                $insert_data[$i]["responsible_department"] = $department_id;
                $insert_data[$i]["responsible_staff"] = $user_id;
                $insert_data[$i] = array_merge($insert_data[$i], $data[$key]);
                $i++;
            }

//            return print_r($insert_data);
            return $this->db->insert_batch("service_request", $insert_data);
        }
    }

    public function get_address_book($reference, $reference_id) {
        $sql = "select ci.id, ct.type, ci.first_name, ci.middle_name, ci.last_name,
                c1.country_name as phone1_country_name, 
                c2.country_name as phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip
                from contact_info ci
                left join contact_info_type ct on ct.id = ci.type
                left join countries c on c.id = ci.country
                left join countries c1 on c1.id = ci.phone1_country
                left join countries c2 on c2.id = ci.phone2_country
                where ci.status=1 and ci.reference='$reference' and ci.reference_id=$reference_id";

        return $this->db->query($sql)->result_array();
    }

    public function show_owner_list($id) {
        $sql = "select t.id, t.title, t.percentage, t.company_id,
                concat(i.last_name, ', ',i.first_name, ' ',i.middle_name) as name, t.existing_reference_id
                from title t
                inner join individual i on i.id = t.individual_id
                where t.company_id = $id and t.status=1 group by t.individual_id";

        return $this->db->query($sql)->result();
    }

    public function get_service_category() {
        return $this->db->get('category')->result_array();
    }

    public function get_recurring_data($id) {
//        echo $id;die;
//        return $this->db->select('sales_tax_recurring',['order_id'=>$id])->row();
        return $this->db->query("select * from sales_tax_recurring where order_id=" . $id . "")->row();
    }

    public function get_processing_data($id) {
        return $this->db->query("select * from sales_tax_processing where order_id=" . $id . "")->row();

//        $data=$this->db->select('sales_tax_processing',['order_id'=>$id]);
//        print_r($data);
    }

    public function get_recurring_data_by_order_id($order_id) {
        return $this->db->get_where('sales_tax_recurring', ['order_id' => $order_id])->row_array();
    }

    public function get_processing_data_by_order_id($order_id) {
        return $this->db->get_where('sales_tax_processing', ['order_id' => $order_id])->row_array();
    }

    public function get_annual_report_data($id) {
        return $this->db->query("select * from annual_report_price where order_id=" . $id . "")->row();
    }

    public function get_county_by_state($state) {
        return $this->db->query("select * from sales_tax_rate where state=$state")->result_array();
    }

    public function get_states() {
        $this->db->select('*');
        $this->db->from('states');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function ajax_services_dashboard_filter($status, $request_type, $category_id, $request_by = "", $department = "", $office = "", $staff_type = "", $sort = "", $form_data = "", $sos_value = "") {
        //print_r($form_data);
        $staff_id = sess('user_id');
        $user_info = staff_info();
        $user_dept = $user_info['department'];
        $usertype = $user_info['type'];
        $userrole = $user_info['role'];
        $sql = "SELECT st.first_name AS requested_staff,o.staff_requested_service, o.assign_user, st.department AS dept,
              o.id, o.order_serial_id, o.order_date, o.start_date, o.complete_date, o.target_start_date, o.target_complete_date, o.total_of_order, o.tracking,
               company.name AS client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id,o.service_id,indt.office AS office_id,
               (SELECT ofc.office_id FROM office as ofc WHERE ofc.id = indt.office) as office,services.description AS service_name,services.ideas AS service_shortname,
               CONCAT(',', (SELECT GROUP_CONCAT(department_staff.staff_id) FROM department_staff WHERE department_staff.department_id = services.dept OR department_staff.department_id IN (SELECT sr2.dept FROM services sr2 WHERE sr2.id IN (SELECT srq.services_id FROM `service_request` AS srq WHERE srq.`order_id` = o.id))), ',', COALESCE((SELECT GROUP_CONCAT(st1.id) FROM staff AS st1 WHERE st1.role = 2 AND st1.office_manager = indt.office AND st1.id IN(SELECT staff_id FROM office_staff WHERE office_staff.office_id = indt.office)),''), ',') AS all_staffs
	       FROM `order` AS o INNER JOIN company ON o.reference_id=company.id 
               INNER JOIN internal_data indt ON indt.reference_id = company.id
	       INNER JOIN services ON services.id=o.service_id
               INNER JOIN staff st ON st.id=o.staff_requested_service";
        if(isset($form_data)){
             if (isset($form_data['variable_dropdown'])) {
                if(in_array('9', $form_data['variable_dropdown'])){
                    $sql .= " INNER JOIN invoice_info inv ON inv.order_id=o.id";
                } 
           }           
        }       
               
        if (isset($sos_value) && $sos_value != '') {
            $sql .= " INNER JOIN sos_notification AS sos ON sos.reference_id=o.id INNER JOIN sos_notification_staff sns ON sns.sos_notification_id=sos.id";
        }
        $where = $having = [];
        if ($status != '') {
            if ($status == '3') {
                $where[] = 'o.status = "1" and o.late_status = "1"';
            } elseif ($status == '4') {
                $where[] = 'o.status != "0"';
            } else {
                $where[] = 'o.status = "' . $status . '"';
            }
        }
        if ($department != '') {
            $where[] = 'services.dept = "' . $department . '"';
        }
        $where[] = "o.reference = 'company'";
        if ($category_id != '') {
            $where[] = 'o.category_id="' . $category_id . '"';
        }

        if ($usertype == 1) {
            if ($request_type == "byme") {
                $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
            } elseif ($request_type == 'byothers') {
                $where[] = 'o.staff_requested_service != "' . $staff_id . '"';
            }
        } elseif ($usertype == 2) {
            if (in_array(6, explode(',', $user_dept))) {
                if ($request_type == "byme") {
                    $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                } elseif ($request_type == 'tome') {
                    $where[] = 'o.staff_requested_service != "' . $staff_id . '"';
                }
            } else {
                if ($userrole == 4) {
                    $req_by_oth = array_column($this->system->get_department_manager_staffs_by_staff_id($staff_id), 'staff_id');
                    if ($request_type == "byme") {
                        $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
//                    elseif ($request_type == 'tome') {
//                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
//                    } 
                    elseif ($request_type == 'byothers') {
                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                        if (!empty($req_by_oth)) {
                            $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                        }
                    } else {
                        $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                        $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
                } else {
                    if ($request_type == "byme") {
                        $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    } elseif ($request_type == 'tome') {
                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                    } else {
                        $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                        $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
                }
            }
        } elseif ($usertype == 3) {
            if ($userrole == 2) {
                $req_by_oth = $this->check_count_reqby_others();
//                print_r($req_by_oth);
                if ($request_type == "byme") {
                    $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                } elseif ($request_type == 'byothers') {
                    $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                    if (!empty($req_by_oth)) {
                        $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                    }
                } else {
                    $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                    $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    if (!empty($req_by_oth)) {
                        $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                    }
                }
            } else {
                $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
            }
        }
        if ($request_by != '') {
            $where[] = 'o.staff_requested_service IN (' . $request_by . ')';
        }

        if ($request_type == 'unassigned') {
            $where[] = 'o.assign_user = 0';
        }

        if (isset($form_data)) {
            if (isset($form_data['variable_dropdown'])) {
                foreach ($form_data['variable_dropdown'] as $key => $variable_val) {
                    if (isset($variable_val) && $variable_val != '') {
                        $condition_val = $form_data['condition_dropdown'][$key];
                        //print_r($form_data['criteria_dropdown']);
                        //$criteria_val = $form_data['criteria_dropdown'][$key];
                        if (isset($condition_val) && $condition_val != '') {
                            $column_name = $this->get_column_name($variable_val);
                            if ($variable_val == 3) {
                                $having[] = $this->build_query($variable_val, $condition_val, $form_data['criteria_dropdown'], $column_name);
                            } else {
                                $where[] = $this->build_query($variable_val, $condition_val, $form_data['criteria_dropdown'], $column_name);
                            }
                        }
                    }
                }
            }
        }

        if ($office != '') {
            $where[] = 'indt.office = ' . $office;
        }

        if (isset($sos_value) && $sos_value != '') {
            if ($sos_value == 'tome') {
                $where[] = 'sns.staff_id = "' . sess('user_id') . '" and sns.read_status = 0';
            } else {
                $where[] = 'sos.added_by_user = "' . sess('user_id') . '"';
            }
        }

        $where[] = "o.status NOT IN (10)";

        $sql .= " WHERE " . implode(' AND ', $where);
        if (isset($sos_value) && $sos_value != '') {
            //if($sos_value=='byme'){
            $sql .= ' GROUP BY o.id';
            // }                
        }
        if (count($having) != 0) {
            $sql .= " HAVING " . implode(' OR ', $having);
        }

        $sql .= " ORDER BY o.id ASC";
        $this->db->query('SET SQL_BIG_SELECTS=1');
        $result = $this->db->query($sql)->result();
        //echo $this->db->last_query();
//        echo'<pre>';
//        print_r($result);
//        die;
        return $result;
    }

    public function check_count_reqby_others() {
        $user_info = staff_info();
        $office_id = $user_info['office_manager'];
        $result = $this->db->query("select * from office_staff  where office_id='$office_id' AND staff_id != " . sess('user_id'))->result_array();
        $render_data = array_column($result, 'staff_id');
        return $render_data;
    }

    public function check_count_reqby_others_for_dept_manager() {
        $user_info = staff_info();
        $staff_id = sess('user_id');
        $result = $this->db->query("select * from department_manager where manager_id='" . $staff_id . "'")->row_array();
        $dept_id = $result['department_id'];
        $result_staff = $this->db->query("select * from department_staff where department_id='" . $dept_id . "' AND staff_id != " . sess('user_id'))->result_array();
        $render_data = array_column($result_staff, 'staff_id');
        //$render_data = array_column($result, 'staff_id');
        return $render_data;
    }

    public function count_service_filter($status, $request_type, $category_id, $request_by = "") {
        $staff_id = sess('user_id');
        $user_info = staff_info();
        $user_dept = $user_info['department'];
        $usertype = $user_info['type'];
        $userrole = $user_info['role'];

        $sql = "SELECT CONCAT(st.last_name,', ', st.first_name) AS requested_staff,o.staff_requested_service, st.department AS dept,
               o.id, o.order_date, o.start_date, o.complete_date, o.target_start_date, o.target_complete_date, o.total_of_order, o.tracking,
               company.name AS client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id,o.service_id,
               (SELECT ofc.name FROM office as ofc WHERE ofc.id = indt.office) as office,services.description AS service_name,
               CONCAT(',', (SELECT GROUP_CONCAT(department_staff.staff_id) FROM department_staff WHERE department_staff.department_id = services.dept OR department_staff.department_id IN (SELECT sr2.dept FROM services sr2 WHERE sr2.id IN (SELECT srq.services_id FROM `service_request` AS srq WHERE srq.`order_id` = o.id))), ',', COALESCE((SELECT GROUP_CONCAT(st1.id) FROM staff AS st1 WHERE st1.role = 2 AND st1.office_manager = indt.office AND st1.id IN(SELECT staff_id FROM office_staff WHERE office_staff.office_id = indt.office)),''), ',') AS all_staffs
	       FROM `order` AS o INNER JOIN company ON o.reference_id=company.id 
               INNER JOIN internal_data indt ON indt.reference_id = company.id
	       INNER JOIN services ON services.id=o.service_id
               INNER JOIN staff AS st ON st.id=o.staff_requested_service";
        $where = $having = [];
        if ($status != '') {
            if ($status == '3') {
                $where[] = 'o.status = "1" and o.late_status = "1"';
            } elseif ($status == '4') {
                $where[] = 'o.status != "0"';
            } else {
                $where[] = 'o.status = "' . $status . '"';
            }
        }
        $where[] = "o.reference = 'company'";
        if ($category_id != '') {
            $where[] = 'o.category_id="' . $category_id . '"';
        }

        if ($usertype == 1) {
            if ($request_type == "byme") {
                $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
            } elseif ($request_type == 'byothers') {
                $where[] = 'o.staff_requested_service != "' . $staff_id . '"';
            }
        } elseif ($usertype == 2) {
            if (in_array(6, explode(',', $user_dept))) {
                if ($request_type == "byme") {
                    $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                } elseif ($request_type == 'tome') {
                    $where[] = 'o.staff_requested_service != "' . $staff_id . '"';
                }
            } else {
                if ($userrole == 4) {
                    $req_by_oth = array_column($this->system->get_department_manager_staffs_by_staff_id($staff_id), 'staff_id');
                    if ($request_type == "byme") {
                        $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
//                    elseif ($request_type == 'tome') {
//                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
//                    } 
                    elseif ($request_type == 'byothers') {
                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                        if (!empty($req_by_oth)) {
                            $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                        }
                    } else {
                        $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                        $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
                } else {
                    if ($request_type == "byme") {
                        $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    } elseif ($request_type == 'tome') {
                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                    } else {
                        $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                        $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
                }
            }
        } elseif ($usertype == 3) {
            if ($userrole == 2) {
                $req_by_oth = $this->check_count_reqby_others();
                if ($request_type == "byme") {
                    $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                } elseif ($request_type == 'byothers') {
                    $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                    if (!empty($req_by_oth)) {
                        $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                    }
                } else {
                    $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                    $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    if (!empty($req_by_oth)) {
                        $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                    }
                }
            } else {
                $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
            }
        }
        if ($request_by != '') {
            $where[] = 'o.staff_requested_service IN (' . $request_by . ')';
        }

        if ($request_type == 'unassigned') {
            $where[] = 'o.assign_user = 0';
        }

        $where[] = "o.status NOT IN (10)";
        $sql .= " WHERE " . implode(' AND ', $where);
        if (count($having) != 0) {
            $sql .= " HAVING " . implode(' OR ', $having);
        }
        $this->db->query('SET SQL_BIG_SELECTS=1');
        $result = $this->db->query($sql)->result();
        return count($result);
    }

    public function add_new_contact($data) {
        $user_id = sess("user_id");
        $old_types = explode(",", $data["old_types"]);
        $type_check = in_array($data["contact"]["type"], $old_types);
        if ($type_check) {
            return -2;
        }
        $email_check = $type_check = $this->db->query("select id from contact_info where email1 = '{$data["contact"]["email1"]}';")->num_rows();
        if ($email_check > 0) {
            return -3;
        }
        $data["contact"]["status"] = 1;
        $data["contact"]["user_id"] = $user_id;
        if ($this->db->insert("contact_info", $data["contact"])) {
            return $this->db->insert_id();
        } else {
            return -1;
        }
    }

    public function get_single_address($id) {
        $sql = "select ci.id, ci.type as type_id, ct.type, ci.first_name, ci.middle_name, ci.last_name,
                c1.country_name as phone1_country_name, 
                c2.country_name as phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip
                from contact_info ci
                left join contact_info_type ct on ct.id = ci.type
                left join countries c on c.id = ci.country
                left join countries c1 on c1.id = ci.phone1_country
                left join countries c2 on c2.id = ci.phone2_country
                where ci.id = '$id';";

        return $this->db->query($sql)->result_array();
    }

    public function get_contacts_by_ref($id) {
        $sql = "select ci.id, ci.type as type_id, ct.type, ci.first_name, ci.middle_name, ci.last_name,
                c1.country_name as phone1_country_name, 
                c2.country_name as phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip
                from contact_info ci
                left join contact_info_type ct on ct.id = ci.type
                left join countries c on c.id = ci.country
                left join countries c1 on c1.id = ci.phone1_country
                left join countries c2 on c2.id = ci.phone2_country
                where ci.reference_id = '$id';";

        return $this->db->query($sql)->result_array();
    }

    public function count_contact_by_reference($reference_id, $reference) {
        return $this->db->get_where('contact_info', ['reference_id' => $reference_id, 'reference' => $reference])->num_rows();
    }

    public function count_owner_by_company($compnay_id) {
        return $this->db->get_where('title', ['company_id' => $compnay_id, 'status' => 1])->num_rows();
    }

    public function add_new_document($data) {
        $status = common_upload("doc_file");
        if ($status["success"] == 1) {
            $data["document"] = $status["status_msg"];
            $data["status"] = 1;
            $data["user_id"] = $this->session->userdata("user_id");
            if ($this->db->insert("documents", $data)) {
                return $this->db->insert_id();
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    }

    public function get_single_contact_info($id) {
        return $this->db->where("id", $id)->get("contact_info")->row_array();
    }

    public function update_contact($id, $data) {
        $old_types = explode(",", $data["old_types"]);
        if (($key = array_search($data["edit_type_id"], $old_types)) !== false) {
            unset($old_types[$key]);
        }
        $type_check = in_array($data["contact"]["type"], $old_types);
        if ($type_check) {
            return -2;
        }
        $email_check = $type_check = $this->db->query("select id from contact_info where email1 = '{$data["contact"]["email1"]}' and id <> '$id';")->num_rows();
        if ($email_check > 0) {
            return -3;
        }
        if ($this->db->set($data["contact"])->where("id", $id)->update('contact_info')) {
            return 1;
        } else {
            return -1;
        }
    }

    public function delete_contact($id) {
        return $this->db->delete('contact_info', ["id" => $id]);
    }

    public function loadDocumentList($id) {
        $sql = "select id, doc_type, document
                from documents 
                where status=1 and id = '$id';";

        $data = $this->db->query($sql)->row();
        if (!empty($data)) {
            echo "<div class=\"row\" id='document_id_{$data->id}'>
                            <label class=\"col-lg-2 control-label\">{$data->doc_type}</label>
                            <div class=\"col-lg-10\" style=\"padding-top:8px\">
                                <p>
                                    <a href ='javascript:void(0)' onClick=\"MyWindow=window.open('" . base_url("/uploads/{$data->document}") . "','Document Preview', width=600, height=300); return false;\">{$data->document}</a>
                                    &nbsp;&nbsp;<i class=\"fa fa-trash\" style=\"cursor:pointer\" onclick=\"delete_document('{$data->id}', '{$data->document}')\" title=\"Remove this document\"></i>
                                </p>
                            </div>
                        </div>";
        }
    }

    public function loadDocumentListByRef($ref_id) {
        $sql = "select id, doc_type, document
                from documents 
                where status=1 and reference_id = '$ref_id';";

        $data = $this->db->query($sql)->result();

        if (!empty($data)) {
            foreach ($data as $value) {
                $document = htmlentities($value->document);
                echo "<div class=\"row\" id='document_id_{$value->id}'>
                            <label class=\"col-lg-2 control-label\">{$value->doc_type}</label>
                            <div class=\"col-lg-10\" style=\"padding-top:8px\">
                                <p>
                                    <a href ='javascript:void(0)' onClick=\"MyWindow=window.open('" . base_url("/uploads/{$value->document}") . "','Document Preview', width=600, height=300); return false;\">{$value->document}</a>
                                    &nbsp;&nbsp;<i class=\"fa fa-trash\" style=\"cursor:pointer\" onclick=\"delete_document('{$value->id}', '{$document}')\" title=\"Remove this document\"></i>
                                </p>
                            </div>
                        </div>";
            }
        }
    }

    public function delete_document($id, $file_name) {
        if ($this->db->delete('documents', ["id" => $id])) {
            if (file_exists(FCPATH . 'uploads/' . html_entity_decode($file_name))) {
                unlink(FCPATH . 'uploads/' . html_entity_decode($file_name));
            }
            return 1;
        } else {
            return -1;
        }
    }

    public function get_edit_data($id) {
        $sql = "select o.*, c.*, c.type as company_type, st.*, sr.*, indt.*, o.id as id from `order` o inner join company c on c.id = o.reference_id inner join staff st on st.id = o.staff_requested_service inner join service_request sr on sr.order_id = o.id inner join internal_data indt on indt.reference_id = o.reference_id where o.id='$id'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function completed_orders() {
        $sql = "select o.*,c.*,o.id as id from `order` o inner join company c on c.id = o.reference_id group by c.name";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_owner_list($reference_id) {
        $sql = "select t.id, t.title, t.percentage, t.company_id,
                concat(i.last_name, ', ',i.first_name, ' ',i.middle_name) as name
                from title t
                inner join individual i on i.id = t.individual_id
                where t.company_id = '$reference_id' and t.status = '1';";

        $data = $this->db->query($sql)->result();

        $output = "";

        if ($data) {
            foreach ($data as $title) {
                $output .= "<div class=\"row\">
                            <label class=\"col-lg-2 control-label\">{$title->title}</label>
                            <div class=\"col-lg-10\" style=\"padding-top:8px\">
                                <p>
                                    <b>Name: {$title->name} </b><br>
                                    Percentage: {$title->percentage}% 
                                </p>
                                <p>
                                    <i class=\"fa fa-edit owneredit\" style=\"cursor:pointer\" onclick=\"openOwnerFormPopup(0, {$title->company_id}, {$title->id})\" title=\"Edit this owner\"></i>
                                    &nbsp;&nbsp;<i class=\"fa fa-trash ownerdelete\" style=\"cursor:pointer\" onclick=\"deleteOwner({$title->id})\" title=\"Remove this owner\"></i>
                                </p>
                            </div>
                        </div>";
            }
        }

//        $quant_title = $this->db->query("select count(*) as total from title where company_id = '$reference_id' and status = '1';")->row_array()["total"];
//        if ($quant_title == 0) {
//            $output .= '<input type="hidden" name="owners" id="owners" required title="Owners">';
//        } else {
//            $output .= '<input type="hidden" name="owners" id="owners" title="Owners">';
//        }

        $total_percentage = $this->db->query("select SUM(percentage) as total from title where company_id = '$reference_id';")->row_array()["total"];

//        $output .= '<input type="hidden" name="owner_percentage_total" id="owner_percentage_total" value="' . $total_percentage . '">';
        return $output;
    }

    public function total_percentage($reference_id) {
        return $this->db->query("select SUM(percentage) as total from title where company_id = '$reference_id';")->row_array()["total"];
    }

    public function get_financial_account_info($id) {
        $sql = "select f.*, group_concat(q.security_question separator '|') as questions, group_concat(q.security_answer separator '|') as answers from financial_accounts as f inner join security_questions as q on q.financial_accounts_id = f.id where f.id='$id'";
        return $this->db->query($sql)->row_array();
    }

    public function load_financial_accounts_list($company_id) {
        $sql = "select * from financial_accounts where company_id='$company_id'";

        $data = $this->db->query($sql)->result();

        $output = "";

        if ($data) {
            foreach ($data as $title) {
                $type = $title->type_of_account;
                if (strpos($type, 'Account') !== false) {
                    $short_type = str_replace('Account', '', $type);
                } else {
                    $short_type = $type;
                }

                $output .= "<div class=\"row\">
                            <label class=\"col-lg-2 control-label\">{$short_type}</label>
                            <div class=\"col-lg-10\" style=\"padding-top:8px\">
                                <p>
                                    <input type=\"hidden\" class=\"total_amounts\" title=\"Total Amount\" value=\"{$title->grand_total}\">
                                    <b> {$title->bank_name} </b><br>
                                    Grand Total Amount: " . "$" . "{$title->grand_total} <br>
                                    # Of Transactions: {$title->number_of_transactions}
                                </p>
                                <p>
                                    <i class=\"fa fa-edit\" style=\"cursor:pointer\" onclick=\"financial_account_by_date('edit', '', '$company_id', '{$title->id}');\" title=\"Edit this owner\"></i>
                                    &nbsp;&nbsp;<i class=\"fa fa-trash\" style=\"cursor:pointer\" onclick=\"delete_financial_account_by_date('{$title->id}')\" title=\"Remove this account\"></i>
                                </p>
                            </div>
                        </div>";
            }
        }
        return $output;
    }

    public function get_contact_list_by_reference($reference_id, $reference) {
        $select = 'ci.id,ci.reference_id, ci.reference, ci.type AS type_id, ct.type, ci.first_name, ci.middle_name, ci.last_name,
                c1.country_name AS phone1_country_name, 
                c2.country_name AS phone2_country_name, 
                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip';
        $this->db->select($select);
        $this->db->from('contact_info AS ci');
        $this->db->join('contact_info_type AS ct', 'ct.id = ci.type', 'left');
        $this->db->join('countries AS c', 'c.id = ci.country', 'left');
        $this->db->join('countries AS c1', 'c1.id = ci.phone1_country', 'left');
        $this->db->join('countries AS c2', 'c2.id = ci.phone2_country', 'left');
        $this->db->where(['ci.status' => 1, 'ci.reference_id' => $reference_id, 'ci.reference' => $reference]);
        return $this->db->get()->result_array();
//        $sql = "select ci.id,ci.reference_id, ci.reference, ci.type as type_id, ct.type, ci.first_name, ci.middle_name, ci.last_name,
//                c1.country_name as phone1_country_name, 
//                c2.country_name as phone2_country_name, 
//                ci.phone1, ci.phone2, ci.email1, ci.email2, ci.skype, ci.whatsapp, ci.website, ci.status,
//                ci.address1, ci.address2, ci.city, ci.state, ci.country, c.country_name, ci.zip
//                from contact_info ci
//                left join contact_info_type ct on ct.id = ci.type
//                left join countries c on c.id = ci.country
//                left join countries c1 on c1.id = ci.phone1_country
//                left join countries c2 on c2.id = ci.phone2_country
//                where ci.status=1 and ci.reference_id = '$reference_id' and
//                ci.reference = '$reference';";
//
//        return $this->db->query($sql)->result_array();
    }

    public function get_individual_id_by_ref_id($ref_id) {
        return $this->db->get_where('title', ['company_id' => $ref_id])->row_array();
    }

    public function get_document_list_by_reference($reference_id, $reference) {
        return $this->db->get_where('documents', ['status' => 1, 'reference_id' => $reference_id, 'reference' => $reference])->result_array();
    }

    public function get_document_list_by_reference_view($reference_id, $reference) {
        $i = 0;
        $len = count($reference_id);
        $where = '';
        foreach ($reference_id as $id) {

            if ($i == $len - 1) {
                $where .= $id->individual_id;
            } else {
                $where .= $id->individual_id . ',';
            }
            $i++;
        }
//            print_r($id);
        if ($where != ''):
            $sql = "select *
                from documents 
                where status = 1 and
                reference_id in(" . $where . ")
                and reference = '$reference';";
            return $this->db->query($sql)->result_array();
        else:
            return [];
        endif;
    }

    public function save_contact($data) {
        $data = (object) $data; // convert the post array into an object

        $ref = $data->reference;
        $ref_id = $data->reference_id;
        $type = $data->type;
        $check_if_contact_type_exists_query = "select * from contact_info where reference='$ref' and reference_id='$ref_id' and type='$type' and status='1'";
        $check_result = $this->db->query($check_if_contact_type_exists_query);
        $check_count = $check_result->num_rows(); //exit;
        //if($check_count==0){
        // $email_check = $this->db->query("select id from contact_info where email1 = '{$data->email1}';");
        // if ($email_check->num_rows() > 0) {
        //     if (!$data->id) {
        //         return -3;
        //     } else {
        //         if ($email_check->row()->id != $data->id) {
        //             return -3;
        //         }
        //     }
        // }

        if (!$data->phone1_country)
            $data->phone1_country = 0;
        // if (!$data->phone2_country)
        //     $data->phone2_country = 0;
        if (!$data->country)
            $data->country = 0;
        if (!$data->id) {
            if ($check_count == 0) {
                $sql = "insert into contact_info
                    (reference, reference_id, type, first_name, middle_name,last_name,
                    phone1_country, phone1, phone2_country, phone2, email1, email2, skype, whatsapp, website, 
                    address1, address2, city, state, zip, country, status, company)
                    values
                    (
                    '{$data->reference}',
                    '{$data->reference_id}',
                    {$data->type},
                    '{$data->first_name}',
                    '',
                    '{$data->last_name}',    
                    {$data->phone1_country}, '{$data->phone1}',
                    '', '',
                    '{$data->email1}',
                    '{null}',
                    '',
                    '',
                    '',
                    '{$data->address1}', '',
                    '{$data->city}',
                    '{$data->state}',
                    '{$data->zip}',
                    {$data->country},
                    1,
                    '{$data->company}'
                    )";

                $action = "insert";
                $this->db->query($sql);
                $this->id = $this->db->insert_id();
                $this->load->model('System');
                $this->System->log($action, 'contact_info', $this->id);

                return 1;
            } else {
                return -2;
            }
        } else {
            if ($check_count == 0) {
                $sql = "update contact_info set
                    type={$data->type},
                    first_name='{$data->first_name}',
                    last_name='{$data->last_name}',    
                    phone1_country={$data->phone1_country}, 
                    phone1='{$data->phone1}',
                    email1='{$data->email1}',
                    address1='{$data->address1}',
                    city='{$data->city}',
                    state='{$data->state}',
                    zip='{$data->zip}',
                    country={$data->country},
                    company='{$data->company}'
                    where id = {$data->id}";

                $action = "update";
                $this->db->query($sql);
                $this->id = $data->id;
                $this->load->model('System');
                $this->System->log($action, 'contact_info', $this->id);

                return 1;
            } else {
                $check_data = $check_result->result_array();
                $old_id = $check_data[0]['id'];
                if ($old_id == $data->id) {
                    $sql = "update contact_info set
                    type={$data->type},
                    first_name='{$data->first_name}',
                    last_name='{$data->last_name}',    
                    phone1_country={$data->phone1_country}, 
                    phone1='{$data->phone1}',
                    email1='{$data->email1}',
                    address1='{$data->address1}',
                    city='{$data->city}',
                    state='{$data->state}',
                    zip='{$data->zip}',
                    country={$data->country},
                    company='{$data->company}'
                    where id = {$data->id}";

                    $action = "update";
                    $this->db->query($sql);
                    $this->id = $data->id;
                    $this->load->model('System');
                    $this->System->log($action, 'contact_info', $this->id);

                    return 1;
                } else {
                    return -2;
                }
            }
        }
    }

    public function get_documents($id) {
        return $this->db->query("select * from documents where reference_id='$id'")->result_array();
    }

    public function save_document($data) {
        $status = common_upload("doc_file");
        if ($status["success"] == 1) {
            $data["document"] = $status["status_msg"];
            $data["status"] = 1;
//            $data["user_id"] = $this->session->userdata("user_id");
            if ($this->db->insert("documents", $data)) {
                return $this->db->insert_id();
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    }

    public function get_tracking_log($id, $table_name) {
        return $this->db->query("SELECT concat(s.last_name, ', ', s.first_name, ' ', s.middle_name) as stuff_id, s.department as department, case when tracking_logs.status_value = '0' then 'Completed' when tracking_logs.status_value = '1' then 'Started' when tracking_logs.status_value = '2' then 'Not Started' when tracking_logs.status_value = '3' then 'Late'  else tracking_logs.status_value end as status, date_format(tracking_logs.created_time, '%m/%d/%Y - %r') as created_time FROM `tracking_logs` inner join staff as s on tracking_logs.stuff_id = s.id where tracking_logs.section_id = '$id' and tracking_logs.related_table_name = '$table_name' order by tracking_logs.id desc")->result_array();
    }

    public function update_suborder_status($statusval, $suborderid) {
        $this->db->insert("tracking_logs", ["stuff_id" => $this->session->userdata("user_id"), "status_value" => $statusval, "section_id" => $suborderid, "related_table_name" => "service_request"]);
        $this->db->where('id', $suborderid);
        $this->db->update('service_request', array('status' => $statusval));
        $get_main_order_query = $this->db->query('select * from service_request where id="' . $suborderid . '"')->result_array();
        if ($statusval == 0) {
            $this->db->where('id', $suborderid);
            $this->db->update('service_request', array('date_completed' => date('Y-m-d h:i:s'), 'status' => 0));
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
                        $status_array .= $val['status'] . ',';
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
            //$this->assign_order_by_order_id($suborder_order_id, sess('user_id'));
        } else {
            if (!empty($get_main_order_query)) {
                $suborder_order_id = $get_main_order_query[0]['order_id'];
            }
            $check_if_all_services_not_started = $this->db->query('select * from service_request where order_id="' . $suborder_order_id . '"')->result_array();
            if (!empty($check_if_all_services_not_started)) {
                $k = 0;
                $status_array = '';
                $len = count($check_if_all_services_not_started);
                foreach ($check_if_all_services_not_started as $val) {
                    if ($k == $len - 1) {
                        $status_array .= $val['status'];
                    } else {
                        $status_array .= $val['status'] . ',';
                    }
                    $k++;
                }
            }
            $status_array_values = explode(",", $status_array);
            if (count(array_unique($status_array_values)) == 1) {
                $this->db->where('id', $suborder_order_id);
                $this->db->update('order', array('status' => 2));
            }
        }
        $this->system->save_general_notification('order', $get_main_order_query[0]['order_id'], 'tracking');
        return $suborderid;
    }
    
    public function get_suborder_details($suborderid) {
        
        $sql = 'select sr.status,c.name '
                . 'from service_request sr '
                . 'inner join services s on(sr.services_id=s.id) '
                . 'inner join category c on(s.category_id=c.id) '
                . 'where sr.id = '.$suborderid;
        $data = $this->db->query($sql)->row_array();
        
        return $data;
    }

    public function get_account_list_by_company_id($company_id) {
        $sql = "select * from financial_accounts where company_id='$company_id'";
        return $this->db->query($sql)->result();
    }

    public function get_account_list_by_order_id($order_id) {
        $sql = "select * from financial_accounts where order_id='$order_id'";
        return $this->db->query($sql)->result();
    }

    public function get_not_started_services_count($status = "2", $request_type = "", $category_id = "", $request_by = "") {
        $staff_id = sess('user_id');
        $user_info = staff_info();
        $user_dept = $user_info['department'];
        $usertype = $user_info['type'];
        $userrole = $user_info['role'];

        $sql = "SELECT CONCAT(st.last_name,', ', st.first_name) AS requested_staff,o.staff_requested_service, st.department AS dept,
               o.id, o.order_date, o.start_date, o.complete_date, o.target_start_date, o.target_complete_date, o.total_of_order, o.tracking,
               company.name AS client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id,o.service_id,
               (SELECT ofc.name FROM office as ofc WHERE ofc.id = indt.office) as office, services.description AS service_name,
               CONCAT(',', (SELECT GROUP_CONCAT(department_staff.staff_id) FROM department_staff WHERE department_staff.department_id = services.dept OR department_staff.department_id IN (SELECT sr2.dept FROM services sr2 WHERE sr2.id IN (SELECT srq.services_id FROM `service_request` AS srq WHERE srq.`order_id` = o.id))), ',', COALESCE((SELECT GROUP_CONCAT(st1.id) FROM staff AS st1 WHERE st1.role = 2 AND st1.office_manager = indt.office AND st1.id IN(SELECT staff_id FROM office_staff WHERE office_staff.office_id = indt.office)),''), ',') AS all_staffs
           FROM `order` AS o INNER JOIN company ON o.reference_id=company.id 
               INNER JOIN internal_data indt ON indt.reference_id = company.id
           INNER JOIN services ON services.id=o.service_id
               INNER JOIN staff AS st ON st.id=o.staff_requested_service";
        $where = $having = [];
        if ($status != '') {
            if ($status == '3') {
                $where[] = 'o.status = "1" and o.late_status = "1"';
            } elseif ($status == '4') {
                $where[] = 'o.status != "0"';
            } else {
                $where[] = 'o.status = "' . $status . '"';
            }
        }
        $where[] = "o.reference = 'company'";
        if ($category_id != '') {
            $where[] = 'o.category_id="' . $category_id . '"';
        }

        if ($usertype == 1) {
            if ($request_type == "byme") {
                $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
            } elseif ($request_type == 'byothers') {
                $where[] = 'o.staff_requested_service != "' . $staff_id . '"';
            }
        } elseif ($usertype == 2) {
            if (in_array(6, explode(',', $user_dept))) {
                if ($request_type == "byme") {
                    $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                } elseif ($request_type == 'tome') {
                    $where[] = 'o.staff_requested_service != "' . $staff_id . '"';
                }
            } else {
                if ($userrole == 4) {
                    $req_by_oth = array_column($this->system->get_department_manager_staffs_by_staff_id($staff_id), 'staff_id');
                    if ($request_type == "byme") {
                        $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
//                    elseif ($request_type == 'tome') {
//                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
//                    } 
                    elseif ($request_type == 'byothers') {
                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                        if (!empty($req_by_oth)) {
                            $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                        }
                    } else {
                        $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                        $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
                } else {
                    if ($request_type == "byme") {
                        $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    } elseif ($request_type == 'tome') {
                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                    } else {
                        $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                        $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
                }
            }
        } elseif ($usertype == 3) {
            if ($userrole == 2) {
                $req_by_oth = $this->check_count_reqby_others();
                if ($request_type == "byme") {
                    $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                } elseif ($request_type == 'byothers') {
                    $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                    if (!empty($req_by_oth)) {
                        $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                    }
                } else {
                    $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                    $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    if (!empty($req_by_oth)) {
                        $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                    }
                }
            } else {
                $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
            }
        }
        if ($request_by != '') {
            $where[] = 'o.staff_requested_service IN (' . $request_by . ')';
        }
        $where[] = "o.status NOT IN (10)";
        $sql .= " WHERE " . implode(' AND ', $where);
        if (count($having) != 0) {
            $sql .= " HAVING " . implode(' OR ', $having);
        }
        $result = $this->db->query($sql)->result();
        return count($result);
    }

    public function get_started_services_count($status = "1", $request_type = "", $category_id = "", $request_by = "") {
        $staff_id = sess('user_id');
        $user_info = staff_info();
        $user_dept = $user_info['department'];
        $usertype = $user_info['type'];
        $userrole = $user_info['role'];

        $sql = "SELECT CONCAT(st.last_name,', ', st.first_name) AS requested_staff,o.staff_requested_service, st.department AS dept,
               o.id, o.order_date, o.start_date, o.complete_date, o.target_start_date, o.target_complete_date, o.total_of_order, o.tracking,
               company.name AS client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id,o.service_id,
               (SELECT ofc.name FROM office as ofc WHERE ofc.id = indt.office) as office, services.description AS service_name,
               CONCAT(',', (SELECT GROUP_CONCAT(department_staff.staff_id) FROM department_staff WHERE department_staff.department_id = services.dept OR department_staff.department_id IN (SELECT sr2.dept FROM services sr2 WHERE sr2.id IN (SELECT srq.services_id FROM `service_request` AS srq WHERE srq.`order_id` = o.id))), ',', COALESCE((SELECT GROUP_CONCAT(st1.id) FROM staff AS st1 WHERE st1.role = 2 AND st1.office_manager = indt.office AND st1.id IN(SELECT staff_id FROM office_staff WHERE office_staff.office_id = indt.office)),''), ',') AS all_staffs
           FROM `order` AS o INNER JOIN company ON o.reference_id=company.id 
               INNER JOIN internal_data indt ON indt.reference_id = company.id
           INNER JOIN services ON services.id=o.service_id
               INNER JOIN staff AS st ON st.id=o.staff_requested_service";
        $where = $having = [];
        if ($status != '') {
            if ($status == '3') {
                $where[] = 'o.status = "1" and o.late_status = "1"';
            } elseif ($status == '4') {
                $where[] = 'o.status != "0"';
            } else {
                $where[] = 'o.status = "' . $status . '"';
            }
        }
        $where[] = "o.reference = 'company'";
        if ($category_id != '') {
            $where[] = 'o.category_id="' . $category_id . '"';
        }

        if ($usertype == 1) {
            if ($request_type == "byme") {
                $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
            } elseif ($request_type == 'byothers') {
                $where[] = 'o.staff_requested_service != "' . $staff_id . '"';
            }
        } elseif ($usertype == 2) {
            if (in_array(6, explode(',', $user_dept))) {
                if ($request_type == "byme") {
                    $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                } elseif ($request_type == 'tome') {
                    $where[] = 'o.staff_requested_service != "' . $staff_id . '"';
                }
            } else {
                if ($userrole == 4) {
                    $req_by_oth = array_column($this->system->get_department_manager_staffs_by_staff_id($staff_id), 'staff_id');
                    if ($request_type == "byme") {
                        $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
//                    elseif ($request_type == 'tome') {
//                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
//                    } 
                    elseif ($request_type == 'byothers') {
                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                        if (!empty($req_by_oth)) {
                            $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                        }
                    } else {
                        $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                        $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
                } else {
                    if ($request_type == "byme") {
                        $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    } elseif ($request_type == 'tome') {
                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                    } else {
                        $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                        $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
                }
            }
        } elseif ($usertype == 3) {
            if ($userrole == 2) {
                $req_by_oth = $this->check_count_reqby_others();
                if ($request_type == "byme") {
                    $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                } elseif ($request_type == 'byothers') {
                    $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                    if (!empty($req_by_oth)) {
                        $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                    }
                } else {
                    $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                    $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    if (!empty($req_by_oth)) {
                        $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                    }
                }
            } else {
                $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
            }
        }
        if ($request_by != '') {
            $where[] = 'o.staff_requested_service IN (' . $request_by . ')';
        }
        $where[] = "o.status NOT IN (10)";
        $sql .= " WHERE " . implode(' AND ', $where);
        if (count($having) != 0) {
            $sql .= " HAVING " . implode(' OR ', $having);
        }
        $result = $this->db->query($sql)->result();
        return count($result);
    }

    public function get_not_started_services_count_catwise($status = "2", $request_type = "", $category_id = "", $request_by = "") {
        $staff_id = sess('user_id');
        $user_info = staff_info();
        $user_dept = $user_info['department'];
        $usertype = $user_info['type'];
        $userrole = $user_info['role'];

        $sql = "SELECT CONCAT(st.last_name,', ', st.first_name) AS requested_staff,o.staff_requested_service, st.department AS dept,
               o.id, o.order_date, o.start_date, o.complete_date, o.target_start_date, o.target_complete_date, o.total_of_order, o.tracking,
               company.name AS client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id,o.service_id,
               (SELECT ofc.name FROM office as ofc WHERE ofc.id = indt.office) as office, services.description AS service_name,
               CONCAT(',', (SELECT GROUP_CONCAT(department_staff.staff_id) FROM department_staff WHERE department_staff.department_id = services.dept OR department_staff.department_id IN (SELECT sr2.dept FROM services sr2 WHERE sr2.id IN (SELECT srq.services_id FROM `service_request` AS srq WHERE srq.`order_id` = o.id))), ',', COALESCE((SELECT GROUP_CONCAT(st1.id) FROM staff AS st1 WHERE st1.role = 2 AND st1.office_manager = indt.office AND st1.id IN(SELECT staff_id FROM office_staff WHERE office_staff.office_id = indt.office)),''), ',') AS all_staffs
           FROM `order` AS o INNER JOIN company ON o.reference_id=company.id 
               INNER JOIN internal_data indt ON indt.reference_id = company.id
           INNER JOIN services ON services.id=o.service_id
               INNER JOIN staff AS st ON st.id=o.staff_requested_service";
        $where = $having = [];
        if ($status != '') {
            if ($status == '3') {
                $where[] = 'o.status = "1" and o.late_status = "1"';
            } elseif ($status == '4') {
                $where[] = 'o.status != "0"';
            } else {
                $where[] = 'o.status = "' . $status . '"';
            }
        }
        $where[] = "o.reference = 'company'";
        if ($category_id != '') {
            $where[] = 'o.category_id="' . $category_id . '"';
        }

        if ($usertype == 1) {
            if ($request_type == "byme") {
                $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
            } elseif ($request_type == 'byothers') {
                $where[] = 'o.staff_requested_service != "' . $staff_id . '"';
            }
        } elseif ($usertype == 2) {
            if (in_array(6, explode(',', $user_dept))) {
                if ($request_type == "byme") {
                    $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                } elseif ($request_type == 'tome') {
                    $where[] = 'o.staff_requested_service != "' . $staff_id . '"';
                }
            } else {
                if ($userrole == 4) {
                    $req_by_oth = array_column($this->system->get_department_manager_staffs_by_staff_id($staff_id), 'staff_id');
                    if ($request_type == "byme") {
                        $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
//                    elseif ($request_type == 'tome') {
//                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
//                    } 
                    elseif ($request_type == 'byothers') {
                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                        if (!empty($req_by_oth)) {
                            $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                        }
                    } else {
                        $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                        $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
                } else {
                    if ($request_type == "byme") {
                        $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    } elseif ($request_type == 'tome') {
                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                    } else {
                        $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                        $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
                }
            }
        } elseif ($usertype == 3) {
            if ($userrole == 2) {
                $req_by_oth = $this->check_count_reqby_others();
                if ($request_type == "byme") {
                    $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                } elseif ($request_type == 'byothers') {
                    $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                    if (!empty($req_by_oth)) {
                        $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                    }
                } else {
                    $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                    $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    if (!empty($req_by_oth)) {
                        $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                    }
                }
            } else {
                $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
            }
        }
        if ($request_by != '') {
            $where[] = 'o.staff_requested_service IN (' . $request_by . ')';
        }
        $where[] = "o.status NOT IN (10)";
        $sql .= " WHERE " . implode(' AND ', $where);
        if (count($having) != 0) {
            $sql .= " HAVING " . implode(' OR ', $having);
        }
        $result = $this->db->query($sql)->result();
        return count($result);
    }

    public function get_started_services_count_catwise($status = "1", $request_type = "", $category_id = "", $request_by = "") {
        $staff_id = sess('user_id');
        $user_info = staff_info();
        $user_dept = $user_info['department'];
        $usertype = $user_info['type'];
        $userrole = $user_info['role'];

        $sql = "SELECT CONCAT(st.last_name,', ', st.first_name) AS requested_staff,o.staff_requested_service, st.department AS dept,
               o.id, o.order_date, o.start_date, o.complete_date, o.target_start_date, o.target_complete_date, o.total_of_order, o.tracking,
               company.name AS client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id,o.service_id,
               (SELECT ofc.name FROM office as ofc WHERE ofc.id = indt.office) as office, services.description AS service_name,
               CONCAT(',', (SELECT GROUP_CONCAT(department_staff.staff_id) FROM department_staff WHERE department_staff.department_id = services.dept OR department_staff.department_id IN (SELECT sr2.dept FROM services sr2 WHERE sr2.id IN (SELECT srq.services_id FROM `service_request` AS srq WHERE srq.`order_id` = o.id))), ',', COALESCE((SELECT GROUP_CONCAT(st1.id) FROM staff AS st1 WHERE st1.role = 2 AND st1.office_manager = indt.office AND st1.id IN(SELECT staff_id FROM office_staff WHERE office_staff.office_id = indt.office)),''), ',') AS all_staffs
           FROM `order` AS o INNER JOIN company ON o.reference_id=company.id 
               INNER JOIN internal_data indt ON indt.reference_id = company.id
           INNER JOIN services ON services.id=o.service_id
               INNER JOIN staff AS st ON st.id=o.staff_requested_service";
        $where = $having = [];
        if ($status != '') {
            if ($status == '3') {
                $where[] = 'o.status = "1" and o.late_status = "1"';
            } elseif ($status == '4') {
                $where[] = 'o.status != "0"';
            } else {
                $where[] = 'o.status = "' . $status . '"';
            }
        }
        $where[] = "o.reference = 'company'";
        if ($category_id != '') {
            $where[] = 'o.category_id="' . $category_id . '"';
        }

        if ($usertype == 1) {
            if ($request_type == "byme") {
                $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
            } elseif ($request_type == 'byothers') {
                $where[] = 'o.staff_requested_service != "' . $staff_id . '"';
            }
        } elseif ($usertype == 2) {
            if (in_array(6, explode(',', $user_dept))) {
                if ($request_type == "byme") {
                    $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                } elseif ($request_type == 'tome') {
                    $where[] = 'o.staff_requested_service != "' . $staff_id . '"';
                }
            } else {
                if ($userrole == 4) {
                    $req_by_oth = array_column($this->system->get_department_manager_staffs_by_staff_id($staff_id), 'staff_id');
                    if ($request_type == "byme") {
                        $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
//                    elseif ($request_type == 'tome') {
//                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
//                    } 
                    elseif ($request_type == 'byothers') {
                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                        if (!empty($req_by_oth)) {
                            $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                        }
                    } else {
                        $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                        $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
                } else {
                    if ($request_type == "byme") {
                        $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    } elseif ($request_type == 'tome') {
                        $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                    } else {
                        $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                        $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    }
                }
            }
        } elseif ($usertype == 3) {
            if ($userrole == 2) {
                $req_by_oth = $this->check_count_reqby_others();
                if ($request_type == "byme") {
                    $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
                } elseif ($request_type == 'byothers') {
                    $having[] = '(all_staffs LIKE "%,' . $staff_id . ',%" AND o.staff_requested_service != "' . $staff_id . '")';
                    if (!empty($req_by_oth)) {
                        $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                    }
                } else {
                    $having[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                    $having[] = 'o.staff_requested_service = "' . $staff_id . '"';
                    if (!empty($req_by_oth)) {
                        $having[] = 'o.staff_requested_service IN (' . implode(',', $req_by_oth) . ')';
                    }
                }
            } else {
                $where[] = 'o.staff_requested_service = "' . $staff_id . '"';
            }
        }
        if ($request_by != '') {
            $where[] = 'o.staff_requested_service IN (' . $request_by . ')';
        }
        $where[] = "o.status NOT IN (10)";
        $sql .= " WHERE " . implode(' AND ', $where);
        if (count($having) != 0) {
            $sql .= " HAVING " . implode(' OR ', $having);
        }
        $result = $this->db->query($sql)->result();
        return count($result);
    }

    public function insertCompany($data) {
        $this->load->model('system');
        $this->db->trans_begin();
        $data = (object) $data; // convert the post array into an object        
        if (isset($data->name_of_business1)) {
            $insert_data['name'] = $data->name_of_business1;
        }
        if (isset($data->name)) {
            $insert_data['name'] = $data->name;
        }
        if (isset($data->type)) {
            $insert_data['type'] = $data->type;
        }
        if ($data->reference_id) {
            $insert_data['id'] = $data->reference_id;
        }
        if (!isset($data->incorporated_date)) {
            $insert_data['incorporated_date'] = $this->system->invertDate(date("d/m/Y"));
        } else {
            $insert_data['incorporated_date'] = $this->system->invertDate($data->incorporated_date);
        }
        if (!isset($data->state)) {
            $insert_data['state_opened'] = 0;
        } else {
            $insert_data['state_opened'] = $data->state;
        }

        if (isset($data->start_year)) {
            $insert_data['start_month_year'] = $data->start_year;
        }

        if (isset($data->fiscal_year_end)) {
            $insert_data['fye'] = $data->fiscal_year_end;
        }

        if (!isset($data->fein)) {
            $insert_data['fein'] = '';
        } else {
            $insert_data['fein'] = $data->fein;
        }

        if (isset($data->business_description)) {
            $insert_data['business_description'] = $data->business_description;
        }
        $this->db->insert('company', $insert_data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $this->system->log("insert", "company", $data->reference_id);
            return true;
        }
    }

    public function updateCompany($data) {
        $this->load->model('system');
        $data = (object) $data; // convert the post array into an object 
        $update_data = [];
        if (isset($data->start_year)) {
            if ($data->start_year != '') {
                $update_data['start_month_year'] = $data->start_year;
            }
        }

        if (isset($data->fein)) {
            if ($data->fein != '') {
                $update_data['fein'] = $data->fein;
            }
        }
        if (count($update_data) != 0) {
            $this->db->trans_begin();
            $this->db->where('id', $data->reference_id);
            $this->db->update('company', $update_data);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } else {
            return true;
        }
    }

    public function update_account_order_id_by_new_reference_id($new_reference_id, $order_id) {
        $this->db->where('company_id', $new_reference_id);
        return $this->db->update('financial_accounts', ['order_id' => $order_id]);
    }

    public function get_service_request($order_id, $service_id) {
        $return_data = array();
        $sql = "select id, retail_price from services where id in 
            (SELECT services_id from service_request where order_id=$order_id AND services_id != $service_id)
                and status = 1 order by description";
        $data = $this->db->query($sql)->result_array();
        foreach ($data as $each_service) {
            $return_data[$each_service['id']] = $each_service['retail_price'];
        }
        return $return_data;
    }

    public function get_date_form_target_days($service_id) {
        $target_days = $this->db->get_where('target_days', ['service_id' => $service_id])->row_array();
        $end_days = $target_days['end_days'];
        $target_days['start_date'] = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + ' . $target_days['start_days'] . ' days'));
        $target_days['end_date'] = date('Y-m-d h:i:s', strtotime($target_days['start_date'] . ' + ' . $end_days . ' days'));
        return $target_days;
    }

    public function getServiceId() {
        return $this->db->get_where('services', ['description' => 'Sales Tax Recurring'])->row_array()['id'];
    }

    public function getService() {
        return $this->db->get_where('services', ['description' => 'Sales Tax processing'])->row_array()['id'];
    }

    function getStateName($state_id) {
        return $this->db->get_where('states', ['id' => $state_id])->row();
    }

    function getCounty($countyid) {
        return $this->db->get_where('sales_tax_rate', ['id' => $countyid])->row();
    }

    public function check_rt6_status($order_id) {
        return $this->db->get_where('payroll_account_numbers', ['order_id' => $order_id])->row_array();
    }

    public function check_shortname($sc) {
        $query = "select * from services where ideas='" . trim($sc) . "'";
        return $this->db->query($query)->num_rows();
    }

    public function get_state_of_incorporation_value($ref_id) {
        $query = "select * from company where id='" . trim($ref_id) . "'";
        return $this->db->query($query)->row_array();
    }

    public function get_company_type($ref_id) {
        $query = "select * from company where id='" . trim($ref_id) . "'";
        return $this->db->query($query)->row_array();
    }

    public function get_state_county_val($ref_id) {
        $query = "select * from sales_tax_application where existing_ref_id='" . trim($ref_id) . "'";
        return $this->db->query($query)->row_array();
    }

    public function get_order_info_by_id($id) {
        $this->db->select(implode(', ', $this->order_select));
        $this->db->from('order AS ord');
        $this->db->join('company AS cpn', 'ord.reference_id = cpn.id');
        $this->db->join('services AS srv', 'srv.id = ord.service_id');
        $this->db->join('category AS ctr', 'ctr.id = srv.category_id');
        $this->db->join('service_request AS srv_rq', 'srv_rq.order_id = ord.id AND srv_rq.services_id = ord.service_id');
        $this->db->where(['ord.id' => $id]);
        return $this->db->get()->row_array();
    }

    public function get_order_by_id($id) {
        return $this->db->get_where('order', ['id' => $id])->row_array();
    }

    public function get_service_request_list($order_id = '') {
        $select[] = 'srv_rq.id AS id';
        $select[] = 'srv.id AS service_id';
        $select[] = 'srv.description AS service_name';
        $select[] = 'srv.category_id AS category_id';
        $select[] = 'ctr.name AS service_category';
        $select[] = 'srv.ideas AS service_shortname';
        $select[] = 'srv.retail_price AS retail_price';
        $select[] = 'srv_rq.price_charged AS price_charged';
        $select[] = 'srv_rq.date_started AS start_date';
        $select[] = 'srv_rq.date_completed AS complete_date';
        $select[] = 'srv_rq.date_started AS date_started';
        $select[] = '(SELECT name from department WHERE department.id = srv.dept) AS responsible_department';
        $select[] = 'srv_rq.status AS service_request_status';
        $this->db->select(implode(', ', $select));
        $this->db->from('service_request AS srv_rq');
        $this->db->join('services AS srv', 'srv.id = srv_rq.services_id');
        $this->db->join('category AS ctr', 'ctr.id = srv.category_id');
        $this->db->where(['srv_rq.order_id' => $order_id]);
        return $this->db->get()->result_array();
    }

    public function get_service_request_info($order_id = '', $service_id = '') {
        $select[] = 'srv_rq.id AS id';
        $select[] = 'srv.id AS service_id';
        $select[] = 'srv.description AS service_name';
        $select[] = 'srv.category_id AS category_id';
        $select[] = 'ctr.name AS service_category';
        $select[] = 'srv.ideas AS service_shortname';
        $select[] = 'srv.retail_price AS retail_price';
        $select[] = 'srv_rq.price_charged AS price_charged';
        $select[] = 'srv_rq.date_started AS start_date';
        $select[] = 'srv_rq.date_completed AS complete_date';
        $select[] = 'srv_rq.date_started AS date_started';
        $select[] = '(SELECT name from department WHERE department.id = srv.dept) AS responsible_department';
        $select[] = 'srv_rq.status AS service_request_status';
        $this->db->select(implode(', ', $select));
        $this->db->from('service_request AS srv_rq');
        $this->db->join('services AS srv', 'srv.id = srv_rq.services_id');
        $this->db->join('category AS ctr', 'ctr.id = srv.category_id');
        $this->db->where(['srv_rq.order_id' => $order_id, 'srv_rq.services_id' => $service_id]);
        return $this->db->get()->row_array();
    }

    public function get_service($service_id) {
        $query = "select * from services where id='" . trim($service_id) . "'";
        return $this->db->query($query)->row_array();
    }

    public function get_order_ref_id($order_id) {
        $query = "select * from `order` where id='" . $order_id . "'";
        return $this->db->query($query)->row_array();
    }

    public function get_service_by_shortname($shortname) {
        return $this->db->get_where('services', ['ideas' => $shortname])->row_array();
    }

    public function save_order($data) {
        $user_info = staff_info();
        $user_department = $user_info['department'];
        $tracking = time();
        $date = date('Y-m-d h:i:s');
        $main_service = $this->get_service_by_id($data['service_id']);
        $data['category_id'] = $main_service['category_id'];
        if ($data['editval'] == '') {
            $order_data = [
                'order_date' => $date,
                'tracking' => $tracking,
                'staff_requested_service' => sess('user_id'),
                'reference' => 'company',
                'reference_id' => $data['reference_id'],
                'new_existing' => $data['type_of_client'],
                'status' => 2,
                'category_id' => $data['category_id'],
                'service_id' => $data['service_id']
            ];
            if ($this->db->insert('order', $order_data)) {
                $order_id = $data['order_id'] = $this->db->insert_id();
            } else {
                return false;
            }
            $target = $this->get_date_form_target_days($data['service_id']);
            $main_service_request_data = [
                'order_id' => $data['order_id'],
                'services_id' => $data['service_id'],
                'price_charged' => $data['retail_price'],
                'tracking' => $tracking,
                'date_started' => $target['start_date'],
                'date_completed' => $target['end_date'],
                'responsible_department' => $user_department,
                'responsible_staff' => sess('user_id'),
                'status' => '2'
            ];
            $this->db->insert('service_request', $main_service_request_data);
            // loop into related services
            if (isset($data['related_services']) && $data['related_services'] != '0' && count($data['related_services']) > 0) {
                $related_services = $data['related_services'];
                for ($i = 0; $i < count($related_services); $i++) {
                    $service_id = $related_services[$i];
                    $service = $this->get_service_by_id($service_id);
                    if (isset($data['related_service']['override_price'][$service_id]) && $data['related_service']['override_price'][$service_id] != '') {
                        $service['retail_price'] = $data['related_service']['override_price'][$service_id];
                    }
                    $target = $this->get_date_form_target_days($service_id);
                    $service_request_data = [
                        'order_id' => $data['order_id'],
                        'services_id' => $service_id,
                        'price_charged' => $service['retail_price'],
                        'tracking' => $tracking,
                        'date_started' => $target['start_date'],
                        'date_completed' => $target['end_date'],
                        'responsible_department' => $user_department,
                        'responsible_staff' => sess('user_id'),
                        'status' => '2'
                    ];
                    $this->db->insert('service_request', $service_request_data);
                }
            }

            $this->db->select('date_started');
            $this->db->where('order_id', $order_id);
            $this->db->order_by('date_started', 'ASC');
            $target_start_date = $this->db->get('service_request')->row_array();

            $this->db->select('date_completed');
            $this->db->where('order_id', $order_id);
            $this->db->order_by('date_completed', 'DESC');
            $target_end_date = $this->db->get('service_request')->row_array();

            $this->db->select('SUM(price_charged) AS total_price');
            $this->db->where('order_id', $order_id);
            $total_price = $this->db->get('service_request')->row_array();

            $update_order_data = [];
            if (!empty($target_start_date)) {
                $update_order_data['start_date'] = $target_start_date['date_started'];
                $update_order_data['target_start_date'] = $target_start_date['date_started'];
            }

            if (!empty($target_end_date)) {
                $update_order_data['complete_date'] = $target_end_date['date_completed'];
                $update_order_data['target_complete_date'] = $target_end_date['date_completed'];
            }

            if (!empty($total_price)) {
                $update_order_data['total_of_order'] = $total_price['total_price'];
            }
        } else {
            $this->db->where(['order_id' => $data['order_id'], 'services_id' => $data['service_id']]);
            $this->db->update('service_request', ['price_charged' => $data['retail_price']]);
            $order_id = $data['editval'];
            if (isset($data['related_service']) && count($data['related_service']) > 0) {
                $related_services = $data['related_service'];
                foreach ($related_services as $service_order_id => $order_data) {
                    $this->db->where(['order_id' => $service_order_id, 'services_id!=' => $data['service_id']]);
                    $this->db->delete('service_request');
                    foreach ($order_data as $service_id => $service_data) {
                        $service = $this->get_service_by_id($service_id);
                        if (isset($service_data['override_price']) && $service_data['override_price'] != '') {
                            $service_request_data['price_charged'] = $service_data['override_price'];
                        } else {
                            $service_request_data['price_charged'] = $service['retail_price'];
                        }
                        $service_request_data['tracking'] = $tracking;
                        if ($service_id == $data['service_id']) {
                            $this->db->where(['order_id' => $service_order_id, 'services_id' => $data['service_id']]);
                            $this->db->update('service_request', $service_request_data);
                        } elseif (in_array($service_id, $data['related_services'])) {
                            if (isset($service_data['override_price']) && $service_data['override_price'] != '') {
                                $price_charged = $service_data['override_price'];
                            } else {
                                $price_charged = $service['retail_price'];
                            }
                            $target = $this->get_date_form_target_days($service_id);
                            $service_request_data = [
                                'order_id' => $order_id,
                                'services_id' => $service_id,
                                'price_charged' => $price_charged,
                                'tracking' => $tracking,
                                'date_started' => $target['start_date'],
                                'date_completed' => $target['end_date'],
                                'responsible_department' => $user_department,
                                'responsible_staff' => sess('user_id'),
                                'status' => '2'
                            ];

                            $this->db->insert('service_request', $service_request_data);
                        }
                    } // inner foreach
                } //outer foreach
            }
            $this->db->select('SUM(price_charged) AS total_price');
            $this->db->where('order_id', $order_id);
            $total_price = $this->db->get('service_request')->row_array();
            if (!empty($total_price)) {
                $update_order_data['total_of_order'] = $total_price['total_price'];
            }
        }

        if (!empty($update_order_data)) {   //  Save total amount of order
            $this->db->where('id', $order_id);
            $this->db->update('order', $update_order_data);
        }
        return $order_id;
    }

    public function get_column_name($variable_val) {
        if ($variable_val == 1) {
            $column_name = 'o.category_id';
        } elseif ($variable_val == 2) {
            $column_name = 'o.service_id';
        } elseif ($variable_val == 3) {
            $column_name = 'office_id';
        } elseif ($variable_val == 4) {
            $column_name = 'o.status';
        } elseif ($variable_val == 5) {
            $column_name = 'o.staff_requested_service';
        } elseif ($variable_val == 6) {
            $column_name = 'o.start_date';
        } elseif ($variable_val == 7) {
            $column_name = 'o.complete_date';
        } elseif ($variable_val == 8) {
            $column_name = 'o.order_serial_id';
        } elseif ($variable_val == 9) {
            $column_name = 'inv.id';
        } elseif ($variable_val == 10) {
            $column_name = 'o.reference_id';
        }
        return $column_name;
    }

    public function build_query($variable_val, $condition_val, $criteria_dd, $column_name) {
        $query = '';
        if ($variable_val == 1) {
            $criteria_val = $criteria_dd['category'];
        } elseif ($variable_val == 2) {
            $criteria_val = $criteria_dd['servicename'];
        } elseif ($variable_val == 3) {
            $criteria_val = $criteria_dd['office'];
        } elseif ($variable_val == 4) {
            $criteria_val = $criteria_dd['tracking'];
        } elseif ($variable_val == 5) {
            $criteria_val = $criteria_dd['staff'];
        } elseif ($variable_val == 6) {
            $criteria_val = $criteria_dd['startdate'];
        } elseif ($variable_val == 7) {
            $criteria_val = $criteria_dd['completedate'];
        } elseif ($variable_val == 8) {
            $criteria_val = $criteria_dd['orderno'];
        } elseif ($variable_val == 9) {
            $criteria_val = $criteria_dd['invoiceno'];
        } elseif ($variable_val == 10) {
            $criteria_val = $criteria_dd['clientname'];
        }

        if ($variable_val == 6 || $variable_val == 7) { // dates
            if ($condition_val == 1 || $condition_val == 3) {
                $dateval = date("Y-m-d", strtotime($criteria_val[0]));
                $query = $column_name . (($condition_val == 1) ? ' like ' : ' not like ') . '"' . $dateval . '%"';
            } elseif ($condition_val == 2 || $condition_val == 4) {
                if ($variable_val == 6) {
                    $criterias = explode(" - ", $criteria_val[0]);
                } elseif ($variable_val == 7) {
                    $criterias = explode(" - ", $criteria_val[0]);
                }
                foreach ($criterias as $key => $c) {
                    $criterias[$key] = "'" . date("Y-m-d", strtotime($c)) . "'";
                }
                $query = 'Date(' . $column_name . ')' . (($condition_val == 2) ? ' between ' : ' not between ') . implode(' AND ', $criterias);
            }
        } elseif ($variable_val == 3) { //office
            if ($condition_val == 1 || $condition_val == 3) {
                $query = $column_name . (($condition_val == 1) ? ' = ' : ' != ') . $criteria_val[0];
            } elseif ($condition_val == 2 || $condition_val == 4) {
                if ($variable_val == 3) {
                    $criterias = implode(",", $criteria_val);
                }
                $query = $column_name . (($condition_val == 2) ? ' in ' : ' not in ') . '(' . $criterias . ')';
            }
        } elseif ($variable_val == 4) { //tracking
            if ($condition_val == 1 || $condition_val == 3) {
                if ($criteria_val[0] != 3) {
                    $query = $column_name . (($condition_val == 1) ? ' = ' : ' != ') . $criteria_val[0];
                } else {
                    if ($condition_val == 1) {
                        $query = $column_name . ' = 1 and o.late_status = 1';
                    } else {
                        $query = $column_name . ' != 1 and o.late_status != 1';
                    }
                }
            } elseif ($condition_val == 2 || $condition_val == 4) {
                if ($variable_val == 4) {
                    $criterias = implode(",", $criteria_val);
                }
                if (in_array("3", $criteria_val)) {
                    $q = '';
                    $i = 0;
                    $len = count($criteria_val);
                    foreach ($criteria_val as $ck => $cv) {
                        if ($i == 0) {
                            if ($cv == 3) {
                                if ($condition_val == 2) {
                                    $q .= '(' . $column_name . ' = 1 and o.late_status = 1';
                                } else {
                                    $q .= '(' . $column_name . ' != 1 and o.late_status != 1';
                                }
                            } else {
                                $q .= '(' . $column_name . (($condition_val == 2) ? ' = ' : ' != ') . $cv;
                            }
                        } else if ($i == $len - 1) {
                            if ($cv == 3) {
                                if ($condition_val == 2) {
                                    $q .= ' AND ' . $column_name . ' = 1 and o.late_status = 1)';
                                } else {
                                    $q .= ' AND ' . $column_name . ' != 1 and o.late_status != 1)';
                                }
                            } else {
                                $q .= ' AND ' . $column_name . (($condition_val == 2) ? ' = ' : ' != ') . $cv . ')';
                            }
                        } else {
                            if ($cv == 3) {
                                if ($condition_val == 2) {
                                    $q .= ' AND ' . $column_name . ' = 1 and o.late_status = 1';
                                } else {
                                    $q .= ' AND ' . $column_name . ' != 1 and o.late_status != 1';
                                }
                            } else {
                                $q .= ' AND ' . $column_name . (($condition_val == 2) ? ' = ' : ' != ') . $cv;
                            }
                        }
                        $i++;
                    }
                    $query = $q;
                } else {
                    $query = $column_name . (($condition_val == 2) ? ' in ' : ' not in ') . '(' . $criterias . ')';
                }
            }
        } else {
            if ($condition_val == 1 || $condition_val == 3) {
                $query = $column_name . (($condition_val == 1) ? ' = ' : ' != ') . $criteria_val[0];
            } elseif ($condition_val == 2 || $condition_val == 4) {
                if ($variable_val == 1) {
                    $criterias = implode(",", $criteria_val);
                } elseif ($variable_val == 2) {
                    $criterias = implode(",", $criteria_val);
                } elseif ($variable_val == 4) {
                    $criterias = implode(",", $criteria_val);
                } elseif ($variable_val == 5) {
                    $criterias = implode(",", $criteria_val);
                } elseif ($variable_val == 8) {
                    $criterias = implode(",", $criteria_val);
                } elseif ($variable_val == 9) {
                    $criterias = implode(",", $criteria_val);
                } elseif ($variable_val == 10) {
                    $criterias = implode(",", $criteria_val);
                }
                $query = $column_name . (($condition_val == 2) ? ' in ' : ' not in ') . '(' . $criterias . ')';
            }
        }
        return $query;
    }

    public function get_extra_data($order_id) {
        return $this->db->get_where('order_extra_data', ['order_id' => $order_id])->row_array();
    }

    public function get_extra_services($order_id, $service_id) {
        return $this->db->query("select * from service_request where `order_id` = " . $order_id . " and `services_id` != " . $service_id . "")->result_array();
    }

    public function get_main_service_data($order_id, $service_id) {
        return $this->db->query("select * from service_request where `order_id` = " . $order_id . " and `services_id` = " . $service_id . "")->row_array();
    }

    public function assign_order_by_order_id($order_id, $staff_id) {
        $this->db->trans_begin();
        $this->db->where(['id' => $order_id]);
        $this->db->update('order', ['assign_user' => $staff_id]);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            if ($staff_id != 0) {
                $this->system->save_general_notification('order', $order_id, 'assign', [$staff_id], $staff_id);
            }
            return true;
        }
    }

    public function get_order_staff_by_order_id($order_id) {
        $sql = "SELECT CONCAT(st.last_name,', ', st.first_name, ' ', st.middle_name) AS requested_staff,o.staff_requested_service, o.assign_user, st.department AS dept,
               o.id, o.order_serial_id, o.order_date, o.start_date, o.complete_date, o.target_start_date, o.target_complete_date, o.total_of_order, o.tracking,
               company.name AS client_name,o.reference_id,o.reference,o.status,o.late_status,o.start_date,o.complete_date,o.category_id,o.service_id,indt.office AS office_id,
               (SELECT ofc.name FROM office as ofc WHERE ofc.id = indt.office) as office,services.description AS service_name,services.ideas AS service_shortname,
               CONCAT((SELECT GROUP_CONCAT(department_staff.staff_id) FROM department_staff WHERE department_staff.department_id = services.dept OR department_staff.department_id IN (SELECT sr2.dept FROM services sr2 WHERE sr2.id IN (SELECT srq.services_id FROM `service_request` AS srq WHERE srq.`order_id` = o.id))), ',', COALESCE((SELECT GROUP_CONCAT(st1.id) FROM staff AS st1 WHERE st1.role = 2 AND st1.office_manager = indt.office AND st1.id IN(SELECT staff_id FROM office_staff WHERE office_staff.office_id = indt.office)),'')) AS all_staffs
	       FROM `order` AS o INNER JOIN company ON o.reference_id=company.id 
               INNER JOIN internal_data indt ON indt.reference_id = company.id
	       INNER JOIN services ON services.id=o.service_id
               INNER JOIN staff AS st ON st.id=o.staff_requested_service
               WHERE o.id = '{$order_id}'";
        return $this->db->query($sql)->row_array();
    }

    public function save_order_extra_data($order_id, $data) {
        $check = $this->get_extra_data($order_id);
        if (!empty($check)) {
            $this->db->where(['order_id' => $order_id]);
            return $this->db->update("order_extra_data", $data);
        } else {
            $data['order_id'] = $order_id;
            return $this->db->insert("order_extra_data", $data);
        }
    }

}
