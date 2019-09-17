<?php

class News_Update_model extends CI_Model {

    public function add_newsandupdate($data) {  // inserting news and update
        $ins_data['priority'] = $data['priority'];
        $ins_data['office_type'] = $data['office_type'];
        $ins_data['is_all'] = 1;
        $ins_data['news_type'] = $data['news_type'];
        $ins_data['subject'] = $data['subject'];
        $ins_data['message'] = $data['news']['body'];
        $ins_data['created_by'] = sess("user_id");
        $this->db->trans_begin();
        $this->db->insert('news_and_updates', $ins_data);
        $id = $this->db->insert_id();

        if ($data['office_type'] == '1') {
            if (!empty($data['department'])) {

                foreach ($data['department'] as $dept_id) {
                    $this->db->insert('news_and_update_department', ['news_and_update_id' => $id, 'department' => $dept_id]);
                }
            }
        } else {
            if (!empty($data['office'])) {

                foreach ($data['office'] as $ofc_id) {
                    $this->db->insert('news_and_update_office', ['news_and_update_id' => $id, 'department' => 2, 'office' => $ofc_id]);
                }
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function save_newsandupdate($data) { // updating news and update
        $ins_data['priority'] = $data['priority'];
        $ins_data['office_type'] = $data['office_type'];
        $ins_data['news_type'] = $data['news_type'];
        $ins_data['subject'] = $data['subject'];
        $ins_data['message'] = $data['news']['body'];
        $this->db->trans_begin();

        $this->db->where('id', $data['news_id']);
        $this->db->update('news_and_updates', $ins_data);

        if ($data['office_type'] == '1') {
            if (!empty($data['department'])) {
                $this->db->delete('news_and_update_department', array('news_and_update_id' => $data['news_id']));
                foreach ($data['department'] as $dept_id) {
                    $this->db->insert('news_and_update_department', ['news_and_update_id' => $data['news_id'], 'department' => $dept_id]);
                }
            }
        } else {
            if (!empty($data['office'])) {
                $this->db->delete('news_and_update_office', array('news_and_update_id' => $data['news_id']));
                foreach ($data['office'] as $ofc_id) {
                    $this->db->insert('news_and_update_office', ['news_and_update_id' => $data['news_id'], 'department' => 2, 'office' => $ofc_id]);
                }
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return "-1";
        } else {
            $this->db->trans_commit();
            return "1";
        }
    }

    public function get_news_update_list($staff_id = '', $filter = [], $for = 'dashboard', $limit = '') {
        $imp_data = [];
        $regular_data = [];

        if ($staff_id != '') {
            if ($for == 'dashboard') {
                if (in_array(1, $filter['variable_dropdown'])) {
                    $key = array_search(1, $filter['variable_dropdown']);
                    unset($filter['variable_dropdown'][$key]);
                    if ($filter['condition_dropdown'][$key] == 1 || $filter['condition_dropdown'][$key] == 2) {
                        if (in_array('important', $filter['criteria_dropdown']['priority']) && !in_array('regular', $filter['criteria_dropdown']['priority'])) {
                            $imp_data = $this->get_important_list($staff_id, $filter, $for, $limit);
                        } elseif (!in_array('important', $filter['criteria_dropdown']['priority']) && in_array('regular', $filter['criteria_dropdown']['priority'])) {
                            $regular_data = $this->get_regular_list($staff_id, $filter, $for, $limit);
                        } else {
                            $imp_data = $this->get_important_list($staff_id, $filter, $for, $limit);
                            $regular_data = $this->get_regular_list($staff_id, $filter, $for, $limit);
                        }
                    } else {
                        if (in_array('important', $filter['criteria_dropdown']['priority']) && !in_array('regular', $filter['criteria_dropdown']['priority'])) {
                            $regular_data = $this->get_regular_list($staff_id, $filter, $for, $limit);
                        } elseif (!in_array('important', $filter['criteria_dropdown']['priority']) && in_array('regular', $filter['criteria_dropdown']['priority'])) {
                            $imp_data = $this->get_important_list($staff_id, $filter, $for, $limit);
                        }
                    }
                } else {
                    $imp_data = $this->get_important_list($staff_id, $filter, $for, $limit);
                    $regular_data = $this->get_regular_list($staff_id, $filter, $for, $limit);
                }
            } else {
                $imp_data = $this->get_important_list($staff_id, [], $for, $limit);
                $regular_data = $this->get_regular_list($staff_id, [], $for, $limit);
            }
        } else {
            if ($for == 'dashboard') {
                if (in_array(1, $filter['variable_dropdown'])) {
                    $key = array_search(1, $filter['variable_dropdown']);
                    unset($filter['variable_dropdown'][$key]);
                    if ($filter['condition_dropdown'][$key] == 1 || $filter['condition_dropdown'][$key] == 2) {
                        if (in_array('important', $filter['criteria_dropdown']['priority']) && !in_array('regular', $filter['criteria_dropdown']['priority'])) {
                            $imp_data = $this->get_important_list(null, $filter, $for, $limit);
                        } elseif (!in_array('important', $filter['criteria_dropdown']['priority']) && in_array('regular', $filter['criteria_dropdown']['priority'])) {
                            $regular_data = $this->get_regular_list(null, $filter, $for, $limit);
                        } else {
                            $imp_data = $this->get_important_list(null, $filter, $for, $limit);
                            $regular_data = $this->get_regular_list(null, $filter, $for, $limit);
                        }
                    }else{
                        if (in_array('important', $filter['criteria_dropdown']['priority']) && !in_array('regular', $filter['criteria_dropdown']['priority'])) {
                            $regular_data = $this->get_regular_list(null, $filter, $for, $limit);
                            
                        } elseif (!in_array('important', $filter['criteria_dropdown']['priority']) && in_array('regular', $filter['criteria_dropdown']['priority'])) {
                            $imp_data = $this->get_important_list(null, $filter, $for, $limit);
                        } 
                    }
                } else {
                    $imp_data = $this->get_important_list(null, $filter, $for, $limit);
                    $regular_data = $this->get_regular_list(null, $filter, $for, $limit);
                }
            } else {
                $imp_data = $this->get_important_list(null, [], $for, $limit);
                $regular_data = $this->get_regular_list(null, [], $for, $limit);
            }
        }

        $final_arr = array_merge($imp_data, $regular_data);

        if ($limit != '') {
            $final_arr = array_slice($final_arr, 0, $limit);
        }
        return $final_arr;
    }

    public function get_important_list($staff_id = '', $filter = [], $for, $limit) {
        $sub_cond = [];
        $final_cond = '';

        if (!empty($filter['variable_dropdown'])) {

            foreach ($filter['variable_dropdown'] as $key1 => $val1) {

                $filter_column = '';
                $filter_oparetor = '';
                $filter_value = '';

//                if($val1 == 1){
//                    $filter_column = ' nu.priority ';
//                    
//                    $main_val = '';
//                    foreach($filter['criteria_dropdown']['priority'] as $val2){
//                        $main_val .= "'".$val2."',";
//                    }
//                    $main_val = substr($main_val,0,-1);
//                    
//                }
                if ($val1 == 2) {
                    $filter_column = ' nu.news_type ';

                    $main_val = '';
                    foreach ($filter['criteria_dropdown']['type'] as $val2) {
                        $main_val .= "'" . $val2 . "',";
                    }
                    $main_val = substr($main_val, 0, -1);
                } elseif ($val1 == 3) {
                    $filter_column = ' nud.department ';

                    $main_val = '';
                    foreach ($filter['criteria_dropdown']['department'] as $val2) {
                        $main_val .= "'" . $val2 . "',";
                    }
                    $main_val = substr($main_val, 0, -1);
                } elseif ($val1 == 4) {
                    $filter_column = ' nuo.department = 2 AND nuo.office ';

                    $main_val = '';
                    foreach ($filter['criteria_dropdown']['office'] as $val2) {
                        $main_val .= "'" . $val2 . "',";
                    }
                    $main_val = substr($main_val, 0, -1);
                } elseif ($val1 == 5) {
                    $filter_column = ' DATE(nu.created_type) ';
                    $date_arr = explode('-', $filter['criteria_dropdown']['start_date'][0]);
                }


                if ($filter['condition_dropdown'][$key1] == 1) {

                    if ($val1 == 5) {
                        $sub_cond[] = $filter_column . ' = "' . date('Y-m-d', strtotime($date_arr[0])) . '"';
                    } else {
                        $sub_cond[] = $filter_column . ' = ' . $main_val;
                    }
                } elseif ($filter['condition_dropdown'][$key1] == 2) {

                    if ($val1 == 5) {
                        $sub_cond[] = $filter_column . ' between "' . date('Y-m-d', strtotime($date_arr[0])) . '" and "' . date('Y-m-d', strtotime($date_arr[1])) . '"';
                    } else {
                        $sub_cond[] = $filter_column . ' in(' . $main_val . ')';
                    }
                } elseif ($filter['condition_dropdown'][$key1] == 3) {

                    if ($val1 == 5) {
                        $sub_cond[] = $filter_column . ' != "' . date('Y-m-d', strtotime($date_arr[0])) . '"';
                    } else {
                        $sub_cond[] = $filter_column . ' != ' . $main_val . '';
                    }
                } elseif ($filter['condition_dropdown'][$key1] == 4) {

                    if ($val1 == 5) {
                        $sub_cond[] = $filter_column . ' not between "' . date('Y-m-d', strtotime($date_arr[0])) . '" and "' . date('Y-m-d', strtotime($date_arr[1])) . '"';
                    } else {
                        $sub_cond[] = $filter_column . ' not in(' . $main_val . ')';
                    }
                }
            }
        }
        
        if(!empty($sub_cond)){
            $final_cond = ' and '.implode(' and ', $sub_cond);
        }


//        if ((isset($filter['news']) && $filter['news'] == 'news') && (isset($filter['update']) && $filter['update'] == '')) {
//            $sub_cond1[] = $filter['news'];
//        }
//        if ((isset($filter['update']) && $filter['update'] == 'update') && (isset($filter['news']) && $filter['news'] == '')) {
//            $sub_cond1[] = $filter['update'];
//        }
//        if (!empty($sub_cond1)) {
//            $cond[] = 'news_type="' . $sub_cond1[0] . '"';
//        }
//        if (!empty($cond)) {
//            $final_cond = ' and ' . implode(' and ', $cond);
//        }

        if ($staff_id != '') {

            $staff_info = staff_info();
//            print_r($staff_info);
//            exit;
            $final_arr = [];

            if ($staff_info['type'] == 2 && $staff_info['department'] != 14) {


                $query1 = 'select nu.*,nud.department,numu.is_read,numu.is_delete,numu.is_notification_deleted as user_notification_deleted,DATEDIFF(CURDATE(), nu.created_type) AS how_old_days '
                        . 'from news_and_updates nu '
                        . 'left join news_and_update_management_for_user numu on(nu.id=numu.news_and_update_id and numu.user_id=' . $staff_id . ') '
                        . 'inner join news_and_update_department nud on(nu.id=nud.news_and_update_id) '
                        . 'where nu.priority="important" and nu.office_type = 1 and nu.is_admin_deleted=0 ' . $final_cond . ' and nud.department IN(' . $staff_info['department'] . ') group by nu.id order by nu.created_type desc';

                if ($limit != '') {
                    $query1 = 'select nu.*,nud.department,numu.is_read,numu.is_delete,numu.is_notification_deleted as user_notification_deleted,DATEDIFF(CURDATE(), nu.created_type) AS how_old_days '
                            . 'from news_and_updates nu '
                            . 'left join news_and_update_management_for_user numu on(nu.id=numu.news_and_update_id and numu.user_id=' . $staff_id . ') '
                            . 'inner join news_and_update_department nud on(nu.id=nud.news_and_update_id) '
                            . 'where nu.priority="important" and nu.office_type = 1 and nu.is_admin_deleted=0 ' . $final_cond . ' and nud.department IN(' . $staff_info['department'] . ') group by nu.id order by nu.created_type desc limit 0,' . $limit;
                }

                $data1 = $this->db->query($query1)->result_array();

//                print_r($data1);
//                exit;

                if (!empty($data1)) {
                    foreach ($data1 as $key1 => $details1) {

                        if ($details1['is_delete'] != 1) {
                            if ($details1['is_all'] == 1) {


                                if ($for == 'notification') {
                                    if ($details1['user_notification_deleted'] == 1) {
                                        continue;
                                    } else {
                                        $final_arr[$key1] = $details1;
                                    }
                                } else {
                                    $final_arr[$key1] = $details1;
                                }
//                                }
                            }
                        }
                    }
                }
//                print_r($final_arr);
//                exit;
                return $final_arr;
            } elseif ($staff_info['type'] == 3) {


                $query1 = 'select nu.*,numu.is_read,numu.is_delete,numu.is_notification_deleted as user_notification_deleted,DATEDIFF(CURDATE(), nu.created_type) AS how_old_days '
                        . 'from news_and_updates nu '
                        . 'left join news_and_update_management_for_user numu on(nu.id=numu.news_and_update_id and numu.user_id=' . $staff_id . ') '
                        . 'inner join news_and_update_office nuo on(nu.id=nuo.news_and_update_id) '
                        . 'where nu.priority="important" and nu.office_type = 2 and nu.is_admin_deleted=0 ' . $final_cond . ' and nuo.department =2 and nuo.office IN(' . $staff_info['office'] . ') group by nu.id order by nu.created_type desc';

                if ($limit != '') {
                    $query1 = 'select nu.*,numu.is_read,numu.is_delete,numu.is_notification_deleted as user_notification_deleted,DATEDIFF(CURDATE(), nu.created_type) AS how_old_days '
                            . 'from news_and_updates nu '
                            . 'left join news_and_update_management_for_user numu on(nu.id=numu.news_and_update_id and numu.user_id=' . $staff_id . ') '
                            . 'inner join news_and_update_office nuo on(nu.id=nuo.news_and_update_id) '
                            . 'where nu.priority="important" and nu.office_type = 2 and nu.is_admin_deleted=0 ' . $final_cond . ' and nuo.department =2 and nuo.office IN(' . $staff_info['office'] . ') group by nu.id order by nu.created_type desc limit 0,' . $limit;
                }

                $data1 = $this->db->query($query1)->result_array();



                if (!empty($data1)) {
                    foreach ($data1 as $key1 => $details1) {

                        if ($details1['is_delete'] != 1) {
                            if ($details1['is_all'] == 1) {

                                if ($for == 'notification') {
                                    if ($details1['user_notification_deleted'] == 1) {
                                        continue;
                                    } else {
                                        $final_arr[$key1] = $details1;
                                    }
                                } else {
                                    $final_arr[$key1] = $details1;
                                }
                            }
                        }
                    }
                }
//                print_r($final_arr);exit;
                return $final_arr;
            }
        } else {

            if ($for == 'dashboard') {
                $query = 'select nu.*,DATEDIFF(CURDATE(), nu.created_type) AS how_old_days '
                        . 'from news_and_updates nu '
                        . 'left join news_and_update_department nud on(nu.id=nud.news_and_update_id) '
                        . 'left join news_and_update_office nuo on(nu.id=nuo.news_and_update_id) '
                        . 'where nu.priority="important" and nu.is_admin_deleted=0 ' . $final_cond . ' group by nu.id order by nu.created_type desc';
            } elseif ($for == 'notification') {
                $query = 'select *,DATEDIFF(CURDATE(),created_type) AS how_old_days from news_and_updates where priority="important" and is_admin_deleted=0 and is_notification_deleted = 0 group by id order by created_type desc limit  0,' . $limit;
            }
            return $this->db->query($query)->result_array();
        }
    }

    public function get_regular_list($staff_id = '', $filter = [], $for, $limit) {

//        $cond = [];
//        $sub_cond1 = [];
//
//        $final_cond = '';
//
//        if ((isset($filter['news']) && $filter['news'] == 'news') && (isset($filter['update']) && $filter['update'] == '')) {
//            $sub_cond1[] = $filter['news'];
//        }
//        if ((isset($filter['update']) && $filter['update'] == 'update') && (isset($filter['news']) && $filter['news'] == '')) {
//            $sub_cond1[] = $filter['update'];
//        }
//
//        if (!empty($sub_cond1)) {
//            $cond[] = 'news_type="' . $sub_cond1[0] . '"';
//        }
//        if (!empty($cond)) {
//            $final_cond = ' and ' . implode(' and ', $cond);
//        }

        $sub_cond = [];
        $final_cond = '';

        if (!empty($filter['variable_dropdown'])) {

            foreach ($filter['variable_dropdown'] as $key1 => $val1) {

                $filter_column = '';
                $filter_oparetor = '';
                $filter_value = '';

//                if($val1 == 1){
//                    $filter_column = ' nu.priority ';
//                    
//                    $main_val = '';
//                    foreach($filter['criteria_dropdown']['priority'] as $val2){
//                        $main_val .= "'".$val2."',";
//                    }
//                    $main_val = substr($main_val,0,-1);
//                    
//                }
                if ($val1 == 2) {
                    $filter_column = ' nu.news_type ';

                    $main_val = '';
                    foreach ($filter['criteria_dropdown']['type'] as $val2) {
                        $main_val .= "'" . $val2 . "',";
                    }
                    $main_val = substr($main_val, 0, -1);
                } elseif ($val1 == 3) {
                    $filter_column = ' nud.department ';

                    $main_val = '';
                    foreach ($filter['criteria_dropdown']['department'] as $val2) {
                        $main_val .= "'" . $val2 . "',";
                    }
                    $main_val = substr($main_val, 0, -1);
                } elseif ($val1 == 4) {
                    $filter_column = ' nuo.department = 2 AND nuo.office ';

                    $main_val = '';
                    foreach ($filter['criteria_dropdown']['office'] as $val2) {
                        $main_val .= "'" . $val2 . "',";
                    }
                    $main_val = substr($main_val, 0, -1);
                } elseif ($val1 == 5) {
                    $filter_column = ' DATE(nu.created_type) ';
                    $date_arr = explode('-', $filter['criteria_dropdown']['start_date'][0]);
                }


                if ($filter['condition_dropdown'][$key1] == 1) {

                    if ($val1 == 5) {
                        $sub_cond[] = $filter_column . ' = "' . date('Y-m-d', strtotime($date_arr[0])) . '"';
                    } else {
                        $sub_cond[] = $filter_column . ' = ' . $main_val;
                    }
                } elseif ($filter['condition_dropdown'][$key1] == 2) {

                    if ($val1 == 5) {
                        $sub_cond[] = $filter_column . ' between "' . date('Y-m-d', strtotime($date_arr[0])) . '" and "' . date('Y-m-d', strtotime($date_arr[1])) . '"';
                    } else {
                        $sub_cond[] = $filter_column . ' in(' . $main_val . ')';
                    }
                } elseif ($filter['condition_dropdown'][$key1] == 3) {

                    if ($val1 == 5) {
                        $sub_cond[] = $filter_column . ' != "' . date('Y-m-d', strtotime($date_arr[0])) . '"';
                    } else {
                        $sub_cond[] = $filter_column . ' != ' . $main_val . '';
                    }
                } elseif ($filter['condition_dropdown'][$key1] == 4) {

                    if ($val1 == 5) {
                        $sub_cond[] = $filter_column . ' not between "' . date('Y-m-d', strtotime($date_arr[0])) . '" and "' . date('Y-m-d', strtotime($date_arr[1])) . '"';
                    } else {
                        $sub_cond[] = $filter_column . ' not in(' . $main_val . ')';
                    }
                }
            }
        }
        
        if(!empty($sub_cond)){
            $final_cond = ' and '.implode(' and ', $sub_cond);
        }


        if ($staff_id != '') {

            $staff_info = staff_info();
            $final_arr = [];
//            print_r($staff_info);exit;
            if ($staff_info['type'] == 2 && $staff_info['department'] != 14) {


                $query1 = 'select nu.*,numu.is_read,numu.is_delete,numu.is_notification_deleted as user_notification_deleted,DATEDIFF(CURDATE(), nu.created_type) AS how_old_days '
                        . 'from news_and_updates nu '
                        . 'left join news_and_update_management_for_user numu on(nu.id=numu.news_and_update_id and numu.user_id=' . $staff_id . ') '
                        . 'inner join news_and_update_department nud on(nu.id=nud.news_and_update_id) '
                        . 'where nu.priority="regular" and nu.office_type = 1 and nu.is_admin_deleted=0 ' . $final_cond . ' and nud.department IN(' . $staff_info['department'] . ') group by nu.id order by nu.created_type desc';

                if ($limit != '') {
                    $query1 = 'select nu.*,numu.is_read,numu.is_delete,numu.is_notification_deleted as user_notification_deleted,DATEDIFF(CURDATE(), nu.created_type) AS how_old_days '
                            . 'from news_and_updates nu '
                            . 'left join news_and_update_management_for_user numu on(nu.id=numu.news_and_update_id and numu.user_id=' . $staff_id . ') '
                            . 'inner join news_and_update_department nud on(nu.id=nud.news_and_update_id) '
                            . 'where nu.priority="regular" and nu.office_type = 1 and nu.is_admin_deleted=0 ' . $final_cond . ' and nud.department IN(' . $staff_info['department'] . ') group by nu.id order by nu.created_type desc limit 0,' . $limit;
                }

                $data1 = $this->db->query($query1)->result_array();



                if (!empty($data1)) {
                    foreach ($data1 as $key1 => $details1) {

                        if ($details1['is_delete'] != 1) {
                            if ($details1['is_all'] == 1) {


                                if ($for == 'notification') {
                                    if ($details1['user_notification_deleted'] == 1) {
                                        continue;
                                    } else {
                                        $final_arr[$key1] = $details1;
                                    }
                                } else {
                                    $final_arr[$key1] = $details1;
                                }
                            }
                        }
                    }
                }
//                print_r($final_arr);exit;
                return $final_arr;
            } elseif ($staff_info['type'] == 3) {


                $query1 = 'select nu.*,numu.is_read,numu.is_delete,numu.is_notification_deleted as user_notification_deleted,DATEDIFF(CURDATE(), nu.created_type) AS how_old_days '
                        . 'from news_and_updates nu '
                        . 'left join news_and_update_management_for_user numu on(nu.id=numu.news_and_update_id and numu.user_id=' . $staff_id . ') '
                        . 'inner join news_and_update_office nuo on(nu.id=nuo.news_and_update_id) '
                        . 'where nu.priority="regular" and nu.office_type = 2 and nu.is_admin_deleted=0 ' . $final_cond . ' and nuo.department =2 and nuo.office IN(' . $staff_info['office'] . ') group by nu.id order by nu.created_type desc';

                if ($limit != '') {
                    $query1 = 'select nu.*,numu.is_read,numu.is_delete,numu.is_notification_deleted as user_notification_deleted,DATEDIFF(CURDATE(), nu.created_type) AS how_old_days '
                            . 'from news_and_updates nu '
                            . 'left join news_and_update_management_for_user numu on(nu.id=numu.news_and_update_id and numu.user_id=' . $staff_id . ') '
                            . 'inner join news_and_update_office nuo on(nu.id=nuo.news_and_update_id) '
                            . 'where nu.priority="regular" and nu.office_type = 2 and nu.is_admin_deleted=0 ' . $final_cond . ' and nuo.department =2 and nuo.office IN(' . $staff_info['office'] . ') group by nu.id order by nu.created_type desc limit 0,' . $limit;
                }

                $data1 = $this->db->query($query1)->result_array();



                if (!empty($data1)) {
                    foreach ($data1 as $key1 => $details1) {

                        if ($details1['is_delete'] != 1) {
                            if ($details1['is_all'] == 1) {

                                if ($for == 'notification') {
                                    if ($details1['user_notification_deleted'] == 1) {
                                        continue;
                                    } else {
                                        $final_arr[$key1] = $details1;
                                    }
                                } else {
                                    $final_arr[$key1] = $details1;
                                }
                            }
                        }
                    }
                }
                //print_r($final_arr);exit;
                return $final_arr;
            }
        } else {

            if ($for == 'dashboard') {
                $query = 'select nu.*,DATEDIFF(CURDATE(), nu.created_type) AS how_old_days '
                        . 'from news_and_updates nu '
                        . 'left join news_and_update_department nud on(nu.id=nud.news_and_update_id) '
                        . 'left join news_and_update_office nuo on(nu.id=nuo.news_and_update_id) '
                        . 'where nu.priority="regular" and nu.is_admin_deleted=0 ' . $final_cond . ' group by nu.id order by nu.created_type desc';
            } elseif ($for == 'notification') {
                $query = 'select *,DATEDIFF(CURDATE(), created_type) AS how_old_days from news_and_updates where priority="regular" and is_admin_deleted=0 and is_notification_deleted = 0 group by id order by created_type desc limit 0,' . $limit;
            }
            return $this->db->query($query)->result_array();
        }
    }

    public function get_assigned_dept_news($id, $office_type) {

//        echo 'kkk';exit;

        if ($office_type == 1) {
            $query = 'select department from news_and_update_department where news_and_update_id=' . $id . '';
            $data1 = $this->db->query($query)->result_array();

            $data1 = array_column($data1, 'department');

            $query = 'select name from department where id IN(' . implode(',', $data1) . ')';
            $data2 = $this->db->query($query)->result_array();

            return array_column($data2, 'name');
            ;
        } else {
            $query = 'select office from news_and_update_office where news_and_update_id=' . $id . '';
            $data1 = $this->db->query($query)->result_array();

            $data1 = array_column($data1, 'office');

            $query = 'select name from office where id IN(' . implode(',', $data1) . ')';
            $data2 = $this->db->query($query)->result_array();

            return array_column($data2, 'name');
        }
    }

    public function get_assigned_staff_news($id) {

        $query = 'select is_all from news_and_updates where id=' . $id . '';
        $data1 = $this->db->query($query)->row_array();

        if ($data1['is_all'] == 1) {

            return "All Staff";
        } else {

            $query = 'select users_id '
                    . 'from news_and_update_assignto_user '
                    . 'where news_and_update_id=' . $id . '';
            $data2 = $this->db->query($query)->row_array();

            $query = 'select CONCAT(last_name, ", ",first_name,", ",middle_name) as full_name '
                    . 'from staff '
                    . 'where id=' . $data2['users_id'] . '';
            $data3 = $this->db->query($query)->row_array();


            return $data3['full_name'];
        }
    }

    public function update_read($user_id, $news_id) {
        $query = 'select COUNT(id) as data_count from news_and_update_management_for_user where user_id=' . $user_id . ' and news_and_update_id=' . $news_id;
        $data = $this->db->query($query)->row_array();

        if ($data['data_count'] == 0) {
            $data1 = array(
                'news_and_update_id' => $news_id,
                'user_id' => $user_id,
                'is_read' => '1',
            );

            if ($this->db->insert('news_and_update_management_for_user', $data1)) {
                return '1';
            } else {
                return '-1';
            }
        } else {
            return '-1';
        }
    }
    public function delete_news_update($user_id, $news_id) {
        $query = 'select COUNT(id) as data_count from news_and_update_management_for_user where news_and_update_id=' . $news_id . ' and user_id=' . $user_id;
        $data = $this->db->query($query)->row_array();

        if ($data['data_count'] > 0) {
            $this->db->set('is_delete', 1);
            $this->db->where('news_and_update_id', $news_id);
            $this->db->where('user_id', $user_id);
            if ($this->db->update('news_and_update_management_for_user')) {
                echo '1';
            } else {
                echo '-1';
            }
        } else {
            $ins_data['news_and_update_id'] = $news_id;
            $ins_data['user_id'] = $user_id;
            $ins_data['is_read'] = 0;
            $ins_data['is_delete'] = 1;
            if ($this->db->insert('news_and_update_management_for_user', $ins_data)) {
                echo '1';
            } else {
                echo '-1';
            }
        }
    }
    public function delete_news_admin($news_id) {
        $this->db->set('is_admin_deleted', 1);
        $this->db->where('id', $news_id);
        if ($this->db->update('news_and_updates')) {
            echo '1';
        } else {
            echo '-1';
        }
    }

    public function delete_news_notification_admin($news_id) {

        $this->db->set('is_notification_deleted', 1);
        $this->db->where('id', $news_id);
        if ($this->db->update('news_and_updates')) {
            echo '1';
        } else {
            echo '-1';
        }
    }

    public function delete_news_notification($news_id, $user_id) {
        $query = 'select COUNT(id) as data_count from news_and_update_management_for_user where news_and_update_id=' . $news_id . ' and user_id=' . $user_id;
        $data = $this->db->query($query)->row_array();

        if ($data['data_count'] > 0) {
            $this->db->set('is_notification_deleted', 1);
            $this->db->where('news_and_update_id', $news_id);
            $this->db->where('user_id', $user_id);
            if ($this->db->update('news_and_update_management_for_user')) {
                echo '1';
            } else {
                echo '-1';
            }
        } else {

            $ins_data['news_and_update_id'] = $news_id;
            $ins_data['user_id'] = $user_id;
            $ins_data['is_read'] = 0;
            $ins_data['is_delete'] = 0;
            $ins_data['is_notification_deleted'] = 1;
            if ($this->db->insert('news_and_update_management_for_user', $ins_data)) {
                echo '1';
            } else {
                echo '-1';
            }
        }
    }
    public function get_news_view_count($news_id) { //read by staff or user info 

        // $query = 'select COUNT(id) as data_count from news_and_update_management_for_user where news_and_update_id=' . $news_id;
        // $data = $this->db->query($query)->row_array();

        // return $data['data_count'];

        $this->db->select("concat(st.last_name, ', ',st.first_name) as name,num.user_id,num.id");
        $this->db->from('news_and_update_management_for_user num');
        $this->db->join('staff st', 'st.id = num.user_id');
        $this->db->where('num.news_and_update_id',$news_id);
        $this->db->where('st.type !=','1');
        $this->db->group_by('st.id');
        $this->db->order_by('st.last_name');
        return $this->db->get()->result_array();
    }
    public function get_all_assigened_staff_news($news_id) { // total assigned staff or user
        $assigened_type = $this->db->get_where('news_and_updates',array('id'=>$news_id))->row_array()['office_type'];
        if ($assigened_type == 1) { // by department
            $this->db->select('naud.*');
            $this->db->from('news_and_updates nau');
            $this->db->join('news_and_update_department naud', 'naud.news_and_update_id = nau.id');
            $query = $this->db->get()->result_array();
            $departments = array_column($query, 'department');

            $this->db->select("concat(st.last_name, ', ',st.first_name) as name,ds.staff_id");
            $this->db->from('staff st');
            $this->db->join('department_staff ds', 'ds.staff_id = st.id');
            $this->db->where_in('ds.department_id',$departments);
            $this->db->where('st.type !=','1');
            $this->db->group_by('st.id');
            $this->db->order_by('st.last_name');
            return $this->db->get()->result_array();

        }elseif ($assigened_type == 2) { // by office 
            $this->db->select('*');
            $this->db->from('news_and_updates');
            $this->db->join('news_and_update_office', 'news_and_update_office.news_and_update_id = news_and_updates.id');
            $query = $this->db->get()->result_array();
            $offices = array_column($query, 'office');

            $this->db->select("concat(st.last_name, ', ',st.first_name) as name,os.staff_id");
            $this->db->from('staff st');
            $this->db->join('office_staff os', 'os.staff_id = st.id');
            $this->db->where_in('os.office_id',$offices);
            $this->db->where('st.type !=','1');
            $this->db->group_by('st.id');
            $this->db->order_by('st.last_name');
            return $this->db->get()->result_array();
            
        }
    }

    public function get_news_details_by_id($news_id) {

        $query = 'select nu.* '
                . 'from news_and_updates nu '
                . 'where id=' . $news_id;
        $data = $this->db->query($query)->row_array();

        return $data;
    }

    public function get_news_department($news_id) {

        $query = 'select department from news_and_update_department where news_and_update_id=' . $news_id . '';
        $data1 = $this->db->query($query)->result_array();

        $data1 = array_column($data1, 'department');

        return $data1;
    }

    public function get_news_office($news_id) {

        $query = 'select office from news_and_update_office where news_and_update_id=' . $news_id . '';
        $data1 = $this->db->query($query)->result_array();

        $data1 = array_column($data1, 'office');

        return $data1;
    }

    public function get_action_filter_element_value($element_key, $office) {
        $type_array = [
                ["id" => "news", "name" => "News"],
                ["id" => "update", "name" => "Update"]
        ];
        $priority_array = [
                ["id" => "important", "name" => "Important"],
                ["id" => "regular", "name" => "Regular"]
        ];
        switch ($element_key):
            case 1: {
                    return $priority_array;
                }
                break;
            case 2: {
                    return $type_array;
                }
                break;
            case 3: {
                    $user_info = staff_info();                    
                    return $this->action_model->get_corp_departments($user_info['department']);
                }
                break;
            case 4: {
                    return $this->action_model->get_office_by_department_id('2');
                }
                break;

            default: {
                    return [];
                }
                break;
        endswitch;
    }
    
    public function count_unread_news_update_by_userId($user_id,$type,$dept_str) {
        
        if($type == '2'){
            $query = 'select id '
                    . 'from news_and_update_department '
                    . 'where department in(' . $dept_str .') group by news_and_update_id';
            $data2 = $this->db->query($query)->row_array();
            
            
        }elseif($type == '3'){
            $query = 'select id '
                    . 'from news_and_update_office '
                    . 'where office in(' . $dept_str .') group by news_and_update_id';
            $data2 = $this->db->query($query)->row_array();
            
            
        }

        $query = 'select id from news_and_update_management_for_user where user_id=' . $user_id . ' and (is_read=1 or is_delete=1) group by news_and_update_id';
        $data1 = $this->db->query($query)->row_array();        
        
        if(!empty($data2)){
            $data2count = count($data2);
        }else{
            $data2count = 0;
        }

        if(!empty($data1)){
            $data1count = count($data1);
        }else{
           $data1count = 0; 
        }

        if($data2count == $data1count){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    function clearNews_updateList($userid){
        $this->db->query("UPDATE news_and_update_management_for_user SET is_delete=1 WHERE user_id='$userid'");
    }
    function clearNews_updateListAdmin($userid){
        $this->db->query("UPDATE news_and_updates SET is_notification_deleted=1 WHERE created_by='$userid'");
//        $this->db->query("UPDATE news_and_updates SET is_admin_deleted=1");
    }

}

?>