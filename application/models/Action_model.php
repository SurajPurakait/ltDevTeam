<?php

class Action_model extends CI_Model {

    private $action_select, $filter_element;

    public function __construct() {
        parent::__construct();
        $this->load->model("notes");
        $this->load->model("system");
        $this->load->model("service");
        $this->load->model("administration");
        $this->load->model("service_model");
        $this->load->model("billing_model");
        $this->action_select[] = 'act.id AS id';
        $this->action_select[] = 'act.added_by_user AS added_by_user';
        $this->action_select[] = 'act.added_by_user AS staff_id';
        $this->action_select[] = 'act.client_id AS client_id';
        $this->action_select[] = 'act.message AS message';
        $this->action_select[] = 'act.creation_date AS creation_date';
        $this->action_select[] = 'act.priority AS priority';
        $this->action_select[] = 'act.complete_date AS complete_date';
        $this->action_select[] = 'act.start_date AS start_date';
        $this->action_select[] = 'act.due_date AS due_date';
        $this->action_select[] = 'act.office AS office_id';
        $this->action_select[] = 'act.created_office AS created_office';
        $this->action_select[] = 'act.created_department AS created_department';
        $this->action_select[] = '(SELECT office.name FROM office WHERE office.id = act.office) AS office_name';
        $this->action_select[] = 'act.my_task AS my_task';
        $this->action_select[] = 'act.status AS status';
        $this->action_select[] = 'act.is_all AS is_all';
        $this->action_select[] = '(CASE WHEN act.status = 0 THEN \'0\' WHEN act.status = 1 THEN \'1\' WHEN act.status = 2 THEN \'2\' WHEN act.status = 6 THEN \'6\' WHEN act.status = 7 THEN \'7\' ELSE \'Unknown\' END) AS filter_status';
        $this->action_select[] = '(CASE WHEN act.status = 0 THEN \'New\' WHEN act.status = 1 THEN \'Started\' WHEN act.status = 6 THEN \'Resolved\' WHEN act.status = 2 THEN \'Completed\' WHEN act.status = 7 THEN \'Canceled\' ELSE \'Unknown\' END) AS tracking_status';
        $this->action_select[] = 'CONCAT(st.last_name, \', \', st.first_name, \' \', st.middle_name) as user_name';
        $this->action_select[] = 'dprt.name as department_name';
        $this->action_select[] = 'act.department as department_id';

        $this->action_select[] = '(SELECT COUNT(act_nt.id) FROM action_notes AS act_nt WHERE act_nt.action_id = act.id) AS notes';
        $this->action_select[] = '(SELECT COUNT(act_fl.id) FROM action_files AS act_fl WHERE act_fl.action_id = act.id) AS files';
        $this->action_select[] = '(SELECT COUNT(act_stf.id) FROM action_staffs AS act_stf WHERE act_stf.action_id = act.id) AS action_staff_count';
        $this->action_select[] = 'REPLACE(CONCAT(",",(SELECT GROUP_CONCAT(act_stf2.staff_id) FROM action_staffs AS act_stf2 WHERE act_stf2.action_id = act.id),","), " ", "") AS all_action_staffs';
        $this->action_select[] = '(SELECT COUNT(frss.id) FROM file_read_status_staff AS frss WHERE frss.reference_id = act.id AND frss.reference = "action" AND frss.read_status = "n") AS unread_files_count';

        $this->filter_element = [
            1 => "priority",
            2 => "filter_status",
            3 => "office_id",
            4 => "department_id",
            5 => "start_date",
            6 => "complete_date",
            7 => "id",
            8 => "added_by_user",
            9 => "all_action_staffs",
            10 => "client_id",
            11 => "creation_date",
            12 => "due_date",
            13 => "request_type",
            14 => "created_department",
            15 => "created_office"
        ];

        $this->sales_tax_filter_element = [
            "client" => "client_id",
            "state" => "state_id",
            "county" => "county_id",
            "added by" => "added_by_user",
            "start_date" => "start_date",
            "complete_date" => "complete_date",
            "period" => "period_of_time",
            "tracking" => "status"
        ];
    }

    public function get_action_list($request = '', $status = '', $priority = '', $office_id = '', $department_id = '', $filter_assign = '', $filter_data = [], $sos_value = '', $sort_criteria = '', $sort_type = '') {
//        print_r($filter_data);die;
        $user_info = staff_info();
        $user_department = $user_info['department'];
        $user_type = $user_info['type'];
        $staff_id = sess('user_id');
        $role = $user_info['role'];
        $user_office = $user_info['office'];
        $office_staff = $department_staff = $departments = $action_id = [];
        if ($user_type == 3 && $role == 2) {
            $office_staff = array_column($this->administration->get_all_office_staff($staff_id), 'staff_id');
            $office_staff = array_unique($office_staff);
        }
        if ($user_type == 2 && $role == 4) {
            if ($user_department != '14') {
                $dept_ids = $this->db->get_where('department_staff', ['staff_id' => $staff_id])->result_array();
                $departments = array_column($dept_ids, 'department_id');
                $this->db->where_in('department_id', array_column($dept_ids, 'department_id'));
                $department_staffs = $this->db->get('department_staff')->result_array();
                $department_staff = array_column($department_staffs, 'staff_id');
                $department_staff = array_unique($department_staff);
                //$action_id = $this->get_request_to_others_action_by_staff_id($staff_id);
            }
        }
        $select = implode(', ', $this->action_select);
        $this->db->select($select);
        $this->db->select('subject', 'id');
        // $this->db->select('id');
        $this->db->from('actions AS act');
//        $this->db->join('action_assign_to_department_rel AS ass_dept', 'ass_dept.action_id = act.id');
        $this->db->join('department AS dprt', 'dprt.id = act.department');
        $this->db->join('staff AS st', 'st.id = act.added_by_user');
        if (isset($sos_value) && $sos_value != '') {
            $this->db->join('sos_notification AS sos', 'sos.reference_id = act.id');
            $this->db->join('sos_notification_staff AS sns', 'sns.sos_notification_id = sos.id');
        }
        $having = [];
        if ($request != '') {

            if ($request == 'byme') {
//            echo $status;die;

                $this->db->where(['added_by_user' => $staff_id, 'my_task' => 0]);
            } elseif ($request == 'tome') {
                $having[] = 'all_action_staffs LIKE "%,' . $staff_id . ',%" AND added_by_user != "' . $staff_id . '" AND my_task = "0"';
            } elseif ($request == 'byother') {
                if ($user_type == 1 || ($user_type == 2 && $user_department == 14)) {
                    $this->db->where(['my_task' => 0, 'added_by_user!=' => $staff_id]);
                }
                if ($user_type == 3 && $role == 2) {
                    unset($office_staff[array_search(sess('user_id'), $office_staff)]);
                    $this->db->where(['my_task' => 0]);
                    if (!empty($office_staff)) {
                        $this->db->where_in('added_by_user', $office_staff);
                    } else {
                        $this->db->where('act.id', 0);
                    }
                }
                if ($user_type == 2 && $role == 4) {
                    if ($user_department != 14) {
                        // unset($department_staff[array_search(sess('user_id'), $department_staff)]);
                        $this->db->where(['my_task' => 0]);
                        if (!empty($department_staff)) {
                            $this->db->where_in('added_by_user', $department_staff);
                        } else {
                            $this->db->where('act.id', 0);
                        }
                    }
                }
            } elseif ($request == 'toother') {
                if ($user_type == 3 && $role == 2) {
                    unset($office_staff[array_search(sess('user_id'), $office_staff)]);
                    $like_staffs = [];
                    foreach ($office_staff as $staffID) {
                        $like_staffs[] = 'all_action_staffs LIKE "%,' . $staffID . ',%"';
                    }
                    if (!empty($like_staffs)) {
                        // this condition is removed for changing the to others logic all_action_staffs NOT LIKE "%,' . $staff_id . ',%" AND 
                        $having[] = '(' . implode(' OR ', $like_staffs) . ') AND added_by_user != "' . $staff_id . '" AND my_task = "0" AND is_all = "1"';
                    } else {
                        $having[] = 'added_by_user != "' . $staff_id . '" AND my_task = "0" AND act.id = "0"';
                    }
                }
                if ($user_type == 2 && $role == 4) {
                    if ($user_department != 14) {
                        if (!empty($departments)) {

                            $having[] = 'all_action_staffs LIKE "%,' . $staff_id . ',%" AND department_id IN (' . implode(',', $departments) . ') AND added_by_user != "' . $staff_id . '" AND my_task = "0" AND is_all = "1"';
                             // print_r($having);die;
                        } else {
                            $having[] = 'added_by_user != "' . $staff_id . '" AND my_task = "0" AND act.id = "0"';
                        }
                    }
                }
            } elseif ($request == 'mytask') {
                $this->db->where(['added_by_user' => $staff_id, 'my_task' => $staff_id]);
            } elseif ($request == 'unassigned') {
                if ($user_type == 1 || ($user_type == 2 && $user_department == 14)) {
                    $having[] = 'action_staff_count > 1 AND added_by_user != "' . $staff_id . '" AND my_task = "0"';
                } else {
                    $having[] = 'action_staff_count > 1 AND department_id IN (' . $user_department . ') AND added_by_user != "' . $staff_id . '" AND my_task = "0"';
                }
            } else {
//                $where='(all_action_staffs LIKE "%,' . $staff_id . ',%" AND added_by_user != "' . $staff_id . '" AND my_task = "0") OR (added_by_user="' .$staff_id. '" AND my_task= "0")';
//                $this->db->where($where);
//                $this->db->where(['added_by_user' => $staff_id, 'my_task' => 0]);
                $having[] = 'all_action_staffs LIKE "%,' . $staff_id . ',%" AND added_by_user != "' . $staff_id . '" OR added_by_user="' . $staff_id . '"';
            }
        } else {
            $having_or = [];
            if ($user_type == 1 || ($user_type == 2 && $user_department == 14)) {
                $this->db->where_in('my_task', [0, $staff_id]);
            } else if ($user_type == 3 && $role == 2) {
                if (!empty($office_staff)) {
                    $having_or[] = 'all_action_staffs LIKE "%,' . $staff_id . ',%"';
                    $having_or[] = 'added_by_user IN (' . implode(',', $office_staff) . ')';
                    $having_or[] = 'my_task = "' . $staff_id . '"';
                    unset($office_staff[array_search(sess('user_id'), $office_staff)]);
                    foreach ($office_staff as $staffID) {
                        $having_or[] = 'all_action_staffs LIKE "%,' . $staffID . ',%"';
                    }
                    $having[] = '(' . implode(' OR ', $having_or) . ')';
                } else {
                    $having[] = '(all_action_staffs LIKE "%,' . $staff_id . ',%" OR my_task = "' . $staff_id . '")';
                }
            } else if ($user_type == 2 && $role == 4) {
                if ($user_department != 14) {
                    if (!empty($departments)) {
                        $having_or[] = 'all_action_staffs LIKE "%,' . $staff_id . ',%"';
                        if (!empty($department_staff)) {
                            $having_or[] = 'added_by_user IN (' . implode(',', $department_staff) . ')';
                        }
                        $having_or[] = 'my_task = "' . $staff_id . '"';
                        $having_or[] = 'department_id IN (' . implode(',', $departments) . ')';
                        $having[] = '(' . implode(' OR ', $having_or) . ')';
                    } else {
                        $having[] = '(all_action_staffs LIKE "%,' . $staff_id . ',%" OR my_task = "' . $staff_id . '")';
                    }
                }
            } else {
                $having[] = '(all_action_staffs LIKE "%,' . $staff_id . ',%" OR added_by_user = "' . $staff_id . '" OR my_task = "' . $staff_id . '")';
            }
        }

        if ($priority != '') {
            $this->db->where('priority', $priority);
        }
        if (isset($sos_value) && $sos_value != '') {
            if ($sos_value == 'tome') {
                $this->db->where(['sns.staff_id' => sess('user_id'), 'sos.reference' => 'action', 'sns.read_status' => 0, 'sos.added_by_user!=' => sess('user_id')]);
            } elseif ($sos_value == "byme") {
                $this->db->where(['sos.reference' => 'action', 'sns.read_status' => 0, 'sos.added_by_user' => sess('user_id')]);
                $this->db->where(['sns.staff_id' => sess('user_id')]);
            } elseif ($sos_value == 'byother') {
//                $this->db->where(['sos.reference' => 'action', 'sns.read_status' => 0,'sos.added_by_user'=>83]);
                if ($user_type == 3 && $role == 2) {
                    unset($office_staff[array_search(sess('user_id'), $office_staff)]);
                    if (!empty($office_staff)) {
                        $this->db->where(['sos.reference' => 'action', 'sns.read_status' => 0]);
                        $this->db->where_in('sos.added_by_user', $office_staff);
                    }
                }
                if ($user_type == 2 && $role == 4) {
                    if ($user_department != 14) {
                        // unset($department_staff[array_search(sess('user_id'), $department_staff)]);
                        if (!empty($department_staff)) {
                            $this->db->where(['sos.reference' => 'action', 'sns.read_status' => 0]);
                            $this->db->where_in('sos.added_by_user', $department_staff);
                        }
                    }
                }
            } elseif ($sos_value == 'toother') {
                $this->db->where(['sos.reference' => 'action', 'sns.read_status' => 0, 'sos.added_by_user!=' => sess('user_id')]);
                $this->db->where(['sns.staff_id!=' => sess('user_id')]);
            }
        }

        if ($office_id != '') {
            $this->db->where('act.office', $office_id);
        } else {
            if ($user_type != 1 && $user_department != 14) {
                //if($role==2 || $role==4){
                $this->db->group_start();
                $this->db->where_in('act.office', explode(",", $user_office))->or_where_in('act.created_office', explode(",", $user_office));
                $this->db->group_end();
                //}
            }
        }

        if ($department_id != '') {
            if ($department_id != 14) {
                $this->db->where('department_id', $department_id);
            }
        }

        if ($filter_assign == 1) {
            $having[] = 'action_staff_count = 1';
        } else if ($filter_assign == 2) {
            $having[] = 'action_staff_count != 1';
        }
        if (!empty($filter_data)) {
            if (isset($filter_data['variable_dropdown'])) {
                foreach ($filter_data['variable_dropdown'] as $key => $variable_value) {
                    if (isset($variable_value) && $variable_value != '') {
                        $condition_value = isset($filter_data['condition_dropdown'][$key]) ? $filter_data['condition_dropdown'][$key] : 1;
                        if (isset($condition_value) && $condition_value != '') {
                            $column_name = $this->filter_element[$variable_value];
                            if ($variable_value == 13) {    #request_type_start
                                $filter_request = isset($filter_data['criteria_dropdown']['request_type'][0]) ? $filter_data['criteria_dropdown']['request_type'][0] : '';
                                if ($filter_request == 'byme') {
                                    $this->db->where(['added_by_user' => $staff_id, 'my_task' => 0]);
                                } elseif ($filter_request == 'tome') {
                                    $having[] = 'all_action_staffs LIKE "%,' . $staff_id . ',%" AND added_by_user != "' . $staff_id . '" AND my_task = "0"';
                                } elseif ($filter_request == 'byother') {
                                    if ($user_type == 1 || ($user_type == 2 && $user_department == 14)) {
                                        $this->db->where(['my_task' => 0, 'added_by_user!=' => $staff_id]);
                                    }
                                    if ($user_type == 3 && $role == 2) {
                                        unset($office_staff[array_search(sess('user_id'), $office_staff)]);
                                        $this->db->where(['my_task' => 0]);
                                        if (!empty($office_staff)) {
                                            $this->db->where_in('added_by_user', $office_staff);
                                        } else {
                                            $this->db->where('act.id', 0);
                                        }
                                    }
                                    if ($user_type == 2 && $role == 4) {
                                        if ($user_department != 14) {
                                            $this->db->where(['my_task' => 0]);
                                            if (!empty($department_staff)) {
                                                $this->db->where_in('added_by_user', $department_staff);
                                            } else {
                                                $this->db->where('act.id', 0);
                                            }
                                        }
                                    }
                                } elseif ($filter_request == 'toother') {
                                    if ($user_type == 3 && $role == 2) {
                                        unset($office_staff[array_search(sess('user_id'), $office_staff)]);
                                        $like_staffs = [];
                                        foreach ($office_staff as $staffID) {
                                            $like_staffs[] = 'all_action_staffs LIKE "%,' . $staffID . ',%"';
                                        }
                                        if (!empty($like_staffs)) {
                                            $having[] = 'all_action_staffs NOT LIKE "%,' . $staff_id . ',%" AND (' . implode(' OR ', $like_staffs) . ') AND added_by_user != "' . $staff_id . '" AND my_task = "0"';
                                        } else {
                                            $having[] = 'added_by_user != "' . $staff_id . '" AND my_task = "0" AND act.id = "0"';
                                        }
                                    }
                                    if ($user_type == 2 && $role == 4) {
                                        if ($user_department != 14) {
                                            if (!empty($departments)) {
                                                $having[] = 'all_action_staffs NOT LIKE "%,' . $staff_id . ',%" AND department_id IN (' . implode(',', $departments) . ') AND added_by_user != "' . $staff_id . '" AND my_task = "0"';
                                            } else {
                                                $having[] = 'added_by_user != "' . $staff_id . '" AND my_task = "0" AND act.id = "0"';
                                            }
                                        }
                                    }
                                } elseif ($filter_request == 'mytask') {
                                    $this->db->where(['added_by_user' => $staff_id, 'my_task' => $staff_id]);
                                } elseif ($filter_request == 'unassigned') {
                                    if ($user_type == 1 || ($user_type == 2 && $user_department == 14)) {
                                        $having[] = 'action_staff_count > 1 AND added_by_user != "' . $staff_id . '" AND my_task = "0"';
                                    } else {
                                        $having[] = 'action_staff_count > 1 AND department_id IN (' . $user_department . ') AND added_by_user != "' . $staff_id . '" AND my_task = "0"';
                                    }
                                } else {
                                    $having[] = 'all_action_staffs LIKE "%,' . $staff_id . ',%" AND added_by_user != "' . $staff_id . '" OR added_by_user="' . $staff_id . '"';
                                }
                                #request_type_end
                            } else {
                                $having[] = $this->build_filter_query($variable_value, $condition_value, $filter_data['criteria_dropdown'], $column_name);
                            }
                        }
                    }
                }
            }
        }

        if ($status != '') {
//            echo $status;die;
            if ($status == '0' || $status == '1' || $status == '6' || $status == '2' || $status == '7') {
                $this->db->where('act.status', $status);
            } else if ($status == 3) {
                $this->db->where('act.status!=', 2);
            }
        } else {
            if ($status == '2') {
                $this->db->where('act.status', $status);
            } else {
                if (empty($filter_data)) {
                    $this->db->where_not_in('act.status', [2, 7]);
                    $this->db->where_in('act.status', [0, 1, 6]);
                } else {
                    if (isset($filter_data['criteria_dropdown']['tracking'])) {
//                        echo 'a';die;
                        $filter_array = $filter_data['criteria_dropdown']['tracking'];
                        if (in_array('2', $filter_array)) {
                            $this->db->where_not_in('act.status', [7]);
                        } elseif (in_array('7', $filter_array)) {
                            $this->db->where_not_in('act.status', [2]);
                        } else {
                            $this->db->where_not_in('act.status', [2, 7]);
                        }
                    } else {
//                        echo 'b';die;
                        $this->db->where_in('act.status', [0, 1, 2, 7, 6]);
                    }
                }
            }
        }

        if (count($having) != 0) {
            $this->db->having(implode(' AND ', $having));
        }
        $this->db->group_by('act.id');
        if ($sort_criteria != '') {
            $this->db->order_by($sort_criteria, $sort_type);
        } else {
            $this->db->order_by("act.id", "DESC");
        }
        $result = $this->db->get()->result_array();
        //print_r($result);
//        echo $this->db->last_query();die;
        return $result;
    }

    public function get_lanuage_list($id) {
        return $this->db->get_where("languages", ['status' => '1', 'id' => $id])->row_array();
    }

    public function get_country_list($id) {
        return $this->db->get_where("countries", ['id' => $id])->row_array();
    }

    public function get_staff_name() {
        return $this->db->query("select staff.id,CONCAT(staff.last_name,' ', staff.first_name)as name from staff")->result_array();
    }

    public function get_client_details() {
        return $this->db->query("select new_company.company_id,new_company.name1 as name  from new_company")->result_array();
    }

    public function ajax_client_type($client) {
        return $this->db->query("select * from sales_tax_process where sales_tax_process.client_id = '" . $client . "'")->result_array();
    }

    public function ajax_added_by($added_by) {
        return $this->db->query("select * from sales_tax_process where sales_tax_process.added_by_user = '" . $added_by . "'")->result_array();
    }

    public function get_departments() {
        $this->db->select('dp.*');
        $this->db->from('department AS dp');
        $this->db->join('department_staff AS dpst', 'dpst.department_id = dp.id');
        $this->db->group_by('dp.id');
        $this->db->where('dp.id !=', 1);
        $this->db->order_by('name', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_departments_for_action() {
        $this->db->select('dp.*');
        $this->db->from('department AS dp');
        $this->db->join('department_staff AS dpst', 'dpst.department_id = dp.id');
        $this->db->group_by('dp.id');
        // $this->db->where('dp.id !=', 1);
        $this->db->order_by('name', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_corp_departments($dept_str = '') {

        $staff_info = staff_info();

        if ($staff_info['type'] == 1) {
            return $this->db
                            ->where('type !=', '2')
                            ->get("department")
                            ->result_array();
        } else {
            if ($dept_str != '') {
                return $this->db
                                ->where('type !=', '2')
                                ->where_in('id', explode(',', $dept_str))
                                ->get("department")
                                ->result_array();
            } else {
                return $this->db
                                ->where('type !=', '2')
                                ->get("department")
                                ->result_array();
            }
        }
    }

    public function get_sentto_office_for_dashboard_dd() {
        $staff_info = staff_info();
        $ofc_arr = array();
//        print_r($staff_info);
        $sql = 'SELECT asf.staff_id FROM actions a INNER JOIN action_staffs asf ON(a.id=asf.action_id) WHERE a.added_by_user=' . $staff_info['id'];
        $staff_arr1 = $this->db->query($sql)->result_array();
        $staff_arr_mod1 = array_map(function($value) {
            return $value['staff_id'];
        }, $staff_arr1);
        $staff_id_arr = array_unique($staff_arr_mod1);
//        print_r($staff_id_arr);
        if (!empty($staff_id_arr)) {
            $sql3 = 'SELECT ofc.id,ofc.name FROM office ofc INNER JOIN office_staff os ON(ofc.id=os.office_id) WHERE os.staff_id IN(' . implode(',', $staff_id_arr) . ') AND ofc.type=2 GROUP BY ofc.id';
            $ofc_arr = $this->db->query($sql3)->result_array();
        }
//        print_r($ofc_arr);
        return $ofc_arr;
    }

    public function get_sentfrom_office_for_dashboard_dd() {
        $staff_info = staff_info();
        $ofc_arr = array();
        $sql2 = 'SELECT a.added_by_user FROM actions a INNER JOIN action_staffs asf ON(a.id=asf.action_id) WHERE asf.staff_id=' . $staff_info['id'];
        $staff_arr2 = $this->db->query($sql2)->result_array();
        $staff_arr_mod2 = array_map(function($value2) {
            return $value2['added_by_user'];
        }, $staff_arr2);
        $staff_id_arr = array_unique($staff_arr_mod2);
//        print_r($staff_id_arr);
        if (!empty($staff_id_arr)) {
            $sql3 = 'SELECT ofc.id,ofc.name FROM office ofc INNER JOIN office_staff os ON(ofc.id=os.office_id) WHERE os.staff_id IN(' . implode(',', $staff_id_arr) . ') AND ofc.type=2 GROUP BY ofc.id';
            $ofc_arr = $this->db->query($sql3)->result_array();
        }
//        print_r($ofc_arr);
        return $ofc_arr;
    }

    public function get_sentto_staff_for_dashboard_dd() {
//                . 'INNER JOIN action_assign_to_department_rel asdr ON(a.id=asdr.action_id) '   remove from $sql join 
        $staff_info = staff_info();
        $staff_arr = array();
//        print_r($staff_info);
        $sql = 'SELECT asf.staff_id '
                . 'FROM actions a '
                . 'INNER JOIN action_staffs asf ON(a.id=asf.action_id) '
                . 'WHERE a.added_by_user=' . $staff_info['id'] . ' AND asdr.is_all=0';
        $staff_arr1 = $this->db->query($sql)->result_array();
        $staff_arr_mod1 = array_map(function($value) {
            return $value['staff_id'];
        }, $staff_arr1);
        $staff_id_arr = array_unique($staff_arr_mod1);
        if (!empty($staff_id_arr)) {
            $sql3 = 'SELECT s.id,CONCAT(s.last_name,", ",s.first_name," ",s.middle_name) as name '
                    . 'FROM staff s '
                    . 'INNER JOIN department_staff ds ON(s.id=ds.staff_id) '
                    . 'INNER JOIN department d ON(ds.department_id=d.id)'
                    . 'WHERE s.id IN(' . implode(',', $staff_id_arr) . ') AND d.type!=2 '
                    . 'GROUP BY s.id';
            $staff_arr = $this->db->query($sql3)->result_array();
        }
        return $staff_arr;
    }

    public function get_sentfrom_staff_for_dashboard_dd() {
        $staff_info = staff_info();
        $staff_arr = array();

        $sql2 = 'SELECT a.added_by_user '
                . 'FROM actions a '
                . 'INNER JOIN action_staffs asf ON(a.id=asf.action_id) '
                . 'WHERE asf.staff_id=' . $staff_info['id'] . '';
        $staff_arr2 = $this->db->query($sql2)->result_array();
        $staff_arr_mod2 = array_map(function($value2) {
            return $value2['added_by_user'];
        }, $staff_arr2);
        $staff_id_arr = array_unique($staff_arr_mod2);
        if (!empty($staff_id_arr)) {
            $sql3 = 'SELECT s.id,CONCAT(s.last_name,", ",s.first_name," ",s.middle_name) as name '
                    . 'FROM staff s '
                    . 'INNER JOIN department_staff ds ON(s.id=ds.staff_id) '
                    . 'INNER JOIN department d ON(ds.department_id=d.id)'
                    . 'WHERE s.id IN(' . implode(',', $staff_id_arr) . ') AND d.type!=2 '
                    . 'GROUP BY s.id';
            $staff_arr = $this->db->query($sql3)->result_array();
        }
        return $staff_arr;
    }

    public function get_sentto_department_for_dashboard_dd() {
        $staff_info = staff_info();
        $staff_arr = array();
        $staffid = $staff_info['id'];
//        $sql2 = 'SELECT a.department '
//                . 'FROM actions a '
//                . 'WHERE a.added_by_user=' . $staff_info['id'] . ' AND a.is_all=1 AND a.department_type!=2';
//        $staff_arr2 = $this->db->query($sql2)->result_array();
        $this->db->select('department');
        $this->db->where(['added_by_user' => $staffid, 'is_all' => 1]);
        $this->db->where('department_type!=', 2);
        $staff_arr2 = $this->db->get('actions')->result_array();
        $staff_arr_mod2 = array_map(function($value2) {
            return $value2['department'];
        }, $staff_arr2);

        $staff_id_arr = array_unique($staff_arr_mod2);

        if (!empty($staff_id_arr)) {
            $sql3 = 'SELECT id,name FROM department WHERE id IN(' . implode(',', $staff_id_arr) . ')';
            $staff_arr = $this->db->query($sql3)->result_array();
        }
        return $staff_arr;
    }

    public function get_staff_by_department($department_id) {
        return $this->db->query("select staff.id, concat(staff.last_name, ', ', staff.first_name, ' ',staff.middle_name) as name from staff inner join department_staff on department_staff.staff_id = staff.id where staff.is_delete = 'n' and department_staff.department_id = '$department_id'")->result_array();
    }

    public function add_new_action($data, $files) {
        // echo "<pre>";
        // print_r($data);
//        echo "</pre>";die;
        $staff_info = staff_info();
        $user_id = sess("user_id");
        if (isset($data['assign_to_myself'])) {
            $is_all = '2';
        } else {
            $is_all = $data["is_all"];
        }

        if (isset($data["action_notes"])) {
            $notes = $data["action_notes"];
            unset($data["action_notes"]);
        }

        // if (isset($data["office"])) {
        //     $notes = $data["office"];
        //     unset($data["office"]);
        // }

        if (isset($data["is_all"]) && $data["is_all"] == 2) {
            $data['my_task'] = $user_id;
        } elseif (isset($data['assign_to_myself'])) {
            $data['my_task'] = $user_id;
        }
        if (isset($data["staff"])) {
            $staffs = $data["staff"];
            unset($data["staff"]);
        } else {
            if (isset($data["is_all"]) && $data["is_all"] != 2) {
                $dept_staff = $this->db->query('select * from department_staff where department_id="' . $data["department"] . '"')->result_array();
                if (!empty($dept_staff)) {
                    foreach ($dept_staff as $key => $value) {
                        $staffs[$key] = $value['staff_id'];
                    }
                }
            } else {
                $staffs[0] = sess('user_id');
            }
        }
        unset($data["is_all"]);
        if ($data['due_date'] != '') {
            $date = date('Y-m-d', strtotime($data['due_date']));
        } else {
            $date = '';
        }
        if (isset($data['assign_to_myself'])) {
            $dept = $this->db->query('select * from department_staff where staff_id="' . $user_id . '"')->row_array();
            if (isset($dept)) {
                $data['department'] = $dept['department_id'];
            }
            // $ofc = $data['office_id'];
            // if (isset($ofc)) {
            //     $data['office'] = $ofc;
            // }
        }
        unset($data['assign_to_myself']);
        if (isset($data['my_task']) && $data['my_task'] != '') {
            $data['is_all'] = 0;
        } else {
            $data['is_all'] = $is_all;
        }
        $actions = array_merge($data, ["added_by_user" => $user_id, "status" => 0, "due_date" => $date]);

//        print_r($notes);die;
        $this->db->trans_begin();
        $this->db->insert('actions', $actions);
        $id = $this->db->insert_id();

        $staff_user_add_ofc = $staff_info['office'];
        // $ex = explode(",", $staff_user_add_ofc);
        // foreach ($ex as $o) {
        //     $insert_action_add_by_user_office = array(
        //         'id' => '',
        //         'action_id' => $id,
        //         'office_id' => $o
        //     );
        //     $this->db->insert('action_add_by_user_office', $insert_action_add_by_user_office);
        // }
//        $dept_type_arr = $this->db->query('select type from department where id="' . $data["department"] . '"')->result_array();
//        if (isset($is_all) && $is_all == 1)
//            $this->db->insert('action_assign_to_department_rel', ["action_id" => $id, "department_id" => $data["department"], "department_type" => $dept_type_arr[0]['type'], "is_all" => 1]);
//        else
//            $this->db->insert('action_assign_to_department_rel', ["action_id" => $id, "department_id" => $data["department"], "department_type" => $dept_type_arr[0]['type'], "is_all" => 0]);


        foreach ($staffs as $value) {
            $this->db->insert('action_staffs', ["action_id" => $id, "staff_id" => $value]);
        }
        if (!empty($notes)) {
            $this->notes->insert_note(2, $notes, "action_id", $id);
        }
        if (!empty($files["name"])) {
            $filesCount = count($files['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['userFile']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $files['name'][$i]));
                $_FILES['userFile']['type'] = $files['type'][$i];
                $_FILES['userFile']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['userFile']['error'] = $files['error'][$i];
                $_FILES['userFile']['size'] = $files['size'][$i];

                $uploadPath = FCPATH . 'uploads/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = "*";

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('userFile')) {
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                    $uploadData[$i]['added_by_user'] = sess('user_id');
                    $uploadData[$i]['action_id'] = $id;
                }
            }
        }
        $this->db->insert("tracking_logs", ["stuff_id" => $this->session->userdata("user_id"), "status_value" => '0', "section_id" => $id, "related_table_name" => "actions", "comment" => ""]);
        if (!empty($uploadData)) {
            $this->db->insert_batch('action_files', $uploadData);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            $this->system->save_general_notification('action', $id, 'insert', $staffs);
            return $id;
        }
    }

    public function insert_client_action($data) {
        $staff_info = staff_info();

        // $action_data['created_office'] = strstr($staff_info['office'], ",", true); 
        // $action_data['created_department']=strstr($staff_info['department'],",",true);
        $office = explode(",", $staff_info['office']);
        $action_data['created_office'] = $office[0];

        $action_data['created_department'] = $staff_info['department'];
        if (isset($data['office']) && $data['office'] != '') {
            $action_data['office'] = $data['office'];
        } else {
            $action_data['office'] = 17;
        }

        if (isset($data['message']) && $data['message'] != '') {
            if (strpos($data['message'], 'order #') !== false) {
                $pos = strpos($data['message'], "on order #") + 10;
                $order_id = trim(substr($data['message'], $pos));
                if (is_numeric($order_id)) {
                    $invoice_info = $this->billing_model->get_invoice_by_order_id($order_id);
                    if (!empty($invoice_info)) {
                        $invoice_id = $invoice_info['id'];
                        $data['message'] = substr_replace($data['message'], '<a href="' . base_url('services/home/view/' . $order_id) . '" target="_blank">' . $invoice_id . '</a>', $pos);
                    }
                }
            }
            $action_data['message'] = $data['message'];
        } else {
            $action_data['office'] = 'New Client Created';
        }

        if (isset($data['subject']) && $data['subject'] != '') {
            $action_data['subject'] = $data['subject'];
        } else {
            $action_data['subject'] = 'New Action Created';
        }
        if (isset($data['reference'])) {
            if ($data['reference'] == 'individual') {
                $action_data['client_id'] = $data['last_name'] . ', ' . $data['first_name'] . ' ' . $data['middle_name'];
                //$action_data['message'] = 'New Individual Created';
            }
            if ($data['reference'] == 'company') {
                if (isset($data['name_of_business1']) && $data['name_of_business1'] != '') {
                    $action_data['client_id'] = $data['name_of_business1'];
                } elseif (isset($data['new_company']['name1']) && $data['new_company']['name1'] != '') {
                    $action_data['client_id'] = $data['new_company']['name1'];
                }
            }
        }
        if (!isset($data['client'])) {
            if ($staff_info['type'] == 3) {
                return 1;
            }
        }

        if (isset($data['department']) && $data['department'] != '') {
            $action_data['department'] = $data['department'];
        } else {
            $action_data['department'] = 6;
        }

        if (isset($data['service_id']) && $data['service_id'] != '') {
            $service_info = $this->service_model->get_service_by_id($data['service_id']);
            if (!empty($service_info)) {
                $action_data['department'] = $service_info['service_department'];
            }
        }

        if (isset($data['priority']) && $data['priority'] != '') {
            $action_data['priority'] = 3;
        } else {
            $action_data['priority'] = 3;
        }
        $action_data['status'] = 0;
        $action_data['added_by_user'] = sess('user_id');

        // print_r($action_data);exit;
        if (isset($data['is_all']) && $data['is_all'] != '') {
            $action_data['is_all'] = $data['is_all'];
        } else {
            $action_data['is_all'] = 1;
        }
        $this->db->trans_begin();
        $this->db->insert('actions', $action_data);
        $action_id = $this->db->insert_id();


//        $this->db->insert('action_assign_to_department_rel', ["action_id" => $action_id, "department_id" => $action_data['department'], "department_type" => 1, "is_all" => $is_all]);

        $department_staffs = $this->db->get_where('department_staff', ['department_id' => $action_data['department']])->result_array();
        foreach ($department_staffs as $ds) {
            $this->db->insert('action_staffs', ["action_id" => $action_id, "staff_id" => $ds['staff_id']]);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            $this->system->save_general_notification('action', $action_id, 'insert');
            return "1";
        }
    }

    public function get_current_status($table_name, $id) {
        return $this->db->query("select status from $table_name where id = '$id'")->row_array()["status"];
    }

    public function update_action_status($id, $status, $comment, $all_staffs = []) {

        $this->db->trans_begin();

        $this->db->select('COUNT(id) as data_count');
        $this->db->where('stuff_id', $this->session->userdata("user_id"));
        $this->db->where('status_value', $status);
        $this->db->where('section_id', $id);
        $this->db->where('related_table_name', 'actions');
        $data_count = $this->db->get('tracking_logs')->row_array();
        if ($data_count['data_count'] == 0) {
            $this->db->insert("tracking_logs", ["stuff_id" => $this->session->userdata("user_id"), "status_value" => $status, "section_id" => $id, "related_table_name" => "actions", "comment" => ""]);
            if (isset($comment) && $comment != "") {
                $notes[] = $comment;
                $this->notes->insert_note(2, $notes, "action_id", $id, 'action');
            }
        }
        $data = ["status" => $status];
        if ($status == "1") {
            $data["start_date"] = date('Y-m-d');
        } else if ($status == "2") {
            $action_dates = $this->db->get('actions', array('id' => $id))->row_array();
            // print_r($action_dates);exit; 
            if ($action_dates['start_date'] == '0000-00-00') {
                $data["start_date"] = date('Y-m-d');
            }

            $data["complete_date"] = date('Y-m-d');
        }
        $this->db->where("id", $id)->update("actions", $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $this->system->save_general_notification('action', $id, 'tracking', $all_staffs);
            return true;
        }
    }

    public function get_tracking_log($id, $table_name) {
        return $this->db->query("SELECT s.id,concat(s.last_name, ', ', s.first_name, ' ', s.middle_name) as stuff_id, s.department as department, case when tracking_logs.status_value = '0' then 'New' when tracking_logs.status_value = '1' then 'Started' 
            when tracking_logs.status_value = '6' then 'Resolved'
            when tracking_logs.status_value = '2' then 'Completed' when tracking_logs.status_value = '7' then 'Canceled' else tracking_logs.status_value end as status, tracking_logs.created_time,tracking_logs.comment as comment FROM `tracking_logs` inner join staff as s on tracking_logs.stuff_id = s.id where tracking_logs.section_id = '$id' and tracking_logs.related_table_name = '$table_name' order by tracking_logs.id desc")->result_array();
    }

    public function load_count_data() {
        $user_info = staff_info();
        $user_dept = $user_info['department'];
        $usertype = $user_info['type'];
        $staff_id = sess('user_id');
        if ($usertype == 3) {
            $role = $user_info['role'];
            if ($role == 1) {
                $sql = "select (select count(*) from actions where added_by_user = '$staff_id' and status = '0') as requested_by_me_new, (select count(*) from actions where added_by_user = '$staff_id' and status = '1') as requested_by_me_started, (select count(*) from actions where added_by_user = '$staff_id' and status = '2') as requested_by_me_completed, (select count(a.id) from actions as a inner join action_staffs as asf on asf.action_id = a.id where asf.staff_id = '$staff_id' and a.status = '0') as requested_to_me_new, (select count(a.id) from actions as a inner join action_staffs as asf on asf.action_id = a.id where asf.staff_id = '$staff_id' and a.status = '1') as requested_to_me_started, (select count(a.id) from actions as a inner join action_staffs as asf on asf.action_id = a.id where asf.staff_id = '$staff_id' and a.status = '2') as requested_to_me_completed";
            } else {

//                $fran_ofc = $user_info['office'];
//                $ofc_staffs = $this->db->query("select * from office_staff where office_id='" . $fran_ofc . "'")->result_array();
//                if (!empty($ofc_staffs)) {
//                    $i = 0;
//                    $len = count($ofc_staffs);
//                    $staff_array = '';
//                    foreach ($ofc_staffs as $os) {
//                        if ($i == $len - 1) {
//                            $staff_array .= $os['staff_id'];
//                        } else {
//                            $staff_array .= $os['staff_id'] . ',';
//                        }
//                        $i++;
//                    }
//                    $staff_array_val = explode(",", $staff_array);
//                    $sql_by_me = '';
//                    $sql_to_me = '';
//                    $j = 0;
//                    $lenj = count($staff_array_val);
//                    if ($lenj > 1) {
//                        foreach ($staff_array_val as $val) {
//                            if ($j == 0) {
//                                $sql_by_me .= " where (added_by_user = '$val'";
//                                $sql_to_me .= " where (asf.staff_id = '$val'";
//                            } elseif ($j == $lenj - 1) {
//                                $sql_by_me .= " or added_by_user = '$val')";
//                                $sql_to_me .= " or asf.staff_id = '$val')";
//                            } else {
//                                $sql_by_me .= " or added_by_user = '$val'";
//                                $sql_to_me .= " or asf.staff_id = '$val'";
//                            }
//                            $j++;
//                        }
//                    } else {
//                        foreach ($staff_array_val as $val) {
//                            $sql_by_me .= " where (added_by_user = '$val')";
//                            $sql_to_me .= " where (asf.staff_id = '$val')";
//                            $j++;
//                        }
//                    }
//                }
//                $sql = "select (select count(*) from actions" . $sql_by_me . " and status = '0') as requested_by_me_new, (select count(*) from actions" . $sql_by_me . " and status = '1') as requested_by_me_started, (select count(*) from actions" . $sql_by_me . " and status = '2') as requested_by_me_completed, (select count(a.id) from actions as a inner join action_staffs as asf on asf.action_id = a.id" . $sql_to_me . " and a.status = '0') as requested_to_me_new, (select count(a.id) from actions as a inner join action_staffs as asf on asf.action_id = a.id" . $sql_to_me . " and a.status = '1') as requested_to_me_started, (select count(a.id) from actions as a inner join action_staffs as asf on asf.action_id = a.id" . $sql_to_me . " and a.status = '2') as requested_to_me_completed";
                $sql = "select (select count(*) from actions where added_by_user = '$staff_id' and status = '0') as requested_by_me_new, (select count(*) from actions where added_by_user = '$staff_id' and status = '1') as requested_by_me_started, (select count(*) from actions where added_by_user = '$staff_id' and status = '2') as requested_by_me_completed, (select count(a.id) from actions as a where a.department = 2 and a.office in({$user_info['office']}) and a.status = '0') as requested_to_me_new, (select count(a.id) from actions as a where a.department = 2 and a.office in({$user_info['office']}) and a.status = '1') as requested_to_me_started, (select count(a.id) from actions as a where a.department = 2 and a.office in({$user_info['office']}) and a.status = '2') as requested_to_me_completed";
            }
        } else {
            $sql = "select (select count(*) from actions where added_by_user = '$staff_id' and status = '0') as requested_by_me_new, (select count(*) from actions where added_by_user = '$staff_id' and status = '1') as requested_by_me_started, (select count(*) from actions where added_by_user = '$staff_id' and status = '2') as requested_by_me_completed, (select count(a.id) from actions as a inner join action_staffs as asf on asf.action_id = a.id where asf.staff_id = '$staff_id' and a.status = '0') as requested_to_me_new, (select count(a.id) from actions as a inner join action_staffs as asf on asf.action_id = a.id where asf.staff_id = '$staff_id' and a.status = '1') as requested_to_me_started, (select count(a.id) from actions as a inner join action_staffs as asf on asf.action_id = a.id where asf.staff_id = '$staff_id' and a.status = '2') as requested_to_me_completed";
        }
        //print_r($sql);
        return $this->db->query($sql)->result_array()[0];
    }

    public function get_action_notes($id) {
        return $this->db->where("action_id", $id)->get("action_notes")->result_array();
    }

    public function get_action_files($id) {
        return $this->db->where("action_id", $id)->get("action_files")->result_array();
    }

    public function fetch_data($id) {
        $sql = "select a.*, group_concat(distinct(asf.staff_id) separator ',') as staffs, group_concat(distinct(an.note) separator ',') as notes, group_concat(distinct(af.file_name) separator ',') as files from actions as a left join action_staffs as asf on asf.action_id = a.id left join action_notes as an on an.action_id = a.id left join action_files as af on af.action_id = a.id where a.id = '$id'";
        $this->db->query('SET SQL_BIG_SELECTS=1');
        return $this->db->query($sql)->row_array();
    }

    public function get_files_by_action_id($action_id) {
        $this->db->where('action_id', $action_id);
        return $this->db->get('action_files')->result_array();
    }

    public function get_files_by_sales_tax_process_id($sales_tax_process_id) {
        $this->db->where('sales_tax_process_id', $sales_tax_process_id);
        return $this->db->get('sales_tax_process_files')->result_array();
    }

    public function delete_file_by_id($file_id) {
        $this->db->where('id', $file_id);
        return $this->db->delete('action_files');
    }

    public function delete_sales_file_by_id($file_id) {
        $this->db->where('id', $file_id);
        return $this->db->delete('sales_tax_process_files');
    }

    public function get_file_by_id($file_id) {
        $this->db->where('id', $file_id);
        return $this->db->get('action_files')->row_array();
    }

    public function get_sales_file_by_id($file_id) {
        $this->db->where('id', $file_id);
        return $this->db->get('sales_tax_process_files')->row_array();
    }

    public function edit_action($action_id, $data, $files) {
//        print_r($data);echo "<br>";
        if (isset($data['assign_to_myself'])) {
            $is_all = '2';
            $data["is_all"] = '2';
        } else {
            $is_all = $data["is_all"];
        }
        unset($data['assign_to_myself']);
        $old_dept_id = 0;
        if (isset($data["action_notes"])) {
            $notes = $data["action_notes"];
            unset($data["action_notes"]);
        }
        if (isset($data["old_department_id"])) {
            $old_dept_id = $data["old_department_id"];
            unset($data["old_department_id"]);
        }
        if ($data["is_all"] == 2) {
            $data['my_task'] = sess('user_id');
        }

        if (isset($data["edit_action_notes"])) {
            $edit_action_notes = $data["edit_action_notes"];
            unset($data["edit_action_notes"]);
        }
        if ($data["is_all"] == 2) {
            $staffs[0] = sess('user_id');
        } else {
            if (isset($data["staff"])) {
                $staffs = $data["staff"];
            }
        }
        unset($data["is_all"]);
        unset($data["staff"]);

        if ($data['staff-hidden'] == 1) {
            $staff_hidden = $data["staff-hidden"];
        } else {
            $staff_hidden = 0;
        }
        unset($data["staff-hidden"]);
        if ($data['due_date'] != '') {
            $data['due_date'] = date('Y-m-d', strtotime($data['due_date']));
        }
        if (isset($data['my_task']) && $data['my_task'] != '') {
            $data['is_all'] = 0;
        } else {
            $data['my_task'] = 0;
            $data['is_all'] = $is_all;
        }

        $actions = $data;
        $this->db->trans_begin();
//        print_r($actions);
//        echo "<br>".$action_id."<br>".$staff_hidden."<br>";
//        print_r($staffs);die;
        $this->db->set($actions)->where("id", $action_id)->update('actions');

//        $is_exist_all_arr = $this->db->query('select COUNT(id) as count_data from action_assign_to_department_rel where action_id="' . $action_id . '" and department_id="' . $data["department"] . '"')->result_array();
//        $dept_type_arr = $this->db->query('select type from department where id="' . $data["department"] . '"')->result_array();
//        if ($is_exist_all_arr[0]['count_data'] == 0) {
//            echo 'a';die;
//            if (isset($is_all) && $is_all == 1)
//                $this->db->insert('action_assign_to_department_rel', ["action_id" => $action_id, "department_id" => $data["department"], "department_type" => $dept_type_arr[0]['type'], "is_all" => 1]);
//            else
//                $this->db->insert('action_assign_to_department_rel', ["action_id" => $action_id, "department_id" => $data["department"], "department_type" => $dept_type_arr[0]['type'], "is_all" => 0]);
//        }else {
//            echo 'b';die;
//            if (isset($is_all) && $is_all == 1)
//                $this->db->set(["department_id" => $data["department"], "department_type" => $dept_type_arr[0]['type'], "is_all" => 1])->where("action_id", $action_id)->where("department_id", $old_dept_id)->update('action_assign_to_department_rel');
//            else
//                $this->db->set(["department_id" => $data["department"], "department_type" => $dept_type_arr[0]['type'], "is_all" => 0])->where("action_id", $action_id)->where("department_id", $old_dept_id)->update('action_assign_to_department_rel');
//        }
//        die;
        if (!empty($notes)) {
            $this->notes->insert_note(2, $notes, "action_id", $action_id);
        }

        if (!empty($edit_action_notes)) {
            $this->notes->update_note(2, $edit_action_notes);
        }

        if ($staff_hidden != 1 || $staff_hidden == 1) {
            $this->db->delete('action_staffs', ["action_id" => $action_id]);
            if (!empty($staffs)) {
                foreach ($staffs as $value) {
                    $this->db->insert('action_staffs', ["action_id" => $action_id, "staff_id" => $value]);
                }
            }
        }


        if (!empty($files["name"])) {
            $filesCount = count($files['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['userFile']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $files['name'][$i]));
                $_FILES['userFile']['type'] = $files['type'][$i];
                $_FILES['userFile']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['userFile']['error'] = $files['error'][$i];
                $_FILES['userFile']['size'] = $files['size'][$i];

                $uploadPath = FCPATH . 'uploads/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = "*";

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('userFile')) {
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                    $uploadData[$i]['added_by_user'] = sess('user_id');
                    $uploadData[$i]['action_id'] = $action_id;
                }
            }
        }

        if (!empty($uploadData)) {
            $this->db->insert_batch('action_files', $uploadData);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            if (($key = array_search(sess('user_id'), $staffs)) !== false) {
                unset($staffs[$key]);
            }
            $this->db->where(['reference_id' => $action_id, 'reference' => 'action', 'action' => 'edit']);
            $this->db->delete('general_notifications');
            $this->system->save_general_notification('action', $action_id, 'edit', $staffs);
            return "1";
        }
    }

    public function get_actions_count($status = null) {
        $user_info = staff_info();
        $user_dept = $user_info['department'];
        $usertype = $user_info['type'];
        $staff_id = sess('user_id');

        if ($usertype == 3) {
            $role = $user_info['role'];
            if ($role == 1) {
                $sql = "select a.id, a.client_id, a.message, a.creation_date, a.priority, a.complete_date, a.start_date, (case when a.status = '0' then 'New' when a.status = '1' then 'Started' when a.status = '2' then 'Completed' else 'Unknown' end) as tracking_status , concat(u.last_name, ', ', u.first_name, ' ', u.middle_name) as user_name, d.name as department_name, (select count(an.id) from action_notes as an where an.action_id = a.id) as notes, (select count(af.id) from action_files as af where af.action_id = a.id) as files from actions as a left join staff as u on u.id = a.added_by_user left join department as d on d.id = a.department inner join action_staffs as asf on asf.action_id = a.id where (a.added_by_user = '$staff_id' or asf.staff_id = '$staff_id') and a.status = '$status' group by a.id";
            } else {
                $sql = "select a.id, a.added_by_user, a.client_id, a.message, a.creation_date, a.priority, a.complete_date, a.start_date, (case when a.status = '0' then 'New' when a.status = '1' then 'Started' when a.status = '2' then 'Completed' else 'Unknown' end) as tracking_status , concat(u.last_name, ', ', u.first_name, ' ', u.middle_name) as user_name, d.name as department_name, (select count(an.id) from action_notes as an where an.action_id = a.id) as notes, (select count(af.id) from action_files as af where af.action_id = a.id) as files from actions as a left join staff as u on u.id = a.added_by_user left join department as d on d.id = a.department inner join action_staffs as asf on asf.action_id = a.id";

                $fran_ofc = $user_info['office'];
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
                                $sql .= " where (a.added_by_user = '$val' or asf.staff_id = '$val'";
                            } elseif ($j == $lenj - 1) {
                                $sql .= " or a.added_by_user = '$val' or asf.staff_id = '$val')";
                            } else {
                                $sql .= " or a.added_by_user = '$val' or asf.staff_id = '$val'";
                            }
                            $j++;
                        }
                    } else {
                        foreach ($staff_array_val as $val) {
                            $sql .= " where (a.added_by_user = '$val' or asf.staff_id = '$val')";
                            $j++;
                        }
                    }
                }
                $sql .= " and a.status = '$status' group by a.id";
            }
        } else {
            $sql = "select a.id, a.client_id, a.message, a.creation_date, a.priority, a.complete_date, a.start_date, (case when a.status = '0' then 'New' when a.status = '1' then 'Started' when a.status = '2' then 'Completed' else 'Unknown' end) as tracking_status , concat(u.last_name, ', ', u.first_name, ' ', u.middle_name) as user_name, d.name as department_name, (select count(an.id) from action_notes as an where an.action_id = a.id) as notes, (select count(af.id) from action_files as af where af.action_id = a.id) as files from actions as a left join staff as u on u.id = a.added_by_user left join department as d on d.id = a.department inner join action_staffs as asf on asf.action_id = a.id where (a.added_by_user = '$staff_id' or asf.staff_id = '$staff_id') and a.status = '$status' group by a.id";
        }

        //echo $sql;

        return $this->db->query($sql)->num_rows();
    }

    public function getFilesContent($id) {
        $query = $this->db->query("select * from action_files where action_id='" . $id . "'");
        return $query->result_array();
    }

    public function updateFileReadStatus($id) {
        $this->db->set('read_status', 'y');
        $this->db->where('reference_id', $id);
        $this->db->update('file_read_status_staff');
    }

    public function msg_details($action_id) {
        $query = $this->db->query("select * from actions where id='" . $action_id . "'");
        return $query->row_array();
    }

    public function get_office_by_department_id($department_id) {
        $staff_info = staff_info();
        $this->load->model("administration");
        if ($staff_info['type'] == 3) {
            if ($department_id == 2) {
                return $this->administration->get_office_by_staff_id(sess("user_id"));
            } else {
                $this->db->where("type", 1);
                return $this->db->get("office")->result_array();
            }
        } elseif ($staff_info['type'] == 2 && $department_id == 2) {
            $this->db->where("type", 2);
            return $this->db->get("office")->result_array();
        } elseif ($staff_info['type'] == 1) {
            if ($department_id == 2) {
                $this->db->where("type", 2);
            } else {
                $this->db->where("type", 1);
            }
            $this->db->where("status", 1);
            return $this->db->get("office")->result_array();
        } else {
            return $this->administration->get_office_by_staff_id(sess("user_id"));
            // return $this->db->get("office")->result_array();
        }
    }

    public function get_staff_by_department_id_office_id($department_id, $office_id) {
        $staff_info = staff_info();
        $this->db->select("st.id, concat(st.last_name, ', ', st.first_name, ' ',st.middle_name) as name");
        $this->db->from("staff st");
        $this->db->join("office_staff ofc", "st.id = ofc.staff_id");
        $this->db->join("department_staff dprt", "st.id = dprt.staff_id");
//        echo $staff_info['type'];
//        $staff_info['type'] == 3 && 
        if ($department_id == 2) {
            $this->db->where("ofc.office_id", $office_id);
        }
//        elseif ($staff_info['type'] == 3 && $department_id != 2) {
//            $this->db->where("ofc.office_id", $office_id);
//        } else {
//            $this->db->where("ofc.office_id", $office_id);
//        }
        $this->db->where("dprt.department_id", $department_id);
        $this->db->where("st.status", '1');
        $this->db->where('st.first_name is NOT NULL', NULL, FALSE);
        $this->db->where('st.middle_name is NOT NULL', NULL, FALSE);
        $this->db->where('st.last_name is NOT NULL', NULL, FALSE);
        $r = $this->db->get()->result_array();
//        echo $this->db->last_query();
        return $r;
    }

    public function request_create_business($data) {
//        print_r($data);
        $this->load->model("company_model");
        $this->load->model("internal_model");
        $this->db->trans_begin();
        if ($data['editval'] == '') {
            $this->load->model('notes');
            $this->load->model('system');
            $this->load->model('internal_model');

            $conn = $this->db;
            $data['company']['name'] = $data['new_company']['name1'];
            $data['company']['id'] = $data['reference_id'];
            $reference_id = $data['reference_id'];

            if (!$this->company_model->save_company_data($data['company'])) {
                return false;
            } else {
                $this->company_model->remove_company_temp_flag($reference_id);
            }
            $data['internal_data']['reference_id'] = $reference_id;
            $data['internal_data']['reference'] = "company";
            $data['internal_data']['practice_id'] = $data['internal_data']['practice_id'];
            // Save company internal data
            if (!$this->internal_model->save_internal_data($data['internal_data'])) {
                return false;
            }

            // Save name options for the new company
            $this->company_model->save_company_name_options($data['new_company'], $reference_id);

            $order_data = [
                'order_date' => date('Y-m-d h:i:s'),
                'tracking' => time(),
                'staff_requested_service' => $this->system->getLoggedUserId(),
                'reference' => 'company',
                'reference_id' => $reference_id,
                'status' => 2,
                'category_id' => 1,
                'service_id' => 0,
                'status' => 10
            ];
            // Create a new order for this request
            $order_result = $this->db->insert('order', $order_data);
            if ($order_result) {
                $order_id = $this->db->insert_id();
            } else {
                return false;
            }

            // Create the service request
            $this->system->log("insert", "order", $order_id);
//            print_r($_FILES['attachments']);die;
            if ($_FILES['attachments']['name'] != '') {
                if ($this->uploadpdffiles($_FILES['attachments'])) {
                    $attachment_filename = $this->file_uploaded;
                } else {
                    $attachment_filename = '';
                }
            } else {
                $attachment_filename = '';
            }
            $sql = "update company set file_name='$attachment_filename' where id='$reference_id'";
            $this->db->query($sql);

            //$data = (object) $data;
            if (isset($data->notes)) {
                $this->notes->insert_note(1, $data['notes'], 'reference_id', $data['reference_id'], $data['reference']);
            }



            $data['subject'] = 'New Client Has Been Added';
            $data['client'] = 'business';
            $data['message'] = staff_info()['full_name'] . ' has added a new client';
            $this->action_model->insert_client_action($data);



            /* mail section */

//            $user_id = sess('user_id');
//            $ci = &get_instance();
//            $ci->load->model('staff');
//            $user_info = $ci->staff->StaffInfo($user_id);
//            $user_type = $user_info[0]['department'];
//            $user_email = "'" . $user_info[0]['user'] . "'";
//            $user_name = $user_info[0]['first_name'] . ' ' . $user_info[0]['last_name'];
//            $admin_email = 'mike@taxleaf.com';
//
//            //if ($user_type == 'Franchise') {
//
//            $config = Array(
//                'protocol' => 'smtp',
//                'smtp_host' => 'ssl://smtp.gmail.com',
//                'smtp_port' => 465,
//                'smtp_user' => 'codetestml001@gmail.com', // change it to yours
//                'smtp_pass' => 'codetest@123', // change it to yours
//                'mailtype' => 'html',
//                'charset' => 'iso-8859-1',
//                'wordwrap' => TRUE
//            );
//            $email_subject = 'Order #' . $order_id . ' has been successfully placed';
//
//
//            $message = '<table cellpadding="0" cellspacing="0" style=" font-family:Arial, Helvetica, sans-serif; font-size:11px;">
//                            <tr>
//                                <td>' .
//                    $user_name .
//                    ',<BR/><BR/> Order #' . $order_id . ' has been successfully placed on your LeafCloud Portal.
//                                    Click here to access this order now!
//                                    </td>
//                                    </tr>
//                                    <tr>
//                                    <td><BR/><BR/><BR/><BR/>
//                                    Sincerely,<br/>
//                                    Admin<br/>
//                                </td>
//                            </tr>
//                        </table>';
//
//            $ci->load->library('email', $config);
//            $ci->email->set_newline("\r\n");
//            $ci->email->from('codetestml001@gmail.com'); // change it to yours
//            $ci->email->to($user_email); // change it to yours
//            $ci->email->cc($admin_email);
//            $ci->email->subject($email_subject);
//            $ci->email->message($message);
//            $ci->email->send();
            //}
        } else {
            $conn = $this->db;
//            print_r($data);exit;
            $this->load->model('Company');
            $this->load->model('Internal');
            $this->load->model('System');
            $this->load->model('Notes');

            $data['name'] = $data['new_company']['name1'];
            $data['business_description'] = $data['company']['business_description'];
            $data['type'] = $data['company']['type'];
            $data['state'] = $data['company']['state_opened'];
            $data['fiscal_year_end'] = $data['company']['fye'];
            $data['fein'] = $data['company']['fein'];
            $data['dba'] = $data['company']['dba'];
//            $reference_id = $data['reference_id'];

            if (!$this->Company->saveCompany($data)) {
                return false;
            } else {
                $this->Company->removeCompanyTempFlag($data['reference_id']);
            }
            $data = (object) $data;
            if (isset($data->notes)) {
                $this->Notes->update_note(1, $data->notes);
            }
            if (isset($data->notes)) {
                $this->Notes->insert_note(1, $data->notes, 'reference_id', $data->reference_id);
            }

            // Save company internal data
            $this->load->model('Internal');
            $data = (array) $data;
            $data['office'] = $data['internal_data']['office'];
            $data['partner'] = $data['internal_data']['partner'];
            $data['manager'] = $data['internal_data']['manager'];
            $data['referred_by_source'] = $data['internal_data']['referred_by_source'];
            $data['referred_by_name'] = $data['internal_data']['referred_by_name'];
            $data['client_association'] = $data['internal_data']['client_association'];
            $data['practice_id'] = $data['internal_data']['practice_id'];
            $data['language'] = $data['internal_data']['language'];
            if (!$this->Internal->saveInternalData($data)) {
                return false;
            }
            $this->company_model->save_company_name_options($data['new_company'], $data['reference_id']);
            // Save name options for the new company
            // $data['name_of_business2'] = $data['new_company']['name2'];
            // $data['name_of_business3'] = $data['new_company']['name3'];
            // $this->Company->saveCompanyNameOptions($data);
//            $this->Notes->saveupdateNotes($data);
            $data = (object) $data;

            // Create a new order for this request
            $tracking = time();

            $orderid = $data->editval;
            $this->System->log("insert", "order", $order_id);
        }

        /* mail section */
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    // public function load_individual_data() {
    //     $ofc_id = request('ofc_id');
    //     $manager_id = request('manager_id');
    //     $partner_id = request('partner_id');
    //     $ref_source = request('ref_source');
    //     $user_info = staff_info();
    //     $user_dept = $user_info['department'];
    //     $usertype = $user_info['type'];
    //     $staff_id = sess('user_id');
    //     $this->db->select("ind.id,ind.first_name,ind.middle_name,ind.last_name,ind.birth_date,ind.ssn_itin,ind.type,ind.language,ind.country_residence,ind.country_citizenship,tit.company_id,tit.individual_id,tit.title,tit.percentage,int.office,int.partner,int.manager,int.client_association,int.referred_by_source,int.referred_by_name,int.language as int_language,int.reference_id,int.practice_id");
    //     $this->db->from("individual ind");
    //     $this->db->join("title tit", "ind.id = tit.individual_id");
    //     $this->db->join("internal_data int", "int.reference_id = ind.id and int.reference='individual'");
    //     //$this->db->join("referred_by_source rs", "int.referred_by_source = rs.id");
    //     //$this->db->join("office", "office.id = int.office");
    //     if ($usertype == 3) {
    //         $this->db->where_in("int.office", explode(',', $user_info['office']));
    //     }
    //     if ($ofc_id != '') {
    //         $this->db->where("int.office", $ofc_id);
    //     }
    //     if ($manager_id != '') {
    //         $this->db->where("int.manager", $manager_id);
    //     }
    //     if ($partner_id != '') {
    //         $this->db->where("int.partner", $partner_id);
    //     }
    //     if ($ref_source != "") {
    //         $this->db->where("int.referred_by_source", $ref_source);
    //     }
    //     $this->db->where("ind.status", '1');
    //     $this->db->group_by('ind.id');
    //     //$this->db->limit(1);
    //     $result = $this->db->get()->result_array();
    //     //echo $this->db->last_query();exit;
    //     return $result;
    // }

    public function load_individual_data() {
        ## Read value
        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $ofc_id = request('ofc_id');
        $manager_id = request('manager_id');
        $partner_id = request('partner_id');
        $ref_source = request('ref_source');


        $user_info = staff_info();
        $user_dept = $user_info['department'];
        $usertype = $user_info['type'];
        $staff_id = sess('user_id');

        $this->db->select("ind.id,ind.status,TRIM(ind.first_name) as first_name,TRIM(ind.last_name) as last_name,ind.birth_date,ind.ssn_itin,ind.type,ind.language,ind.country_residence,ind.country_citizenship,tit.company_id,tit.individual_id,tit.title,tit.percentage,int.office,int.partner,int.manager,int.client_association,int.referred_by_source,int.referred_by_name,int.language as int_language,int.reference,int.reference_id,int.practice_id,ofc.office_id");
        $this->db->from("individual ind");
        $this->db->join("title tit", "tit.individual_id = ind.id");
        $this->db->join("internal_data int", "int.reference_id = ind.id and int.reference='individual'");
        //$this->db->join("referred_by_source rs", "int.referred_by_source = rs.id");
        $this->db->join("office ofc", "ofc.id = int.office");
        //if ($usertype == 3 || ($usertype==2 && $user_dept!=14)) {
        if ($usertype == 3) {
            $this->db->where_in("int.office", explode(',', $user_info['office']));
        }
        if ($ofc_id != '') {
            $this->db->where("int.office", $ofc_id);
        }
        if ($manager_id != '') {
            $this->db->where("int.manager", $manager_id);
        }
        if ($partner_id != '') {
            $this->db->where("int.partner", $partner_id);
        }
        if ($ref_source != "") {
            $this->db->where("int.referred_by_source", $ref_source);
        }
        if ($searchValue != '') {
            $this->db->group_start();
            $this->db->like('int.practice_id', $searchValue);
            $this->db->or_like('ind.first_name', $searchValue);
            $this->db->or_like('ind.last_name', $searchValue);
            $this->db->or_like('ofc.office_id', $searchValue);
            $this->db->group_end();
        }
        $this->db->where('first_name !=', null);
        $this->db->where('last_name !=', null);
        //$this->db->where("int.reference", "individual");
        // $this->db->where("ind.status", "1");
        $this->db->where_not_in("ind.status", [0, 3]);
        $this->db->group_by('ind.id');
        $res_for_all = $this->db->get()->num_rows();
        $qr = $this->db->last_query();
        $qr .= ' order by ' . $columnName . ' ' . $columnSortOrder;
        $qr .= ' limit ' . $row . ',' . $rowperpage;
        $result = $this->db->query($qr)->result_array();
        //echo $this->db->last_query(); exit;
        if (!empty($result)) {
            foreach ($result as $row) {
                if ($usertype == 1 || $usertype == 2 || $user_dept == 14 || $user_dept == 6) {
                    $edit = '&nbsp;&nbsp;<a title="EDIT" target="_blank" href="' . base_url("/action/home/edit_individual/" . $row["id"]) . '"><i class="fa fa-edit"></i>&nbsp;<span>Edit</span></a>&nbsp;&nbsp;';
                    $delete = '<a title="DELETE" href="javascript:void(0);" onclick="delete_individual(' . $row["id"] . ',\'delete\');"><i class="fa fa-trash"></i>&nbsp;<span>Delete</span></a>&nbsp;&nbsp;';
                    $inactive = '<a title="INACTIVE" style="font-size: 20px; color:green;" href="javascript:void(0);" onclick="inactive_individual(' . $row["id"] . ');"><i class="fa fa-check"></i>&nbsp;<span style="font-size:13px;">Active</span></a>';
                    $active = '<a title="ACTIVE" style="font-size: 20px; color:red;" href="javascript:void(0);" onclick="active_individual(' . $row["id"] . ');"><i class="fa fa-ban"></i>&nbsp;<span style="font-size:13px;">Inactive</span></a>';
                } else {
                    $edit = '';
                    $delete = '';
                    $inactive = '';
                    $active = '';
                }
                if ($row['status'] == 1) {
                    $data[] = array(
                        "first_name" => $row['first_name'],
                        "last_name" => $row['last_name'],
                        "practice_id" => $row['practice_id'],
                        "office_id" => $row['office_id'],
                        "action" => '<a title="VIEW" target="_blank" href="' . base_url("/action/home/view_individual/" . $row["id"]) . '"><i class="fa fa-eye"></i>&nbsp;<span>View</span></a>&nbsp;' . $edit . $delete . $inactive
                    );
                } elseif ($row['status'] == 2) {
                    $data[] = array(
                        "first_name" => $row['first_name'],
                        "last_name" => $row['last_name'],
                        "practice_id" => $row['practice_id'],
                        "office_id" => $row['office_id'],
                        "action" => '<a title="VIEW" target="_blank" href="' . base_url("/action/home/view_individual/" . $row["id"]) . '"><i class="fa fa-eye"></i>&nbsp;<span>View</span></a>&nbsp;' . $edit . $delete . $active
                    );
                }
            }
        } else {
            $data = array();
        }

        $totalRecords = $res_for_all;
        $totalRecordwithFilter = $res_for_all;
        //echo $this->db->last_query();exit;
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        return $response;
        //return $result;
    }

//     public function load_business_data() {
//         $user_info = staff_info();
// //        print_r($user_info);
//         $user_dept = $user_info['department'];
//         $usertype = $user_info['type'];
//         //$this->db->select("c.*,st.state_name,ct.type,ind.practice_id");
//         //$this->db->select("c.*,ct.type,ind.practice_id");
//         $this->db->select("c.*,ind.practice_id,ind.office");
//         $this->db->from("company c");
//         //$this->db->join("states st", "c.state_opened = st.id");
//         //$this->db->join("company_type ct", "c.type = ct.id");
// //        $this->db->join("order ord", "ord.reference_id = c.id");
//         $this->db->join("internal_data ind", "c.id = ind.reference_id");
//         if ($usertype == 3) {
//             $this->db->where_in("ind.office", explode(',', $user_info['office']));
//         }
//         if (post('ofc') != '') {
//             $this->db->where("ind.office", post('ofc'));
//         }
//         if (post('manager_id') != '') {
//             $this->db->where("ind.manager", post('manager_id'));
//         }
//         if (post('partner_id') != '') {
//             $this->db->where("ind.partner", post('partner_id'));
//         }
//         if (post('ref_source') != '') {
//             $this->db->where("ind.referred_by_source", post('ref_source'));
//         }
//         if (post('company_type') != "") {
//             $this->db->where("c.type", post('company_type'));
//         }
//         $this->db->where("ind.reference", "company");
//         $this->db->where("c.status", "1");
//         $this->db->group_by('c.name');
//         $data = $this->db->get()->result_array();
//         return $data;
//     }

    public function load_business_data() {
        ## Read value
        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        $ofc_id = request('ofc');
        $manager_id = request('manager_id');
        $partner_id = request('partner_id');
        $ref_source = request('ref_source');
        $company_type = request('company_type');


        $user_info = staff_info();
        $user_dept = $user_info['department'];
        $usertype = $user_info['type'];
        $staff_id = sess('user_id');

        $this->db->select("c.id,c.company_id,c.type,c.status,TRIM(c.name) as name,ind.practice_id,ofc.office_id,ind.reference,ind.office,ind.manager,ind.partner,ind.referred_by_source");
        $this->db->from("company c");
        //$this->db->join("states st", "c.state_opened = st.id");
        //$this->db->join("company_type ct", "c.type = ct.id");
//        $this->db->join("order ord", "ord.reference_id = c.id");
        $this->db->join("internal_data ind", "ind.reference_id = c.id and ind.reference = 'company'");
        $this->db->join("office ofc", "ofc.id = ind.office");
        //if ($usertype == 3 || ($usertype==2 && $user_dept!=14)) {
        if ($usertype == 3) {
            $this->db->where_in("ind.office", explode(',', $user_info['office']));
        }
        if ($ofc_id != '') {
            $this->db->where("ind.office", $ofc_id);
        }
        if ($manager_id != '') {
            $this->db->where("ind.manager", $manager_id);
        }
        if ($partner_id != '') {
            $this->db->where("ind.partner", $partner_id);
        }
        if ($ref_source != '') {
            $this->db->where("ind.referred_by_source", $ref_source);
        }
        if ($company_type != '') {
            $this->db->where("c.type", $company_type);
        }
        if ($searchValue != '') {
            $this->db->group_start();
            $this->db->like('ind.practice_id', $searchValue);
            $this->db->or_like('c.name', $searchValue);
            $this->db->or_like('ofc.office_id', $searchValue);
            $this->db->group_end();
        }
        //$this->db->where("ind.reference", "company");
        // $this->db->where("c.status", "1");
        $this->db->where_not_in("c.status", [0, 3]);
        //$this->db->group_by('c.name');
        $this->db->group_by('c.id');
        $res_for_all = $this->db->get()->num_rows();
        $qr = $this->db->last_query();
        $qr .= ' order by ' . $columnName . ' ' . $columnSortOrder;
        $qr .= ' limit ' . $row . ',' . $rowperpage;
        $result = $this->db->query($qr)->result_array();
        //echo $this->db->last_query(); exit;
        if (!empty($result)) {
            foreach ($result as $row) {
                if ($usertype == 1 || $usertype == 2 || $user_dept == 14 || $user_dept == 6) {
                    $edit = '&nbsp;&nbsp;<a title="EDIT" target="_blank" href="' . base_url("/action/home/edit_business/" . $row["id"] . "/" . $row["company_id"]) . '"><i class="fa fa-edit"></i><span>Edit</span></a>&nbsp;&nbsp;';
                    $delete = '<a title="DELETE" href="javascript:void(0);" onclick="delete_business(' . $row["id"] . ',' . $row["company_id"] . ',\'delete\');"><i class="fa fa-trash"></i>&nbsp;<span>Delete</span></a>&nbsp;&nbsp;';
                    $inactive = '<a title="INACTIVE" style="font-size: 20px; color:green;" href="javascript:void(0);" onclick="inactive_business(' . $row["id"] . ',' . $row["company_id"] . ');"><i class="fa fa-check"></i>&nbsp;<span style="font-size:13px;">Active</span></a>';
                    $active = '<a title="ACTIVE" style="font-size: 20px; color:red;" href="javascript:void(0);" onclick="active_business(' . $row["id"] . ',' . $row["company_id"] . ');"><i class="fa fa-ban"></i>&nbsp;<span style="font-size:13px;">Inactive</span></a>';
                } else {
                    $edit = '';
                    $delete = '';
                    $inactive = '';
                    $active = '';
                }
                if ($row['status'] == 1) {
                    $data[] = array(
                        "name" => $row['name'],
                        "practice_id" => $row['practice_id'],
                        "office_id" => $row['office_id'],
                        "action" => '<a title="VIEW" target="_blank" href="' . base_url("/action/home/view_business/" . $row["id"] . "/" . $row["company_id"]) . '"><i class="fa fa-eye"></i>&nbsp;<span>View</span></a>&nbsp;' . $edit . $delete . $inactive
                    );
                } else {
                    $data[] = array(
                        "name" => $row['name'],
                        "practice_id" => $row['practice_id'],
                        "office_id" => $row['office_id'],
                        "action" => '<a title="VIEW" target="_blank" href="' . base_url("/action/home/view_business/" . $row["id"] . "/" . $row["company_id"]) . '"><i class="fa fa-eye"></i>&nbsp;<span>View</span></a>&nbsp;' . $edit . $delete . $active
                    );
                }
            }
        } else {
            $data = array();
        }

        $totalRecords = $res_for_all;
        $totalRecordwithFilter = $res_for_all;
        //echo $this->db->last_query();exit;
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        return $response;
    }

    public function business_list($office_id = '') {
        $user_info = staff_info();
        $this->db->select("c.id,c.company_id,c.type,c.status,TRIM(c.name) as name,ind.practice_id,ofc.office_id,ind.reference,ind.office,ind.manager,ind.partner,ind.referred_by_source");
        $this->db->from("company c");
        $this->db->join("internal_data ind", "ind.reference_id = c.id and ind.reference = 'company'");
        $this->db->join("office ofc", "ofc.id = ind.office");
        if ($user_info['type'] == 3) {
            $this->db->where_in("ind.office", explode(',', $user_info['office']));
        }
        if ($office_id != '') {
            $this->db->where("ind.office", $office_id);
        }
        $this->db->where_not_in("c.status", [0, 3]);
        $this->db->group_by('c.id');
        return $this->db->get()->result_array();
    }

    public function individual_list($office_id = '') {
        $user_info = staff_info();
        $this->db->select("ind.id,ind.status,TRIM(ind.first_name) as first_name,TRIM(ind.last_name) as last_name,ind.birth_date,ind.ssn_itin,ind.type,ind.language,ind.country_residence,ind.country_citizenship,tit.company_id,tit.individual_id,tit.title,tit.percentage,int.office,int.partner,int.manager,int.client_association,int.referred_by_source,int.referred_by_name,int.language as int_language,int.reference,int.reference_id,int.practice_id,ofc.office_id");
        $this->db->from("individual ind");
        $this->db->join("title tit", "tit.individual_id = ind.id");
        $this->db->join("internal_data int", "int.reference_id = ind.id and int.reference='individual'");
        $this->db->join("office ofc", "ofc.id = int.office");
        if ($user_info['type'] == 3) {
            $this->db->where_in("int.office", explode(',', $user_info['office']));
        }
        if ($office_id != '') {
            $this->db->where("int.office", $office_id);
        }
        $this->db->where('first_name !=', null);
        $this->db->where('last_name !=', null);
        $this->db->where_not_in("ind.status", [0, 3]);
        $this->db->group_by('ind.id');
        return $this->db->get()->result_array();
    }

    public function get_individual_data($id) {
        $this->db->select("ind.id,ind.first_name,ind.middle_name,ind.last_name,ind.birth_date,ind.ssn_itin,ind.type,ind.language,ind.country_residence,ind.country_citizenship,tit.id as title_id,tit.company_id,tit.individual_id,tit.title,tit.percentage,int.office,int.partner,int.manager,int.client_association,int.referred_by_source,int.referred_by_name,int.language as int_language,int.reference_id,int.practice_id");
        $this->db->from("individual ind");
        $this->db->join("title tit", "ind.id = tit.individual_id");
        $this->db->join("internal_data int", "int.reference_id = ind.id and int.reference='individual'");
        $this->db->where("ind.id", $id);
        $this->db->group_by('ind.id');
        return $this->db->get()->row_array();
    }

    public function get_individual_data_old($id) {
        $this->db->select("ind.id,ind.first_name,ind.middle_name,ind.last_name,ind.birth_date,ind.ssn_itin,ind.type,ind.language,ind.country_residence,ind.country_citizenship,tit.id as title_id,tit.company_id,tit.individual_id,tit.title,tit.percentage,int.office,int.partner,int.manager,int.client_association,int.referred_by_source,int.referred_by_name,int.language as int_language,int.reference_id,int.practice_id");
        $this->db->from("individual ind");
        $this->db->join("title tit", "ind.id = tit.individual_id");
        $this->db->join("internal_data int", "int.reference_id = tit.company_id");
        $this->db->where("ind.id", $id);
        $this->db->group_by('ind.id');
        return $this->db->get()->row_array();
    }

    public function get_office_staffwise() {
        $staff_id = sess('user_id');
        $this->db->select('ofc.id, ofc.name');
        $this->db->from('office_staff os');
        $this->db->join('office ofc', 'os.office_id = ofc.id');
        $this->db->where(['os.staff_id' => $staff_id, 'ofc.status' => '1']);
        return $this->db->get()->result_array();
    }

    public function get_action_edit_permission($action_id) {
        $res = $this->db->get_where('action_staffs', ['action_id' => $action_id])->result_array();
        $all_staff = array_column($res, 'staff_id');
        $all_staff[] = sess('user_id');
        return $all_staff;
    }

    public function get_sales_tax_process($client_type, $added_by, $req_by, $status) {
        $staff_info = staff_info();
        $staff_id = sess('user_id');
        $staff_dept = $staff_info['department'];
        $stafftype = $staff_info['type'];
        $staffrole = $staff_info['role'];
        $staff_department = explode(',', $staff_info['department']);
        $office_staff = [];
        if ($stafftype == 3 && $staffrole == 2) {
            $office_staff = array_column($this->administration->get_all_office_staff($staff_id), 'staff_id');
        }

        if ($client_type != '') {
            $this->db->where(['client_id' => $client_type]);
        }
        if ($added_by != '') {
            $this->db->where(['added_by_user' => $added_by]);
        }
        if ($req_by != '') {
            if ($req_by == 1) {
                $this->db->where(['added_by_user' => sess('user_id')]);
            } else {
                $this->db->where('added_by_user !=', sess('user_id'));
                if ($staff_info['type'] == 3) {
                    if (!empty($office_staff)) {
                        $this->db->where_in('added_by_user', $office_staff);
                    }
                }
            }
        } else {
            if ($staff_info['type'] == 3) {
                $this->db->where('added_by_user', sess('user_id'));
                if (!empty($office_staff)) {
                    $this->db->where_in('added_by_user', $office_staff);
                }
            } else {
                if (in_array(1, $staff_department) || in_array(6, $staff_department) || in_array(8, $staff_department)) {
//                    $this->db->where('added_by_user !=', sess('user_id'));
                } else {
                    $this->db->where('added_by_user', sess('user_id'));
                }
            }
        }
        if ($status != 3) {
            $this->db->where(['status' => $status]);
        }
        return $this->db->get('sales_tax_process')->result_array();
    }

    public function get_sales_tax_process_list($staff_id, $month_year = '', $request_type = '', $status = '', $filter_data = []) {
        $staff_info = staff_info_by_id($staff_id);
        $staff_dept = $staff_info['department'];
        $stafftype = $staff_info['type'];
        $staffrole = $staff_info['role'];
        $staff_department = explode(',', $staff_info['department']);
        $office_staff = [];
        $month = $year = '';
//        if ($stafftype == 3 && $staffrole == 2) {
//            $office_staff = array_column($this->administration->get_all_office_staff_by_office_id($staff_info['office_manager']), 'staff_id');
//        }

        $office_staff = $department_staff = [];
        if ($stafftype == 3 && $staffrole == 2) {
            $office_staff = array_column($this->administration->get_all_office_staff($staff_id), 'staff_id');
            $office_staff = array_unique($office_staff);
        }
        if ($stafftype == 2 && $staffrole == 4) {
            $dept_ids = $this->db->get_where('department_staff', ['staff_id' => $staff_id])->result_array();
            $this->db->where_in('department_id', array_column($dept_ids, 'department_id'));
            $department_staffs = $this->db->get('department_staff')->result_array();
            $department_staff = array_column($department_staffs, 'staff_id');
            $department_staff = array_unique($department_staff);
        }

        if ($month_year != '') {
            $month_year_array = explode('/', $month_year);
            $month = $month_year_array[0];
            if ($month_year_array[1]) {
                $year = $month_year_array[1];
            }
        }
        $this->db->select('sales_tax_process.*, (SELECT due_date FROM sales_tax_rate WHERE sales_tax_rate.id = sales_tax_process.county_id) AS due_date');
        if ($request_type != '') {
            if ($request_type == 'my') {
                $this->db->where(['added_by_user' => $staff_id]);
            } else {
                $this->db->where('added_by_user !=', $staff_id);
                if ($staff_info['type'] == 2) {
                    if (!empty($department_staff)) {
                        $this->db->where_in('added_by_user', $department_staff);
                    }
                }
                if ($staff_info['type'] == 3) {
                    if (!empty($office_staff)) {
                        $this->db->where_in('added_by_user', $office_staff);
                    }
                }
            }
        } else {
            if ($stafftype == 3 && $staffrole == 2) {
                $this->db->where(['added_by_user' => $staff_id]);
                if (!empty($office_staff)) {
                    $this->db->where_in('added_by_user', $office_staff);
                }
            } else if ($stafftype == 2 && $staffrole == 4) {
                $this->db->where(['added_by_user' => $staff_id]);
                if (!empty($department_staff)) {
                    $this->db->where_in('added_by_user', $department_staff);
                }
            } else {
                if ($stafftype != 1) {
                    $this->db->where(['added_by_user' => $staff_id]);
                }
            }
        }
        if ($month != '') {
            $this->db->where(['period_of_time_val' => date('F', strtotime(date('Y') . '-' . $month . '-01'))]);
        }

        if ($year != '') {
            $this->db->where(['period_of_time_yearval' => $year]);
        }

        $filter_where_in = [];
        $between = '';
        if (!empty($filter_data)) {
            if (isset($filter_data['criteria_dropdown'])) {
                foreach ($filter_data['criteria_dropdown'] as $filter_key => $filter) {
                    if ($filter_key == "start_date" || $filter_key == "complete_date") {
                        if (strlen($filter[0]) == 10) {
                            $date_value = date("Y-m-d", strtotime($filter[0]));
//                            $query = $this->sales_tax_filter_element[$filter_key] . ' LIKE ' . '"' . $date_value . '%"';
                            $filter_where_in[$this->sales_tax_filter_element[$filter_key]][] = [$date_value];
                        } elseif (strlen($filter[0]) == 23) {
                            $date_value = explode(" - ", $filter[0]);
                            foreach ($date_value as $date_key => $date) {
                                $date_value[$date_key] = "'" . date("Y-m-d", strtotime($date)) . "'";
                            }
                            $between = 'Date(' . $this->sales_tax_filter_element[$filter_key] . ') BETWEEN ' . implode(' AND ', $date_value);
                        }
                    } else {
                        foreach ($filter as $key => $filter_value) {
                            if ($filter_value != '') {
                                $filter_where_in[$this->sales_tax_filter_element[$filter_key]][] = $filter_value;
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

        if ($status !== '') {
            $this->db->where(['status' => $status]);
        } else {
            $this->db->where(['status!=' => 2]);
        }

        $result = $this->db->get('sales_tax_process')->result_array();
        return $result;
//        echo $this->db->last_query();exit;
    }

    public function get_sales_tax_process_count($req_by, $status) {
        $staff_info = staff_info();
        $staff_id = sess('user_id');
        $staff_dept = $staff_info['department'];
        $stafftype = $staff_info['type'];
        $staffrole = $staff_info['role'];
        $staff_department = explode(',', $staff_info['department']);
        $office_staff = [];
        if ($stafftype == 3 && $staffrole == 2) {
            $office_staff = array_column($this->administration->get_all_office_staff($staff_id), 'staff_id');
        }

        if ($req_by != '') {
            if ($req_by == 1) {
                $this->db->where(['added_by_user' => sess('user_id')]);
            } else {
                $this->db->where('added_by_user !=', sess('user_id'));
                if ($staff_info['type'] == 3) {
                    if (!empty($office_staff)) {
                        $this->db->where_in('added_by_user', $office_staff);
                    }
                }
            }
        } else {
            if ($staff_info['type'] == 3) {
                $this->db->where('added_by_user', sess('user_id'));
                if (!empty($office_staff)) {
                    $this->db->where_in('added_by_user', $office_staff);
                }
            } else {
                if (in_array(1, $staff_department) || in_array(6, $staff_department) || in_array(8, $staff_department)) {
//                    $this->db->where('added_by_user !=', sess('user_id'));
                } else {
                    $this->db->where('added_by_user', sess('user_id'));
                }
            }
        }
        if ($status != 3) {
            $this->db->where(['status' => $status]);
        }
        $num_rows = $this->db->get('sales_tax_process')->num_rows();
        return $num_rows;
    }

    function get_county_name() {
        return $this->db->get_where('sales_tax_rate', ['status' => 0])->result_array();
    }

    function get_individual_attachments($id) {
        return $this->db->get_where('title', ['individual_id' => $id])->row_array();
    }

    function get_county_rate($county_id) {
        return $this->db->get_where('sales_tax_rate', ['id' => $county_id])->row_array();
    }

    function get_client_name_by_id($client_id) {
        $this->db->select('id,name');
        $this->db->from('company');
        $this->db->where('id', $client_id);
        return $this->db->get()->row_array();
    }

    function get_county_name_by_id($county_id) {
        return $this->db->get_where('sales_tax_rate', ['id' => $county_id])->row_array();
    }

    function getSalesTaxProcessById($id) {
        return $this->db->get_where('sales_tax_process', ['id' => $id])->row_array();
    }

    function getCountyAjaxRate($county, $rate) {
        return $this->db->get_where('sales_tax_rate', ['id' => $county, 'rate' => $rate]);
    }

    public function updateSalesProcessStatus($id, $status) {
        $this->db->trans_begin();
        $this->db->insert("tracking_logs", ["stuff_id" => $this->session->userdata("user_id"), "status_value" => $status, "section_id" => $id, "related_table_name" => "sales_tax_process"]);
        $data = ["status" => $status];
        if ($status == "1") {
            $data["start_date"] = date('Y-m-d');
        } else if ($status == "2") {
            $data["complete_date"] = date('Y-m-d');
        }
        $this->db->where("id", $id)->update("sales_tax_process", $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function getCounty($state) {
        return $this->db->get_where('sales_tax_rate', ['state' => $state])->result_array();
    }

    public function get_sales_process_edit_permission($user_type) {
        $res = $this->db->get_where('staffs', ['type' => $user_type])->result_array();
        $all_staff = array_column($res, 'type');
        print_r($all_staff);
        die;
        $all_staff[] = sess('user_id');
        return $all_staff;
    }

    public function get_sales_tax_recurring_data($clval) {
        $res = $this->db->get_where('sales_tax_recurring', ['reference_id' => $clval])->row_array();
        return $res;
    }

    public function assign_action_by_action_id($action_id, $staff_id, $all_staffs = []) {
        $this->db->trans_begin();
        $this->db->where('id', $action_id);
        $this->db->update('actions', ['is_all' => 0]);
        $this->db->where('action_id', $action_id);
        $this->db->delete("action_staffs");
        if ($staff_id != 0) {
            $this->db->insert("action_staffs", ['action_id' => $action_id, 'staff_id' => $staff_id]);
        } else {
            if (empty($all_staffs)) {
                $res = $this->db->get_where('actions', ['id' => $action_id])->row_array();
                $dept_id = $res['department'];
                $department_staffs = $this->db->get_where('department_staff', ['department_id' => $dept_id])->result_array();
                foreach ($department_staffs as $ds) {
                    $this->db->insert('action_staffs', ["action_id" => $action_id, "staff_id" => $ds['staff_id']]);
                }
            } else {
                foreach ($all_staffs as $ds) {
                    $this->db->insert('action_staffs', ["action_id" => $action_id, "staff_id" => $ds]);
                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $this->system->save_general_notification('action', $action_id, 'assign', [$staff_id], $staff_id);
            return true;
        }
    }

    public function check_if_current_user_is_from_assigned_dept($action_id) {
        $staff_info = staff_info();
        $dept = $staff_info['department'];
        $get_action_dept = $this->db->get_where('actions', ['id' => $action_id])->row_array()['department'];
        $ex = explode(',', $dept);
        if (in_array($get_action_dept, $ex)) {
            return '1';
        } else {
            return '0';
        }
    }

    public function get_created_by_staff($action_id) {
        $res = $this->db->get_where('actions', ['id' => $action_id])->row_array();
        return $res['added_by_user'];
    }

    public function get_action_staff_by_action_id($action_id) {
        $this->db->where('action_id', $action_id);
        return $this->db->get("action_staffs")->result_array();
    }

    private function uploadpdffiles($file) {

        $upload_dir = FCPATH . 'uploads/';
        $temp = explode('.', $file['name']);
        $extension = strtolower(end($temp));
        $filename = trim(strtolower(reset($temp)));
        $save_as = time() . "_" . $filename . "." . $extension;

        $upload_file = $upload_dir . basename($save_as);

        $max_size = 1024 * 1024 * 5; // 5Mb
        $allowed_extensios = array('pdf');

        if (!in_array(strtolower($extension), $allowed_extensios)) {
            $this->upload_message = "File extension not allowed";
            return false;
        } else {
            if ($file['size'] > $max_size) {
                $this->upload_message = "File exceeds the size limit ($max_size)";
                return false;
            } else {
                if (!move_uploaded_file($file['tmp_name'], $upload_file)) {
                    $this->upload_message = "An error ocurred during the upload process";
                    return false;
                } else {
                    $this->upload_message = "File uploaded successfully";
                    $this->file_uploaded = $save_as;
                    return true;
                }
            }
        }
    }

    public function get_individual_attachment($id) {
        return $this->db->query("select file_name from title where company_id='$id'")->row_array();
    }

    public function get_individual_notes($id) {
        return $this->db->query("select note from notes where reference_id='$id'")->result_array();
    }

    public function get_all_staff_by_ids($staff_ids) {
        $this->db->select("CONCAT(staff.last_name, ', ',staff.first_name,' ',staff.middle_name) as name, staff.*");
        $this->db->where_in("id", $staff_ids);
        return $this->db->get('staff')->result_array();
    }

    public function get_all_office_by_ids($office_ids) {
        $this->db->where_in("id", $office_ids);
        return $this->db->get('office')->result_array();
    }

    public function get_all_department_by_ids($department_ids) {
        $this->db->where_in("id", $department_ids);
        return $this->db->get('department')->result_array();
    }

    public function changeActionStatus($id) {
        $this->db->where('id', $id);
        $this->db->update('actions', array('status' => 1));
    }

    public function check_action_created_by($id) {
        return $this->db->query("select * from actions where id='$id'")->row_array();
    }

    public function get_request_to_others_action_by_manager_id($manager_id) {
        $departments = $this->db->get_where('department_manager', ['manager_id' => $manager_id])->result_array();
        if (!empty($departments)) {
            $this->db->where_in('department_id', array_column($departments, 'department_id'));
            $department_staffs = $this->db->get('department_staff')->result_array();
            if (!empty($department_staffs)) {
                $this->db->where_in('staff_id', array_column($department_staffs, 'staff_id'));
                $action_staffs = $this->db->get('action_staffs')->result_array();
                if (!empty($action_staffs)) {
                    $action_id = $unassigned = [];
                    foreach ($action_staffs as $as) {
                        $action_assign = $this->db->get_where('actions', ['id' => $as['action_id']])->row_array();
                        if (!empty($action_assign)) {
                            if ($action_assign['is_all'] == '1') {
                                $this->db->where_in('department', array_column($departments, 'department_id'));
                                $this->db->where('id', $as['action_id']);
                                $check_action = $this->db->get('actions')->row_array();
                                if (!empty($check_action)) {
                                    $action_id[] = $as['action_id'];
                                }
                            } else {
                                $action_id[] = $as['action_id'];
                            }
                        }
                    }
                    if (!empty($action_id)) {
                        $action_id = array_unique($action_id);
                        return $action_id;
                    }
                } else {
                    return [];
                }
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function get_request_to_others_action_by_staff_id($staff_id) {
        $dept_ids = $this->db->get_where('department_staff', ['staff_id' => $staff_id])->result_array();
        $this->db->where_in('department_id', array_column($dept_ids, 'department_id'));
        $department_staffs = $this->db->get('department_staff')->result_array();
        if (!empty($department_staffs)) {
            $this->db->where_in('staff_id', array_column($department_staffs, 'staff_id'));
            $action_staffs = $this->db->get('action_staffs')->result_array();
            if (!empty($action_staffs)) {
                $action_id = $unassigned = [];
                foreach ($action_staffs as $as) {
                    $action_assign = $this->db->get_where('actions', ['id' => $as['action_id']])->row_array();
                    if (!empty($action_assign)) {
                        if ($action_assign['is_all'] == '1') {
                            $this->db->where_in('department', array_column($dept_ids, 'department_id'));
                            $this->db->where('id', $as['action_id']);
                            $check_action = $this->db->get('actions')->row_array();
                            if (!empty($check_action)) {
                                $action_id[] = $as['action_id'];
                            }
                        } else {
                            $action_id[] = $as['action_id'];
                        }
                    }
                }
                if (!empty($action_id)) {
                    $action_id = array_unique($action_id);
                    return $action_id;
                }
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function get_action_filter_element_value($element_key, $office) {
        $staff_info = staff_info();
        $tracking_array = [
//                ["id" => 4, "name" => "All Tracking"],
                ["id" => 0, "name" => "New"],
                ["id" => 1, "name" => "Started"],
                ["id" => 6, "name" => "Resolved"],
                ["id" => 2, "name" => "Completed"],
                ["id" => 7, "name" => "Cancelled"]
//                ["id" => 3, "name" => "Not Completed"],
        ];
        $priority_array = [
                ["id" => 1, "name" => "URGENT"],
                ["id" => 2, "name" => "IMPORTANT"],
                ["id" => 3, "name" => "REGULAR"]
        ];
        switch ($element_key):
            case 1: {
                    return $priority_array;
                }
                break;
            case 2: {
                    return $tracking_array;
                }
                break;
            case 3:
            case 15: {
                    return $this->administration->get_all_office();
                }
                break;
            case 14:
            case 4: {
                    return $this->administration->get_all_dept();
                }
                break;
            case 8:
            case 9: {
                    $this->db->select("st.id AS id, CONCAT(st.last_name, ', ',st.first_name,' ',st.middle_name) AS name");
                    $this->db->from('staff AS st');
                    if ($office != ''):
                        $this->db->join('office_staff os', 'os.staff_id = st.id');
                        $this->db->where(['os.office_id' => $office]);
                    endif;
                    $this->db->where(['st.type!=' => 4, 'st.status!=' => 0]);
                    return $this->db->get()->result_array();
                }
                break;
            case 7: {
                    $this->db->select("act.id as id,act.id as name");
                    $this->db->from('actions act');
                    return $this->db->get()->result_array();
                }
                break;
            case 10: {
                    $this->db->select("act.client_id as id,act.client_id as name");
                    $this->db->from('actions act');
                    return $this->db->get()->result_array();
                }
                break;
            case 13: {

                    if($staff_info['type'] == 1){
                        return [
                            ["id" => 'byme', "name" => "By ME"],
                            ["id" => 'tome', "name" => "To ME"],
                            ["id" => 'byother', "name" => "By My Team"],
                            ["id" => 'mytask', "name" => "My Tasks"]
                    ]; 
                }else{
                     return [
                            ["id" => 'byme', "name" => "By ME"],
                            ["id" => 'tome', "name" => "To ME"],
                            // ["id" => 'byother', "name" => "By Others"],
                            ["id" => 'byother', "name" => "By My Team"],
                            // ["id" => 'toother', "name" => "To Others"],
                            ["id" => 'toother', "name" => "To My Team"],
                            ["id" => 'mytask', "name" => "My Tasks"]
                    ];
                }
                   
                }
                break;
            default: {
                    return [];
                }
                break;
        endswitch;
    }

    public function build_filter_query($variable_value, $condition_value, $criteria, $column_name) {
        $query = '';
        if ($variable_value == 1) {
            $criteria_value = $criteria['priority'];
        } elseif ($variable_value == 2) {
            $criteria_value = $criteria['tracking'];
        } elseif ($variable_value == 3) {
            $criteria_value = $criteria['to_office'];
        } elseif ($variable_value == 4) {
            $criteria_value = $criteria['to_department'];
        } elseif ($variable_value == 5) {
            $criteria_value = $criteria['start_date'];
        } elseif ($variable_value == 6) {
            $criteria_value = $criteria['complete_date'];
        } elseif ($variable_value == 7) {
            $criteria_value = $criteria['action_id'];
        } elseif ($variable_value == 8) {
            $criteria_value = $criteria['created_by'];
        } elseif ($variable_value == 9) {
            $criteria_value = $criteria['assigned_to'];
        } elseif ($variable_value == 10) {
            $criteria_value = $criteria['client_id'];
        } elseif ($variable_value == 11) {
            $criteria_value = $criteria['creation_date'];
        } elseif ($variable_value == 12) {
            $criteria_value = $criteria['due_date'];
        } elseif ($variable_value == 14) {
            $criteria_value = $criteria['by_department'];
        } elseif ($variable_value == 15) {
            $criteria_value = $criteria['by_office'];
        }
        if ($variable_value == 5 || $variable_value == 6 || $variable_value == 11 || $variable_value == 12) { // dates
            if ($condition_value == 1 || $condition_value == 3) {
                $date_value = date("Y-m-d", strtotime($criteria_value[0]));
                $query = $column_name . (($condition_value == 1) ? ' like ' : ' not like ') . '"' . $date_value . '%"';
            } elseif ($condition_value == 2 || $condition_value == 4) {
                if ($variable_value == 5) {
                    $criterias = explode(" - ", $criteria_value[0]);
                } elseif ($variable_value == 6) {
                    $criterias = explode(" - ", $criteria_value[0]);
                } elseif ($variable_value == 11) {
                    $criterias = explode(" - ", $criteria_value[0]);
                } elseif ($variable_value == 12) {
                    $criterias = explode(" - ", $criteria_value[0]);
                }
                foreach ($criterias as $key => $c) {
                    $criterias[$key] = "'" . date("Y-m-d", strtotime($c)) . "'";
                }
                $query = 'Date(' . $column_name . ')' . (($condition_value == 2) ? ' between ' : ' not between ') . implode(' AND ', $criterias);
            }
        } elseif ($variable_value == 9) {
            if ($condition_value == 1 || $condition_value == 3) {
                $query = $column_name . (($condition_value == 1) ? ' like' : ' not like ') . '",' . $criteria_value[0] . ',"';
            } elseif ($condition_value == 2 || $condition_value == 4) {
                foreach ($criteria_value as $k => $c) {
                    $criterias[$k] = $column_name . (($condition_value == 2) ? ' like ' : ' not like ') . '",' . $c . ',"';
                }
                $query = implode(' OR ', $criterias);
            }
        } else {
            if ($condition_value == 1 || $condition_value == 3) {
                // if ($variable_value == 3) {
                //     $query = 'office_id' . (($condition_value == 1) ? ' = ' : ' != ') . "'" . $criteria_value[0] . "'";
                //     $query .= ' and created_office' . (($condition_value == 1) ? ' = ' : ' != ') . "'" . $criteria_value[0] . "'";
                // } elseif ($variable_value == 4) {
                //     $query = 'department_id' . (($condition_value == 1) ? ' = ' : ' != ') . "'" . $criteria_value[0] . "'";
                //     $query .= ' and created_department' . (($condition_value == 1) ? ' = ' : ' != ') . "'" . $criteria_value[0] . "'";
                // } else {
                //     $query = $column_name . (($condition_value == 1) ? ' = ' : ' != ') . "'" . $criteria_value[0] . "'";
                // }
                if ($variable_value == 3) {

                    $query = $column_name . (($condition_value == 1) ? ' = ' : ' != ') . "'" . $criteria_value[0] . "'";
                } elseif ($variable_value == 4) {
                    $query = $column_name . (($condition_value == 1) ? ' = ' : ' != ') . "'" . $criteria_value[0] . "'";
                } else {
                    $query = $column_name . (($condition_value == 1) ? ' = ' : ' != ') . "'" . $criteria_value[0] . "'";
                }
            } elseif ($condition_value == 2 || $condition_value == 4) {
                if ($variable_value == 1) {
                    $criterias = implode(",", $criteria_value);
                } elseif ($variable_value == 2) {
                    $criterias = implode(",", $criteria_value);
                } elseif ($variable_value == 3) {
                    $criterias = implode(",", $criteria_value);
                } elseif ($variable_value == 4) {
                    $criterias = implode(",", $criteria_value);
                } elseif ($variable_value == 7) {
                    $criterias = implode(",", $criteria_value);
                } elseif ($variable_value == 8) {
                    $criterias = implode(",", $criteria_value);
                } elseif ($variable_value == 9) {
                    $criterias = implode(",", $criteria_value);
                }
                // if ($variable_value == 3) {
                //     $query = 'office_id' . (($condition_value == 2) ? ' in ' : ' not in ') . '(' . $criterias . ')';
                //     $query .= ' or created_office' . (($condition_value == 2) ? ' in ' : ' not in ') . '(' . $criterias . ')';
                // } elseif ($variable_value == 4) {
                //     $query = 'department_id' . (($condition_value == 2) ? ' in ' : ' not in ') . '(' . $criterias . ')';
                //     $query .= ' or created_department' . (($condition_value == 2) ? ' in ' : ' not in ') . '(' . $criterias . ')';
                // } else {
                //     $query = $column_name . (($condition_value == 2) ? ' in ' : ' not in ') . '(' . $criterias . ')';
                // }
                $query = $column_name . (($condition_value == 2) ? ' in ' : ' not in ') . '(' . $criterias . ')';
            }
        }
        return $query;
    }

    function get_county_list() {
        return $this->db->get_where('sales_tax_rate', ['status' => 0])->result_array();
    }

    public function get_salestax_filter_element_value($element_key) {
        $tracking_array = [
                ["id" => 0, "name" => "New"],
                ["id" => 1, "name" => "Started"],
                ["id" => 2, "name" => "Completed"]
        ];
        $period_array = [
                ["id" => "m", "name" => "Monthly"],
                ["id" => "q", "name" => "Quarterly"],
                ["id" => "y", "name" => "Yearly"]
        ];
        switch ($element_key):
            case 1: {
                    return $this->service->completed_orders_salestax(47);
                }
                break;
            case 2: {
                    return $this->system->get_all_state();
                }
                break;
            case 3: {
                    return $this->get_county_list();
                }
                break;
            case 4: {
                    $this->db->select("st.id AS id, CONCAT(st.last_name, ', ',st.first_name,' ',st.middle_name) AS name");
                    $this->db->from('staff AS st');
                    $this->db->where(['st.type!=' => 4]);
                    return $this->db->get()->result_array();
                }
                break;
            case 7: {
                    return $period_array;
                }
                break;
            case 8: {
                    return $tracking_array;
                }
                break;
            default: {
                    return [];
                }
                break;
        endswitch;
    }

    function repeat_save_sales_tax_process($month_year) {
        $month_year_array = explode('/', $month_year);
        $year = $month_year_array[1];
        $month = date('F', strtotime(date('Y') . '-' . $month_year_array[0] . '-01'));

        /* check limit of two month */
        $start_date = date_create(date('Y-m-d'));
        $end_date = date_create($year . "-" . $month_year_array[0] . "-01");
        $diff = date_diff($start_date, $end_date);
        $df = explode(" ", $diff->format("%R %y %m"));
        $result_month = (($df[1] * 12) + $df[2]);
        if (($df[0] == "+" && $result_month <= 2) || $df[0] == "-") { /* check limit of two month */
            $this->db->trans_begin();
            $this->db->where('main_salse_tax_id', 0);
            $sales_tax_list = $this->db->get('sales_tax_process')->result_array();
            if (!empty($sales_tax_list)) {
                foreach ($sales_tax_list as $stl) {
                    $main_month = date('m', strtotime($stl['period_of_time_val'] . ' 01' . ' ' . date('Y')));
                    $main_year = $stl['period_of_time_yearval'];
                    $start_date = date_create($main_year . "-" . $main_month . "-01");
                    $end_date = date_create($year . "-" . date('m', strtotime(date('Y') . '-' . $month_year_array[0] . '-01')) . "-01");
                    $diff = date_diff($start_date, $end_date);
                    $df = explode(" ", $diff->format("%R %y %m"));
                    $total_month = (($df[1] * 12) + $df[2]);
                    $total_year = $df[1];
                    $insert = FALSE;
                    if ($stl['period_of_time'] == 'm') {
                        if ($df[0] == "+" && $total_month > 0) {
                            $this->db->where(['period_of_time_val' => $month, 'period_of_time_yearval' => $year, 'period_of_time' => $stl['period_of_time'], 'main_salse_tax_id' => $stl['id']]);
                            $check = $this->db->get('sales_tax_process')->row_array();
                            if (empty($check)) {
                                if ($stl['period_of_time_val'] != $month && $stl['period_of_time_yearval'] != $year) {
                                    $insert = TRUE;
                                }
                            }
                        }
                    } else if ($stl['period_of_time'] == 'y') {
                        if ($df[0] == "+" && $total_year > 0) {
                            $this->db->where(['period_of_time_yearval' => $year, 'period_of_time' => $stl['period_of_time'], 'main_salse_tax_id' => $stl['id']]);
                            $check = $this->db->get('sales_tax_process')->row_array();
                            if (empty($check)) {
                                if ($stl['period_of_time_yearval'] != $year) {
                                    $insert = TRUE;
                                }
                            }
                        }
                    } else {
                        if ($df[0] == "+" && $total_month % 6 == 0) {
                            $this->db->where(['period_of_time_val' => $month, 'period_of_time_yearval' => $year, 'period_of_time' => $stl['period_of_time'], 'main_salse_tax_id' => $stl['id']]);
                            $check = $this->db->get('sales_tax_process')->row_array();
                            if (empty($check)) {
                                if ($stl['period_of_time_val'] != $month && $stl['period_of_time_yearval'] != $year) {
                                    $insert = TRUE;
                                }
                            }
                        }
                    }
                    if ($insert) {
                        $insert_data = $stl;
                        unset($insert_data['id']);
                        $insert_data['main_salse_tax_id'] = $stl['id'];
                        $insert_data['period_of_time_val'] = $month;
                        $insert_data['period_of_time_yearval'] = $year;
                        $insert_data['status'] = 0;
                        $this->db->insert('sales_tax_process', $insert_data);
                    }
                }
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return TRUE;
            } else {
                $this->db->trans_commit();
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

    public function check_if_company_exists($name) {
        // $this->db->select('*');
        // $this->db->from('company');
        $this->db->like('name', trim($name), 'after');
        $this->db->where("status", "1");
        $query = $this->db->get('company');
        return $query->row_array();
    }

    public function check_if_company_exists_by_practice_id($practice_id) {
        $this->db->select("comp.*");
        $this->db->from("company comp");
        $this->db->join("internal_data int", "int.reference_id = comp.id");
        $this->db->where(["int.practice_id" => $practice_id, "int.reference" => 'company', "comp.status" => "1"]);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function type_of_company($name) {
        $this->db->select('*');
        $this->db->from('company_type');
        $this->db->like('type', trim($name));
        $query = $this->db->get();
        $result = $query->row_array();
        if (!empty($result)) {
            return $result['id'];
        } else {
            return 3;
        }
    }

    public function get_ofc_id($name) {
        $this->db->select('*');
        $this->db->from('office');
        $this->db->like('name', trim($name));
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['id'];
    }

    public function get_partner_mngr($fname, $lname, $office_id) {
        $this->db->like('first_name', trim($fname), 'after');
        $this->db->like('last_name', trim($lname), 'after');
        //$query = "select * from staff where first_name like '" . trim($fname) . "%' and last_name like '" . trim($lname) . "%'";
        //$result = $this->db->query($query)->row_array();
        $result = $this->db->get('staff')->row_array();
        if (!empty($result)) {
            return $result['id'];
        } else {
            $user = strtolower(trim($fname)) . '@taxleaf.com';
            $data = array(
                'id' => '',
                'type' => '3',
                'first_name' => trim($fname),
                'last_name' => trim($lname),
                'birth_date' => '0000-00-00',
                'user' => $user,
                'password' => md5('taxleaf@123'),
                'date' => '0000-00-00',
                'status' => '1',
                'is_delete' => 'n',
                'role' => '1'
            );
            $this->db->insert('staff', $data);
            $staff_id = $this->db->insert_id();
            $this->db->insert('office_staff', ['staff_id' => $staff_id, 'office_id' => $office_id]);
            $this->db->insert('department_staff', ['staff_id' => $staff_id, 'department_id' => '2']);
            return $staff_id;
        }
    }

    public function get_lang_id($name) {
        $query = "select * from languages where language like '" . trim($name) . "%'";
        $result = $this->db->query($query)->row_array();
        if (!empty($result)) {
            return $result['id'];
        } else {
            return '1';
        }
    }

    public function get_referred_by_source($rbs) {
        $query = "select * from referred_by_source where source like '" . trim($rbs) . "%'";
        $result = $this->db->query($query)->row_array();
        if (!empty($result)) {
            return $result['id'];
        } else {
            return '1';
        }
    }

    public function insert_company_data($data, $reference_id, $type_of_company) {
        if (substr($data['state_of_incorporation'], 0, 1) == 'D') {
            $state = '8';
        } else {
            $state = '10';
        }
        if (isset($data['client_fye'])) {
            $monthnum = date("n", strtotime("01-" . $data['client_fye'] . "-2011 00:00:00"));
        }
        if (isset($data['date_of_incorporation'])) {
            $inc_data = date('Y-m-d', strtotime($data['date_of_incorporation']));
        } else {
            $inc_data = '';
        }
        $insert_data = array(
            'company_id' => '',
            'id' => $reference_id,
            'name' => $data['company_name'],
            'fein' => $data['federal_id'],
            'type' => $type_of_company,
            'state_opened' => $state,
            'fye' => $monthnum,
            'business_description' => $data['business_description'],
            'incorporated_date' => $inc_data,
            'status' => '1'
        );
        $this->db->insert('company', $insert_data);
    }

    public function insert_internal_data($data, $reference_id, $ofc_id, $partner_id, $manager_id, $lang, $referred_by_source) {
        if (isset($data['practice_id']) && $data['practice_id'] != '') {
            $practice_id = $data['practice_id'];
        } else {
            $comp_name = str_replace(' ', '', $data['company_name']);
            if (strlen($comp_name) <= 12) {
                $practice_id = $comp_name;
            } else {
                $practice_id = substr($comp_name, 0, 12);
                ;
            }
        }
        $insert_data = array(
            'id' => '',
            'reference' => isset($data['reference']) ? $data['reference'] : 'company',
            'reference_id' => $reference_id,
            'office' => $ofc_id,
            'partner' => $partner_id,
            'manager' => $manager_id,
            'client_association' => isset($data['client_association']) ? $data['client_association'] : '',
            'practice_id' => $practice_id,
            'referred_by_source' => $referred_by_source,
            'referred_by_name' => isset($data['referred_by_name']) ? $data['referred_by_name'] : '',
            'language' => $lang,
            'status' => '1'
        );
        $this->db->insert('internal_data', $insert_data);
    }

    public function insert_contact_data($data, $reference_id, $ref, $state_id) {
        $fname = trim($data['contact_first_name']);
        $lname = trim($data['contact_last_name']);
        // $con = explode(" ", trim($data['contact_name']));
        // $fname = $con[0];
        // unset($con[0]);
        // $lname = implode(" ", $con);
        if ($data['contact_address'] == '') {
            $data['contact_address'] = 'Unknown';
        }
        if ($data['contact_city'] == '') {
            $data['contact_city'] = 'Unknown';
        }
        if ($data['contact_phone'] == '') {
            $data['contact_phone'] = '12345';
        }
        if ($data['contact_zip'] == '') {
            $data['contact_zip'] = '12345';
        }
        $insert_data = array(
            'id' => '',
            'reference' => $ref,
            'reference_id' => $reference_id,
            'type' => '1',
            'first_name' => $fname,
            'last_name' => $lname,
            'phone1' => $data['contact_phone'],
            'phone1_country' => '230',
            'email1' => $data['contact_email'],
            'address1' => $data['contact_address'],
            'city' => $data['contact_city'],
            'state' => $state_id,
            'zip' => $data['contact_zip'],
            'country' => '230',
            'status' => '1'
        );
        $this->db->insert('contact_info', $insert_data);
    }

    public function insert_owner_data($data, $reference_id, $lang) {
        if (isset($data['owner_dob'])) {
            $dob = date('Y-m-d', strtotime($data['owner_dob']));
        } else {
            $dob = '';
        }
        if (isset($data['ssn'])) {
            $ssn = $data['ssn'];
        } else {
            $ssn = '';
        }
        if ($data['owner_first_name'] != '' && $data['owner_last_name'] != '') {
            $check_if_owner_exists = $this->check_if_owner_exists($data['owner_first_name'], $data['owner_last_name']);
            if (empty($check_if_owner_exists)) {
                $insert_data = array(
                    'id' => '',
                    'first_name' => $data['owner_first_name'],
                    'last_name' => $data['owner_last_name'],
                    'birth_date' => $dob,
                    'ssn_itin' => $ssn,
                    'language' => $lang,
                    'country_residence' => '230',
                    'country_citizenship' => '230',
                    'status' => '1',
                    'added_by_user' => sess('user_id')
                );
                $this->db->insert('individual', $insert_data);
                return $this->db->insert_id();
            } else {
                return $check_if_owner_exists['id'];
            }
        } else {
            return '0';
        }
    }

    public function check_if_owner_exists($fname, $lname) {
        $fname = trim($fname);
        $lname = trim($lname);

        $sql = "select * from individual where LOWER(`first_name`) = '" . strtolower($fname) . "' and LOWER(`last_name`) = '" . strtolower($lname) . "' and status=1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function insert_owner_title($data, $insert_owner_data, $reference_id, $type_of_company) {
        if (isset($data['owner_title'])) {
            if ($data['owner_title'] == '') {
                $owner_title = 'MEMBER';
            } else {
                $owner_title = $data['owner_title'];
            }
        } else {
            $owner_title = 'MEMBER';
        }
        $insert_data = array(
            'id' => '',
            'company_id' => $reference_id,
            'individual_id' => $insert_owner_data,
            'company_type' => $type_of_company,
            'title' => $owner_title,
            'percentage' => '100.00',
            'status' => '1',
            'existing_reference_id' => $reference_id
        );
        $this->db->insert('title', $insert_data);
    }

//    public function get_action_by_id($action_id) {
//        $select = implode(', ', $this->action_select);
//        $this->db->select($select);
//        $this->db->from('actions AS act');
//        $this->db->join('action_assign_to_department_rel AS ass_dept', 'ass_dept.action_id = act.id');
//        $this->db->join('department AS dprt', 'dprt.id = act.department');
//        $this->db->join('staff AS st', 'st.id = act.added_by_user');
//        $this->db->where('act.id', $action_id);
//        return $this->db->get("actions")->row_array();
//    }

    public function get_action_by_action_id($action_id) {
        $this->db->where('id', $action_id);
        return $this->db->get("actions")->row_array();
    }

    public function get_mngrs($ofc_id) {
        $this->db->select('*');
        $this->db->from('office_staff as os');
        $this->db->join('staff AS s', 's.id = os.staff_id');
        $this->db->where('os.office_id', $ofc_id);
        $this->db->where('s.role', '2');
        return $this->db->get()->result_array();
    }

    public function import_individual($data) {
        $this->db->trans_begin();
        $data['reference_id'] = $this->system->create_reference_id();
        $data['reference'] = 'individual';
        $type_of_company = '3';
        $ofc_id = $this->get_ofc_id(trim($data['office_name']));
        $partner = trim($data['partner_name']);
        $manager = trim($data['manager_name']);
        $pex = explode(" ", $partner);
        $mex = explode(" ", $manager);
        $partner_id = $this->get_partner_mngr($pex[0], $pex[1], $ofc_id);
        $manager_id = $this->get_partner_mngr($mex[0], $mex[1], $ofc_id);

        $lang = $this->get_lang_id($data['language']);
        $referred_by_source = $this->get_referred_by_source(isset($data['referred_by_source']) ? $data['referred_by_source'] : 'Website');
        $insert_internal_data = $this->insert_internal_data($data, $data['reference_id'], $ofc_id, $partner_id, $manager_id, $lang, $referred_by_source, $data['referred_by_name']);
        $insert_owner_data = $this->insert_owner_data($data, '', $lang);
        if ($insert_owner_data != '0') {
            $contact_state = $this->get_contact_state($data['contact_state']);
            $insert_contact_data_owner = $this->insert_contact_data($data, $insert_owner_data, 'individual', $contact_state);
            $insert_owner_title = $this->insert_owner_title($data, $insert_owner_data, $data['reference_id'], $type_of_company);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    public function update_import_individual($data, $reference_id) {
        $this->db->trans_begin();
        $data['reference_id'] = $reference_id;
        $data['reference'] = 'individual';
        $type_of_company = '3';
        $ofc_id = $this->get_ofc_id(trim($data['office_name']));
        $partner = trim($data['partner_name']);
        $manager = trim($data['manager_name']);
        $pex = explode(" ", $partner);
        $mex = explode(" ", $manager);
        $partner_id = $this->get_partner_mngr($pex[0], $pex[1], $ofc_id);
        $manager_id = $this->get_partner_mngr($mex[0], $mex[1], $ofc_id);

        $lang = $this->get_lang_id($data['language']);
        $referred_by_source = $this->get_referred_by_source(isset($data['referred_by_source']) ? $data['referred_by_source'] : 'Website');
        $update_internal_data = $this->update_internal_data($data, $data['reference_id'], $ofc_id, $partner_id, $manager_id, $lang, $referred_by_source, $data['referred_by_name'], 'individual');
        $update_owner_data = $this->update_owner_data($data, '', $lang);
        if ($update_owner_data != '0') {
            $contact_state = $this->get_contact_state($data['contact_state']);
            $update_contact_data_owner = $this->update_contact_data($data, $update_owner_data, 'individual', $contact_state);
            $update_owner_title = $this->update_owner_title($data, $update_owner_data, $data['reference_id'], $type_of_company);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    public function get_add_by_user_ofc($action_id) {
        $this->db->where(['action_id' => $action_id]);
        $result = $this->db->get('action_add_by_user_office')->result_array();
        $ofc_name = [];
        if (!empty($result)) {
            foreach ($result as $k => $r) {
                $this->db->where(['id' => $r['office_id']]);
                $ofc_result = $this->db->get('office')->row_array();
                $ofc_name[$k] = $ofc_result['name'];
            }
        }
        return implode(", ", $ofc_name);
    }

    public function get_add_by_user_ofc_id($action_id) {
        $this->db->where(['action_id' => $action_id]);
        $result = $this->db->get('action_add_by_user_office')->result_array();
        $ofc_name = [];
        if (!empty($result)) {
            foreach ($result as $k => $r) {
                $this->db->where(['id' => $r['office_id']]);
                $ofc_result = $this->db->get('office')->row_array();
                $ofc_name[$k] = $ofc_result['office_id'];
            }
        }
        return implode(", ", $ofc_name);
    }

    public function delete_individual() {
        $this->db->trans_begin();
        $id = post('id');
        $page = post('page');
        if ($page != '') { // delete block
            $this->db->set(["status" => '3'])->where("id", $id)->update('individual');
            $this->db->set(["status" => '3'])->where("individual_id", $id)->update('title');
            $this->db->set(["status" => '3'])->where("reference_id", $id)->where("reference", 'individual')->update('contact_info');
        } else { // inactive block
            $this->db->set(["status" => '2'])->where("id", $id)->update('individual');
            $this->db->set(["status" => '2'])->where("individual_id", $id)->update('title');
            $this->db->set(["status" => '2'])->where("reference_id", $id)->where("reference", 'individual')->update('contact_info');
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function activate_individual($id) {
        $this->db->trans_begin();
        $this->db->set(["status" => '1'])->where("id", $id)->update('individual');
        $this->db->set(["status" => '1'])->where("individual_id", $id)->update('title');
        $this->db->set(["status" => '1'])->where("reference_id", $id)->where("reference", 'individual')->update('contact_info');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function delete_business() {
        $id = post('id');
        $reference_id = post('reference_id');
        $page = post('page');

        $this->db->trans_begin();
        if ($page != '') {
            $this->db->set(["status" => '3'])->where("company_id", $id)->update('company');
        } else {
            $this->db->set(["status" => '2'])->where("company_id", $id)->update('company');
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function activate_business($id, $reference_id) {
        $this->db->trans_begin();
        $this->db->set(["status" => '1'])->where("company_id", $id)->update('company');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        } else {
            $this->db->trans_commit();
            return 1;
        }
    }

    public function check_if_individual_associated($individual_id) {
        //$val1 = $this->db->where(['reference_id' => $individual_id, 'reference' => 'individual', 'status' => '1'])->from("contact_info")->count_all_results(); 
        //$val2 = $this->db->where(['reference_id' => $individual_id, 'reference' => 'individual', 'status' => '1'])->from("documents")->count_all_results();
        $get_company_ids = $this->db->where(['individual_id' => $individual_id, 'status' => '1'])->get("title")->result_array();
        if (!empty($get_company_ids)) {
            $company_ids = array_column($get_company_ids, 'company_id');
            $this->db->where('reference', 'company');
            $this->db->where_in('reference_id', $company_ids);
            $val1 = $this->db->from('order')->count_all_results();
            $this->db->where('type', '1');
            $this->db->where_in('reference_id', $company_ids);
            $val2 = $this->db->from('invoice_info')->count_all_results();
            $this->db->where('type', '2');
            $this->db->where_in('reference_id', $company_ids);
            $val3 = $this->db->from('invoice_info')->count_all_results();
        } else {
            $val1 = 0;
            $val2 = 0;
            $val3 = 0;
        }
        // $val3 = $this->db->where(['individual_id' => $individual_id, 'company_type!=' => '0', 'status' => '1'])->from("title")->count_all_results();
        // $query = $this->db->where(['individual_id' => $individual_id, 'status' => '1'])->get("title")->row_array();
        // $reference_id = $query['company_id'];
        // $val4 = $this->db->where(['reference_id' => $reference_id])->from("invoice_info")->count_all_results();
        $val = $val1 + $val2 + $val3;
        return $val;
    }

    public function check_if_business_associated($reference_id) {
        $val1 = $this->db->where(['reference_id' => $reference_id, 'reference' => 'company'])->from("order")->count_all_results();
        $val2 = $this->db->where(['reference_id' => $reference_id])->from("invoice_info")->count_all_results();
        $val = $val1 + $val2;
        return $val;
    }

    public function import_clients($data) {
        $this->db->trans_begin();
        $reference_id = $this->system->create_reference_id();

        $type_of_company = $this->type_of_company($data['type_of_company']);

        $insert_company_data = $this->insert_company_data($data, $reference_id, $type_of_company);

        $ofc_id = $this->get_ofc_id($data['office_name']);

        $partner_name = explode(" ", trim($data['partner_name']));

        $manager_name = explode(" ", trim($data['manager_name']));

        $partner_fname = $partner_name[0];

        $partner_lname = $partner_name[1];

        $manager_fname = $manager_name[0];

        $manager_lname = $manager_name[1];

        $partner_id = $this->get_partner_mngr($partner_fname, $partner_lname, $ofc_id);

        $manager_id = $this->get_partner_mngr($manager_fname, $manager_lname, $ofc_id);

        $lang = $this->get_lang_id($data['owner_language']);

        $internal_lang = $this->get_lang_id($data['internal_language']);

        $referred_by_source = $this->get_referred_by_source($data['referred_by_source']);

        // $insert_internal_data = $this->action_model->insert_internal_data($data, $reference_id, $ofc_id, $partner_mngr, $lang, $referred_by_source);

        $insert_internal_data = $this->insert_internal_data($data, $reference_id, $ofc_id, $partner_id, $manager_id, $internal_lang, $referred_by_source);

        $contact_state = $this->get_contact_state($data['contact_state']);

        $insert_contact_data = $this->insert_contact_data($data, $reference_id, 'company', $contact_state);

        //$country_residence = $this->action_model->get_country_residence($data['owner_cor']);

        $insert_owner_data = $this->insert_owner_data($data, $reference_id, $lang);

        if ($insert_owner_data != '0') {
            $insert_contact_data_owner = $this->insert_contact_data($data, $insert_owner_data, 'individual', $contact_state);

            $insert_owner_title = $this->insert_owner_title($data, $insert_owner_data, $reference_id, $type_of_company);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    public function get_contact_state($state) {
        $result = $this->db->get_where('states', array('state_code' => $state))->row_array();
        if (!empty($result)) {
            return $result['id'];
        } else {
            return '10';
        }
    }

    public function update_import_clients($data, $reference_id) {
        $this->db->trans_begin();

        $type_of_company = $this->type_of_company($data['type_of_company']);

        $update_company_data = $this->update_company_data($data, $reference_id, $type_of_company);

        $ofc_id = $this->get_ofc_id($data['office_name']);

        $partner_name = explode(" ", trim($data['partner_name']));

        $manager_name = explode(" ", trim($data['manager_name']));

        $partner_fname = $partner_name[0];

        $partner_lname = $partner_name[1];

        $manager_fname = $manager_name[0];

        $manager_lname = $manager_name[1];

        $partner_id = $this->get_partner_mngr($partner_fname, $partner_lname, $ofc_id);

        $manager_id = $this->get_partner_mngr($manager_fname, $manager_lname, $ofc_id);

        $lang = $this->get_lang_id($data['owner_language']);
        
        $internal_lang = $this->get_lang_id($data['internal_language']);

        $referred_by_source = $this->get_referred_by_source($data['referred_by_source']);

        $update_internal_data = $this->update_internal_data($data, $reference_id, $ofc_id, $partner_id, $manager_id, $internal_lang, $referred_by_source, $data['referred_by_name'], 'company');
        $contact_state = $this->get_contact_state($data['contact_state']);

        $update_contact_data = $this->update_contact_data($data, $reference_id, 'company', $contact_state);

        $update_owner_data = $this->update_owner_data($data, $reference_id, $lang);

        if ($update_owner_data != '0') {
            $update_contact_data_owner = $this->update_contact_data($data, $update_owner_data, 'individual', $contact_state);

            $update_owner_title = $this->update_owner_title($data, $update_owner_data, $reference_id, $type_of_company);
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    public function import_failed_data($data, $cause, $type) {
        if ($type == 1) {
            $name = $data['company_name'];
        } else {
            $name = $data['owner_first_name'] . ' ' . $data['owner_last_name'];
        }
        $insert_data = array(
            'id' => '',
            'name' => $name,
            'cause' => $cause,
            'type' => $type
        );
        $this->db->insert('import_failed_data', $insert_data);
    }

    public function update_company_data($data, $reference_id, $type_of_company) {
        if (substr($data['state_of_incorporation'], 0, 1) == 'D') {
            $state = '8';
        } else {
            $state = '10';
        }
        if (isset($data['client_fye'])) {
            $monthnum = date("n", strtotime("01-" . $data['client_fye'] . "-2011 00:00:00"));
        }
        if (isset($data['date_of_incorporation'])) {
            $inc_data = date('Y-m-d', strtotime($data['date_of_incorporation']));
        } else {
            $inc_data = '';
        }
        $update_data = array(
            'name' => $data['company_name'],
            'fein' => $data['federal_id'],
            'type' => $type_of_company,
            'state_opened' => $state,
            'fye' => $monthnum,
            'business_description' => $data['business_description'],
            'incorporated_date' => $inc_data,
            'status' => '1'
        );
        $this->db->where('id', $reference_id);
        $this->db->update('company', $update_data);
    }

    public function update_internal_data($data, $reference_id, $ofc_id, $partner_id, $manager_id, $lang, $referred_by_source, $referred_by_name, $reference) {

        if (isset($data['practice_id']) && $data['practice_id'] != '') {
            $practice_id = $data['practice_id'];
        } else {
            if($reference=='individual'){
                $practice_id='';
            }else{
                $comp_name = str_replace(' ', '', $data['company_name']);
                if (strlen($comp_name) <= 12) {
                    $practice_id = $comp_name;
                } else {
                    $practice_id = substr($comp_name, 12);
                }
            }
        }
        $update_data = array(
            'office' => $ofc_id,
            'partner' => $partner_id,
            'manager' => $manager_id,
            'client_association' => isset($data['client_association']) ? $data['client_association'] : '',
            'practice_id' => $practice_id,
            'referred_by_source' => $referred_by_source,
            'referred_by_name' => isset($data['referred_by_name']) ? $data['referred_by_name'] : '',
            'language' => $lang,
            'status' => '1'
        );
        $this->db->where('reference', $reference);
        $this->db->where('reference_id', $reference_id);
        $this->db->update('internal_data', $update_data);
    }

    public function update_contact_data($data, $reference_id, $ref, $state_id) {
        $fname = trim($data['contact_first_name']);
        $lname = trim($data['contact_last_name']);
        // $con = explode(" ", trim($data['contact_name']));
        // $fname = $con[0];
        // unset($con[0]);
        // $lname = implode(" ", $con);
        if ($data['contact_address'] == '') {
            $data['contact_address'] = 'Unknown';
        }
        if ($data['contact_city'] == '') {
            $data['contact_city'] = 'Unknown';
        }
        if ($data['contact_phone'] == '') {
            $data['contact_phone'] = '12345';
        }
        if ($data['contact_zip'] == '') {
            $data['contact_zip'] = '12345';
        }
        $update_data = array(
            'type' => '1',
            'first_name' => $fname,
            'last_name' => $lname,
            'phone1' => $data['contact_phone'],
            'phone1_country' => '230',
            'email1' => $data['contact_email'],
            'address1' => $data['contact_address'],
            'city' => $data['contact_city'],
            'state' => $state_id,
            'zip' => $data['contact_zip'],
            'country' => '230',
            'status' => '1'
        );
        $this->db->where('reference', $ref);
        $this->db->where('reference_id', $reference_id);
        $this->db->update('contact_info', $update_data);
    }

    public function update_owner_data($data, $reference_id, $lang) {
        if (isset($data['owner_dob'])) {
            $dob = date('Y-m-d', strtotime($data['owner_dob']));
        } else {
            $dob = '';
        }
        if (isset($data['ssn'])) {
            $ssn = $data['ssn'];
        } else {
            $ssn = '';
        }
        if ($data['owner_first_name'] != '' && $data['owner_last_name'] != '') {
            $check_if_owner_exists = $this->check_if_owner_exists($data['owner_first_name'], $data['owner_last_name']);
            if (empty($check_if_owner_exists)) {
                $insert_data = array(
                    'id' => '',
                    'first_name' => $data['owner_first_name'],
                    'last_name' => $data['owner_last_name'],
                    'birth_date' => $dob,
                    'ssn_itin' => $ssn,
                    'language' => $lang,
                    'country_residence' => '230',
                    'country_citizenship' => '230',
                    'status' => '1',
                    'added_by_user' => sess('user_id')
                );
                $this->db->insert('individual', $insert_data);
                return $this->db->insert_id();
            } else {
                $update_data = array(
                    'first_name' => $data['owner_first_name'],
                    'last_name' => $data['owner_last_name'],
                    'birth_date' => $dob,
                    'ssn_itin' => $ssn,
                    'language' => $lang,
                    'status' => '1',
                    'added_by_user' => sess('user_id')
                );
                $this->db->where('id', $check_if_owner_exists['id']);
                $this->db->update('individual', $update_data);
                return $check_if_owner_exists['id'];
            }
        } else {
            return '0';
        }
    }

    public function update_owner_title($data, $update_owner_data, $reference_id, $type_of_company) {
        if (isset($data['owner_title'])) {
            if ($data['owner_title'] == '') {
                $owner_title = 'MEMBER';
            } else {
                $owner_title = $data['owner_title'];
            }
        } else {
            $owner_title = 'MEMBER';
        }

        $update_data = array(
            'company_type' => $type_of_company,
            'title' => $owner_title,
            'percentage' => '100.00',
            'status' => '1',
            'existing_reference_id' => $reference_id
        );
        $this->db->where('company_id', $reference_id);
        $this->db->where('individual_id', $update_owner_data);
        $this->db->update('title', $update_data);
    }

    public function get_read_status($id) {
        $result = $this->db->get_where('action_notes', array('action_id' => $id))->result_array();
        return array_column($result, 'read_status');
        // return $result['read_status'];
    }

    public function get_action_notes_read_status($id, $staffid) {
        $result = $this->db->get_where('action_notes', array('action_id' => $id))->result_array();
        $note_id = array_column($result, 'id');
//        print_r($note_id);die;
        if (!empty($note_id)) {
            $this->db->select("*");
            $this->db->from('notes_log');
            $this->db->where_in('note_id', $note_id);
            $this->db->where('user_id', $staffid);
            $this->db->group_by('user_id');
            $read_status = $this->db->get()->result_array();
            return array_column($read_status, 'read_status');
        } else {
            return 0;
        }
        // return $result['read_status'];
    }

    public function file_upload_actions($data, $files) {
        if (!empty($files["name"])) {
            $filesCount = count($files['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['userFile']['name'] = basename(time() . "_" . rand(111111, 99999) . "_" . str_replace(" ", "", $files['name'][$i]));
                $_FILES['userFile']['type'] = $files['type'][$i];
                $_FILES['userFile']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['userFile']['error'] = $files['error'][$i];
                $_FILES['userFile']['size'] = $files['size'][$i];

                $uploadPath = FCPATH . 'uploads/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = "*";

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('userFile')) {
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                    $uploadData[$i]['added_by_user'] = sess('user_id');
                    $uploadData[$i]['action_id'] = $data['action_id'];
                }
            }
        }

        if (!empty($uploadData)) {
            $this->db->insert_batch('action_files', $uploadData);
        }

        $last_id_arr = [];
        $last_id = $this->db->insert_id();
        for ($j = 0; $j < count($files['name']); $j++) {
            if (!empty($files['name'][$j])) {
                array_push($last_id_arr, $last_id + $j);
                $variable = explode(',', $data['staff_list']);

                foreach ($variable as $value) {
                    $staff_array = array(
                        'file_id' => $last_id_arr[$j],
                        'reference' => 'action',
                        'reference_id' => $data['action_id'],
                        'staff_id' => $value
                    );
                    $this->db->insert('file_read_status_staff', $staff_array);
                }
            }
        }

        return $this->db->get_where('action_files', array('action_id' => $data['action_id']))->num_rows();
        ;
    }

    public function get_business_info($id) {
        $company_ids = $this->db->get_where('title', ['individual_id' => $id])->result_array();
        $companys = array_column($company_ids, 'company_id');
        $this->db->where_in('id', $companys);
        $this->db->where('status', '1');
        $all_companys = $this->db->get('company')->result_array();
        return $all_companys;
    }

    public function get_added_by($id) {
        $added_by = $this->db->get_where('actions', ['id' => $id])->row_array();
        return $added_by['added_by_user'];
    }

    public function get_action_priority($id) {
        $added_by = $this->db->get_where('actions', ['id' => $id])->row_array();
        return $added_by['priority'];
    }

    public function get_sos_read_status($id) {
        $sos_data = $this->db->get_where('sos_notification', array('reference_id' => $id))->result_array();
        if (!empty($sos_data)) {
            $sos_id = array_column($sos_data, 'id');
            $this->db->where('staff_id', sess('user_id'));
            $this->db->where_in('sos_notification_id', $sos_id);
            $values = $this->db->get('sos_notification_staff')->result_array();
            if (!empty($values)) {
                $read_status_arr = array_column($values, 'read_status');
                if (count($read_status_arr) != count(array_filter($read_status_arr))) {
                    return 0;
                } else {
                    return 1;
                }
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }

    public function get_office_name_for_action_view($id) {
        $this->db->select('of.name');
        $this->db->from('office of');
        $this->db->join('actions ac','ac.office = of.id');
        $this->db->where('ac.id',$id);
        return $this->db->get()->row_array();
    }
    // report dashboard's client data
    public function get_clients_data($category) {
        $data_office = $this->db->get('office')->result_array();
        // $data_office = $this->system->get_staff_office_list();
        if ($category == 'clients_by_office') {
            $all_client_details = [];
            foreach ($data_office as $do) {    
                $data = [
                    'id' => $do['id'],
                    'office_name' => $do['name'],
                    'total_clients' => $this->db->get_where('report_client',array('office'=>$do['id']))->num_rows(),           
                    'business' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'company'))->num_rows(),           
                    'individuals' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'individual'))->num_rows()           
                ];
                array_push($all_client_details,$data);
            }
            return $all_client_details;
        } else if($category == 'business_clients_by_office') {
            $business_client_details = [];
            
            foreach ($data_office as $do) {    
                $data = [
                    'id' => $do['id'],
                    'office_name' => $do['name'],
                    'total_clients' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'company'))->num_rows(),           
                    'llc' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'company','type_of_company'=>'LLC'))->num_rows(),                  
                    'singlellc' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'company','type_of_company'=>'Single Member LLC'))->num_rows(),           
                    'ccrop' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'company','type_of_company'=>'C Corporation'))->num_rows(),       
                    'fcrop' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'company','type_of_company'=>'F Corporation'))->num_rows(),           
                    'scrop' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'company','type_of_company'=>'S Corporation'))->num_rows(),           
                    'nonprofit' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'company','type_of_company'=>'Non Profit Corporation'))->num_rows(),           
                    'active' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'company','status'=>'1'))->num_rows(),           
                    'inactive' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'company','status'=>'2'))->num_rows()           
                ];
                array_push($business_client_details,$data);
            }
            return $business_client_details;
        } else if ($category == 'individual_clients_by_office') {
            $individual_client_details = [];
            
            foreach ($data_office as $do) {    
                $data = [
                    'id' => $do['id'],
                    'office_name' => $do['name'],
                    'total_clients' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'individual'))->num_rows(),           
                    'usresidents' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'individual','country_residence'=>'230'))->num_rows(),           
                    'nonresidents' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'individual','country_residence!='=>'230'))->num_rows(),           
                    'active' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'individual','status'=>'1'))->num_rows(),           
                    'inactive' => $this->db->get_where('report_client',array('office'=>$do['id'],'type'=>'individual','status'=>'2'))->num_rows()           
                ];
                array_push($individual_client_details,$data);
            }
            return $individual_client_details;
        }
    }
    // report dashboard's action data
    public function get_action_data($category) {
        $data_office = $this->db->get('office')->result_array();
        $data_department = $this->db->get('department')->result_array();
        // $data_office = $this->system->get_staff_office_list();
        $all_actions_data = [];
        if ($category == 'action_by_office') {
            foreach ($data_office as $do) {    
                $data = [
                    'id' => $do['id'],
                    'office_name' => $do['name'],
                    'total_actions' => $this->db->get_where('report_dashboard_action',array('by_office'=>$do['id']))->num_rows(),           
                    'new' => $this->db->get_where('report_dashboard_action',array('by_office'=>$do['id'],'status'=> '0'))->num_rows(),           
                    'started' => $this->db->get_where('report_dashboard_action',array('by_office'=>$do['id'],'status'=> '0'))->num_rows(),           
                    'resolved' => $this->db->get_where('report_dashboard_action',array('by_office'=>$do['id'],'status'=> '0'))->num_rows(),           
                    'completed' => $this->db->get_where('report_dashboard_action',array('by_office'=>$do['id'],'status'=> '0'))->num_rows(),
                    'less_then_30' => $this->action_late_status('action_by_office','less_then_30',$do['id']),
                    'less_then_60' => $this->action_late_status('action_by_office','less_then_60',$do['id']),
                    'more_then_60' => $this->action_late_status('action_by_office','more_then_60',$do['id']),
                    'sos' => $this->db->get_where('report_dashboard_action',array('by_office'=>$do['id'],'sos!='=> ''))->num_rows(),           
                ];
                array_push($all_actions_data,$data);
            }
            return $all_actions_data;

        } else if($category == 'action_to_office') {
            foreach ($data_office as $do) {    
                $data = [
                    'id' => $do['id'],
                    'office_name' => $do['name'],
                    'total_actions' => $this->db->get_where('report_dashboard_action',array('to_office'=>$do['id']))->num_rows(),           
                    'new' => $this->db->get_where('report_dashboard_action',array('to_office'=>$do['id'],'status'=> '0'))->num_rows(),           
                    'started' => $this->db->get_where('report_dashboard_action',array('to_office'=>$do['id'],'status'=> '0'))->num_rows(),           
                    'resolved' => $this->db->get_where('report_dashboard_action',array('to_office'=>$do['id'],'status'=> '0'))->num_rows(),           
                    'completed' => $this->db->get_where('report_dashboard_action',array('to_office'=>$do['id'],'status'=> '0'))->num_rows(),
                    'less_then_30' => $this->action_late_status('action_to_office','less_then_30',$do['id']),
                    'less_then_60' => $this->action_late_status('action_to_office','less_then_60',$do['id']),
                    'more_then_60' => $this->action_late_status('action_to_office','more_then_60',$do['id']),
                    'sos' => $this->db->get_where('report_dashboard_action',array('to_office'=>$do['id'],'sos!='=> ''))->num_rows(),           
                ];
                array_push($all_actions_data,$data);
            }
            return $all_actions_data;

        } else if ($category == 'action_by_department') {
            foreach ($data_department as $dd) {    
                $data = [
                    'id' => $dd['id'],
                    'office_name' => $dd['name'],
                    'total_actions' => $this->db->get_where('report_dashboard_action',array('by_department'=>$dd['id']))->num_rows(),           
                    'new' => $this->db->get_where('report_dashboard_action',array('by_department'=>$dd['id'],'status'=> '0'))->num_rows(),           
                    'started' => $this->db->get_where('report_dashboard_action',array('by_department'=>$dd['id'],'status'=> '0'))->num_rows(),           
                    'resolved' => $this->db->get_where('report_dashboard_action',array('by_department'=>$dd['id'],'status'=> '0'))->num_rows(),           
                    'completed' => $this->db->get_where('report_dashboard_action',array('by_department'=>$dd['id'],'status'=> '0'))->num_rows(),
                    'less_then_30' => $this->action_late_status('action_by_department','less_then_30','',$dd['id']),
                    'less_then_60' => $this->action_late_status('action_by_department','less_then_60','',$dd['id']),
                    'more_then_60' => $this->action_late_status('action_by_department','more_then_60','',$dd['id']),
                    'sos' => $this->db->get_where('report_dashboard_action',array('by_department'=>$dd['id'],'sos!='=> ''))->num_rows(),           
                ];
                array_push($all_actions_data,$data);
            }
            return $all_actions_data;

        } else if ($category == 'action_to_department') {
            foreach ($data_department as $dd) {    
                $data = [
                    'id' => $dd['id'],
                    'office_name' => $dd['name'],
                    'total_actions' => $this->db->get_where('report_dashboard_action',array('to_department'=>$dd['id']))->num_rows(),           
                    'new' => $this->db->get_where('report_dashboard_action',array('to_department'=>$dd['id'],'status'=> '0'))->num_rows(),           
                    'started' => $this->db->get_where('report_dashboard_action',array('to_department'=>$dd['id'],'status'=> '0'))->num_rows(),           
                    'resolved' => $this->db->get_where('report_dashboard_action',array('to_department'=>$dd['id'],'status'=> '0'))->num_rows(),           
                    'completed' => $this->db->get_where('report_dashboard_action',array('to_department'=>$dd['id'],'status'=> '0'))->num_rows(),
                    'less_then_30' => $this->action_late_status('action_to_department','less_then_30','',$dd['id']),
                    'less_then_60' => $this->action_late_status('action_to_department','less_then_60','',$dd['id']),
                    'more_then_60' => $this->action_late_status('action_to_department','more_then_60','',$dd['id']),
                    'sos' => $this->db->get_where('report_dashboard_action',array('to_department'=>$dd['id'],'sos!='=> ''))->num_rows(),           
                ];
                array_push($all_actions_data,$data);
            }
            return $all_actions_data;

        }        
    }

    public function action_late_status($related_section="",$duration="",$office_id="",$department="") {
        if ($related_section == 'action_by_office') {            
            if ($duration == 'less_then_30') {
                return 0;
            } elseif ($duration == 'less_then_60') {
                return 0;
            } elseif ($duration == 'more_then_60') {
                return 0;
            }
        } elseif ($related_section == 'action_to_office') {
            if ($duration == 'less_then_30') {
                return 0;
            } elseif ($duration == 'less_then_60') {
                return 0;
            } elseif ($duration == 'more_then_60') {
                return 0;
            }
        } elseif ($related_section == 'action_by_department') {
            if ($duration == 'less_then_30') {
                return 0;
            } elseif ($duration == 'less_then_60') {
                return 0;
            } elseif ($duration == 'more_then_60') {
                return 0;
            }
        } elseif ($related_section == 'action_to_department') {
            if ($duration == 'less_then_30') {
                return 0;
            } elseif ($duration == 'less_then_60') {
                return 0;
            } elseif ($duration == 'more_then_60') {
                return 0;
            }
        }
    }

}
