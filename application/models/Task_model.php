<?php

class Task_model extends CI_Model {

    private $filter_element, $project_select;

    public function __construct() {
        parent::__construct();
        $this->filter_element = [
            1 => "id",
            2 => "assign_staff",
            3 => "tracking_description"
        ];

//        $this->project_select[] = 'REPLACE(CONCAT(",",(SELECT GROUP_CONCAT(psm2.staff_id) FROM project_staff_main AS psm2 WHERE psm2.project_id = pro.id),","), " ", "") AS all_project_staffs';
        $this->project_select[] = 'REPLACE(CONCAT(",",(SELECT GROUP_CONCAT(pts.staff_id) FROM project_task_staff AS pts WHERE pts.task_id = pt.id),","), " ", "") AS assign_staff';
        $this->project_select[] = 'pt.added_by_user AS added_by_user';
        $this->project_select[] = 'pt.added_by_user AS staff_id';
        $this->project_select[] = 'pt.department_id as department_id';
//        $this->project_select[] = 'REPLACE(CONCAT(",",(SELECT case when (pm.office_id=1 then GROUP_CONCAT(psm2.staff_id) FROM project_staff_main AS psm2 WHERE psm2.project_id = pro.id )),",")," "," ") AS responsible_staff';
    }

    public function get_task_list($request = '', $status = '', $priority = '', $office_id = '', $department_id = '', $filter_assign = '', $filter_data = [], $sos_value = '', $sort_criteria = '', $sort_type = '', $client_type = '', $client_id = '') {
//        echo 'kkk'.$sos_value;die;
        $user_info =  $this->session->userdata('staff_info');
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
        $select = implode(', ', $this->project_select);
        $this->db->select($select);
        $this->db->select('pt.*');
        $this->db->select('pm.created_at as project_created_at,pro.client_id,pm.office_id as project_office_id');
        $this->db->from('project_task AS pt');
        $this->db->join('project_main AS pm', 'pm.id = pt.project_id', 'LEFT');
        $this->db->join('projects AS pro', 'pro.id = pt.project_id', 'inner');
//        $this->db->join('project_recurrence_main AS prm', 'prm.project_id = pro.id', 'left');
//        $this->db->join('project_task AS pt', 'pt.project_id = pro.id','left');
//        $this->db->join('staff AS st', 'st.id = act.added_by_user');
        if (isset($sos_value) && $sos_value != '') {
            $this->db->join('sos_notification AS sos', 'sos.service_id = pt.id');
            $this->db->join('sos_notification_staff AS sns', 'sns.sos_notification_id = sos.id');
        }
        $having = [];
//        if($user_type==1 && $user_department==14){
//            $having[] = 'all_project_staffs LIKE "%,' . $staff_id . ',%" AND added_by_user != "' . $staff_id . '"';
//        }
        if ($request != '') {
            if ($request == 'byme') {
                $this->db->where(['pt.added_by_user' => $staff_id]);
            } elseif ($request == 'tome') {
                $having[] = 'added_by_user != "' . $staff_id . '" AND assign_staff LIKE "%,' . $staff_id . ',%"';
            }elseif ($request == 'byother') {
                if ($user_type == 1 || ($user_type == 2 && $user_department == 14)) {
                    $this->db->where(['pt.added_by_user!=' => $staff_id]);
                }
                if ($user_type == 3 && $role == 2) {
                    unset($office_staff[array_search(sess('user_id'), $office_staff)]);
//                    $this->db->where(['my_task' => 0]);
                    if (!empty($office_staff)) {
                        $this->db->where_in('pt.added_by_user', $office_staff);
                    } else {
                        $this->db->where('pt.id', 0);
                    }
                }
                if ($user_type == 2 && $role == 4) {
                    if ($user_department != 14) {
                        // unset($department_staff[array_search(sess('user_id'), $department_staff)]);
//                        $this->db->where(['my_task' => 0]);
                        if (!empty($department_staff)) {
                            $this->db->where_in('pt.added_by_user', $department_staff);
                        } else {
                            $this->db->where('pt.id', 0);
                        }
                    }
                }
            } elseif ($request == 'toother') {
                if ($user_type == 3 && $role == 2) {
                    unset($office_staff[array_search(sess('user_id'), $office_staff)]);
                    $like_staffs = [];
                    foreach ($office_staff as $staffID) {
                        $like_staffs[] = 'assign_staff LIKE "%,' . $staffID . ',%"';
                    }
                    if (!empty($like_staffs)) {
                        $having[] = 'assign_staff NOT LIKE "%,' . $staff_id . ',%" AND (' . implode(' OR ', $like_staffs) . ') AND added_by_user != "' . $staff_id . '"';
                    } else {
                        $having[] = 'added_by_user != "' . $staff_id . '" AND pt.id = "0"';
                    }
                }
                if ($user_type == 2 && $role == 4) {
                    if ($user_department != 14) {
                        if (!empty($departments)) {
                            $having[] = 'assign_staff NOT LIKE "%,' . $staff_id . ',%" AND department_id IN (' . implode(',', $departments) . ') AND added_by_user != "' . $staff_id . '"';
                        } else {
                            $having[] = 'added_by_user != "' . $staff_id . '" AND pt.id = "0"';
                        }
                    }
                }
            }
            
            
            if ($status != '') {
                if ($status == '0' || $status == '1' || $status == '2') {
                    $this->db->where('pt.tracking_description', $status);
                }
            } else {
                if ($status == 0) {
                    $this->db->where('pt.tracking_description', $status);
                } else {
                    if (empty($filter_data)) {
                        $this->db->where_not_in('pt.tracking_description', [1, 2]);
                    }
                }
            }
//            if ($priority != '') {
//                $this->db->where('priority', $priority);
//            }
        } else {
//            echo 'bbb';die;
            $having_or = [];
            if ($user_type == 1 || ($user_type == 2 && $user_department == 14)) {
//                echo "b1";die;
//                $this->db->where_in('pt.added_by_user', [0, $staff_id]);
//                $having[] = '(assign_staff LIKE "%,' . $staff_id . ',%")';
            } else if ($user_type == 3 && $role == 2) {
//                echo 'b2';die;
                if (!empty($office_staff)) {
//                    $having_or[] = 'all_project_staffs LIKE "%,' . $staff_id . ',%"';
                    $having_or[] = 'added_by_user IN (' . implode(',', $office_staff) . ')';
//                    $having_or[] = 'my_task = "' . $staff_id . '"';
                    unset($office_staff[array_search(sess('user_id'), $office_staff)]);
                    foreach ($office_staff as $staffID) {
                        $having_or[] = 'assign_staff LIKE "%,' . $staff_id . ',%"';
                    }
                    $having[] = '(' . implode(' OR ', $having_or) . ')';
                } else {
                    $having[] = '(assign_staff LIKE "%,' . $staff_id . ',%")';
                }
            } else if ($user_type == 2 && $role == 4) {
//                echo 'b3';die;
                if ($user_department != 14) {
                    if (!empty($departments)) {
//                    $having_or[] = 'all_project_staffs LIKE "%,' . $staff_id . ',%"';
                        if (!empty($department_staff)) {
                            $having_or[] = 'added_by_user IN (' . implode(',', $department_staff) . ')';
                        }
//                    $having_or[] = 'my_task = "' . $staff_id . '"';
                        $having_or[] = 'department_id IN (' . implode(',', $departments) . ') OR assign_staff LIKE "%,' . $staff_id . ',%"';
                        $having[] = '(' . implode(' OR ', $having_or) . ')';
                    } else {
                        $having[] = '(assign_staff LIKE "%,' . $staff_id . ',%")';
                    }
                }
            } else {
//                echo 'b4';die;
                $having[] = '(added_by_user = "' . $staff_id . '" OR assign_staff LIKE "%,' . $staff_id . ',%")';
            }
        }

        if (isset($sos_value) && $sos_value != '') {
            if ($sos_value == 'tome') {
                $this->db->where(['sns.staff_id' => sess('user_id'), 'sos.reference' => 'projects', 'sns.read_status' => 0, 'sos.added_by_user!=' => sess('user_id')]);
            } else {
                $this->db->where(['sos.reference' => 'projects', 'sns.read_status' => 0, 'sos.added_by_user' => sess('user_id')]);
            }
        }

//        if ($office_id != '') {
//            $this->db->where('pro.office', $office_id);
//        }

        if ($department_id != '') {
            if ($department_id != 14) {
                $this->db->where('department_id', $department_id);
            }
        }

//        if($client_type != ''){
//            $this->db->where('pro.client_type', $client_type);
//        }
//
//        if($client_id != ''){
//            $this->db->where('pro.client_id', $client_id);
//        }
//        if ($filter_assign == 1) {
//            $having[] = 'action_staff_count = 1';
//        } else if ($filter_assign == 2) {
//            $having[] = 'action_staff_count != 1';
//        }
        if (!empty($filter_data)) {
            if (isset($filter_data['variable_dropdown'])) {
                foreach ($filter_data['variable_dropdown'] as $key => $variable_value) {
                    if (isset($variable_value) && $variable_value != '') {
                        $condition_value = $filter_data['condition_dropdown'][$key];
                        if (isset($condition_value) && $condition_value != '') {
                            $column_name = $this->filter_element[$variable_value];
//                            echo $column_name;die;
                            if ($column_name == 'tracking_description') {
                                $this->db->where($this->build_filter_query($variable_value, $condition_value, $filter_data['criteria_dropdown'], $column_name));
                            } else {
                                $having[] = $this->build_filter_query($variable_value, $condition_value, $filter_data['criteria_dropdown'], $column_name);
                            }
                        }
                    }
                }
            }
        }

        if (count($having) != 0) {
            $this->db->having(implode(' AND ', $having));
        }
//        print_r($having);die;
        $this->db->where('pro.is_deleted', 0);
        $this->db->group_by('pt.id');
        if ($sort_criteria != '') {
//            echo "a";
//            print_r($sort_criteria);
//            die;
            $this->db->order_by($sort_criteria, $sort_type);
        } else {
//            echo "b";die;
            $this->db->order_by("pt.id", "DESC");
        }
        $result = $this->db->get()->result_array();
//        print_r($result);die;
//        echo $this->db->last_query();die;
        return $result;
    }

    public function build_filter_query($variable_value, $condition_value, $criteria, $column_name) {
//        print_r($condition_value);
//        die;
        $query = '';
        if ($variable_value == 1) {
            $criteria_value = $criteria['id'];
        } elseif ($variable_value == 2) {
            $criteria_value = $criteria['assigned_to'];
        } elseif ($variable_value == 3) {
            $criteria_value = $criteria['tracking_description'];
        }
        if ($condition_value == 1) {
            if ($column_name == 'tracking_description' || $column_name == 'id') {
                $query = 'pt.' . $column_name . (($condition_value == 1) ? ' = ' : ' != ') . "'" . $criteria_value[0] . "'";
            } else {
                $query = $column_name . (($condition_value == 1) ? ' like ' : ' not like ') . "'," . $criteria_value[0] . ",'";
            }
        } elseif ($condition_value == 2 || $condition_value == 3) {
            foreach ($criteria_value as $k => $c) {
                $criterias[$k] = $column_name . (($condition_value == 2) ? ' like ' : ' not like ') . '",' . $c . ',"';
            }
            $query = implode(' OR ', $criterias);
        }elseif ($condition_value == 4) {
            foreach ($criteria_value as $k => $c) {
                $criterias[$k] = $column_name . (($condition_value == 2) ? ' like ' : ' not like ') . '",' . $c . ',"';
            }
            $query = implode(' AND ', $criterias);
        }


        return $query;
    }

    public function get_task_filter_element_value($element_key, $office) {
        $tracking_array = [
                ["id" => 0, "name" => "Not Started"],
                ["id" => 1, "name" => "Started"],
                ["id" => 2, "name" => "Completed"]
        ];
        switch ($element_key):
            case 1: {
                    $this->db->select("pt.id as id,pt.id as name");
                    $this->db->from('project_task pt');
                    return $this->db->get()->result_array();
                }
                break;

            case 3: {
                    return $tracking_array;
                }
                break;
            case 2: {
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

}
