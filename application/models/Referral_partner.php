<?php

class Referral_partner extends CI_Model {

    function getReferralPartnerData($req_by,$form_data='') {
        $userinfo = staff_info();
        $office = $userinfo['office'];
        $result = $this->db->query("select staff_id from office_staff where office_id in ('" . $office . "')")->result_array();
        $staff_ids = '';
        $i = 0;
        $len = count($result);
        foreach ($result as $r) {
            if ($i == $len - 1) {
                $staff_ids .= $r['staff_id'];
            } else {
                $staff_ids .= $r['staff_id'] . ',';
            }
            $i++;
        }
        $where = $having = [];
        $sql = "SELECT lm.id,concat(lm.last_name, ', ', lm.first_name) as partner_name,lm.type_of_contact,lm.email, lm.type as lead_type, rf.assigned_date,rf.assisned_by_userid, (case when lm.type = '1' then (select name from type_of_contact_prospect where id = lm.type_of_contact) else (select name from type_of_contact_referral where id = lm.type_of_contact) end) as type,concat(lm.first_name, ', ', lm.last_name) as name, (case when lm.status = '0' then 'New' when lm.status = '1' then 'Complete' when lm.status = '2' then 'Inactive' when lm.status = '3' then 'Active' else 'Unknown' end) as status, concat(s.first_name, ', ', s.last_name, ' ', s.middle_name) as requested_by,s.id as requested_by_id, lm.submission_date, lm.active_date, lm.inactive_date, lm.complete_date, (select count(ln.id) from lead_notes as ln where ln.lead_id = lm.id) as notes from lead_management as lm inner join staff as s on s.id = lm.staff_requested_by left join referral_partner as rf on rf.partner_id = lm.id";
        $where[] = 'lm.type="2" and lm.status="1"';
        if ($userinfo['type'] == 3) {
            if ($userinfo['role'] == 1) {
                $where[] = 'lm.staff_requested_by = ' . sess('user_id') . '';
            } else {
               $where[] = 'lm.staff_requested_by in (' . $staff_ids . ')';
            }
        } elseif ($userinfo['type'] == 2) {
            if($userinfo['department']!=14){
              $where[] = 'lm.staff_requested_by = ' . sess('user_id') . '';  
            }           
        }
        if ($req_by != '') {
            if ($req_by == 1) {
                //$sql .= ' and rf.assigned_clientid = '.sess('user_id').'';
                $where[] = 'lm.staff_requested_by = ' . sess('user_id') . '';
            } else {
                //$sql .= ' and rf.assigned_clientid != '.sess('user_id').'';
                $where[] = 'lm.staff_requested_by != ' . sess('user_id') . '';
            }
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
                            if ($variable_val == 1) {
                                $where[] = $this->build_query($variable_val, $condition_val, $form_data['criteria_dropdown'], $column_name);
                            } else {
                                $where[] = $this->build_query($variable_val, $condition_val, $form_data['criteria_dropdown'], $column_name);
                            }
                        }
                    }
                }
            }
        }
        $sql .= " WHERE " . implode(' AND ', $where);

        $sql .= ' group by lm.id';
        
        //echo $sql;exit;
        $this->db->query('SET SQL_BIG_SELECTS=1');
        return $this->db->query($sql)->result_array();
    }

    public function get_column_name($variable_val) {
        if ($variable_val == 1) {
            $column_name = 'lm.type_of_contact';
        } elseif ($variable_val == 2) {
            $column_name = 'lm.staff_requested_by';
        } elseif ($variable_val == 3) {
            $column_name = 'lm.submission_date';
        } elseif ($variable_val == 4) {
            $column_name = 'lm.id';
        }
        return $column_name;
    }

    public function build_query($variable_val, $condition_val, $criteria_dd, $column_name) {
        $query = '';
        if ($variable_val == 1) {
            $criteria_val = $criteria_dd['type'];
        } elseif ($variable_val == 2) {
            $criteria_val = $criteria_dd['requested_by'];
        } elseif ($variable_val == 3) {
            $criteria_val = $criteria_dd['added_date'];
        } elseif ($variable_val == 4) {
            $criteria_val = $criteria_dd['partner_name'];
        }
        if ($variable_val == 3) { // added_date
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
          }  else {
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
                }
                $query = $column_name . (($condition_val == 2) ? ' in ' : ' not in ') . '(' . $criterias . ')';
            }
        }
        return $query;
    }

    function load_ref_partner_count($req_by) {
        $userinfo = staff_info();
        $office = $userinfo['office'];
        $result = $this->db->query("select staff_id from office_staff where office_id in ('" . $office . "')")->result_array();
        $staff_ids = '';
        $i = 0;
        $len = count($result);
        foreach ($result as $r) {
            if ($i == $len - 1) {
                $staff_ids .= $r['staff_id'];
            } else {
                $staff_ids .= $r['staff_id'] . ',';
            }
            $i++;
        }
        $sql = "SELECT lm.id,lm.type_of_contact, lm.type as lead_type, rf.assigned_date,rf.assisned_by_userid, (case when lm.type = '1' then (select name from type_of_contact_prospect where id = lm.type_of_contact) else (select name from type_of_contact_referral where id = lm.type_of_contact) end) as type,concat(lm.last_name, ', ', lm.first_name) as name, (case when lm.status = '0' then 'New' when lm.status = '1' then 'Complete' when lm.status = '2' then 'Inactive' when lm.status = '3' then 'Active' else 'Unknown' end) as status, concat(s.last_name, ', ', s.first_name, ' ', s.middle_name) as requested_by, lm.submission_date, lm.active_date, lm.inactive_date, lm.complete_date, (select count(ln.id) from lead_notes as ln where ln.lead_id = lm.id) as notes from lead_management as lm inner join staff as s on s.id = lm.staff_requested_by left join referral_partner as rf on rf.partner_id = lm.id where lm.type=2 and lm.status=1";
        if ($userinfo['type'] == 3) {
            if ($userinfo['role'] == 1) {
                $sql .= ' and lm.staff_requested_by = ' . sess('user_id') . '';
            } else {
                $sql .= ' and lm.staff_requested_by in (' . $staff_ids . ')';
            }
        } elseif ($userinfo['type'] == 2) {
            $sql .= ' and lm.staff_requested_by = ' . sess('user_id') . '';
        }
        if ($req_by != '') {
            if ($req_by == 1) {
                //$sql .= ' and rf.assigned_clientid = '.sess('user_id').'';
                $sql .= ' and lm.staff_requested_by = ' . sess('user_id') . '';
            } else {
                //$sql .= ' and rf.assigned_clientid != '.sess('user_id').'';
                $sql .= ' and lm.staff_requested_by != ' . sess('user_id') . '';
            }
        }
        $sql .= ' group by lm.id';
        //echo $sql; exit;
        return $this->db->query($sql)->num_rows();
    }

    function getReferralPartnerLeadData() {
        $sql = "SELECT lm.id, lm.type as lead_type, (case when lm.type = '1' then (select name from type_of_contact_prospect where id = lm.type_of_contact) else (select name from type_of_contact_referral where id = lm.type_of_contact) end) as type,concat(lm.last_name, ', ', lm.first_name) as name, (case when lm.status = '0' then 'New' when lm.status = '1' then 'Complete' when lm.status = '2' then 'Inactive' when lm.status = '3' then 'Active' else 'Unknown' end) as status, concat(s.last_name, ', ', s.first_name, ' ', s.middle_name) as requested_by, lm.submission_date, lm.active_date, lm.inactive_date, lm.complete_date, (select count(ln.id) from lead_notes as ln where ln.lead_id = lm.id) as notes from lead_management as lm inner join staff as s on s.id = lm.staff_requested_by where lm.type=1 and lm.staff_requested_by=" . sess('user_id') . "";
        return $this->db->query($sql)->result_array();
    }

    public function getReferralPartnerDatabyid($id) {
        $sql = "select * from lead_management where id='" . $id . "'";
        return $this->db->query($sql)->row_array();
    }
    public function load_referral_partners_dashboard_data($lead_id="",$data = "") {
        $lead_email = $this->db->get_where('lead_management',array('id'=>$lead_id,'type'=>'2'))->row_array()['email'];
        $staff_id = $this->db->get_where('staff',array('user'=>$lead_email))->row_array()['id'];

        $this->db->select('rl.*,lm.*');
        $this->db->from('referred_lead rl');
        $this->db->join('lead_management lm', 'lm.id = rl.lead_id');
        $this->db->group_start();
        if ($lead_id != '') {
            $this->db->where('rl.referred_by',$staff_id);   
        } else {
            $this->db->where('rl.referred_by',sess('user_id'));    
            $this->db->or_where('rl.referred_to',sess('user_id'));    
        }
        $this->db->group_end();
        if (!empty($data)) {
            if ($data['type'] == 1) { // By Me
                
                if ($data['status'] == 0) { // New
                    $this->db->where('lm.status',$data['status']);    
                } elseif ($data['status'] == 1) { // Completed
                    $this->db->where('lm.status',$data['status']);
                } elseif ($data['status'] == 2) { // Inactive
                    $this->db->where('lm.status',$data['status']);
                } elseif ($data['status'] == 3) { // Active
                    $this->db->where('lm.status',$data['status']);
                }
                $this->db->where('lm.referred_status','0'); // partner to staff
            } elseif ($data['type'] == 2) { // To Me
                
                if ($data['status'] == 0) { // New
                    $this->db->where('lm.status',$data['status']);
                } elseif ($data['status'] == 1) { // Completed
                    $this->db->where('lm.status',$data['status']);
                } elseif ($data['status'] == 2) { // Inactive
                    $this->db->where('lm.status',$data['status']);
                } elseif ($data['status'] == 3) { // Active
                    $this->db->where('lm.status',$data['status']);
                }
                $this->db->where('lm.referred_status','1'); // staff to partner
            }
        }
        
        return $this->db->get()->result_array();
    }

    public function load_referred_leads_dashboard_data($status,$lead_id="") {
        $lead_email = $this->db->get_where('lead_management',array('id'=>$lead_id,'type'=>'2'))->row_array()['email'];
        $staff_id = $this->db->get_where('staff',array('user'=>$lead_email))->row_array()['id'];

        $this->db->select('rl.*,lm.*');
        $this->db->from('referred_lead rl');
        $this->db->join('lead_management lm', 'lm.id = rl.lead_id');
        if ($lead_id != '') {
            $this->db->where('rl.referred_to',$staff_id);   
        } else {
            $this->db->where('rl.referred_to',sess('user_id'));    
        }
        $this->db->where('lm.referred_status','1');
        return $this->db->get()->result_array();
    }

    public function load_referred_leads_count($status) {
        $userinfo = staff_info();
        $this->db->select('rl.*,lm.*');
        $this->db->from('referred_lead rl');
        $this->db->join('lead_management lm', 'lm.id = rl.lead_id');
        if ($status != '' && $status != 7) {
            $this->db->where('lm.status', $status);
        }
        return $this->db->get()->num_rows();
    }

    public function set_password($data, $pwd,$staffrequestedby) { 
        $query = $this->db->query('select * from staff where user="' . $data['email'] . '"')->row_array();
        if (!empty($query)) { 
            $this->db->query("update staff set password='" . md5($pwd) . "' where id='" . $query["id"] . "'");
        } else {
            $insert_data = array(
                'id' => '',
                'type' => 4,
                'first_name' => $data['first_name'],
                'middle_name' => '',
                'last_name' => $data['last_name'],
                'birth_date' => '0000-00-00',
                'ssn_itin' => '',
                'department' => NULL,
                'phone' => '',
                'cell' => '',
                'extension' => '',
                'test' => NULL,
                'user' => $data['email'],
                'password' => md5($pwd),
                'security_level' => NULL,
                'status' => '1',
                'photo' => '',
                'is_delete' => 'n',
                'role' => '0',
                'office_manager' => $staffrequestedby
            );

            $this->db->insert('staff', $insert_data);
            return $this->db->insert_id();
        }
    }

    public function assign_client($data) {
        $userinfo = staff_info();
        $query = $this->db->query('select * from lead_management where id="' . $data['hiddenid'] . '"')->row_array();
        $query_staff = $this->db->query('select * from staff where user="' . $query['email'] . '"')->row_array();
        //print_r($query_staff); exit;

        if (!empty($query_staff)) {
            if ($data['client_type'] == 1) {
                $client_id = $data['client_list'];
            } else {
                $client_id = $data['individual_list'];
            }
            $sql = "insert into `referral_partner` (id,partner_id,assigned_by_usertype,assisned_by_userid,  assigned_clienttype,assigned_clientid,assigned_to_clienttype, assigned_to_clientid, status) 
                values 
                ('','" . $data['hiddenid'] . "','" . $userinfo['type'] . "','" . $userinfo['id'] . "', '" . $data['client_type'] . "', '" . $client_id . "','4','" . $query_staff['id'] . "','1')";
            if ($this->db->query($sql)) {
                $insert = $this->db->insert_id();
                $note_data = array(
                    'id' => '',
                    'ref_partner_table_id' => $insert,
                    'note' => $data['refnote']
                );
                $this->db->insert('referral_partner_note', $note_data);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function assign_lead($lead_id) {
        $userinfo = staff_info();
        $user_email = $userinfo['user'];
        $query = $this->db->query('select * from lead_management where email="' . $user_email . '"')->row_array();
        $sql = "insert into `referral_partner` (id,partner_id,assigned_by_usertype,assisned_by_userid,  assigned_clienttype,assigned_clientid,assigned_to_clienttype, assigned_to_clientid, status) 
                values 
                ('','" . $lead_id . "','" . $userinfo['type'] . "','" . $userinfo['id'] . "', '2', '" . $query['staff_requested_by'] . "', 0 ,0, '1')";
        if ($this->db->query($sql)) {
            $insert = $this->db->insert_id();
            return true;
        } else {
            return false;
        }
    }

    public function get_assigned_data($partner_id) {
        $query = $this->db->query('select * from referral_partner where partner_id="' . $partner_id . '"')->result_array();
        return $query;
    }

    public function get_assigned_client_name($client_type, $client_id) {
        if ($client_type == '1') {
            $query = $this->db->query('select name from company where id="' . $client_id . '"')->row_array();
        } else {
            $query = $this->db->query("select concat(last_name, ', ', first_name, ' ', middle_name) as name from individual where id='" . $client_id . "'")->row_array();
        }
        echo $query['name'];
    }

    public function getLeadDataByRefPartner($by, $status, $lead_type = '') {
        $userinfo = staff_info();
        $office = $userinfo['office'];
        $result = $this->db->query("select staff_id from office_staff where office_id in ('" . $office . "')")->result_array();
        $staff_ids = '';
        $i = 0;
        $len = count($result);
        foreach ($result as $r) {
            if ($i == $len - 1) {
                $staff_ids .= $r['staff_id'];
            } else {
                $staff_ids .= $r['staff_id'] . ',';
            }
            $i++;
        }
        $sql = "SELECT lm.id, lm.type as lead_type, lm.type_of_contact,rf.assigned_clientid, (case when lm.type = '1' then (select name from type_of_contact_prospect where id = lm.type_of_contact) else (select name from type_of_contact_referral where id = lm.type_of_contact) end) as type,concat(lm.last_name, ', ', lm.first_name) as name, (case when lm.status = '0' then 'New' when lm.status = '1' then 'Complete' when lm.status = '2' then 'Inactive' when lm.status = '3' then 'Active' else 'Unknown' end) as status, concat(s.last_name, ', ', s.first_name, ' ', s.middle_name) as requested_by, lm.submission_date, lm.active_date, lm.inactive_date, lm.complete_date, (select count(ln.id) from lead_notes as ln where ln.lead_id = lm.id) as notes from lead_management as lm inner join staff as s on s.id = lm.staff_requested_by inner join referral_partner as rf on rf.partner_id = lm.id where lm.type=1";
        $staffinfo = staff_info();
        if (isset($by) && $by != '') {
            if ($by == 1) {
                $sql .= " and rf.assigned_clientid=" . sess('user_id') . "";
            } elseif ($by == 2) {
                if ($staffinfo['role'] == 2) {
                    $sql .= ' and rf.assigned_clientid in (' . $staff_ids . ')';
                }
                $sql .= " and rf.assigned_clientid!=" . sess('user_id') . "";
            }
        } else {
            if ($staffinfo['type'] == 3) {
                if ($staffinfo['role'] == 1) {
                    $sql .= " and rf.assigned_clientid=" . sess('user_id') . "";
                } else {
                    $sql .= ' and rf.assigned_clientid in (' . $staff_ids . ')';
                }
            }
        }
        if (isset($status) && ($status == '1' || $status == '0' || $status == '2' || $status == '3')) {
            $sql .= " and lm.status=" . $status . "";
        }
        if ($lead_type != '') {
            $sql .= (stripos($sql, "where") ? ' AND ' : ' WHERE ') . 'lm.type_of_contact = "' . $lead_type . '"';
        }
        return $this->db->query($sql)->result_array();
    }

    public function count_leads_ref_by_refpartner($by, $status) {
        $userinfo = staff_info();
        $office = $userinfo['office'];
        $result = $this->db->query("select staff_id from office_staff where office_id in ('" . $office . "')")->result_array();
        $staff_ids = '';
        $i = 0;
        $len = count($result);
        foreach ($result as $r) {
            if ($i == $len - 1) {
                $staff_ids .= $r['staff_id'];
            } else {
                $staff_ids .= $r['staff_id'] . ',';
            }
            $i++;
        }
        $sql = "SELECT lm.id, lm.type as lead_type,rf.assigned_clientid, (case when lm.type = '1' then (select name from type_of_contact_prospect where id = lm.type_of_contact) else (select name from type_of_contact_referral where id = lm.type_of_contact) end) as type,concat(lm.last_name, ', ', lm.first_name) as name, (case when lm.status = '0' then 'New' when lm.status = '1' then 'Complete' when lm.status = '2' then 'Inactive' when lm.status = '3' then 'Active' else 'Unknown' end) as status, concat(s.last_name, ', ', s.first_name, ' ', s.middle_name) as requested_by, lm.submission_date, lm.active_date, lm.inactive_date, lm.complete_date, (select count(ln.id) from lead_notes as ln where ln.lead_id = lm.id) as notes from lead_management as lm inner join staff as s on s.id = lm.staff_requested_by inner join referral_partner as rf on rf.partner_id = lm.id where lm.type=1";
        $staffinfo = staff_info();
        if (isset($by) && $by != '') {
            if ($by == 1) {
                $sql .= " and rf.assigned_clientid=" . sess('user_id') . "";
            } elseif ($by == 2) {
                if ($staffinfo['role'] == 2) {
                    $sql .= ' and rf.assigned_clientid in (' . $staff_ids . ')';
                }
                $sql .= " and rf.assigned_clientid!=" . sess('user_id') . "";
            }
        } else {
            if ($staffinfo['type'] == 3) {
                if ($staffinfo['role'] == 1) {
                    $sql .= " and rf.assigned_clientid=" . sess('user_id') . "";
                } else {
                    $sql .= ' and rf.assigned_clientid in (' . $staff_ids . ')';
                }
            }
        }
        if (isset($status) && ($status == '1' || $status == '0' || $status == '2' || $status == '3')) {
            $sql .= " and lm.status=" . $status . "";
        }
        return $this->db->query($sql)->num_rows();
    }

    public function check_if_lead_assigned($lead_id) {
        return $this->db->query('select * from referral_partner where partner_id="' . $lead_id . '"')->num_rows();
    }

    public function get_type_of_contact_name($type_of_contact, $lead_type) {
        if ($lead_type == 1) {
            $table = 'type_of_contact_prospect';
        } else {
            $table = 'type_of_contact_referral';
        }
        return $this->db->query('select name from ' . $table . ' where id="' . $type_of_contact . '"')->row_array();
    }

    public function get_notes_ref_partner($lead_id) {
        return $this->db->query('select * from lead_notes where lead_id="' . $lead_id . '"')->num_rows();
    }

    public function get_assigned_by_staff_name($staff_id) {
        return $this->db->query('select * from staff where id="' . $staff_id . '"')->row_array();
    }

    public function get_ref_note_count($ref_partner_table_id) {
        return $this->db->query('select * from referral_partner_note where ref_partner_table_id="' . $ref_partner_table_id . '"')->num_rows();
    }

    public function get_note_data($ref_partner_table_id) {
        $this->db->select('rfn.*,ref.*');
        $this->db->from('referral_partner_note rfn');
        $this->db->join('referral_partner ref', 'ref.id = rfn.ref_partner_table_id');
        $this->db->where('rfn.ref_partner_table_id', $ref_partner_table_id);
        return $this->db->get()->result_array();
    }

    public function addRefPartnerClientNotes($data) {
        $ref_partner_table_id = $data['ref_partner_table_id'];
        $note = $data['referral_partner_note'];
        foreach ($note as $n) {
            $ndata = array('id' => '', 'ref_partner_table_id' => $ref_partner_table_id, 'note' => $n);
            $this->db->insert('referral_partner_note', $ndata);
        }
        return true;
    }

    public function get_user_who_referred_id($user_id) {
        return $this->db->query('select * from staff where id="' . $user_id . '"')->row_array();
    }

    public function delete_reffererd_leads($id,$assigned_client_id){
        $this->db->trans_begin();

        $this->db->where('id',$id)->delete("lead_management");
        $this->db->where('reference_id',$assigned_client_id)->delete("notes");
        $this->db->where('partner_id',$id)->delete("referral_partner");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }           
    }

    public function delete_referral_partners($id){
        $this->db->trans_begin();

        $this->db->where('id',$id)->delete("lead_management");
        $this->db->where('partner_id',$id)->delete("referral_partner");

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }
    public function is_staff_check($data) {
        $email = $data['email'];
        return $this->db->get_where('staff',array('user'=>$email))->num_rows();
    }
    public function getPartnerData() {
        return $this->db->get_where('lead_management',array('type'=>'2'))->result_array();
    }
}
