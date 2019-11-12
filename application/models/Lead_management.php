<?php

Class Lead_management extends CI_Model {

    private $lead_select;
    private $filter_element;
    private $filter_element_partner;

    public function __construct() {
        parent::__construct();
        $this->load->model("notes");
        $this->load->model("administration");
        $this->load->model('System');
        $this->load->model('action_model');
        $this->lead_select[] = 'lm.id AS id';
        $this->lead_select[] = 'lm.office AS office';
        $this->lead_select[] = 'lm.type AS type';
        $this->lead_select[] = 'lm.type_of_contact AS type_of_contact';
        $this->lead_select[] = 'lm.language AS language';
        $this->lead_select[] = '(CASE WHEN lm.type = \'1\' THEN (SELECT name FROM type_of_contact_prospect WHERE id = lm.type_of_contact) ELSE (SELECT name FROM type_of_contact_referral WHERE id = lm.type_of_contact) END) AS contact_type_name';
        $this->lead_select[] = 'CONCAT(lm.last_name, \', \', lm.first_name) AS full_name';
        $this->lead_select[] = 'lm.first_name AS first_name';
        $this->lead_select[] = '(CASE WHEN lm.status = 0 THEN \'New\' WHEN lm.status = 1 THEN \'Complete\' WHEN lm.status = 2 THEN \'Inactive\' WHEN lm.status = 3 THEN \'Active\' ELSE \'Unknown\' END) AS status_name';
        $this->lead_select[] = 'lm.status AS status';
        $this->lead_select[] = 'lm.submission_date AS submission_date';
        $this->lead_select[] = 'lm.active_date AS active_date';
        $this->lead_select[] = 'lm.inactive_date AS inactive_date';
        $this->lead_select[] = 'lm.complete_date AS complete_date';
        $this->lead_select[] = 'lm.assigned_status AS assigned_status';
        $this->lead_select[] = 'lm.lead_source_detail AS lead_source_detail';
        $this->lead_select[] = '(SELECT CONCAT(staff.last_name, \', \',staff.first_name, \' \', staff.middle_name) FROM staff WHERE id = lm.staff_requested_by) AS requested_staff_name';
        $this->lead_select[] = '(SELECT id FROM staff WHERE id = lm.staff_requested_by) AS requested_staff_id';
        $this->lead_select[] = '(SELECT office_id from office WHERE id = (SELECT office_id FROM office_staff WHERE staff_id = lm.staff_requested_by limit 0,1)) AS request_staff_office_name';
        $this->lead_select[] = '(SELECT COUNT(ln.id) FROM lead_notes AS ln WHERE ln.lead_id = lm.id) AS notes_count';
        $this->lead_select[] = 'lm.day_0_mail_date AS day_0_mail_date';
        $this->lead_select[] = 'lm.day_3_mail_date AS day_3_mail_date';
        $this->lead_select[] = 'lm.day_6_mail_date AS day_6_mail_date';
        $this->filter_element = [
            "type" => "type_of_contact",
            "tracking" => "status",
            "office" => "office",
            "staff" => "staff_requested_by",
            "active_date" => "active_date",
            "complete_date" => "complete_date"
        ];
        $this->filter_element_partner = [
            "type" => "type_of_contact",
            "tracking" => "status",
            "requested_by" => "staff_requested_by",
            "requested_to" => "rl.referred_to",
            "submission_date" => "submission_date"
        ];
    }

    public function get_lead_types() {
        return $this->db->get("type_of_contact_prospect")->result_array();
    }

    public function get_added_by_user_by_lead_id($lead_id) {
        return $this->db->get_where("lead_management", ['id' => $lead_id])->row_array()['staff_requested_by'];
    }

    public function get_lead_referral() {
        return $this->db->get("type_of_contact_referral")->result_array();
    }

    public function get_lead_sources() {
        return $this->db->get("lead_prospect")->result_array();
    }

    public function get_lead_type_name_by_id($id) {
        return $this->db->get_where("type_of_contact_prospect", ['id' => $id])->row_array();
    }

    public function check_if_type_exists($lead_type_name, $id = null) {
        $sql = "select * from type_of_contact_prospect where name = '$lead_type_name'";
        if ($id != null) {
            $sql .= ' AND id!=' . $id;
        }
        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function get_type_of_contact_by_id($id) {
        return $this->db->get_where("lead_type", ['id' => $id])->row_array();
    }
    public function get_type_of_contact_prospect($id) {
        return $this->db->get_where("type_of_contact_prospect", ['id' => $id])->row_array();
    }
    public function get_type_of_contact_referral_by_id($id) {
        return $this->db->get_where("type_of_contact_referral", ['id' => $id])->row_array();
    }

    public function view_leads_record($id) {
        return $this->db->get_where("lead_management", ['id' => $id])->row_array();
    }

    public function get_state_by_id($id) {
        return $this->db->get_where("states", ['id' => $id])->row_array();
    }

    public function get_notes_by_lead_id($lead_id) {
        return $this->db->get_where("lead_notes", ['lead_id' => $lead_id])->result_array();
    }

    public function add_lead_type($lead_type_name) {
        return $this->db->insert('type_of_contact_prospect', ["name" => $lead_type_name]);
    }

    public function update_lead_type($lead_type_name, $type_id) {
        return $this->db->set(["name" => $lead_type_name])->where("id", $type_id)->update("type_of_contact_prospect");
    }

    public function delete_lead_type($type_id) {
        return $this->db->where("id", $type_id)->delete("type_of_contact_prospect");
    }

    public function get_lead_ref_name_by_id($id) {
        return $this->db->get_where("type_of_contact_referral", ['id' => $id])->row_array();
    }

    public function check_if_ref_exists($ref_name, $id = null) {
        $sql = "select * from type_of_contact_referral where name = '$ref_name'";
        if ($id != null) {
            $sql .= ' AND id!=' . $id;
        }
        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function add_ref_type($ref_name) {
        return $this->db->insert('type_of_contact_referral', ["name" => $ref_name]);
    }

    public function update_ref_type($ref_name, $id) {
        return $this->db->set(["name" => $ref_name])->where("id", $id)->update("type_of_contact_referral");
    }

    public function delete_ref_type($id) {
        return $this->db->where("id", $id)->delete("type_of_contact_referral");
    }

    public function get_lead_source_by_id($id) {
        return $this->db->get_where("lead_prospect", ['id' => $id])->row_array();
    }

    public function get_language_by_id($id) {
        return $this->db->get_where("languages", ['id' => $id])->row_array();
    }

    public function check_if_lead_source_exists($source_name, $id = null) {
        $sql = "select * from lead_prospect where name = '$source_name'";
        if ($id != null) {
            $sql .= ' AND id!=' . $id;
        }
        $data = $this->db->query($sql)->num_rows();
        return $data;
    }

    public function add_lead_source($source_name) {
        return $this->db->insert('lead_prospect', ["name" => $source_name]);
    }

    public function update_lead_source($source_name, $id) {
        return $this->db->set(["name" => $source_name])->where("id", $id)->update("lead_prospect");
    }

    public function delete_lead_source($id) {
        return $this->db->where("id", $id)->delete("lead_prospect");
    }

    public function get_lead_agents() {
        return $this->db->where(["type" => "2", "status" => "1"])->get("lead_management")->result_array();
    }

    public function get_client_name($id) {
        return $this->db->where(["type" => "2", "id" => $id])->get("lead_management")->row();
    }

    public function get_clients() {
        $staff_info = staff_info();
        $sql = "SELECT o.*,c.*,o.id AS id "
                . "FROM `order` o "
                . "INNER JOIN company c ON c.id = o.reference_id ";
        if ($staff_info['type'] == 3) {
            $sql .= "INNER JOIN internal_data ind ON c.id = ind.reference_id WHERE ind.office IN (" . $staff_info['office'] . ")";
        }
        $sql .= "GROUP BY c.name ORDER BY c.name";
        $this->db->query('SET SQL_BIG_SELECTS=1');
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function duplicate_email_check($email,$lead_type) {
        
        $this->db->where('email',$email);
        $this->db->group_start();
            $this->db->where('type',3);
            $this->db->or_where('type',2);
        $this->db->group_end();
        $check = $this->db->get("lead_management")->num_rows();

        if ($lead_type != 1) {
            if ($check != 0) {
                return true;
            } else {
                $check_staff = $this->db->get_where("staff", ['user' => $email])->num_rows();
                if ($check_staff != 0) {
                    return true;
                } else {
                    return false;
                }
            }    
        } else {
            return false;
        }
    }

    public function get_leads_referred_by_to_him($status = "", $request = "", $filter_data = []) {
        $staff_info = staff_info();
        $user_id = sess('user_id');

        $this->db->select("lm.*,rl.*");
        $this->db->from('lead_management lm');
        $this->db->join('referred_lead rl', 'rl.lead_id = lm.id');
        if ($request == 'byother') {
            $this->db->join('staff s', 's.id = rl.referred_by');
        } elseif ($request == 'toother') {
            $this->db->join('staff s', 's.id = rl.referred_to');
        }

        if ($staff_info['type'] != 1) {
            $this->db->group_start();
            if ($request == 'byme') {
                $this->db->where('rl.referred_by', $user_id);
                if ($status == 0) { //new
                    $this->db->where("lm.status", $status);
                } elseif ($status == 1) { // completed
                    $this->db->where("lm.status", $status);
                } elseif ($status == 2) { // inactive
                    $this->db->where("lm.status", $status);
                } elseif ($status == 3) { // active
                    $this->db->where("lm.status", $status);
                }
            } elseif ($request == 'tome') {
                $this->db->where('rl.referred_to', $user_id);
                if ($status == 0) { //new
                    $this->db->where("lm.status", $status);
                } elseif ($status == 1) { // completed
                    $this->db->where("lm.status", $status);
                } elseif ($status == 2) { // inactive
                    $this->db->where("lm.status", $status);
                } elseif ($status == 3) { // active
                    $this->db->where("lm.status", $status);
                }
            } else {
                $this->db->where('rl.referred_by', $user_id);
                $this->db->or_where('rl.referred_to', $user_id);
            }
            $this->db->group_end();
        } else {
            $this->db->group_start();
            if ($request == 'byme') {
                $this->db->where('rl.referred_by', $user_id);
                if ($status == 0) { //new
                    $this->db->where("lm.status", $status);
                } elseif ($status == 1) { // completed
                    $this->db->where("lm.status", $status);
                } elseif ($status == 2) { // inactive
                    $this->db->where("lm.status", $status);
                } elseif ($status == 3) { // active
                    $this->db->where("lm.status", $status);
                }
            } elseif ($request == 'tome') {
                $this->db->where('rl.referred_to', $user_id);
                if ($status == 0) { //new
                    $this->db->where("lm.status", $status);
                } elseif ($status == 1) { // completed
                    $this->db->where("lm.status", $status);
                } elseif ($status == 2) { // inactive
                    $this->db->where("lm.status", $status);
                } elseif ($status == 3) { // active
                    $this->db->where("lm.status", $status);
                }
            } elseif ($request == 'byother') {
                $this->db->where('rl.referred_by!=', $user_id);
                $this->db->where('s.type!=', '4');

                if ($status == 0) { //new
                    $this->db->where("lm.status", $status);
                } elseif ($status == 1) { // completed
                    $this->db->where("lm.status", $status);
                } elseif ($status == 2) { // inactive
                    $this->db->where("lm.status", $status);
                } elseif ($status == 3) { // active
                    $this->db->where("lm.status", $status);
                }
            } elseif ($request == 'toother') {
                $this->db->where('rl.referred_to!=', $user_id);
                $this->db->where('s.type!=', '4');

                if ($status == 0) { //new
                    $this->db->where("lm.status", $status);
                } elseif ($status == 1) { // completed
                    $this->db->where("lm.status", $status);
                } elseif ($status == 2) { // inactive
                    $this->db->where("lm.status", $status);
                } elseif ($status == 3) { // active
                    $this->db->where("lm.status", $status);
                }
            } else {
                $this->db->where("lm.referred_status!=", '2');
                $this->db->where("lm.type", '1');
            }
            $this->db->group_end();
        }
        // filter
        $filter_where_in = [];
        $between = '';
        if (!empty($filter_data)) {
            if (isset($filter_data['criteria_dropdown'])) {
                foreach ($filter_data['criteria_dropdown'] as $filter_key => $filter) {
                    $filter_key = trim($filter_key);
                    if ($filter_key == "submission_date") {
                        if (strlen($filter[0]) == 10) {
                            $date_value = date("Y-m-d", strtotime($filter[0]));
                            $filter_where_in[$this->filter_element_partner[$filter_key]][] = $date_value;
                        } elseif (strlen($filter[0]) == 23) {
                            $date_value = explode(" - ", $filter[0]);
                            foreach ($date_value as $date_key => $date) {
                                $date_value[$date_key] = "'" . date("Y-m-d", strtotime($date)) . "'";
                            }
                            $between = 'Date(' . $this->filter_element_partner[$filter_key] . ') BETWEEN ' . implode(' AND ', $date_value);
                        }
                    } else {
                        foreach ($filter as $key => $filter_value) {
                            if ($filter_value != '') {
                                $filter_where_in[$this->filter_element_partner[$filter_key]][] = $filter_value;
                            }
                        }
                    }
                }
            }
        }

        if (!empty($filter_where_in)) {
            foreach ($filter_where_in as $column => $in) {
                $this->db->where_in($column, $in);
            }
        }

        if ($between != '') {
            $this->db->where($between);
        }

        $this->db->group_by('lm.id');
        return $this->db->get()->result_array();
    }

    public function get_ref_partner_id($lead_id) {
        $email = $this->db->get_where("lead_management", ['id' => $lead_id])->row_array()['email'];
        $staff = $this->db->get_where("staff", ['user' => $email])->row_array();
        if (!empty($staff)) {
            return $staff['id'];
        } else {
            return 0;
        }
    }

    public function insert_lead_prospect($data) {
//         print_r($data);die;
        unset($data['event_id']);
        if (isset($data["lead_notes"])) {
            $lead_notes = $data["lead_notes"];
            unset($data["lead_notes"]);
        }

        if (isset($data["added_by"])) {
            $added_by = $data["added_by"];
            unset($data["added_by"]);
        } else {
            $added_by = '';
        }

        if (isset($data["refer_lead"]) && $data["refer_lead"] != '') {
            $referred_lead=$data["refer_lead"];
            unset($data["refer_lead"]);
        } else {
            $referred_lead = '';
        }
        if (isset($data["sender_email"])) {
            unset($data["sender_email"]);
        }
        if (isset($data['ref_partner_id'])) {
            $ref_partner_id = $data["ref_partner_id"];
            unset($data["ref_partner_id"]);
        } else {
            $ref_partner_id = '';
        }

        if ($data['referred_status'] == '') {
            $data['referred_status'] = '2';
        } elseif ($data['referred_status'] == 'partnertolead') {
            $data['referred_status'] = '0';
        }

        if ($data['lead_source'] == 5) {
            $data['lead_agent'] = $data['lead_agent'];
        }
//        elseif ($data['lead_source'] == 7) {
//            $data['lead_agent'] = $data['lead_client'];
//        } elseif ($data['lead_source'] == 6) {
//            $data['lead_agent'] = $data['lead_client_other'];
//        } else {
//            $data['lead_agent'] = '';
//        }
//        unset($data['lead_client']);
//        unset($data['lead_client_other']);
//        if ($data['lead_source'] == 1) {
//            if (isset($data['lead_networking']) && $data['lead_networking'] != '') {
//                $data['lead_networking'] = $data['lead_networking'];
//            } else {
//                $data['lead_networking'] = '';
//            }
//        } else {
//            $data['lead_networking'] = "";
//        }
        $dofc_array = explode('/', $data['date_of_first_contact']);
        $data['date_of_first_contact'] = $dofc_array[2] . '-' . $dofc_array[0] . '-' . $dofc_array[1];

        if ($data['partner_section'] != '') {
            $status = 1;
        } else {
            if (isset($data['mail_campaign_status'])) {
                if ($data['mail_campaign_status'] == 1) {
                    $status = 3;
                } else {
                    $status = 0;
                }
            } else {
                $status = 0;
            }
        }

        if (isset($data['lead_staff']) && $data['lead_staff'] == '') {
            unset($data["lead_staff"]);
        }

        if (isset($data['fromval'])) {
            $fromval = $data['fromval'];
        }

        if (isset($data['partner_creator'])) {
            $partner_creator = $data['partner_creator'];
        }
        if (isset($data['lead_type'])) {
            if ($data['lead_type'] == '1') {
                $data['type'] = '1';
            } elseif ($data['lead_type'] == '2') {
                $data['type'] = '3';
            }
        }
        unset($data['lead_type']);
        unset($data["partner_section"]);
        unset($data["partner_creator"]);
        unset($data["fromval"]);
        $lead_management = $data;
        $lead_management = array_merge($lead_management, ["staff_requested_by" => $this->session->userdata("user_id"), "status" => $status, "submission_date" => date('Y-m-d')]);
//        print_r($lead_management);die;
        $this->db->trans_begin();
        $this->db->insert('lead_management', $lead_management);
        $id = $this->db->insert_id();
        if (isset($fromval) && $fromval == 'staff_section') {
            $in_data = array('referred_by' => sess('user_id'), 'lead_id' => $id, 'referred_to' => $ref_partner_id);
            $this->db->insert('referred_lead', $in_data);
        } elseif (isset($fromval) && $fromval == 'partner_section') {
            $in_data = array('referred_by' => sess('user_id'), 'lead_id' => $id, 'referred_to' => $partner_creator);
            $this->db->insert('referred_lead', $in_data);
        }
        if ($added_by != '') {
            $userinfo = staff_info();
            $user_email = $userinfo['user'];
            $query = $this->db->query('select * from lead_management where email="' . $user_email . '"')->row_array();
            $sql = "insert into `referral_partner` (id,partner_id,assigned_by_usertype,assisned_by_userid,  assigned_clienttype,assigned_clientid,assigned_to_clienttype, assigned_to_clientid, status) 
				values 
				('','" . $id . "','" . $userinfo['type'] . "','" . $userinfo['id'] . "', '2', '" . $query['staff_requested_by'] . "', 0 ,0, '1')";
            $this->db->query($sql);
        }

        if (!empty($lead_notes)) {
            $this->notes->insert_note(3, $lead_notes, "lead_id", $id);
        }
        $lead_type = $lead_management['type'];
        if ($lead_type == 1 || $lead_type == 3) {
            $reference = 'lead';
        }if ($lead_type == 2) {
            $reference = 'partner';
        }
        $staff[0] = sess('user_id');
        $this->system->save_general_notification($reference, $id, 'insert', $staff, '', $lead_type);
        if ($referred_lead != '') {
            unset($staff);
            $staff=array();
            $this->system->save_general_notification($reference, $id, 'refer', $staff, '', $lead_type);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return $id;
        }
    }

    public function get_lead_list($lead_type, $status, $request_by = "", $lead_contact_type = "", $filter_data = [], $is_partner = "", $sort_criteria = '', $sort_type = '', $event_id = '') {
        $staff_info = staff_info();
        $user_department = $staff_info['department'];
        $staff_id = sess('user_id');
        $department_staff = $office_staff = [];
        if ($staff_info['type'] == 3 && $staff_info['role'] == 2) {
            $office_staff = array_column($this->administration->get_all_office_staff($staff_info['id']), 'staff_id');
            $office_staff = array_unique($office_staff);
        }
        if ($staff_info['type'] == 2 && $staff_info['role'] == 4) {
            if ($user_department != '14') {
                $dept_ids = $this->db->get_where('department_staff', ['staff_id' => $staff_id])->result_array();
                $this->db->where_in('department_id', array_column($dept_ids, 'department_id'));
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');
                $department_staff = array_unique($department_staff);
            }
        }

        $select = implode(', ', $this->lead_select);
        $this->db->select($select);
        $this->db->from('lead_management AS lm');
        if ($request_by == "") {
            if ($staff_info['type'] == 2) {
                if ($user_department != '14') {
                    $this->db->where(['lm.staff_requested_by' => sess('user_id')]);
                    if (!empty($department_staff)) {
                        $this->db->where_in('lm.staff_requested_by', $department_staff);
                    }
                }
            }
            if ($staff_info['type'] == 3) {
                $this->db->where(['lm.staff_requested_by' => sess('user_id')]);
                if (!empty($office_staff)) {
                    $this->db->where_in('lm.staff_requested_by', $office_staff);
                }
            }
        } else {
            $this->db->where(['lm.staff_requested_by' => $request_by]);
        }
        if ($status != '') {
            if ($status == 4) {
                $this->db->where_in('lm.status', [0, 3]);
            } else {
                $this->db->where(['lm.status' => $status]);
            }
        }
        if ($lead_contact_type != '') {
            $this->db->where(['lm.type_of_contact' => $lead_contact_type]);
        }
        if ($event_id != '') {
            $this->db->where(['lm.event_id' => $event_id]);
        }
        if ($lead_type != '') {
            if ($lead_type == '1') {
                $this->db->group_start();
                $this->db->group_start();
                $this->db->where(['lm.type' => $lead_type]);
                $this->db->or_where(['lm.type' => '3']);
                $this->db->group_end();

                $this->db->or_group_start();
                $this->db->where(['lm.type' => '2']);
                $this->db->where(['lm.assigned_status' => 'y']);
                $this->db->group_end();
                $this->db->group_end();
            } else {
                $this->db->group_start();
                $this->db->where(['lm.type' => $lead_type]);
                $this->db->or_where(['lm.type' => '3']);
                $this->db->group_end();
            }
        } else {
            $this->db->group_start();
            $this->db->where(['lm.type' => '1']);
            $this->db->or_where(['lm.type' => '3']);
            $this->db->group_end();
        }
        $filter_where_in = [];
        $between = '';
        if (!empty($filter_data)) {
            if (isset($filter_data['criteria_dropdown'])) {
                foreach ($filter_data['criteria_dropdown'] as $filter_key => $filter) {
                    $filter_key = trim($filter_key);
                    if ($filter_key == "active_date" || $filter_key == "complete_date") {
                        if (strlen($filter[0]) == 10) {
                            $date_value = date("Y-m-d", strtotime($filter[0]));
                            // echo $date_value;
                            $filter_where_in[$this->filter_element[$filter_key]][] = $date_value;
                            // print_r($filter_where_in);
                        } elseif (strlen($filter[0]) == 23) {
                            $date_value = explode(" - ", $filter[0]);
                            foreach ($date_value as $date_key => $date) {
                                $date_value[$date_key] = "'" . date("Y-m-d", strtotime($date)) . "'";
                            }
                            $between = 'Date(' . $this->filter_element[$filter_key] . ') BETWEEN ' . implode(' AND ', $date_value);
                        }
                    } else {
                        foreach ($filter as $key => $filter_value) {
                            if ($filter_value != '') {
                                $filter_where_in[$this->filter_element[$filter_key]][] = $filter_value;
                            }
                        }
                    }
                }
            }
        }

        if (!empty($filter_where_in)) {
            foreach ($filter_where_in as $column => $in) {
                $this->db->where_in($column, $in);
            }
        }

        if ($between != '') {
            $this->db->where($between);
        }
        // $this->db->where(['lm.import_status' => 1]); // removed due to count mismatch issue on 12.11.2019        
        if ($is_partner == 1) {
            $this->db->where(['lm.referred_status' => 1]);
        }
        if ($sort_criteria != '') {
//            echo $sort_criteria.', '.$sort_type;die;
            $this->db->order_by($sort_criteria, $sort_type);
        } else {
            $this->db->order_by("lm.id", "DESC");
        }

        $result = $this->db->get()->result_array();
//        echo $this->db->last_query();die;
        return $result;
    }

    public function load_all_data($type, $status, $req_by = "", $lead_type = "") {
        $user_details = staff_info();
        $usertype = $user_details['type'];
        $userid = $user_details['id'];
        if ($type == '' && $status == '') {
            $sql = "SELECT lm.id, lm.office, lm.type as lead_type, lm.type_of_contact as type_of_contact, lm.language as language, (case when lm.type = '1' then (select name from type_of_contact_prospect where id = lm.type_of_contact) else (select name from type_of_contact_referral where id = lm.type_of_contact) end) as type, concat(lm.last_name, ', ', lm.first_name) as name, lm.first_name AS first_name, (case when lm.status = '0' then 'New' when lm.status = '1' then 'Complete' when lm.status = '2' then 'Inactive' when lm.status = '3' then 'Active' else 'Unknown' end) as status, concat(s.last_name, ', ', s.first_name, ' ', s.middle_name) as requested_by, lm.submission_date, lm.active_date, lm.inactive_date, lm.complete_date, (select count(ln.id) from lead_notes as ln where ln.lead_id = lm.id) as notes from lead_management as lm inner join staff as s on s.id = lm.staff_requested_by";
            if ($req_by == "") {
                if ($usertype == 2) {
                    $sql .= " where lm.staff_requested_by='" . $userid . "'";
                } elseif ($usertype == 3) {
                    if ($user_details['role'] == 1) {
                        $sql .= " where lm.staff_requested_by='" . $userid . "'";
                    } else {

                        $fran_ofc = $user_details['office'];
                        $ofc_staffs = $this->db->query("select * from office_staff where office_id='" . $fran_ofc . "'")->result_array();
                        if (!empty($ofc_staffs)) {
                            $i = 0;
                            $len = count($ofc_staffs);
                            $staff_array = '';
                            foreach ($ofc_staffs as $os) {
                                if ($i == $len - 1) {
                                    $staff_array .= $os['staff_id'];
                                } else {
                                    $staff_array .= $os['staff_id'] . ',';
                                }
                                $i++;
                            }

                            $staff_array_val = explode(",", $staff_array);
                            $j = 0;
                            $lenj = count($staff_array_val);
                            if ($lenj > 1) {
                                foreach ($staff_array_val as $val) {
                                    if ($j == 0) {
                                        $sql .= " where (lm.staff_requested_by='" . $val . "'";
                                    } elseif ($j == $lenj - 1) {
                                        $sql .= " or lm.staff_requested_by='" . $val . "')";
                                    } else {
                                        $sql .= " or lm.staff_requested_by='" . $val . "'";
                                    }
                                    $j++;
                                }
                            } else {
                                foreach ($staff_array_val as $val) {
                                    $sql .= " where lm.staff_requested_by='" . $val . "'";
                                    $j++;
                                }
                            }
                        }
                    }
                }
            } else {
                $sql .= " where lm.staff_requested_by='" . $req_by . "'";
            }
        } elseif ($type == 'bullets' && $status != '') {
            $sql = "SELECT lm.id, lm.office, lm.type as lead_type, lm.type_of_contact as type_of_contact, lm.language as language, (case when lm.type = '1' then (select name from type_of_contact_prospect where id = lm.type_of_contact) else (select name from type_of_contact_referral where id = lm.type_of_contact) end) as type,concat(lm.last_name, ', ', lm.first_name) as name, lm.first_name AS first_name, (case when lm.status = '0' then 'New' when lm.status = '1' then 'Complete' when lm.status = '2' then 'Inactive' when lm.status = '3' then 'Active' else 'Unknown' end) as status, concat(s.last_name, ', ', s.first_name, ' ', s.middle_name) as requested_by, lm.submission_date, lm.active_date, lm.inactive_date, lm.complete_date, (select count(ln.id) from lead_notes as ln where ln.lead_id = lm.id) as notes from lead_management as lm inner join staff as s on s.id = lm.staff_requested_by";
            if ($status == 4) {
                $sql .= " where (lm.status = '0' or lm.status = '3')";
            } else {
                if ($status != '') {
                    $sql .= " where lm.status = '$status'";
                }
            }
            if ($req_by == "") {
                if ($usertype == 2) {
                    $sql .= " and lm.staff_requested_by='" . $userid . "'";
                } elseif ($usertype == 3) {
                    if ($user_details['role'] == 1) {
                        $sql .= " and lm.staff_requested_by='" . $userid . "'";
                    } else {

                        $fran_ofc = $user_details['office'];
                        $ofc_staffs = $this->db->query("select * from office_staff where office_id='" . $fran_ofc . "'")->result_array();
                        if (!empty($ofc_staffs)) {
                            $i = 0;
                            $len = count($ofc_staffs);
                            $staff_array = '';
                            foreach ($ofc_staffs as $os) {
                                if ($i == $len - 1) {
                                    $staff_array .= $os['staff_id'];
                                } else {
                                    $staff_array .= $os['staff_id'] . ',';
                                }
                                $i++;
                            }

                            $staff_array_val = explode(",", $staff_array);
                            $j = 0;
                            $lenj = count($staff_array_val);
                            if ($lenj > 1) {
                                foreach ($staff_array_val as $val) {
                                    if ($j == 0) {
                                        $sql .= " and (lm.staff_requested_by='" . $val . "'";
                                    } elseif ($j == $lenj - 1) {
                                        $sql .= " or lm.staff_requested_by='" . $val . "')";
                                    } else {
                                        $sql .= " or lm.staff_requested_by='" . $val . "'";
                                    }
                                    $j++;
                                }
                            } else {
                                foreach ($staff_array_val as $val) {
                                    $sql .= " and lm.staff_requested_by='" . $val . "'";
                                    $j++;
                                }
                            }
                        }
                    }
                }
            } else {
                $sql .= " and lm.staff_requested_by='" . $req_by . "'";
            }
            //echo $sql;
        } else {
            $sql = "SELECT lm.id, lm.office, lm.type as lead_type, lm.type_of_contact as type_of_contact, lm.language as language, (case when lm.type = '1' then (select name from type_of_contact_prospect where id = lm.type_of_contact) else (select name from type_of_contact_referral where id = lm.type_of_contact) end) as type,concat(lm.last_name, ', ', lm.first_name) as name, lm.first_name AS first_name, (case when lm.status = '0' then 'New' when lm.status = '1' then 'Complete' when lm.status = '2' then 'Inactive' when lm.status = '3' then 'Active' else 'Unknown' end) as status, concat(s.last_name, ', ', s.first_name, ' ', s.middle_name) as requested_by, lm.submission_date, lm.active_date, lm.inactive_date, lm.complete_date, (select count(ln.id) from lead_notes as ln where ln.lead_id = lm.id) as notes from lead_management as lm inner join staff as s on s.id = lm.staff_requested_by where lm.type = '$type'";
            if ($status != '') {
                $sql .= " and lm.status = '" . $status . "'";
            }

            if ($req_by == "") {
                if ($usertype == 2) {
                    $sql .= " and lm.staff_requested_by='" . $userid . "'";
                } elseif ($usertype == 3) {
                    if ($user_details['role'] == 1) {
                        $sql .= " and lm.staff_requested_by='" . $userid . "'";
                    } else {
                        $fran_ofc = $user_details['office'];
                        $ofc_staffs = $this->db->query("select * from office_staff where office_id='" . $fran_ofc . "'")->result_array();
                        if (!empty($ofc_staffs)) {
                            $i = 0;
                            $len = count($ofc_staffs);
                            $staff_array = '';
                            foreach ($ofc_staffs as $os) {
                                if ($i == $len - 1) {
                                    $staff_array .= $os['staff_id'];
                                } else {
                                    $staff_array .= $os['staff_id'] . ',';
                                }
                                $i++;
                            }

                            $staff_array_val = explode(",", $staff_array);
                            $j = 0;
                            $lenj = count($staff_array_val);
                            if ($lenj > 1) {
                                foreach ($staff_array_val as $val) {
                                    if ($j == 0) {
                                        $sql .= " and (lm.staff_requested_by='" . $val . "'";
                                    } elseif ($j == $lenj - 1) {
                                        $sql .= " or lm.staff_requested_by='" . $val . "')";
                                    } else {
                                        $sql .= " or lm.staff_requested_by='" . $val . "'";
                                    }
                                    $j++;
                                }
                            } else {
                                foreach ($staff_array_val as $val) {
                                    $sql .= " and lm.staff_requested_by='" . $val . "'";
                                    $j++;
                                }
                            }
                        }
                    }
                }
            } else {
                $sql .= " and lm.staff_requested_by='" . $req_by . "'";
            }
            //echo $sql;
        }
        if ($lead_type != '') {
            $sql .= (stripos($sql, "where") ? ' AND ' : ' WHERE ') . 'type_of_contact = "' . $lead_type . '"';
        }
        return $this->db->query($sql)->result_array();
    }

    public function get_lead_notes($id) {
        return $this->db->where("lead_id", $id)->get("lead_notes")->result_array();
    }

    public function get_current_status($table_name, $id) {
        return $this->db->query("select status from $table_name where id = '$id'")->row_array()["status"];
    }

    public function get_tracking_log($id, $table_name) {
        return $this->db->query("SELECT concat(s.last_name, ', ', s.first_name, ' ', s.middle_name) as stuff_id,s.id, s.department as department, case when tracking_logs.status_value = '0' then 'New' when tracking_logs.status_value = '1' then 'Completed' when tracking_logs.status_value = '2' then 'Inactive' when tracking_logs.status_value = '3' then 'Active' else 'Unknown' end as status, date_format(tracking_logs.created_time, '%m/%d/%Y - %r') as created_time FROM `tracking_logs` inner join staff as s on tracking_logs.stuff_id = s.id where tracking_logs.section_id = '$id' and tracking_logs.related_table_name = '$table_name' order by tracking_logs.id desc")->result_array();
    }

    public function update_lead_status($id, $status) {
        $this->db->trans_begin();
        $this->db->insert("tracking_logs", ["stuff_id" => $this->session->userdata("user_id"), "status_value" => $status, "section_id" => $id, "related_table_name" => "lead_management"]);
        $data = ["status" => $status];
        switch ($status) {
            case "0":
                $data["submission_date"] = date('Y-m-d');
                break;
            case "1":
                $data["complete_date"] = date('Y-m-d');
                break;
            case "2":
                $data["inactive_date"] = date('Y-m-d');
                break;
            case "3":
                $data["active_date"] = date('Y-m-d');
                $data["mail_campaign_status"] = '1';
                break;
        }

        $this->db->where("id", $id)->update("lead_management", $data);

        if ($status == 3) {
            $check = $this->db->query("select * from lead_management where id=$id")->row_array();
            if (!empty($check)) {
                //if ($check['day_0_mail_date'] == '0000-00-00') {
                /* mail section */
                $user_email = $check['email'];
                // $config = Array(
                //    'protocol' => 'smtp',
                //    'smtp_host' => 'ssl://smtp.gmail.com',
                //    'smtp_port' => 465,
                //    'smtp_user' => 'codetestml0016@gmail.com', // change it to yours
                //    'smtp_pass' => 'codetestml0016@123', // change it to yours
                //    'mailtype' => 'html',
                //    'charset' => 'utf-8',
                //    'wordwrap' => TRUE
                // );

                $config = Array(
                    //'protocol' => 'smtp',
                    'smtp_host' => 'mail.leafnet.us',
                    'smtp_port' => 465,
                    'smtp_user' => 'developer@leafnet.us', // change it to yours
                    'smtp_pass' => 'developer@123', // change it to yours
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE
                );
                $lead_result = $this->view_leads_record($id);
                $mail_data = $this->get_campaign_mail_data(($check["type"] == '1') ? '1':'2', $check["language"], 1);
                $email_subject = $mail_data['subject'];
                $mail_body = urldecode($mail_data['body']);
                $user_details = staff_info();
                $from = $user_details['user']; // email of staff
                $from_name = $user_details['first_name'] . ', ' . $user_details['last_name'];
                $user_name = $check["first_name"] . ', ' . $check["last_name"];
                $contact_type = $this->get_type_of_contact_by_id(($check["type"] == '1') ? '1':'2');
                $lead_source = $this->get_lead_source_by_id($check["lead_source"]);
                $office_info = $this->administration->get_office_by_id($lead_result['office']);
                $requested_by = $this->system->get_staff_info($lead_result['staff_requested_by']);
                if($lead_result['type'] == '1') {
                    $lead_type_name = $this->get_type_of_contact_prospect($lead_result['type_of_contact']);
                } else {
                    $lead_type_name = $this->get_type_of_contact_referral_by_id($lead_result['type_of_contact']);
                }

                // Set veriables --- #name, #type,#lead_type ,#company, #phone, #email, #requested_by, #staff_office, #staff_phone, #staff_email, #first_contact_date, #lead_source, #source_detail, #office_name, #office_address, #office_phone_number
                $veriable_array = [
                    'name' => $lead_result['first_name'],
                    'type' => $contact_type['type'],
                    'company' => $lead_result['company_name'],
                    'phone' => $lead_result['phone1'],
                    'email' => $lead_result['email'],
                    'staff_name' => $user_details['full_name'],
                    'staff_office' => staff_office_name(sess('user_id')),
                    'staff_phone' => $user_details['phone'],
                    'staff_email' => $user_details['user'],
                    'first_contact_date' => ($lead_result['date_of_first_contact'] != '0000-00-00') ? date('m/d/Y', strtotime($lead_result['date_of_first_contact'])) : '',
                    'lead_source' => $lead_source['name'],
                    'source_detail' => $lead_result['lead_source_detail'],
                    'lead_type' => $lead_type_name['name'],
                    'office_phone_number' => $office_info['phone'],
                    'office_address' => $office_info['address'],
                    'office_name' => $office_info['name'],
                    'requested_by' => $requested_by['full_name']
                ];
                // print_r($veriable_array);exit;
                foreach ($veriable_array as $index => $value) {
                    if ($value != '') {
                        $mail_body = str_replace('#' . $index, $value, $mail_body);
                        $email_subject = str_replace('#' . $index, $value, $email_subject);
                    }
                }

                $user_logo = "";
                if ($lead_result['office'] != 0) {
                    $user_logo = get_user_logo($lead_result['office']);
                }

                if ($user_logo != "" && !file_exists('https://leafnet.us/uploads/' . $user_logo)) {
                    $user_logo_fullpath = 'https://leafnet.us/uploads/' . $user_logo;
                } else {
                    $user_logo_fullpath = 'https://leafnet.us/assets/img/logo_mail.png';
                }
                if ($lead_result['office'] == 1 || $lead_result['office'] == 18 || $lead_result['office'] == 34) {
                    $bgcolor = '#00aec8';
                    $divider_img = 'https://leafnet.us/assets/img/divider-blue.jpg';
                } else {
                    $bgcolor = '#8ab645';
                    $divider_img = 'http://www.taxleaf.com/Email/divider2.gif';
                }
                $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		                    <html xmlns="http://www.w3.org/1999/xhtml">
		                    <head>
		                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		                    <title>TAXLEAF</title>
		                    <style type="text/css">
		                    body {
		                        background-color: #FFFFFF;
		                        margin-left: 0px;
		                        margin-top: 0px;
		                        margin-right: 0px;
		                        margin-bottom: 0px;
		                    }
		                    .textoblanco {
		                        font-family: Arial, Helvetica, sans-serif;
		                        font-size: 12px;
		                        color: #000;
		                    }
		                    .textoblanco {
		                        font-family: Arial, Helvetica, sans-serif;
		                        font-size: 12px;
		                        color: #FFF;
		                    }
		                    .textonegro {
		                        font-family: Arial, Helvetica, sans-serif;
		                        font-size: 12px;
		                        color: #000;
		                    }
		                    </style>
		                    </head>

		                    <body>
		                    <br />
		                    <table width="600" border="0" bgcolor="' . $bgcolor . '" align="center" cellpadding="0" cellspacing="10">
		                      <tr>
		                        <td><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
		                          <tr>
		                            <td style="background: #fff"><img src="' . $user_logo_fullpath . '" width="250" /></td>
		                          </tr>
		                        </table>
		                         <table width="100%" border="0" cellspacing="0" cellpadding="0">
		                            <tr>
		                              <td><img src="' . $divider_img . '" width="600" height="30" /></td>
		                            </tr>
		                          </table>
		                          <table width="600" bgcolor="#FFFFFF" border="0" align="center" cellpadding="0" cellspacing="15">
		                            <tr>
		                              <td valign="top" style="color:#000;" class="textoblanco"><p><span class="textonegro"><strong>
		                                </strong>' . $mail_body . '</span></p>
		                              </td>
		                            </tr>
		                          </table>          
		                          </td>
		                      </tr>		                        
		                    </table>
		                    </body>
		                    </html>';
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from($from, $from_name); // change it to yours
                $this->email->reply_to($from, $from_name);
                $this->email->to($user_email); // change it to yours
                $this->email->cc($requested_by['user']);
                $this->email->subject($email_subject);
                $this->email->message($message);
                if ($this->email->send()) {
                    //$this->lm->update_mail_campaign($mail_data['id'], ['submission_date' => date('Y-m-d')]);
                    $this->update_lead_day(0, $id);
                }
                /* mail section */
                //}
            }
        }
        $staff[0] = sess('user_id');
        $this->system->save_general_notification('lead', $id, 'tracking', $staff, '', 1);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function load_count_data() {
        $user_details = staff_info();
        $usertype = $user_details['type'];
        $userid = $user_details['id'];
        if ($usertype == 1) {
            $sql = "SELECT (SELECT COUNT(id) FROM `lead_management` WHERE status = '0' AND type = '1') AS lead_new, (SELECT COUNT(id) FROM `lead_management` WHERE status = '1' AND type = '1') AS lead_complete, (SELECT COUNT(id) FROM `lead_management` WHERE status = '2' AND type = '1') AS lead_inactive, (SELECT COUNT(id) FROM `lead_management` WHERE status = '3' AND type = '1') AS lead_active, (SELECT COUNT(id) FROM `lead_management` WHERE status = '0' AND type = '2') AS ref_new, (SELECT COUNT(id) FROM `lead_management` WHERE status = '1' AND type = '2') AS ref_complete, (SELECT COUNT(id) FROM `lead_management` WHERE status = '2' AND type = '2') AS ref_inactive, (SELECT COUNT(id) FROM `lead_management` WHERE status = '3' AND type = '2') AS ref_active";
        } elseif ($usertype == 2) {
            $sql = "SELECT (SELECT COUNT(id) FROM `lead_management` WHERE status = '0' AND type = '1' AND staff_requested_by='" . $userid . "') AS lead_new, (SELECT COUNT(id) FROM `lead_management` WHERE status = '1' AND type = '1' AND staff_requested_by='" . $userid . "') AS lead_complete, (SELECT COUNT(id) FROM `lead_management` WHERE status = '2' AND type = '1' AND staff_requested_by='" . $userid . "') AS lead_inactive, (SELECT COUNT(id) FROM `lead_management` WHERE status = '3' AND type = '1' AND staff_requested_by='" . $userid . "') AS lead_active, (SELECT COUNT(id) FROM `lead_management` WHERE status = '0' AND type = '2' AND staff_requested_by='" . $userid . "') AS ref_new, (SELECT COUNT(id) FROM `lead_management` WHERE status = '1' AND type = '2' AND staff_requested_by='" . $userid . "') AS ref_complete, (SELECT COUNT(id) FROM `lead_management` WHERE status = '2' AND type = '2' AND staff_requested_by='" . $userid . "') AS ref_inactive, (SELECT COUNT(id) FROM `lead_management` WHERE status = '3' AND type = '2' AND staff_requested_by='" . $userid . "') AS ref_active";
        } else {
            if ($user_details['role'] == 1) {
                $sql = "SELECT (SELECT COUNT(id) FROM `lead_management` WHERE status = '0' AND type = '1' AND staff_requested_by='" . $userid . "') AS lead_new, (SELECT COUNT(id) FROM `lead_management` WHERE status = '1' AND type = '1' AND staff_requested_by='" . $userid . "') AS lead_complete, (SELECT COUNT(id) FROM `lead_management` WHERE status = '2' AND type = '1' AND staff_requested_by='" . $userid . "') AS lead_inactive, (SELECT COUNT(id) FROM `lead_management` WHERE status = '3' AND type = '1' AND staff_requested_by='" . $userid . "') AS lead_active, (SELECT COUNT(id) FROM `lead_management` WHERE status = '0' AND type = '2' AND staff_requested_by='" . $userid . "') AS ref_new, (SELECT COUNT(id) FROM `lead_management` WHERE status = '1' AND type = '2' AND staff_requested_by='" . $userid . "') AS ref_complete, (SELECT COUNT(id) FROM `lead_management` WHERE status = '2' AND type = '2' AND staff_requested_by='" . $userid . "') AS ref_inactive, (SELECT COUNT(id) FROM `lead_management` WHERE status = '3' AND type = '2' AND staff_requested_by='" . $userid . "') AS ref_active";
            } else {

                $staffsql = '';
                $fran_ofc = $user_details['office'];
                $ofc_staffs = $this->db->query("SELECT * from office_staff WHERE office_id='" . $fran_ofc . "'")->result_array();
                if (!empty($ofc_staffs)) {
                    $i = 0;
                    $len = COUNT($ofc_staffs);
                    $staff_array = '';
                    foreach ($ofc_staffs AS $os) {
                        if ($i == $len - 1) {
                            $staff_array .= $os['staff_id'];
                        } else {
                            $staff_array .= $os['staff_id'] . ',';
                        }
                        $i++;
                    }

                    $staff_array_val = explode(",", $staff_array);
                    $j = 0;
                    $lenj = COUNT($staff_array_val);
                    if ($lenj > 1) {
                        foreach ($staff_array_val AS $val) {
                            if ($j == 0) {
                                $staffsql .= "(staff_requested_by='" . $val . "'";
                            } elseif ($j == $lenj - 1) {
                                $staffsql .= " OR staff_requested_by='" . $val . "')";
                            } else {
                                $staffsql .= " OR staff_requested_by='" . $val . "'";
                            }
                            $j++;
                        }
                    } else {
                        foreach ($staff_array_val AS $val) {
                            $staffsql .= "staff_requested_by='" . $val . "'";
                            $j++;
                        }
                    }
                }

                $sql = "SELECT (SELECT COUNT(id) FROM `lead_management` WHERE status = '0' AND type = '1' AND " . $staffsql . ") AS lead_new, (SELECT COUNT(id) FROM `lead_management` WHERE status = '1' AND type = '1' AND " . $staffsql . ") AS lead_complete, (SELECT COUNT(id) FROM `lead_management` WHERE status = '2' AND type = '1' AND " . $staffsql . ") AS lead_inactive, (SELECT COUNT(id) FROM `lead_management` WHERE status = '3' AND type = '1' AND " . $staffsql . ") AS lead_active, (SELECT COUNT(id) FROM `lead_management` WHERE status = '0' AND type = '2' AND " . $staffsql . ") AS ref_new, (SELECT COUNT(id) FROM `lead_management` WHERE status = '1' AND type = '2' AND " . $staffsql . ") AS ref_complete, (SELECT COUNT(id) FROM `lead_management` WHERE status = '2' AND type = '2' AND " . $staffsql . ") AS ref_inactive, (SELECT COUNT(id) FROM `lead_management` WHERE status = '3' AND type = '2' AND " . $staffsql . ") AS ref_active";
            }
        }
        return $this->db->query($sql)->result_array()[0];
    }

    public function fetch_data($id) {
        return $this->db->query("select lm.*, group_concat(distinct(ln.note) separator ',') as notes from lead_management as lm inner join lead_notes as ln on ln.lead_id = lm.id where lm.id = '$id';")->row_array();
    }

    public function edit_lead_prospect_now($lead_id, $data) {
        if (isset($data["lead_notes"])) {
            $lead_notes = $data["lead_notes"];
            unset($data["lead_notes"]);
        }
        if ($data['lead_source'] == 5) {
            $data['lead_agent'] = $data['lead_agent'];
        } elseif ($data['lead_source'] == 7) {
            $data['lead_agent'] = $data['lead_client'];
        } elseif ($data['lead_source'] == 6) {
            $data['lead_agent'] = $data['lead_client_other'];
        } else {
            $data['lead_agent'] = '';
        }
        if (isset($data['lead_type'])) {
            if ($data['lead_type'] == '1') {
                $data['type'] = '1';
            } elseif ($data['lead_type'] == '2') {
                $data['type'] = '3';
            }
        }
        unset($data['lead_type']);

        unset($data['lead_client']);
        unset($data['lead_client_other']);

        if (isset($data["edit_lead_notes"])) {
            $edit_lead_notes = $data["edit_lead_notes"];
            unset($data["edit_lead_notes"]);
        }


        if (isset($data["mail_campaign_status"])) {
            if ($data['mail_campaign_status'] == 1) {
                $data['status'] = 3;
            }
        }

        $dofc_array = explode('/', $data['date_of_first_contact']);
        $data['date_of_first_contact'] = $dofc_array[2] . '-' . $dofc_array[0] . '-' . $dofc_array[1];

        if ($data["lead_staff"] == '') {
            unset($data["lead_staff"]);
        }

        $lead_management = $data;
        $this->db->trans_begin();

        $this->db->set($lead_management)->where("id", $lead_id)->update('lead_management');

        if (!empty($lead_notes)) {
            $this->notes->insert_note(3, $lead_notes, "lead_id", $lead_id);
        }

        if (!empty($edit_lead_notes)) {
            $this->notes->update_note(3, $edit_lead_notes);
        }
        $lead_type = $lead_management['type'];
        if ($lead_type == 1 || $lead_type == 3) {
            $reference = 'lead';
        }if ($lead_type == 2) {
            $reference = 'partner';
        }
        $staff = [];
        $staff[0] = sess('user_id');
        $this->system->save_general_notification($reference, $lead_id, 'edit', $staff, '', $lead_type);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function get_leads_count() {
        $user_details = staff_info();
        $usertype = $user_details['type'];

        $userid = $user_details['id'];

        $sql = "SELECT * FROM `lead_management` WHERE status ='0' and type!='2'";
        if ($usertype != 1) {
            $sql .= " and staff_requested_by='" . $userid . "'";
        }
        return $this->db->query($sql)->num_rows();
    }

    public function get_active_leads_count() {
        $user_details = staff_info();
        $usertype = $user_details['type'];
        $userid = $user_details['id'];

        $sql = "SELECT * FROM `lead_management` WHERE status = '3' and type!='2'";
        if ($usertype != 1) {
            $sql .= " and staff_requested_by='" . $userid . "'";
        }
        return $this->db->query($sql)->num_rows();
    }

    public function insert_mail_content($data) {

        $update_data = array('subject' => $data['subject'],
            'schedule_date' => $this->System->invertDate($data['schedule_date']),
            'body' => urlencode($data['body']),
            'status' => 0
        );

        $this->db->trans_begin();

        $this->db->insert('lead_mail', $update_data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "0";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function update_mail_content($data) {

        $update_data = array('subject' => $data['subject'],
            'schedule_date' => $this->System->invertDate($data['schedule_date']),
            'body' => urlencode($data['body'])
        );

        $this->db->trans_begin();

        $this->db->where(['id' => $data['email_id']]);
        $this->db->update('lead_mail', $update_data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "0";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function get_lead_mail_content() {
        return $this->db->query("SELECT * FROM `lead_mail`")->result_array();
    }

    public function edit_lead_mail_content($id) {
        return $this->db->query("SELECT * FROM `lead_mail` where id='$id'")->row_array();
    }

    public function lead_campaign_mails($leadtype, $language, $day, $status = '', $group_by = '') {
        $query = "SELECT lmc.*,(select type from lead_type where id=lmc.lead_type) as lead_name,(select language from languages where id=lmc.language) as language_name, CONCAT((select type from lead_type where id=lmc.lead_type) , '-', (select language from languages where id=lmc.language)) AS main_title FROM `lead_mail_chain` lmc";
        $sql = '';
        if ($leadtype != '') {
            if ($sql == '') {
                $sql .= ' where lmc.lead_type = "' . $leadtype . '" and lmc.lead_type!=0 ';
            } else {
                $sql .= ' and lmc.lead_type = "' . $leadtype . '"';
            }
        }
        if ($language != '') {
            if ($sql == '') {
                $sql .= ' where lmc.language = "' . $language . '"';
            } else {
                $sql .= ' and lmc.language = "' . $language . '"';
            }
        }
        if ($day != '') {
            if ($sql == '') {
                $sql .= ' where lmc.type = "' . $day . '"';
            } else {
                $sql .= ' and lmc.type = "' . $day . '"';
            }
        }
        if ($status != '') {
            if ($sql == '') {
                $sql .= ' where lmc.status = "' . $status . '"';
            } else {
                $sql .= ' and lmc.status = "' . $status . '"';
            }
        }
        if ($group_by != '') {
            $sql .= ' GROUP BY main_title';
        }
        $query_sql = $query . $sql . ' ORDER BY lmc.lead_type';
        return $this->db->query($query_sql)->result_array();
        // return $this->db->last_query();
    }

    public function edit_lead_mail_chain_content($id) {
        return $this->db->query("SELECT * FROM `lead_mail_chain` where id='$id'")->row_array();
    }

    public function insert_mail_campaign_content($data) {

        $check = $this->check_if_mail_exists($data['leadtype'], $data['language'], $data['day']);

        if (empty($check)) {
            $update_data = array('lead_type' => $data['leadtype'],
                'language' => $data['language'],
                'type' => $data['day'],
                'subject' => $data['subject'],
                'body' => urlencode($data['body']),
                'status' => 1
            );

            $this->db->trans_begin();

            $this->db->insert('lead_mail_chain', $update_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return "0";
            } else {
                $this->db->trans_commit();
                return "1";
            }
        } else {
            return "0";
        }
    }

    public function update_mail_campaign_content($data) {

        $check = $this->check_if_mail_exists($data['leadtype'], $data['language'], $data['day']);

        if (empty($check)) {

            $update_data = array('lead_type' => $data['leadtype'],
                'language' => $data['language'],
                'type' => $data['day'],
                'subject' => $data['subject'],
                'body' => urlencode($data['body']),
                'status' => $data['hidden_onoff']
            );

            $this->db->trans_begin();

            $this->db->where(['id' => $data['email_id']]);
            $this->db->update('lead_mail_chain', $update_data);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return "0";
            } else {
                $this->db->trans_commit();
                return "1";
            }
        } else {
            if ($check['id'] == $data['email_id']) {
                $update_data = array('lead_type' => $data['leadtype'],
                    'language' => $data['language'],
                    'type' => $data['day'],
                    'subject' => $data['subject'],
                    'body' => urlencode($data['body']),
                    'status' => $data['hidden_onoff']
                );

                $this->db->trans_begin();

                $this->db->where(['id' => $data['email_id']]);
                $this->db->update('lead_mail_chain', $update_data);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return "0";
                } else {
                    $this->db->trans_commit();
                    return "1";
                }
            } else {
                return "0";
            }
        }
    }

    public function delete_lead_mail($id) {
        $this->db->trans_begin();
        $this->db->where("id", $id)->delete("lead_mail");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function check_if_mail_exists($leadtype, $language, $day) {
        return $this->db->query("SELECT * FROM `lead_mail_chain` where lead_type='" . $leadtype . "' and language='" . $language . "' and type='" . $day . "'")->row_array();
    }

    public function get_campaign_mail_data($lead_type, $language, $day) {
        return $this->db->query("SELECT * FROM `lead_mail_chain` where lead_type='" . $lead_type . "' and language='" . $language . "' and type='" . $day . "'")->row_array();
        // return $this->db->last_query();
    }

    public function delete_mail_campaign($id) {
        $this->db->trans_begin();
        $this->db->where("id", $id)->delete("lead_mail_chain");
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function change_mail_campaign_status($leadtype, $language, $status) {
        $this->db->trans_begin();
        $this->db->where(['lead_type' => $leadtype, 'language' => $language]);
        $this->db->update("lead_mail_chain", ['status' => $status]);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function update_mail_campaign($mail_id, $data) {
        $this->db->where(['id' => $mail_id]);
        return $this->db->update("lead_mail_chain", $data);
    }

    public function get_partner_filter_element_value($element_key, $office) {
        $tracking_array = [
                ["id" => 0, "name" => "New"],
                ["id" => 1, "name" => "Complete"],
                ["id" => 2, "name" => "Inactive"],
                ["id" => 3, "name" => "Active"]
        ];
        switch ($element_key):
            case 1: {
                    return $this->db->get('type_of_contact_referral')->result_array();
                }
                break;
            case 2: {
                    return $tracking_array;
                }
                break;
            case 4: {
                    $this->db->select("st.id AS id, CONCAT(st.last_name, ', ',st.first_name,' ',st.middle_name) AS name");
                    $this->db->from('staff AS st');
                    if ($office != ''):
                        $this->db->join('office_staff os', 'os.staff_id = st.id');
                        $this->db->where(['os.office_id' => $office]);
                    endif;
                    return $this->db->get()->result_array();
                }
                break;
            case 7: {
                    $this->db->select("st.id AS id, CONCAT(st.last_name, ', ',st.first_name,' ',st.middle_name) AS name");
                    $this->db->from('staff AS st');
                    if ($office != ''):
                        $this->db->join('office_staff os', 'os.staff_id = st.id');
                        $this->db->where(['os.office_id' => $office]);
                    endif;
                    return $this->db->get()->result_array();
                }
                break;
            default: {
                    return [];
                }
                break;
        endswitch;
    }

    public function get_lead_filter_element_value($element_key, $office) {
        $tracking_array = [
                ["id" => 0, "name" => "New"],
                ["id" => 1, "name" => "Complete"],
                ["id" => 2, "name" => "Inactive"],
                ["id" => 3, "name" => "Active"]
        ];
        // $type_array = [
        //         ["id" => 1, "name" => "LEADS"],
        //         ["id" => 2, "name" => "REFERRAL AGENT"]
        // ];
        switch ($element_key):
            case 1: {
                    // return $type_array;
                    return $this->db->get('type_of_contact_prospect')->result_array();
                }
                break;
            case 2: {
                    return $tracking_array;
                }
                break;
            case 3: {
                    return $this->administration->get_all_office();
                }
                break;
            case 4: {
                    $this->db->select("st.id AS id, CONCAT(st.last_name, ', ',st.first_name,' ',st.middle_name) AS name");
                    $this->db->from('staff AS st');
                    if ($office != ''):
                        $this->db->join('office_staff os', 'os.staff_id = st.id');
                        $this->db->where(['os.office_id' => $office]);
                    endif;
                    return $this->db->get()->result_array();
                }
                break;

            default: {
                    return [];
                }
                break;
        endswitch;
    }

    public function delete_lead_management($id) {
        return $this->db->where("id", $id)->delete("lead_management");
    }

    public function insert_new_event($id, $data) {
        // echo $id;exit;		
        // return $data['lead_id'];

        unset($data['lead_staff']);
        unset($data['lead_id']);
        unset($data['addlead_info']);
        $data['event_date'] = date('Y-m-d', strtotime($data['event_date']));

        $this->db->insert("event", $data);
        $event_id = $this->db->insert_id();

        $values = array(
            'event_id' => $event_id
        );

        if ($id != "") {
            $ar = array(
                'type' => 1,
                'lead_source' => 11,
                'lead_source_detail' => $data['event_type'] . " - " . $data['event_name']
            );
            $this->db->set($ar);
            $id_arr = explode(",", $id);
            $this->db->where_in('id', $id_arr);
            return $this->db->update('lead_management', $values);
        } else {
            return true;
        }
    }

    public function get_event_details($office_id = '') {
        if ($office_id != '') {
            $this->db->where("office_id", $office_id);
        }
        return $this->db->get('event')->result_array();
    }

    public function get_office_by_id($id) {
        return $this->db->get_where("office", array('id' => $id));
    }

    public function get_prospects() {
        return $this->db->get("lead_management")->result_array();
    }

    public function insert_event_lead($array) {
        $this->db->trans_begin();
        $this->db->insert("event_lead", $array);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function get_prospect_by_event_id($id) {
        $this->db->select('*');
        $this->db->from('event_lead');
        $this->db->join('lead_management', 'lead_management.id = event_lead.lead_id');
        return $this->db->get();
    }

    public function get_event_details_by_id($e_id) {
        return $this->db->get_where("event", array("id" => $e_id))->row_array();
    }

    public function get_office_name_by_id($id) {
        $this->db->select('name');
        $office = $this->db->get_where("office", array("id" => $id))->row_array();
        return $office['name'];
    }

    public function update_event($event_id, $data, $leadid) {
        unset($data['lead_staff']);
        unset($data['lead_id']);
        unset($data['addlead_info']);
        $newDate = date("Y-m-d", strtotime($data['event_date']));
        $values = array(
            'office_id' => $data['office_id'],
            'event_type' => $data['event_type'],
            'event_name' => $data['event_name'],
            'description' => $data['description'],
            'location' => $data['location'],
            'event_date' => $newDate
        );
        $this->db->set($values);
        $this->db->where('id', $event_id);
        $this->db->update('event');

        $values = array(
            'event_id' => $event_id
        );

        if ($leadid != "") {

            $d = array(
                'type' => 1,
                'lead_source' => 11,
                'lead_source_detail' => $data['event_type'] . " - " . $data['event_name']
            );

            $this->db->set($d);
            $id_arr = explode(",", $leadid);
            $this->db->where_in('id', $id_arr);
            return $this->db->update('lead_management', $values);
        } else {
            return true;
        }
    }

    public function change_tracking_status() {
        $id = post('id');
        $status = post('value');
        if ($status == 1) {
            $this->db->set('status', 1);
            $this->db->where('id', $id);
            $this->db->update('lead_management');
            return 1;
        } else {
            $this->db->set('status', 0);
            $this->db->where('id', $id);
            $this->db->update('lead_management');
            return 0;
        }
    }

    public function get_referred_leads() {
        $user_id = sess('user_id');
        $this->db->where('staff_requested_by', $user_id);
        $this->db->where('referred_status', '1');
        $data = $this->db->get('lead_management')->result_array();
        $lead_id_arr = array_column($data, 'id');

        $this->db->where('assigned_to_userid', $user_id);
        $value = $this->db->get('referral_partner')->result_array();
        foreach ($value as $value) {
            array_push($lead_id_arr, $value['partner_id']);
        }
        $this->db->where_in('id', $lead_id_arr);
        return $this->db->get('lead_management')->result_array();
    }

    // public function get_leads_referred_to_partners($agent_id_arr){
    // 	$staff_type = staff_info()['type'];
    // 	$lead_id_arr = [];
    // 	foreach ($agent_id_arr as $aid) { 
    // 		 if($aid['staff_requested_by']==sess('user_id')){
    // 		$this->db->where('ref_partner_id',$aid['id']);
    // 		$data = $this->db->get('referred_lead')->result_array();
    // 		//return $data;
    // 		if(!empty($data)){
    // 			foreach ($data as $value) {
    // 			 array_push($lead_id_arr, $value['lead_id']);			  
    // 		   }
    // 		}	
    // 	  }		
    // 	}
    // 	$lead_id_arr = array_values(array_filter($lead_id_arr));
    // 	$this->db->where('assisned_by_userid',sess('user_id'));
    // 	$this->db->where('assigned_by_usertype',$staff_type);
    // 	$lead_id_to_partner_arr = $this->db->get('referral_partner')->result_array();
    // 	// return $lead_id_to_partner_arr;
    // 	foreach ($lead_id_to_partner_arr as $val) {
    // 		array_push($lead_id_arr, $val['partner_id']);
    // 	}
    // 	if(!empty($lead_id_arr)){
    // 		$this->db->where_in('id', $lead_id_arr);
    // 	        $newarray =  $this->db->get('lead_management')->result_array();
    // 	}else{
    // 		$newarray = array();
    // 	}
    // 		return $newarray;
    // }

    public function get_requested_to_partner($id) {
        $data = $this->db->get_where('referred_lead', array('lead_id' => $id))->row_array();
        $partner_id = $data['ref_partner_id'];

        $value = $this->db->get_where('lead_management', array('id' => $partner_id))->row_array();
        return $value;
    }

    public function get_requested_to_partner_id($id) {
        $data = $this->db->get_where('referral_partner', array('partner_id' => $id))->row_array();
        $partner_id = $data['assisned_by_userid'];
        return $partner_id;
    }

    public function update_lead_day($day, $lead_id) {
        $date_array = array();
        if ($day == 0) {
            $date_array['day_3_mail_date'] = '0000-00-00';
            $date_array['day_6_mail_date'] = '0000-00-00';
        }
        $date_array['day_' . $day . '_mail_date'] = date('Y-m-d');
        //$this->db->set('day_' . $day . '_mail_date', date('Y-m-d'));
        $this->db->where('id', $lead_id);
        $this->db->update('lead_management', $date_array);
    }

    // Assign a lead as Partner
    public function assign_lead_as_partner($id) {
        $this->db->trans_begin();

        $this->db->set('type', '2');
        $this->db->set('assigned_status', 'y');
        $this->db->where('id', $id);
        $this->db->update('lead_management');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    // Assign a lead as Client
    public function assign_lead_as_client($id, $partner_id) {
        $this->db->trans_begin();

        // Individual
        $lead_details = $this->db->get_where('lead_management', array('id' => $id))->row_array();
        $Individual_data = array(
            'first_name' => $lead_details['first_name'],
            'last_name' => $lead_details['last_name'],
            'language' => 3,
            'country_residence' => 30,
            'status' => $lead_details['status'],
            'added_by_user' => 1
        );
        $this->db->insert('individual', $Individual_data);
        $last_insert_id = $this->db->insert_id();


        // Internal Data
        $partner_details = $this->db->get_where('staff', array('id' => $partner_id))->row_array();
        $office_id = $this->db->get_where('office_staff', array('staff_id' => $partner_id))->row_array()['office_id'];

        $internal_data_arr = array(
            'reference' => 'individual',
            'reference_id' => $last_insert_id,
            'office' => $office_id,
            'partner' => $id,
            'manager' => $id,
            'language' => 3,
            'status' => $partner_details['status']
        );
        $this->db->insert('internal_data', $internal_data_arr);

        // Contact Info
        $contact_info = array(
            'reference' => 'individual',
            'reference_id' => $id,
            'type' => $lead_details['type'],
            'first_name' => $lead_details['first_name'],
            'last_name' => $lead_details['last_name'],
            'phone1_country' => 30,
            'email1' => $lead_details['email'],
            'city' => $lead_details['city'],
            'state' => $lead_details['state'],
            'zip' => $lead_details['zip'],
            'country' => $lead_details['country'],
            'status' => $lead_details['status']
        );
        $this->db->insert('contact_info', $contact_info);

        // Title
        $reference_id = $this->system->create_reference_id();
        $title_arr = array(
            'company_id' => $reference_id,
            'individual_id' => $last_insert_id,
            'company_type' => 1,
            'title' => 'MANAGER',
            'percentage' => 100.00,
            'status' => 1,
            'existing_reference_id' => $last_insert_id,
        );
        $this->db->insert('title', $title_arr);

        // Notes
        $note_data = $this->db->get_where('lead_notes', array('lead_id' => $id))->result_array();
        $notes = array_column($note_data, 'note');
        $notes = (object) $notes; // convert the post array into an object

        if (isset($notes)) {
            $this->notes->insert_note(1, $notes, 'reference_id', $last_insert_id, 'individual');
        }

        // Change lead as client by assigned status
        $this->db->set('assigned_status', 'y');
        $this->db->where('id', $id);
        $this->db->update('lead_management');

        // Action
        $data['subject'] = 'New Client Has Been Added';
        $data['client'] = 'individual';
        $data['message'] = staff_info()['full_name'] . ' has added a new client';
        $this->action_model->insert_client_action($data);


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function save_add_leads_modal($data) {

        if (isset($data["lead_notes"])) {
            $lead_notes = $data["lead_notes"];
            unset($data["lead_notes"]);
        }

       
        $values = array(
            'type_of_contact' => $data['type-of-contact'],
            'lead_source' => $data['lead-source'],
            'date_of_first_contact' => $data['date-of-first-contact'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['u_email'],
            'phone1' => $data['phone'],
            'company_name' => $data['company'],
            'language' => $data['language']
        );

         $this->db->trans_begin();
         $this->db->insert("lead_management", $values);
         $id = $this->db->insert_id();
        
          if (!empty($lead_notes)) {
            $this->notes->insert_note(3, $lead_notes, "lead_id", $id);
        }


          if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return $id;
        }
    }

    public function update_addlead_modal($id, $data) {

        if (isset($data["lead_notes"])) {
            $lead_notes = $data["lead_notes"];
            unset($data["lead_notes"]);
        }

        if (isset($data["edit_lead_notes"])) {
            $edit_lead_notes = $data["edit_lead_notes"];
            unset($data["edit_lead_notes"]);
        }

        $this->db->trans_begin();

        $values = array(
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['u_email'],
            'phone1' => $data['phone'],
            'company_name' => $data['company'],
            'language' => $data['language']
        );

        $this->db->set($values);
        $this->db->where('id', $id);
        $this->db->update('lead_management');

        if (!empty($lead_notes)) {
            $this->notes->insert_note(3, $lead_notes, "lead_id", $id);
        }

        if (!empty($edit_lead_notes)) {
            $this->notes->update_note(3, $edit_lead_notes);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function get_addleads_information($id) {
        return $this->db->get_where("lead_management", array('id' => $id))->result_array();
    }

    public function get_addlead_details($id) {
        return $this->db->get_where("lead_management", array('id' => $id))->row_array();
    }

    public function get_selected_languages($id) {

        $this->db->select('lm.*,lg.*');
        $this->db->from('lead_management lm');
        $this->db->join('languages lg', 'lm.language = lg.id');
        $this->db->where('lm.id', $id);
        $result = $this->db->get()->row_array();
        return $result;
    }

    public function get_addlead_details_by_id($id) {

        $this->db->select('e.*,lmg.*');
        $this->db->from('event e');
        $this->db->join('lead_management lmg', 'e.id = lmg.event_id');
        $this->db->where('e.id', $id);
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_partner_count_by_staff($request_type) {
        if ($request_type == 'byme') {
            $this->db->where('type', 2);
            $this->db->where('staff_requested_by', sess('user_id'));
            return $this->db->get('lead_management')->result_array();
        } elseif ($request_type == 'byothers') {
            $this->db->where('type', 2);
            $this->db->where('staff_requested_by!=', sess('user_id'));
            return $this->db->get('lead_management')->result_array();
        }
    }

    public function get_types_of_lead($id) {
        $data = $this->db->get_where('lead_management', array('id' => $id))->row_array();
        return $data['type'];
    }

    public function get_lead_type_for_mail() {
        return $this->db->get("lead_type")->result_array();
    }

    public function get_event_lead_by_id($id) {
        $data = $this->db->get_where('lead_management', array('event_id' => $id))->row_array();
        return $data['event_id'];
    }

    public function get_event_lead_details($event_id) {
        $this->db->select('lead_management.*,languages.language as language_name');
        $this->db->from('lead_management');
        $this->db->join('languages','lead_management.language=languages.id');
        $this->db->where("lead_management.event_id", $event_id);
        return $this->db->get()->result_array();
    }

    public function get_lead_note_count($id) {
        $this->db->select('lead_notes.*');
        $this->db->from('lead_notes');
        $this->db->join('lead_management','lead_management.id=lead_notes.lead_id');
        $this->db->where("lead_management.id", $id);
        return $this->db->get()->result_array();
    }
    public function get_office_info_by_partner_id($partner_id) {
        return $this->db->get_where('office_staff', array('staff_id' => $partner_id))->row_array()['office_id'];        
    }
    public function update_lead_assigned_status($lead_id) {
        $this->db->set('assigned_status', 'y');
        $this->db->where('id', $lead_id);
        return $this->db->update('lead_management');
    }
    public function get_typeof_contact($type) {
        if ($type == '1') {
            return $this->db->get('type_of_contact_prospect')->result_array();
        } elseif ($type == '2') {
            return $this->db->get('type_of_contact_referral')->result_array();
        }
    }
    public function get_updated_lead_status($id) {
        $lead_status = $this->db->get_where('lead_management',array('id'=>$id))->row_array();
        switch ($lead_status['status']) {
            case '1':
                return 'Completed';
                break;
            case '2':
                return 'Inactive';
                break;
            case '3':
                return 'Active';
                break;    
            default:
                return 'New';
                break;
        }

    }
}
