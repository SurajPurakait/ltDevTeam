<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class System extends CI_Model {

    private $tracking_status_array;

    public function __construct() {
        parent::__construct();
        $this->load->model('service_model');
        $this->load->model('action_model');
        $this->load->model('billing_model');
        $this->load->model('administration');
        $this->load->model('individual');
        $this->tracking_status_array['order'] = [
            0 => 'Completed',
            1 => 'Started',
            2 => 'Not Started',
            7 => 'Canceled'
        ];
        $this->tracking_status_array['action'] = [
            0 => 'New',
            1 => 'Started',
            6 => 'Resolved',
            2 => 'Completed',
            7 => 'Canceled'
        ];
        $this->tracking_status_array['invoice'] = [
            1 => 'Not Started',
            2 => 'Started',
            3 => 'Completed',
            7 => 'Canceled'
        ];
    }

    function authentication($user_post) {
        $user_post['is_delete'] = 'n';
        $user_post['status'] = '1';
        $this->db->select('id as user_id, security_level');
        $this->db->where($user_post);
        $this->db->limit(1);
        $query = $this->db->get('staff');
        if ($query->num_rows() == 1) {
            $result = $query->row_array();
            $result['user_office_id'] = $this->db->get_where("office_staff", ['staff_id' => $result['user_id']])->row_array()['office_id'];
            $result['login'] = 'ok';
            $result['user_type'] = $this->db->get_where("staff", ['id' => $result['user_id']])->row_array()['type'];
            return $result;
        } else {
            return false;
        }
    }

    public function set_user_session($id) {
        $user_post['is_delete'] = 'n';
        $user_post['status'] = '1';
        $this->db->select('id as user_id, security_level');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get('staff');
        $result = $query->row_array();
        $result['user_office_id'] = $this->db->get_where("office_staff", ['staff_id' => $result['user_id']])->row_array()['office_id'];
        $result['login'] = 'ok';
        $result['user_type'] = $this->db->get_where("staff", ['id' => $result['user_id']])->row_array()['type'];
        $result['staff_info'] = $this->get_staff_info($id);
        foreach ($result as $index => $value) {
            $this->session->set_userdata($index, $value);
        }
        $this->log('login', 'staff', $result['user_id']);
    }

    public function updatessn($ssn_no, $user_id) {
        $this->db->set(["ssn_itin" => $ssn_no])->where("id", $user_id)->update("staff");
    }

    public function ssn_authentication($user_id) {
        $result = $this->db->get_where("staff", ['id' => $user_id])->row_array();
        return $result;
    }

    public function check_user($data) {

        $user = $data['user'];
        $value = $this->db->query("select * from staff where user='$user'");
        if ($value->num_rows() == 1) {
            return $value->row_array();
        } else {
            return 0;
        }
    }

    public function update_password($id, $password) {
        $id = base64_decode($id);
        $password = md5($password);
        $date = date('Y-m-d');
        return $data = $this->db->query("update staff set password='$password',date='$date' where id='$id'");
    }

    public function log($action, $reference, $reference_id) {
        $insert_data = [
            'date' => date("Y-m-d H:i:s"),
            'staff' => $this->session->userdata('user_id'),
            'reference' => $reference,
            'reference_id' => $reference_id,
            'action' => $action,
            'ip' => getenv("REMOTE_ADDR")
        ];
        return $this->db->insert('log', $insert_data);
    }

    public function get_state_by_id($states_id) {
        return $this->db->get_where("states", ["id" => $states_id])->row_array();
    }

    public function get_county_by_id($county_id) {
        return $this->db->get_where("sales_tax_rate", ["id" => $county_id])->row_array();
    }

    public function get_all_state($state_code = []) {
        $this->db->select('states.*, states.state_name AS name');
        if (count($state_code) > 0) {
            $this->db->where_in('state_code', $state_code);
        }
        return $this->db->get("states")->result_array();
    }

    public function get_all_company_type() {
        return $this->db->get_where("company_type", ['status' => '1'])->result_array();
    }

    public function get_languages() {
        return $this->db->where("status", "1")->order_by("language", "asc")->get("languages")->result_array();
    }

    public function count_duplicate_field($table, $where_data) {
        return $this->db->get_where($table, $where_data)->num_rows();
    }

    public function get_staff_info($staff_id) {
        $this->db->select("CONCAT(staff.last_name, ', ',staff.first_name) as full_name, staff.*");
        $result = $this->db->get_where('staff', ['id' => $staff_id])->row_array();
        if (!empty($result)) {
            $office_staff = $this->db->get_where('office_staff', ['staff_id' => $staff_id])->result_array();
            $office_list = [];
            foreach ($office_staff as $os) {
                $office_list[] = $os['office_id'];
            }
            $result['office'] = implode(',', $office_list);

            if (!empty($office_list)) {
                $this->db->where_in('office_id', $office_list);
                $office_staff = $this->db->get('office_staff')->result_array();
                $office_staff = array_column($office_staff, 'staff_id');
                $result['office_staff'] = implode(',', $office_staff);
            }


            $department_staff = $this->db->get_where('department_staff', ['staff_id' => $staff_id])->result_array();
            $department_list = [];
            foreach ($department_staff as $ds) {
                $department_list[] = $ds['department_id'];
            }
            $result['department'] = implode(',', $department_list);

            if (!empty($department_list)) {
                $this->db->where_in('department_id', $department_list);
                $department_staff = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staff, 'staff_id');
                $result['department_staff'] = implode(',', $department_staff);
            }
            return $result;
        } else {
            return [];
        }
    }

    public function get_staff_address_info($staff_id = "") {
        if ($staff_id == "") {
            $return = $this->db->get_where('office', ['status' => '1'])->result_array();
        } else {
            $this->db->select('ofc.id, ofc.address, ofc.city');
            $this->db->from('office_staff os');
            $this->db->join('office ofc', 'os.office_id = ofc.id');
            $this->db->where(['os.staff_id' => $staff_id, 'ofc.status' => '1']);
            $return = $this->db->get()->row_array();
        }
        return $return;
    }

    public function get_all_staff() {
        $result = $this->db->get_where('staff', ['is_delete' => "n"])->result_array();
        if (!empty($result)) {
            foreach ($result as $key => $sl) {
                $office_staff = $this->db->get_where('office_staff', ['staff_id' => $sl['id']])->result_array();
                $office_list = [];
                foreach ($office_staff as $os) {
                    $office_list[] = $os['office_id'];
                }
                $result[$key]['office'] = implode(',', $office_list);

                $department_staff = $this->db->get_where('department_staff', ['staff_id' => $sl['id']])->result_array();
                $department_list = [];
                foreach ($department_staff as $ds) {
                    $department_list[] = $ds['department_id'];
                }
                $result[$key]['department'] = implode(',', $department_list);
            }
            return $result;
        } else {
            return [];
        }
    }

    public function get_manager_staff_list() {
        $this->db->select("concat(last_name, ', ', first_name) as name, id");
        return $this->db->get_where('staff', ['is_delete' => "n", 'role' => '2'])->result_array();
    }

    public function get_staff_ids_by_office_id($office_ids) {
        $this->db->where_in('office_id', $office_ids);
        return $this->db->get('office_staff')->result_array();
    }

    public function get_staff() {
        return $this->db->get('staff')->result_array();
    }

    public function get_staff_office_list($staff_id = "") {
        if ($staff_id == "") {
            $this->db->order_by("name", "ASC");
            $return = $this->db->get_where('office', ['status' => '1'])->result_array();
        } else {
            $this->db->select('ofc.id, ofc.name');
            $this->db->from('office_staff os');
            $this->db->join('office ofc', 'os.office_id = ofc.id');
            $this->db->where(['os.staff_id' => $staff_id, 'ofc.status' => '1']);
            $this->db->order_by("name", "ASC");
            $return = $this->db->get()->result_array();
        }
        return $return;
    }

    public function create_reference_id() {
        $this->db->insert('reference_id_generator', ['user_id' => sess('user_id')]);
        return $this->db->insert_id();
    }

    public function getLoggedUserId() {
        return $this->session->userdata('user_id');
    }

    public function getLoggedUserOfficeId() {
        return $this->session->userdata('user_office_id');
    }

    public function getDateTime() {
        return date("Y - m - d H:i:s");
    }

    public function getDate() {
        return date("Y - m - d");
    }

    public function normalizeDate($date) {
        $date = str_replace(" / ", " - ", $date);
        $formatted_date = date_create($date);
        return date_format($formatted_date, 'm/d/Y');
    }

    public function normalizeDateTime($date) {
        $date = str_replace(" / ", " - ", $date);
        $formatted_date = date_create($date);
        return date_format($formatted_date, 'm/d/Y h:i a');
    }

    public function invertDate($dateInput) {
        return DateTime::createFromFormat('m/d/Y', $dateInput)->format('Y-m-d');
    }

    public function getURL($encode = false) {
        if ($encode) {
            return base64_encode("http://" . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI']);
        } else {
            return "http://" . $_SERVER['SERVER_NAME'] . $_SERVER ['REQUEST_URI'];
        }
    }

    public function activeMenu($main_menu, $for) {
        return $main_menu == $for ? 'class="active"' : "";
    }

    public function get_refered_by_source() {
        return $this->db->get_where("referred_by_source", ['status' => '1'])->result_array();
    }

    public function get_select_service($service_id) {
        return $this->db->query("select id, description from services where id in (select related_services_id from related_services where services_id = $service_id) and status = 1 order by description")->result_array();
    }

    public function get_all_countries() {
        return $this->db->order_by("sort_order", "asc")->get("countries")->result_array();
    }

    public function get_contact_info_type() {
        return $this->db->get_where("contact_info_type", ['status' => '1'])->result_array();
    }

    public function updateLateStatusSystem() {
        $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.start_date,o.complete_date,
                concat(st.last_name, ', ', st.first_name) as requested_staff
                from `order` o
                inner join company c on c.id = o.reference_id
                inner join staff st on st.id = o.staff_requested_service
                order by o.order_date desc";
        $all_ongoing_order = $this->db->query($sql)->result();
        foreach ($all_ongoing_order as $row) {
            $target_end_date = $row->complete_date;
//            $target_start_date = $row->start_date;

            if (strtotime($target_end_date) < time()) {
                $this->db->query("update `order` set late_status= 1 where id = " . $row->id);
            }
        }
    }

    public function get_internal_data_by_reference($reference_id, $reference) {
        $select[] = '(SELECT name FROM office WHERE id = internal_data.office) AS office_name';
        $select[] = '(SELECT photo FROM office WHERE id = internal_data.office) AS office_photo';
        $select[] = '(SELECT source FROM referred_by_source WHERE id = internal_data.referred_by_source) AS source_name';
        $select[] = '(SELECT language FROM languages WHERE id = internal_data.language) AS language_name';
        $select[] = '(SELECT CONCAT(staff.last_name, ", ",staff.first_name," ",staff.middle_name) FROM staff WHERE id = internal_data.partner) AS partner_name';
        $select[] = '(SELECT CONCAT(staff.last_name, ", ",staff.first_name," ",staff.middle_name) FROM staff WHERE id = internal_data.manager) AS manager_name';
        $this->db->select('internal_data.*, ' . implode(', ', $select));
        return $this->db->get_where('internal_data', ['internal_data.reference' => $reference, 'internal_data.reference_id' => $reference_id])->row_array();
    }

    public function get_company_type_by_id($type_id) {
        return $this->db->get_where("company_type", ['id' => $type_id])->row_array();
    }

    public function get_reference_by_source($reference_by_source) {
        return $this->db->get_where('referred_by_source', ['id' => $reference_by_source])->row_array();
    }

    public function update_order_serial_id_by_order_id($order_id) {
        $this->db->select('MAX(order_serial_id) AS serial_id');
        $result = $this->db->get("order")->row_array();
        $serial_id = $result['serial_id'] + 1;
        $this->db->where(['id' => $order_id]);
        $this->db->update("order", ['order_serial_id' => $serial_id]);
    }

    public function get_all_dept() {
        return $this->db->get('department')->result_array();
    }

    public function get_staff_list() {
        $staff_info = staff_info();
        if ($staff_info['type'] == 3) {
            $this->db->select("s.*");
            $this->db->from('staff s');
            $this->db->join('office_staff os', 'os.staff_id = s.id');
            $this->db->where_in('os.office_id', explode(",", $staff_info['office']));
            $result = $this->db->get()->result_array();
        } elseif ($staff_info['type'] == 2 && $staff_info['department'] != 14) {
            $this->db->select("s.*");
            $this->db->from('staff s');
            $this->db->join('department_staff ds', 'ds.staff_id = s.id');
            $this->db->where_in('ds.department_id', explode(",", $staff_info['department']));
            $result = $this->db->get()->result_array();
        } else {
            $result = $this->db->get('staff')->result_array();
        }
        return $result;
    }

    public function get_reffered_by_source() {
        return $this->db->get('referred_by_source')->result_array();
    }

    public function get_company_type() {
        return $this->db->get('company_type')->result_array();
    }

    public function get_servicecat_name($cat_id) {
        return $this->db->get_where("category", ['id' => $cat_id])->row_array();
    }

    public function input_form_check($service_id) {
        return $this->db->get_where("target_days", ['service_id' => $service_id])->row_array();
    }

    public function check_if_related_service_exists($service_id, $order_id) {
        return $this->db->get_where("service_request", ['services_id' => $service_id, 'order_id' => $order_id])->row_array();
    }

    public function get_department_manager_staffs_by_staff_id($staff_id) {
        $departments = $this->db->get_where('department_manager', ['manager_id' => $staff_id])->result_array();
        if (!empty($departments)) {
            $this->db->where_in('department_id', array_column($departments, 'department_id'));
            return $this->db->get('department_staff')->result_array();
        } else {
            return [];
        }
    }

    public function get_user_types() {
        return $this->db->get('staff_type')->result_array();
    }

    public function get_all_ofc() {
        return $this->db->get('office')->result_array();
    }

    public function get_staff_ids_by_department_id($dept_ids) {
        $this->db->where_in('department_id', $dept_ids);
        return $this->db->get('department_staff')->result_array();
    }

    public function get_staff_ids_of_admin_user() {
        return $this->db->get_where("staff", ['type' => 1])->result_array();
    }

    public function get_filter_dropdown_options($val, $ofc_val) {
        $staff_info = staff_info();
        if ($val == 1) {
            $query = "select * from category";
        }
        if ($val == 14) {
            $query = "select * from department";
        } elseif ($val == 2) {
            $query = "select * from services";
        } elseif ($val == 3) {
            if ($staff_info['type'] == 1 || $staff_info['department'] == 14) {
                $query = "select * from office";
            } else {
                $query = "select o.* from office o inner join office_staff os on os.office_id = o.id where os.staff_id = '" . $staff_info['id'] . "'";
            }
        } elseif ($val == 5) {
            if ($ofc_val == '') {
                $query = "select * from staff where status=1";
            } else {
                if (is_array($ofc_val)) {
                    $ofc_values = implode(",", $ofc_val);
                } else {
                    $ofc_values = $ofc_val;
                }
                $query = "select s.* from staff s inner join office_staff os on os.staff_id=s.id where s.status=1 and os.office_id in (" . $ofc_values . ")";
            }
        } elseif ($val == 8) {
            $query = "select * from `order` where order_serial_id!=0";
        } elseif ($val == 9) {
            $query = "select * from `invoice_info`";
        } elseif ($val == 10) {
            $query = "select * from `company` where name is not null";
        }
        return $this->db->query($query)->result_array();
    }

    public function get_filter_dropdown_options_ref_partner($val) {
        if ($val == 1) {
            $query = "select * from type_of_contact_referral";
        } elseif ($val == 2) {
            $query = "select * from staff where status=1";
        }
        return $this->db->query($query)->result_array();
    }

    public function get_user_date($id) {
        return $data = $this->db->query("select * from staff where id= '$id'")->row_array();
    }

    public function check_if_new_sos($ref, $order_id) {
        $staff_info = staff_info();
        $query = "select sn.* from sos_notification sn inner join sos_notification_staff sns on sns.sos_notification_id = sn.id where sn.reference= '" . $ref . "' and sn.reference_id='" . $order_id . "' and sns.read_status=0 and sns.staff_id='" . $staff_info['id'] . "'";
        $result = $this->db->query($query)->result_array();
        if (!empty($result)) {
            return 'sos';
        } else {
            return 'no-sos';
        }
    }

    public function get_sos_count($reference, $service_id, $ref_id) {
        $staff_info = staff_info();
        if ($service_id == '') {
            $service_id = 0;
        }

        $query1 = "select sn.*,sns.staff_id from sos_notification sn inner join sos_notification_staff sns on sns.sos_notification_id = sn.id where sn.reference='" . $reference . "' and sn.reference_id='" . $ref_id . "' and sn.service_id='" . $service_id . "' and sn.added_by_user!='" . sess('user_id') . "' and sns.staff_id='" . sess('user_id') . "' and sns.read_status='0' group by sn.reference_id";

        $query2 = "select sn.*,sns.staff_id from sos_notification sn inner join sos_notification_staff sns on sns.sos_notification_id = sn.id where sn.reference='" . $reference . "' and sn.reference_id='" . $ref_id . "' and sn.service_id='" . $service_id . "' and sn.added_by_user='" . sess('user_id') . "' and sns.staff_id='" . sess('user_id') . "' and sns.read_status='0' group by sn.reference_id";

        $result1 = $this->db->query($query1)->num_rows();
        $result2 = $this->db->query($query2)->num_rows();
        $result = $result1 + $result2;
        return $result;
    }

    public function get_sos_count_action($reference, $service_id, $ref_id) {
        $data = $this->db->query("select count(id) as sos_count FROM sos_notification GROUP BY(reference_id) HAVING reference_id='$ref_id'")->row();
        return $data->sos_count;
    }

    public function show_sos($reference, $service_id, $ref_id) {
        $staff_info = staff_info();
        if ($service_id == '') {
            $service_id = 0;
        }
        if ($staff_info['type'] == 1 || $staff_info['department'] == 14) {
            $and = ' ';
        } else {
            $and = " and (sns.staff_id='" . sess('user_id') . "' or sn.added_by_user='" . sess('user_id') . "')";
        }
//        $query = "select sn.*,sns.staff_id,sns.read_status from sos_notification sn inner join sos_notification_staff sns on sns.sos_notification_id = sn.id where sn.reference='" . $reference . "' and sn.reference_id='" . $ref_id . "'and sns.staff_id='".sess('user_id')."' and sn.service_id='" . $service_id . "'$and group by sn.msg order by sn.id asc";
        $query = "select sn.*,sns.staff_id,sns.read_status from sos_notification sn inner join sos_notification_staff sns on sns.sos_notification_id = sn.id where sn.reference='" . $reference . "' and sn.reference_id='" . $ref_id . "' group by sn.id order by sn.id asc";

//        echo $query;die;
        $res = $this->db->query($query)->result_array();

        $returnarray = array_map("unserialize", array_unique(array_map("serialize", $res)));
        // echo '<pre>';
        // print_r($input);    
        return $returnarray;
    }

    public function created_by_staff($action_id) {
        $result = $this->db->get_where('actions', ['id' => $action_id])->row_array();
        return $result['added_by_user'];
    }

    public function insert_sos($data) {
        //  print_r($data);die;
        $all_staffs = explode(",", $data['staffs']);
        if ($data['serviceid'] == '') {
            $data['serviceid'] = '0';
        }
        // if (($key = array_search(sess('user_id'), $all_staffs)) !== false) {
        //     unset($all_staffs[$key]);
        // }
//        print_r($all_staffs);die;
        if ($data['reference'] == 'action') {

            $created_by_staff = $this->created_by_staff($data['refid']);
            array_push($all_staffs, $created_by_staff);

            if (!empty($all_staffs)) {
//                print_r($all_staffs);exit;
                $insert_data = array(
                    'id' => '',
                    'reference' => $data['reference'],
                    'reference_id' => $data['refid'],
                    'service_id' => $data['serviceid'],
                    'msg' => $data['sos_note'],
                    'added_by_user' => sess('user_id'),
                    'post_or_reply' => '1'
                );
                $this->db->insert('sos_notification', $insert_data);
                $sos_notification_id = $this->db->insert_id();
                foreach ($all_staffs as $staff) {
                    if (isset($staff) && $staff != '') {
                        $insert_sos_staff_data = array(
                            'id' => '',
                            'sos_notification_id' => $sos_notification_id,
                            'staff_id' => $staff,
                            'read_status' => '0'
                        );
                        $this->db->insert('sos_notification_staff', $insert_sos_staff_data);
                    }
                }
                if (($key = array_search(sess('user_id'), $all_staffs)) !== false) {
                    unset($all_staffs[$key]);
                }
                $this->save_general_notification('action', $data['refid'], 'sos', $all_staffs);
                $sos_action_notification_array = $this->db->where(['reference_id' => $data['actionid'], 'reference' => 'action', 'added_by_user' => sess('user_id'), 'id!=' => $sos_notification_id])->get("sos_notification")->result_array();
                if (empty($sos_action_notification_array)) {
                    return '0';
                } else {
                    $sos_notification_ids = array_column($sos_action_notification_array, 'id');
                    $this->db->where(['read_status' => '0']);
                    $this->db->where_in('sos_notification_id', $sos_notification_ids);
                    $check_if_unread_sos_exists_for_same_action = $this->db->from("sos_notification_staff")->count_all_results();
                    //echo $this->db->last_query(); exit;
                    return $check_if_unread_sos_exists_for_same_action;
                }
            }
        } elseif ($data['reference'] == 'projects') {
//            print_r($data['refid']);die;
            if (empty($all_staffs)) {
                $created_by_staff = $this->task_created_by_staff($data['serviceid']);
                array_push($all_staffs, $created_by_staff);
            }
            if (!empty($all_staffs)) {
                //print_r($all_staffs);exit;
                $insert_data = array(
                    'id' => '',
                    'reference' => $data['reference'],
                    'reference_id' => $data['refid'],
                    'service_id' => $data['serviceid'],
                    'msg' => $data['sos_note'],
                    'added_by_user' => sess('user_id'),
                    'post_or_reply' => '1'
                );
                $this->db->insert('sos_notification', $insert_data);
                $sos_notification_id = $this->db->insert_id();
                foreach ($all_staffs as $staff) {
                    if (isset($staff) && $staff != '') {
                        $insert_sos_staff_data = array(
                            'id' => '',
                            'sos_notification_id' => $sos_notification_id,
                            'staff_id' => $staff,
                            'read_status' => '0'
                        );
                        $this->db->insert('sos_notification_staff', $insert_sos_staff_data);
                    }
                }
                $insert_sos_byme_staff_data = array(
                    'id' => '',
                    'sos_notification_id' => $sos_notification_id,
                    'staff_id' => sess('user_id'),
                    'read_status' => '0'
                );
                $this->db->insert('sos_notification_staff', $insert_sos_byme_staff_data);

                $sos_action_notification_array = $this->db->where(['reference_id' => $data['actionid'], 'reference' => 'projects', 'added_by_user' => sess('user_id'), 'id!=' => $sos_notification_id])->get("sos_notification")->result_array();
                if (empty($sos_action_notification_array)) {
                    return '0';
                } else {
                    $sos_notification_ids = array_column($sos_action_notification_array, 'id');
                    $this->db->where(['read_status' => '0']);
                    $this->db->where_in('sos_notification_id', $sos_notification_ids);
                    $check_if_unread_sos_exists_for_same_action = $this->db->from("sos_notification_staff")->count_all_results();
                    //echo $this->db->last_query(); exit;
                    return $check_if_unread_sos_exists_for_same_action;
                }
            }
        } //for project
        else { //for order
            $check_if_order_assigned = $this->check_if_service_assigned($data['servreqid']);
            if ($check_if_order_assigned == 0) {
                if (!empty($all_staffs)) {
                    $insert_data = array(
                        'id' => '',
                        'reference' => $data['reference'],
                        'reference_id' => $data['refid'],
                        'service_id' => $data['serviceid'],
                        'msg' => $data['sos_note'],
                        'added_by_user' => sess('user_id'),
                        'post_or_reply' => '1'
                    );
                    $this->db->insert('sos_notification', $insert_data);
                    $sos_notification_id = $this->db->insert_id();
                    foreach ($all_staffs as $staff) {
                        if (isset($staff) && $staff != '') {
                            $insert_sos_staff_data = array(
                                'id' => '',
                                'sos_notification_id' => $sos_notification_id,
                                'staff_id' => $staff,
                                'read_status' => '0'
                            );
                            $this->db->insert('sos_notification_staff', $insert_sos_staff_data);
                        }
                    }
                    $insert_sos_byme_staff_data = array(
                        'id' => '',
                        'sos_notification_id' => $sos_notification_id,
                        'staff_id' => sess('user_id'),
                        'read_status' => '0'
                    );
                    $this->db->insert('sos_notification_staff', $insert_sos_byme_staff_data);

                    $sos_service_notification_array = $this->db->where(['reference_id' => $data['orderid'], 'service_id' => $data['serviceid'], 'reference' => 'order', 'added_by_user' => sess('user_id'), 'id!=' => $sos_notification_id])->get("sos_notification")->result_array();
                    if (empty($sos_service_notification_array)) {
                        return '0';
                    } else {
                        $sos_notification_ids = array_column($sos_service_notification_array, 'id');
                        $this->db->where(['read_status' => '0']);
                        $this->db->where_in('sos_notification_id', $sos_notification_ids);
                        $check_if_unread_sos_exists_for_same_order = $this->db->from("sos_notification_staff")->count_all_results();
                        //echo $this->db->last_query(); exit;
                        return $check_if_unread_sos_exists_for_same_order;
                    }
                }
            } else {
                $insert_data = array(
                    'id' => '',
                    'reference' => $data['reference'],
                    'reference_id' => $data['refid'],
                    'service_id' => $data['serviceid'],
                    'msg' => $data['sos_note'],
                    'added_by_user' => sess('user_id'),
                    'post_or_reply' => '1'
                );
                $this->db->insert('sos_notification', $insert_data);
                $sos_notification_id = $this->db->insert_id();
                $insert_sos_staff_data = array(
                    'id' => '',
                    'sos_notification_id' => $sos_notification_id,
                    'staff_id' => $check_if_order_assigned,
                    'read_status' => '0'
                );
                $this->db->insert('sos_notification_staff', $insert_sos_staff_data);
                $insert_sos_byme_staff_data = array(
                    'id' => '',
                    'sos_notification_id' => $sos_notification_id,
                    'staff_id' => sess('user_id'),
                    'read_status' => '0'
                );
                $this->db->insert('sos_notification_staff', $insert_sos_byme_staff_data);

                $sos_service_notification_array = $this->db->where(['reference_id' => $data['orderid'], 'reference' => 'order', 'added_by_user' => sess('user_id'), 'id!=' => $sos_notification_id])->get("sos_notification")->result_array();
                if (empty($sos_service_notification_array)) {
                    return '0';
                } else {
                    $sos_notification_ids = array_column($sos_service_notification_array, 'id');
                    $this->db->where(['read_status' => '0']);
                    $this->db->where_in('sos_notification_id', $sos_notification_ids);
                    $check_if_unread_sos_exists_for_same_order = $this->db->from("sos_notification_staff")->count_all_results();
                    //echo $this->db->last_query(); exit;
                    return $check_if_unread_sos_exists_for_same_order;
                }
            }
        }
    }

    public function check_if_order_assigned($order_id) {
        $query = "select * from `order` where id='" . $order_id . "'";
        return $this->db->query($query)->row_array()['assign_user'];
    }

    public function check_if_service_assigned($service_req_id) {
        $query = "select * from `service_request` where id='" . $service_req_id . "'";
        return $this->db->query($query)->row_array()['assign_user'];
    }

    public function reply_sos($data) {
        $get_main_sos_val = $this->db->query("select * from sos_notification where id='" . $data['mainsos'] . "'")->row_array();
        $insert_data = array(
            'id' => '',
            'reference' => $get_main_sos_val['reference'],
            'reference_id' => $get_main_sos_val['reference_id'],
            'service_id' => $get_main_sos_val['service_id'],
            'msg' => $data['sos_note'],
            'added_by_user' => sess('user_id'),
            'post_or_reply' => '2'
        );
        $this->db->insert('sos_notification', $insert_data);
        $sos_notification_id = $this->db->insert_id();
        $insert_sos_staff_data = array(
            'id' => '',
            'sos_notification_id' => $sos_notification_id,
            'staff_id' => $get_main_sos_val['added_by_user'],
            'read_status' => '0'
        );
        $this->db->insert('sos_notification_staff', $insert_sos_staff_data);
    }

    public function sos_dashboard_count_for_reply($reference, $byval) {
        if ($byval == 'tome') {
            $query = "select sn.*,sns.staff_id from sos_notification sn inner join sos_notification_staff sns on sns.sos_notification_id = sn.id where sn.reference='" . $reference . "' and sns.staff_id='" . sess('user_id') . "'  and sns.read_status='0' and sn.post_or_reply='2' group by sn.reference_id";
        } else {
            $query = "select sn.*,sns.staff_id from sos_notification sn inner join sos_notification_staff sns on sns.sos_notification_id = sn.id where sn.reference='" . $reference . "' and sn.added_by_user='" . sess('user_id') . "' and sns.read_status='0' and sn.post_or_reply='2' group by sn.reference_id";
        }
        return $this->db->query($query)->num_rows();
    }

    public function sos_dashboard_count($reference, $byval) {
        if ($reference == 'action') {
            $action_list = $this->action_model->get_action_list('', '', '', '', '', '', '', $byval);
            return count($action_list);
        } else {
            if ($byval == 'tome') {
                $query = "select sn.*,sns.staff_id from sos_notification sn inner join sos_notification_staff sns on sns.sos_notification_id = sn.id where sn.reference='" . $reference . "' and sn.added_by_user!='" . sess('user_id') . "' and sns.staff_id='" . sess('user_id') . "'  and sns.read_status='0' group by sn.reference_id";
            } else {
                $query = "select sn.*,sns.staff_id from sos_notification sn inner join sos_notification_staff sns on sns.sos_notification_id = sn.id where sn.reference='" . $reference . "' and sn.added_by_user='" . sess('user_id') . "' and sns.staff_id='" . sess('user_id') . "' and sns.read_status='0' group by sn.reference_id";
            }
            return $this->db->query($query)->num_rows();
        }
    }

    public function clear_sos_notifications($sosids, $reference = '', $reference_id) {
//        echo $reference;die;
//        print_r($sosids);die;
        foreach ($sosids as $id) {
            // $fetch_values = $this->db->query("select * from `sos_notification` where id = " . $id . "")->row_array();
            // $service_id = $fetch_values['service_id'];
            // $reference_id = $fetch_values['reference_id'];
//             $this->db->query("UPDATE `sos_notification` SET `read_status` = '1' WHERE reference = '" . $reference . "' and reference_id = " . $reference_id . " and service_id = " . $service_id . "");
            $this->db->query("UPDATE `sos_notification_staff` SET `notification_read` = '1' WHERE sos_notification_id = '" . $id . "' and staff_id = " . sess('user_id') . "");
//            $this->db->query("UPDATE 'sos_notification SET post_or_reply=1 WHERE id='$id'");
//            $this->save_general_notification('action', $reference_id, 'clear');
        }
    }

    public function clear_sos($sosids, $reference = '', $reference_id) {
        foreach ($sosids as $id) {
            // $this->db->query("UPDATE `sos_notification_staff` SET `read_status` = '1' WHERE sos_notification_id = '" . $id . "' and staff_id = " . sess('user_id') . "");
            $this->db->query("UPDATE `sos_notification_staff` SET `read_status` = '1' WHERE sos_notification_id = '" . $id . "'");
        }
        $this->save_general_notification($reference, $reference_id, 'clear');
    }

    public function check_if_sos_exists($reference, $reference_id) {
        $query = "select sn.*,sns.staff_id from sos_notification sn inner join sos_notification_staff sns on sns.sos_notification_id = sn.id where sn.reference='" . $reference . "' and sn.reference_id='" . $reference_id . "' and sns.staff_id='" . sess('user_id') . "' and sns.read_status='0'";
        return $this->db->query($query)->result_array();
    }

    public function get_owner_list_by_company_id($company_id) {
        $this->db->select("ttl.id, ttl.individual_id, ttl.title, ttl.percentage, ttl.company_type,
            CONCAT(TRIM(indl.last_name), ', ',TRIM(indl.first_name)) AS name, 
            indl.first_name, indl.last_name, indl.birth_date, indl.ssn_itin, indl.type,
            indl.language AS language_id, lng.language,
            cnt.id AS country_residence_id, cnt.country_name AS country_residence_name,
            cnt2.id AS country_citizenship_id, cnt2.country_name AS country_citizenship_name");
        $this->db->from('title AS ttl');
        $this->db->join('individual AS indl', 'indl.id = ttl.individual_id', 'LEFT');
        $this->db->join('languages AS lng', 'lng.id = indl.language', 'LEFT');
        $this->db->join('countries AS cnt', 'cnt.id = indl.country_residence', 'LEFT');
        $this->db->join('countries AS cnt2', 'cnt2.id = indl.country_citizenship', 'LEFT');
        $this->db->join('internal_data AS indt', 'indt.reference="individual" and indt.reference_id=indl.id', 'LEFT');
        $this->db->where(['ttl.company_id' => $company_id, 'ttl.status' => 1, 'ttl.title!=' => '']);
        $this->db->group_by('ttl.individual_id');
        $this->db->query('SET SQL_BIG_SELECTS=1');
        return $this->db->get()->result_array();
    }

    public function change_profile_picture($imgurl) {
        $this->db->trans_begin();
        if ($imgurl != '') {
            $this->db->set(["photo" => $imgurl])->where("id", sess('user_id'))->update("staff");
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return "-1";
            } else {
                $this->db->trans_commit();
                return $imgurl;
            }
        } else {
            return "-1";
        }
    }

    public function get_profile_picture() {
        $query = "select * from staff where id='" . sess('user_id') . "'";
        $res = $this->db->query($query)->row_array();
        if ($res['photo'] != '') {
            return $res['photo'];
        } else {
            return '';
        }
    }

    public function update_profile($fname, $lname, $phno, $birth_date, $cell, $extension, $pwd) {
        $this->db->trans_begin();
        if (isset($pwd) && $pwd != '' && $pwd != '*******') {
            $this->db->set(["first_name" => $fname, "last_name" => $lname, "birth_date" => $birth_date, "phone" => $phno, "cell" => $cell, "extension" => $extension, "password" => md5($pwd)])->where("id", sess('user_id'))->update("staff");
        } else {
            $this->db->set(["first_name" => $fname, "last_name" => $lname, "birth_date" => $birth_date, "phone" => $phno, "cell" => $cell, "extension" => $extension])->where("id", sess('user_id'))->update("staff");
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function get_sos_notification_by_user_id($user_id, $limit = '') {
//        echo $user_id;die;
        $this->db->select("sn.*,ac.department, sns.read_status, DATEDIFF(CURDATE(), sn.added_on) AS how_old_days");
        $this->db->from('sos_notification AS sn');
        $this->db->join('sos_notification_staff AS sns', 'sns.sos_notification_id = sn.id');
        $this->db->join('actions AS ac', 'sn.reference_id = ac.id');
        $this->db->where(['sns.staff_id' => $user_id, 'sns.notification_read' => 0]);
//        $this->db->or_where(['sn.added_by_user' => $user_id, 'sns.read_status' => 0]);
//        $this->db->where(['sns.read_status' => 0]);
        if ($limit != '') {
            $this->db->limit($limit);
        }
        $this->db->group_by('sn.id');
        $this->db->order_by('sn.id', 'desc');
//        echo $this->db->last_query();die;
        return $this->db->get()->result_array();
    }

    public function save_general_notification($reference, $reference_id, $action, $user_id_array = [], $assign_to_user = '') {
        $tracking_status = '';
        if ($reference == 'order') {
            $order_info = $this->service_model->get_order_staff_by_order_id($reference_id);
//            print_r($order_info);die;
            $admin_staffs = $this->administration->get_department_staffs_by_id(1);
            $data_staffs = $this->administration->get_department_staffs_by_id(6);
            if (!empty($admin_staffs)) {
                $user_id_array = array_merge($user_id_array, array_column($admin_staffs, 'staff_id'));
            }
            if (!empty($data_staffs)) {
                $user_id_array = array_merge($user_id_array, array_column($data_staffs, 'staff_id'));
            }
            if ($action == 'insert' || $action == 'edit') {
                $user_id_array = array_merge($user_id_array, [$order_info['staff_requested_service']], array_column($order_info, 'all_staffs'));
            }
            if ($action == 'tracking') {
                $tracking_status = $this->tracking_status_array['order'][$order_info['status']];
            }
            $user_id_array = array_merge($user_id_array, explode(',', $order_info['all_staffs']), [$order_info['staff_requested_service']]);
            $notification_text = 'ORDER(#' . $order_info['order_serial_id'] . ')';
        }
        if ($reference == 'action') {
            if ($action != 'insert' && $action != 'sos' && $action != 'edit' && $action != 'note' && $action != 'tracking' && $action != 'assign') {
                $action_staff = $this->action_model->get_action_staff_by_action_id($reference_id);
                $action_info = $this->action_model->get_action_by_action_id($reference_id);
            } else {
                $user_id_array = array_merge($user_id_array, [sess('user_id')]);
                $action_info = $this->action_model->get_action_by_action_id($reference_id);
            }

            // if ($action == 'tracking') {
            //     $user_id_array = array_merge($user_id_array, [$action_info['added_by_user']], array_column($action_staff, 'staff_id'));
            // }
            if ($action == 'assign') {
                $user_id_array = array_merge($user_id_array, [$action_info['added_by_user']]);
            }
            if ($action == 'tracking') {
                $tracking_status = $this->tracking_status_array['action'][$action_info['status']];
            }
            if ($action == 'clear') {
                $user_id_array = array_column($action_staff, 'staff_id');
            }
            $notification_text = 'ACTION(#' . $reference_id . ')';
        }
        if ($reference == 'invoice') {
            $invoice_info = $this->db->get_where('invoice_info', ['id' => $reference_id])->row_array();
            $user_id_array[] = $invoice_info['created_by'];
            if ($action == 'insert' || $action == 'edit' || $action == 'tracking' || $action == 'note') {
                $office_staff = $this->administration->get_all_office_staff($invoice_info['created_by']);
                if (!empty($office_staff)) {
                    $user_id_array = array_merge($user_id_array, array_column($office_staff, 'staff_id'));
                }
            }
            if ($action == 'tracking') {
                $tracking_status = $this->tracking_status_array['invoice'][$invoice_info['status']];
            }
            $notification_text = 'INVOICE(#' . $reference_id . ')';
        }
        $notification_data = [];
        if ($reference != 'action' && $action != 'clear') {
            $user_id_array[] = sess('user_id');
        }

        if (!empty($user_id_array)) {
            $user_id_array = array_unique($user_id_array);
            foreach ($user_id_array as $key => $user_id) {
                $notification_data[$key]['reference'] = $reference;
                $notification_data[$key]['reference_id'] = $reference_id;
                $notification_data[$key]['action'] = $action;
                $notification_data[$key]['user_id'] = $user_id;
                $notification_data[$key]['notification_text'] = $notification_text;
                $notification_data[$key]['added_by'] = sess('user_id');
                $notification_data[$key]['assign_to_user'] = $assign_to_user;
                $notification_data[$key]['tracking_status'] = $tracking_status;
            }
        }
//        print_r($notification_data);die;
        if (!empty($notification_data)) {
            return $this->db->insert_batch('general_notifications', $notification_data);
        } else {
            return TRUE;
        }
    }

    public function get_general_notification_by_user_id($user_id, $limit = '', $where = [], $start = '', $request_type = '') {
        // For fetch all general notifications @sumanta
//        echo $request_type;die;
        $user_info = staff_info();
        $staff_office = $user_info['office'];
        $select[] = 'gn.id AS id';
        $select[] = '(CASE WHEN gn.action = "assign" THEN CONCAT((CASE WHEN gn.added_by != "' . $user_id . '" THEN (SELECT CONCAT("<strong>", `staff`.`last_name`, ", ",`staff`.`first_name`, " ", `staff`.`middle_name`, "</strong>") FROM staff WHERE id = gn.added_by) ELSE "<strong>YOU</strong> have" END), " assigned an<strong> ", gn.notification_text, " </strong>to ", (CASE WHEN gn.assign_to_user != "' . $user_id . '" THEN (SELECT CONCAT("<strong>", `staff`.`last_name`, ", ",`staff`.`first_name`, " ", `staff`.`middle_name`, "</strong>") FROM staff WHERE id = gn.assign_to_user) ELSE " <strong>YOU</strong>" END))
            WHEN gn.action = "tracking" THEN CONCAT((CASE WHEN gn.added_by != "' . $user_id . '" THEN (SELECT CONCAT("<strong>", `staff`.`last_name`, ", ",`staff`.`first_name`, " ", `staff`.`middle_name`, "</strong>") FROM staff WHERE id = gn.added_by) ELSE "<strong>YOU</strong>" END), " changed tracking of this<strong> ", gn.notification_text, "</strong> ", (CASE WHEN gn.tracking_status != "" THEN CONCAT("to ", gn.tracking_status) ELSE "" END))
            WHEN gn.action = "edit" THEN CONCAT("<strong> ", gn.notification_text, " </strong>has been edited by ", (CASE WHEN gn.added_by != "' . $user_id . '" THEN (SELECT CONCAT("<strong>", `staff`.`last_name`, ", ",`staff`.`first_name`, " ", `staff`.`middle_name`, "</strong>") FROM staff WHERE id = gn.added_by) ELSE "<strong>YOU</strong>" END))
            WHEN gn.action = "clear" THEN CONCAT((CASE WHEN gn.added_by != "' . $user_id . '" THEN (SELECT CONCAT("<strong>", `staff`.`last_name`, ", ",`staff`.`first_name`, " ", `staff`.`middle_name`, "</strong>") FROM staff WHERE id = gn.added_by) ELSE "<strong>YOU</strong>" END), " has cleared sos from<strong> ", gn.notification_text, "</strong> ")
            WHEN gn.action = "note" THEN CONCAT("<strong> ", gn.notification_text, " </strong>has been added note by ", (CASE WHEN gn.added_by != "' . $user_id . '" THEN (SELECT CONCAT("<strong>", `staff`.`last_name`, ", ",`staff`.`first_name`, " ", `staff`.`middle_name`, "</strong>") FROM staff WHERE id = gn.added_by) ELSE "<strong>YOU</strong>" END))
            WHEN gn.action = "reaches" THEN CONCAT("<strong> ", gn.notification_text, " </strong>has passed the due date ")
            WHEN gn.action = "sos" THEN CONCAT("<strong> ", gn.notification_text, " </strong>has a new SOS notification ")    
            ELSE CONCAT("New<strong> ", gn.notification_text, " </strong>has been created by ", (CASE WHEN gn.added_by != "' . $user_id . '" THEN (SELECT CONCAT("<strong>", `staff`.`last_name`, ", ",`staff`.`first_name`, " ", `staff`.`middle_name`, "</strong>") FROM staff WHERE id = gn.added_by) ELSE "<strong>YOU</strong>" END)) END) AS notification_text';
        $select[] = '(SELECT GROUP_CONCAT(`office`.`name`) AS `staff_office_name` FROM `office` WHERE `office`.`id` IN (SELECT `office_staff`.`office_id` FROM `office_staff` WHERE `office_staff`.`staff_id` = gn.added_by)) AS added_by_user_office';
        $select[] = 'gn.reference AS reference';
        $select[] = 'gn.reference_id AS reference_id';
        $select[] = 'gn.action AS action';
        $select[] = 'gn.user_id AS user_id';
        $select[] = 'gn.added_by AS added_by';
        $select[] = 'gn.assign_to_user AS assign_to_user';
        $select[] = 'gn.added_on AS added_on';
        $select[] = 'gn.read_status AS read_status';
        $select[] = 'DATEDIFF(CURDATE(), gn.added_on) AS how_old_days';
        $this->db->select(implode(', ', $select));
        $this->db->from('general_notifications AS gn');
        if ($user_info['type'] == 1 || $user_info['department'] == 14) {
            //$this->db->where(['gn.read_status' => 'n']);
            if ($request_type == 'forme') {
                $this->db->where(['gn.added_by' => $user_id, 'gn.read_status' => 'n']);
            } elseif ($request_type == 'forother') {
                $this->db->where(['gn.added_by!=' => $user_id, 'gn.read_status' => 'n', 'gn.added_by!=' => $user_id]);
            } else {
                $this->db->where(['gn.user_id' => $user_id, 'gn.read_status' => 'n']);
            }
        } elseif ($user_info['type'] == 2 && $user_info['role'] == 4 && $user_info['department'] != 14) {
            $get_dept_staffs = $this->get_dept_staffs($user_id);
            $this->db->where_in('gn.user_id', $get_dept_staffs);
            $this->db->where('gn.read_status', 'n');
        } elseif ($user_info['type'] == 3 && $user_info['role'] == 2) {
            $get_ofc_staffs = $this->get_ofc_staffs($user_id);
            $this->db->where_in('gn.user_id', $get_ofc_staffs);
            $this->db->where('gn.read_status', 'n');
        } else {
            if ($request_type == 'forme') {
                $this->db->where(['gn.user_id' => $user_id, 'gn.read_status' => 'n']);
            } elseif ($request_type == 'forother') {
                $this->db->where(['gn.user_id!=' => $user_id, 'gn.read_status' => 'n', 'gn.added_by!=' => $user_id]);
            } else {
                $this->db->where(['gn.user_id' => $user_id, 'gn.read_status' => 'n']);
            }
        }

        if (!empty($where)) {
            $this->db->where($where);
        }

        $this->db->group_by(array("gn.added_by", "gn.reference_id", "gn.reference", "gn.action"));
        $this->db->order_by('gn.id', 'DESC');
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
//        echo $this->db->last_query();die;
        return $result->result_array();
    }

    public function count_services_order($status, $cat = '') {
        $this->load->model('service_model');
        $staff_info = staff_info();
        $user_dept = $staff_info['department'];
        $userrole = $staff_info['role'];
        if ($staff_info['type'] == 1) { //admin
            $query = "select * from dashboard_count where type='order' and status='" . $status . "'";
        } elseif ($staff_info['type'] == 2) { //corporate
            if (in_array(6, explode(',', $user_dept))) {
                $query = "select * from dashboard_count where type='order' and status='" . $status . "'";
            } else {
                $condition = 'LIKE "%,' . sess('user_id') . ',%"';
                $query = "select * from dashboard_count where type='order' and (added_by_user='" . sess('user_id') . "' or all_staffs " . $condition . ") and status='" . $status . "'";
            }
        } else {
            if ($userrole != 2) {
                $query = "select * from dashboard_count where type='order' and added_by_user='" . sess('user_id') . "' and status='" . $status . "'";
            } else {
                $req_by_oth = $this->service_model->check_count_reqby_others();
                $condition = 'LIKE "%,' . sess('user_id') . ',%"';
                $query = "select * from dashboard_count where type='order' and (added_by_user='" . sess('user_id') . "' or all_staffs " . $condition . " or added_by_user IN (" . implode(',', $req_by_oth) . ")) and status='" . $status . "'";
            }
        }
        if ($cat != '') {
            $query .= " and category='" . $cat . "'";
        }
        //echo $query; exit;
        $res = $this->db->query($query)->result_array();
        if (!empty($res)) {
            $total = 0;
            foreach ($res as $r) {
                $total += $r['total'];
            }
            return $total;
        } else {
            return '0';
        }
    }

    public function count_actions($status) {
        $user_info = staff_info();
        $user_department = $user_info['department'];
        $user_type = $user_info['type'];
        $staff_id = sess('user_id');
        $role = $user_info['role'];
        $office_staff = $department_staff = $departments = $action_id = [];
        if ($user_type == 3 && $role == 2) {
            $office_staff = array_column($this->administration->get_all_office_staff_by_office_id($user_info['office_manager']), 'staff_id');
            $office_staff = array_unique($office_staff);
        }
        if ($user_type == 2 && $role == 4) {
            $departments = $this->db->get_where('department_manager', ['manager_id' => $staff_id])->result_array();
            $departments = array_column($departments, 'department_id');
            $department_staff = array_column($this->get_department_manager_staffs_by_staff_id($staff_id), 'staff_id');
            $department_staff = array_unique($department_staff);
            $action_id = $this->action_model->get_request_to_others_action_by_manager_id($staff_id);
        }

        $this->db->select('*');
        $this->db->from("dashboard_count");
        $this->db->where(['type' => 'action', 'status' => $status]);

        $where = [];
        if ($user_type == 1) {
            $this->db->where_in('my_task', [0, $staff_id]);
        } else if ($user_type == 3 && $role == 2) {
            if (!empty($office_staff)) {
                $where_or[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                $where_or[] = 'added_by_user IN (' . implode(',', $office_staff) . ')';
                $where_or[] = 'my_task = "' . $staff_id . '"';
                foreach ($office_staff as $staffID) {
                    $where_or[] = 'all_staffs LIKE "%,' . $staffID . ',%"';
                }
                $where[] = '(' . implode(' OR ', $where_or) . ')';
            } else {
                $where[] = '(all_staffs LIKE "%,' . $staff_id . ',%" OR my_task = "' . $staff_id . '")';
            }
        } else if ($user_type == 2 && $role == 4) {
            if (!empty($departments)) {
                $where_or[] = 'all_staffs LIKE "%,' . $staff_id . ',%"';
                if (!empty($department_staff)) {
                    $where_or[] = 'added_by_user IN (' . implode(',', $department_staff) . ')';
                }
                $where_or[] = 'my_task = "' . $staff_id . '"';
                $where_or[] = 'department_id IN (' . implode(',', $departments) . ')';
                $where[] = '(' . implode(' OR ', $where_or) . ')';
            } else {
                $where[] = '(all_staffs LIKE "%,' . $staff_id . ',%" OR my_task = "' . $staff_id . '")';
            }
        } else {
            $where[] = '(all_staffs LIKE "%,' . $staff_id . ',%" OR added_by_user = "' . $staff_id . '" OR my_task = "' . $staff_id . '")';
        }

        if (count($where) != 0) {
            $this->db->where(implode(' AND ', $where));
        }
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        $result = $query->result_array();
        if (!empty($result)) {
            $total = 0;
            foreach ($result as $r) {
                $total += $r['total'];
            }
            return $total;
        } else {
            return '0';
        }
    }

    public function count_invoice($status) {
        $staff_info = staff_info();
        $staffrole = $staff_info['role'];
        $staff_department = $staff_info['department'];
        $staff_office = $staff_info['office'];
        $departments = explode(',', $staff_info['department']);
        $where = $where_in = $department = [];
        if (in_array(2, $departments)) { // frinchisee
            if ($staffrole == 2) {
                $where_in = [$staff_info['office_manager']];
            } else {
                $where['added_by_user'] = sess('user_id');
            }
        }

        $where['status'] = $status;
        $where['type'] = 'invoice';
        if (count($where) != 0) {
            $this->db->where($where);
        }
        if (count($where_in) != 0) {
            $this->db->where_in('all_staffs', $where_in);
        }
        $this->db->query('SET SQL_BIG_SELECTS=1');
        $result = $this->db->get('dashboard_count')->result_array();
        if (!empty($result)) {
            $total = 0;
            foreach ($result as $r) {
                $total += $r['total'];
            }
            return $total;
        } else {
            return '0';
        }
    }

    public function count_payment($status) {
        $staff_info = staff_info();
        $staffrole = $staff_info['role'];
        $staff_department = $staff_info['department'];
        $staff_office = $staff_info['office'];
        $departments = explode(',', $staff_info['department']);
        $where = $where_in = $department = [];
        if (in_array(2, $departments)) { // frinchisee
            if ($staffrole == 2) {
                $where_in = [$staff_info['office_manager']];
            } else {
                $where['added_by_user'] = sess('user_id');
            }
        }

        $where['status'] = $status;
        $where['type'] = 'payment';
        if (count($where) != 0) {
            $this->db->where($where);
        }
        if (count($where_in) != 0) {
            $this->db->where_in('all_staffs', $where_in);
        }
        $this->db->query('SET SQL_BIG_SELECTS=1');
        $result = $this->db->get('dashboard_count')->result_array();
        if (!empty($result)) {
            $total = 0;
            foreach ($result as $r) {
                $total += $r['total'];
            }
            return $total;
        } else {
            return '0';
        }
    }

    public function read_general_notification($notification_id, $reference = '') {
        if ($reference != '') {
            $this->db->where(['id' => $notification_id, 'reference' => $reference]);
        } else {
            $this->db->where(['id' => $notification_id]);
        }
        return $this->db->update('general_notifications', ['read_status' => 'y']);
    }

    public function change_order_assigned($service_id, $staff_id) {
        if ($staff_id != 0) {
            $this->db->where(['id' => $service_id]);
            $main_order_id = $this->db->get('service_request')->row_array()['order_id'];
            $this->db->where(['order_id' => $main_order_id, 'assign_user' => 0]);
            $check_if_all_services_assigned = $this->db->get('service_request')->result_array();
            if (empty($check_if_all_services_assigned)) {
                $this->db->where(['id' => $main_order_id]);
                $this->db->update('order', ['assign_user' => '1']);
            }
        } else {
            $this->db->where(['id' => $service_id]);
            $main_order_id = $this->db->get('service_request')->row_array()['order_id'];
            $this->db->where(['id' => $main_order_id]);
            $this->db->update('order', ['assign_user' => '0']);
        }
    }

    public function get_dept_staffs($user_id) {
        $sql = "select * from department_staff where staff_id='" . $user_id . "'";
        $res = $this->db->query($sql)->result_array();
        if (!empty($res)) {
            $dept_staffs = [];
            foreach ($res as $r) {
                $sub_sql = "select * from department_staff where department_id='" . $r['department_id'] . "'";
                $result = $this->db->query($sql)->result_array();
                if (!empty($result)) {
                    foreach ($result as $rs) {
                        array_push($dept_staffs, $rs['staff_id']);
                    }
                }
            }
        }
        return implode(",", $dept_staffs);
    }

    public function get_ofc_staffs($user_id) {
        $sql = "select * from office_staff where staff_id='" . $user_id . "'";
        $res = $this->db->query($sql)->result_array();
        if (!empty($res)) {
            $ofc_staffs = [];
            foreach ($res as $r) {
                $sub_sql = "select * from office_staff where office_id='" . $r['office_id'] . "'";
                $result = $this->db->query($sql)->result_array();
                if (!empty($result)) {
                    foreach ($result as $rs) {
                        array_push($ofc_staffs, $rs['staff_id']);
                    }
                }
            }
        }
        return implode(",", $ofc_staffs);
    }

    public function get_ofc_by_id($ofc_id) {
        $sql = "select * from office where id='" . $ofc_id . "'";
        $res = $this->db->query($sql)->row_array();
        return $res;
    }

    public function get_department_name_by_id($id) {
        $sql = "select * from department where id='" . $id . "'";
        $res = $this->db->query($sql)->row_array();
        return $res['name'];
    }

    public function get_action_notifications_count($forvalue) {
//        $where['gn.action'] = 'tracking';
        $where['gn.reference'] = 'action';
        $result = $this->get_general_notification_by_user_id(sess('user_id'), '', $where, '', $forvalue);
        if (!empty($result)) {
            return count($result);
        } else {
            return 0;
        }
    }

    public function get_service_notifications_count($forvalue) {
//        $where['gn.action'] = 'tracking';
        $where['gn.reference'] = 'order';
        $result = $this->get_general_notification_by_user_id(sess('user_id'), '', $where, '', $forvalue);
        if (!empty($result)) {
            return count($result);
        } else {
            return 0;
        }
    }

    public function get_action_sos_added_user($reference, $reference_id, $userid) {
        $data = $this->db->query("SELECT CONCAT(staff.last_name, ', ',staff.first_name,' ',staff.middle_name) as full_name FROM staff WHERE id='$userid'")->row();
        return $data->full_name;
    }

    public function get_project_notifications_count() {
        $where['gn.action'] = 'tracking';
        $where['gn.reference'] = 'projects';
        $result = $this->get_general_notification_by_user_id(sess('user_id'), '', $where);
        if (!empty($result)) {
            return count($result);
        } else {
            return 0;
        }
    }

    public function clear_notification_list($userid, $type, $reference = '') {
        if ($type == 'sos') {
//        $this->db->query("UPDATE `sos_notification_staff` JOIN sos_notification ON(sos_notification.id=sos_notification_staff.sos_notification_id) SET `read_status` = '1' WHERE sos_notification_staff.staff_id = " . sess('user_id') . " and sos_notification.reference IN "."('action','order')");
            $this->db->query("UPDATE `sos_notification_staff` SET `read_status` = '1' WHERE staff_id = " . sess('user_id') . "");
        } elseif ($type == 'notification') {
            if ($reference != '') {
                $this->db->query("UPDATE general_notifications SET read_status='y' WHERE user_id='$userid' AND reference='$reference'");
            } else {
                $this->db->query("UPDATE general_notifications SET read_status='y' WHERE user_id='$userid'");
            }
        }
    }

    public function get_user_logo($id) {
        $data = $this->db->get_where('office', array('id' => $id))->row_array();
        return $data['photo'];
    }

    public function get_office_id($id) {
        $data = $this->db->get_where('office', array('id' => $id))->row_array();
        return $data['office_id'];
    }

    public function task_created_by_staff($task_id) {
        $result = $this->db->get_where('project_task', ['id' => $task_id])->row_array();
        return $result['added_by_user'];
    }

    public function generete_practice_id($reference_id, $reference) {
        if ($reference == 'company') {
            $company_info = $this->company_model->get_company_by_id($reference_id);
            $client_name = $company_info['name'];
        } else {
            $individual_info = $this->individual->get_individual_by_id($reference_id);
            $client_name = $individual_info['last_name'] . $individual_info['first_name'];
        }
        $company_name = str_replace(' ', '',$client_name);
        $c = preg_replace("/[^a-zA-Z0-9]/", "",$company_name);
        return strtoupper(substr($c, 0, 11));
    }

}
