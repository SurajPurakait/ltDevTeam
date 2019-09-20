<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = 'leafnet_db';
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);
// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}else{
	//echo "Connected successfully"; 
}

$sql = 'SELECT * from project_recurrence_main where generation_type="1"';
$project_id_array = array();
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($pattern_details = mysqli_fetch_array($result)) {
        	$due_date = '';
            $actual_day = $pattern_details['actual_due_day'];
            $actual_mnth = $pattern_details['actual_due_month'];
            $actual_yr = $pattern_details['actual_due_year'];
            if (strlen($actual_mnth) == 1) {
                $actual_mnth = '0' . $actual_mnth;
            }
            if (strlen($actual_day) == 1) {
                $actual_day = '0' . $actual_day;
            }
            $dueDate = $actual_mnth . '-' . $actual_day . '-' . $actual_yr;

            if($pattern_details['generation_month']==''){
                $pattern_details['generation_month'] = '0';
            }

            if($pattern_details['generation_day']==''){
                $pattern_details['generation_day'] = '0';
            }

            $recur_days = (int)($pattern_details['generation_month']*30) + (int)$pattern_details['generation_day'];

            $recurDate = date('m-d-Y', strtotime('-'.$recur_days.' days', strtotime($dueDate)));

            $curDate = date('m-d-Y');
            if(strtotime($curDate)==strtotime($recurDate)){
            	$project_id = $pattern_details['project_id'];
                //insert projects table
            	$get_projects_data = 'SELECT * from projects where id="' . $project_id . '"';
                $get_projects_result = mysqli_query($conn, $get_projects_data);
                if (mysqli_num_rows($get_projects_result) > 0) {
                    while ($row = mysqli_fetch_array($get_projects_result)) {
                       $insert_projects_data = array('template_id' => "'".$row['template_id']."'",
                                                      'client_type' => "'".$row['client_type']."'",
                                                      'office_id' => "'".$row['office_id']."'",
                                                      'client_id' => "'".$row['client_id']."'",
                                                      'status' => 0
                                                       );
                        $columns = implode(", ",array_keys($insert_projects_data));
                        $escaped_values = array_values($insert_projects_data);
                        $values  = implode(", ", $escaped_values);
                        $insert_projects_sql = "INSERT INTO `projects`($columns) VALUES ($values)";
                        mysqli_query($conn, $insert_projects_sql);
                        $project_id_new = mysqli_insert_id($conn);
                        //end projects table
                        array_push($project_id_array,$project_id_new);
                        //insert project_main table
                        $get_project_main_data = 'SELECT * from project_main where project_id="' . $project_id . '"';
                        $get_project_main_result = mysqli_query($conn, $get_project_main_data);
                        if (mysqli_num_rows($get_project_main_result) > 0) {
                            while ($row1 = mysqli_fetch_array($get_project_main_result)) {
                               $insert_project_main_data = array('added_by_user' => "'".$row1['added_by_user']."'",
                                                              'template_id' => "'".$row1['template_id']."'",
                                                              'project_id' => "'".$project_id_new."'",
                                                              'title' => "'".$row1['title']."'",
                                                              'description' => "'".$row1['description']."'",
                                                              'category_id' => "'".$row1['category_id']."'",
                                                              'service_id' => "'".$row1['service_id']."'",
                                                              'status' => 0,
                                                              'department_id' => "'".$row1['department_id']."'",
                                                              'ofc_is_all' => "'".$row1['ofc_is_all']."'",
                                                              'dept_is_all' => "'".$row1['dept_is_all']."'",
                                                              'office_id' => "'".$row1['office_id']."'",
                                                              'responsible_department' => "'".$row1['responsible_department']."'",
                                                              'responsible_staff' => "'".$row1['responsible_staff']."'",
                                                              'partner_id' => "'".$row1['partner_id']."'",
                                                              'manager_id' => "'".$row1['manager_id']."'",
                                                              'associate_id' => "'".$row1['associate_id']."'"
                                                               );
                                $columns1 = implode(", ",array_keys($insert_project_main_data));
                                $escaped_values1 = array_values($insert_project_main_data);
                                $values1  = implode(", ", $escaped_values1);
                                $insert_project_main_sql = "INSERT INTO `project_main`($columns1) VALUES ($values1)";
                                mysqli_query($conn, $insert_project_main_sql);
                            }
                        }

                        //end project_main table

                        //insert project_note table
                        $get_project_note_data = 'SELECT * from project_note where project_id="' . $project_id . '"';
                        $get_project_note_result = mysqli_query($conn, $get_project_note_data);
                        if (mysqli_num_rows($get_project_note_result) > 0) {
                            while ($row2 = mysqli_fetch_array($get_project_note_result)) {
                               $insert_project_note_data = array(
                                                              'project_id' => "'".$project_id_new."'",
                                                              'added_by_user' => "'".$row2['added_by_user']."'",
                                                              'note' => "'".$row2['note']."'",
                                                              'read_status' => 0
                                                               );
                                $columns2 = implode(", ",array_keys($insert_project_note_data));
                                $escaped_values2 = array_values($insert_project_note_data);
                                $values2  = implode(", ", $escaped_values2);
                                $insert_project_note_sql = "INSERT INTO `project_note`($columns2) VALUES ($values2)";
                                mysqli_query($conn, $insert_project_note_sql);
                                $note_id_new = mysqli_insert_id($conn);

                                //insert notes_log table
                                $insert_project_note_log_data = array(
                                                              'note_id' => "'".$project_id_new."'",
                                                              'user_id' => "'".$row2['added_by_user']."'",
                                                              'related_table_id' => 9
                                                               );
                                $columns3 = implode(", ",array_keys($insert_project_note_log_data));
                                $escaped_values3 = array_values($insert_project_note_log_data);
                                $values3  = implode(", ", $escaped_values3);
                                $insert_project_note_log_sql = "INSERT INTO `notes_log`($columns3) VALUES ($values3)";
                                mysqli_query($conn, $insert_project_note_log_sql);
                                //end notes_log table
                            }
                        }

                        //end project_note table

                         //insert project_recurrence table
                        $get_project_recurrence_main_data = 'SELECT * from project_recurrence_main where project_id="' . $project_id . '"';
                        $get_project_recurrence_main_result = mysqli_query($conn, $get_project_recurrence_main_data);
                        if (mysqli_num_rows($get_project_recurrence_main_result) > 0) {
                            while ($row3 = mysqli_fetch_array($get_project_recurrence_main_result)) { 

                            if (strlen($row3['actual_due_month']) == 1) {
                                $row3['actual_due_month'] = '0' . $row3['actual_due_month'];
                            }
                            if (strlen($row3['actual_due_day']) == 1) {
                                $row3['actual_due_day'] = '0' . $row3['actual_due_day'];
                            }   

                            if($row3['pattern']=='annually' || $row3['pattern']=='none'){
                               $current_due = $row3['actual_due_day'] . '-' . $row3['actual_due_month'] . '-' . $row3['actual_due_year'];
                                $date = strtotime($current_due);
                                $date = strtotime("+1 year", $date);
                                $actual_due_day = date('d', $date);
                                $actual_due_month = date('m', $date);
                                $actual_due_year = date('Y', $date);
                            }elseif($row3['pattern']=='monthly'){
                                $current_due = $row3['actual_due_day'] . '-' . $row3['actual_due_month'] . '-' . $row3['actual_due_year'];
                                $date = strtotime($current_due);
                                $date = strtotime("+1 month", $date);
                                $actual_due_day = date('d', $date);
                                $actual_due_month = date('m', $date);
                                $actual_due_year = date('Y', $date);
                            }elseif($row3['pattern']=='weekly'){
                                $current_due = $row3['actual_due_day'] . '-' . $row3['actual_due_month'] . '-' . $row3['actual_due_year'];
                                $date = strtotime($current_due);
                                $date = strtotime("+7 days", $date);
                                $actual_due_day = date('d', $date);
                                $actual_due_month = date('m', $date);
                                $actual_due_year = date('Y', $date);
                            }elseif($row3['pattern']=='quarterly'){
                                $current_due = $row3['actual_due_day'] . '-' . $row3['actual_due_month'] . '-' . $row3['actual_due_year'];
                                $date = strtotime($current_due);
                                $date = strtotime("+3 months", $date);
                                $actual_due_day = date('d', $date);
                                $actual_due_month = date('m', $date);
                                $actual_due_year = date('Y', $date);
                            }

                            $insert_project_recurrence_main_data = array(
                                                      'template_id' => "'".$row3['template_id']."'",
                                                      'project_id' => "'".$project_id_new."'",
                                                      'pattern' => "'".$row3['pattern']."'",
                                                      'occur_weekdays' => "'".$row3['occur_weekdays']."'",
                                                      'client_fiscal_year_end' => "'".$row3['client_fiscal_year_end']."'",
                                                      'fye_type' => "'".$row3['fye_type']."'",
                                                      'fye_day' => "'".$row3['fye_day']."'",
                                                      'fye_is_weekday' => "'".$row3['fye_is_weekday']."'",
                                                      'fye_month' => "'".$row3['fye_month']."'",
                                                      'due_type' => "'".$row3['due_type']."'",
                                                      'due_day' => "'".$row3['due_day']."'",
                                                      'due_month' => "'".$row3['due_month']."'",
                                                      'due_year_1' => "'".$row3['due_year_1']."'",
                                                      'target_start_days' => "'".$row3['target_start_days']."'",
                                                      'target_start_day' => "'".$row3['target_start_day']."'",
                                                      'target_end_days' => "'".$row3['target_end_days']."'",
                                                      'target_end_day' => "'".$row3['target_end_day']."'",
                                                      'expiration_type' => "'".$row3['expiration_type']."'",
                                                      'end_occurrence' => "'".$row3['end_occurrence']."'",
                                                      'generation_type' => "'".$row3['generation_type']."'",
                                                      'generation_day' => "'".$row3['generation_day']."'",
                                                      'generation_month' => "'".$row3['generation_month']."'",
                                                      'actual_due_day' => "'".$actual_due_day."'",
                                                      'actual_due_month' => "'".$actual_due_month."'",
                                                      'actual_due_year' => "'".$actual_due_year."'"
                                                       );

                                if($insert_project_recurrence_main_data['pattern']=='monthly'){
                                    $cur_day = date('d');
                                    if($cur_day<=$insert_project_recurrence_main_data['actual_due_day']){
                                       $insert_project_recurrence_main_data['actual_due_month'] = date('m');
                                    }
                                } 

                                $columns4 = implode(", ",array_keys($insert_project_recurrence_main_data));
                                $escaped_values4 = array_values($insert_project_recurrence_main_data);
                                $values4  = implode(", ", $escaped_values4);
                                $insert_project_recurrence_main_sql = "INSERT INTO `project_recurrence_main`($columns4) VALUES ($values4)";
                                mysqli_query($conn, $insert_project_recurrence_main_sql);
                            }
                        }

                        //end project_recurrence table

                        //insert project_staff table
                        $get_project_staff_data = 'SELECT * from project_staff_main where project_id="' . $project_id . '"';
                        $get_project_staff_result = mysqli_query($conn, $get_project_staff_data);
                        if (mysqli_num_rows($get_project_staff_result) > 0) {
                            while ($row4 = mysqli_fetch_array($get_project_staff_result)) {
                               $insert_project_staff_data = array(
                                                              'template_id' => "'".$row4['template_id']."'",
                                                              'project_id' => "'".$project_id_new."'",
                                                              'staff_id' => "'".$row4['staff_id']."'",
                                                              'type' => "'".$row4['type']."'"
                                                               );
                                $columns5 = implode(", ",array_keys($insert_project_staff_data));
                                $escaped_values5 = array_values($insert_project_staff_data);
                                $values5  = implode(", ", $escaped_values5);
                                $insert_project_staff_sql = "INSERT INTO `project_staff_main`($columns5) VALUES ($values5)";
                                mysqli_query($conn, $insert_project_staff_sql);
                            }
                        }

                        //end project_staff table

                        //insert project_task table
                        $get_project_task_data = 'SELECT * from project_task where project_id="' . $project_id . '"';
                        $get_project_task_result = mysqli_query($conn, $get_project_task_data);
                        if (mysqli_num_rows($get_project_task_result) > 0) {
                            while ($row5 = mysqli_fetch_array($get_project_task_result)) {
                               $insert_project_task_data = array(
                                                              'template_main_id' => "'".$row5['template_main_id']."'",
                                                              'project_id' => "'".$project_id_new."'",
                                                              'added_by_user' => "'".$row5['added_by_user']."'",
                                                              'task_order' => "'".$row5['task_order']."'",
                                                              'description' => "'".$row5['description']."'",
                                                              'target_start_date' => "'".$row5['target_start_date']."'",
                                                              'target_start_day' => "'".$row5['target_start_day']."'",
                                                              'target_complete_date' => "'".$row5['target_complete_date']."'",
                                                              'target_complete_day' => "'".$row5['target_complete_day']."'",
                                                              'tracking_description' => 0,
                                                              'is_all' => "'".$row5['is_all']."'",
                                                              'department_id' => "'".$row5['department_id']."'",
                                                              'office_id' => "'".$row5['office_id']."'",
                                                              'responsible_task_staff' => "'".$row5['responsible_task_staff']."'",
                                                              'date_started' => 'NULL',
                                                              'date_completed' => 'NULL',
                                                              'status' => 0
                                                               );
                               $columns6 = implode(", ",array_keys($insert_project_task_data));
                                $escaped_values6 = array_values($insert_project_task_data);
                                $values6  = implode(", ", $escaped_values6);
                                $insert_project_task_sql = "INSERT INTO `project_task`($columns6) VALUES ($values6)";
                                // echo '<pre>';
                                // echo $insert_project_task_sql; continue;
                                mysqli_query($conn, $insert_project_task_sql);
                                $project_task_id_new = mysqli_insert_id($conn);

                                //insert project_task_staff table
                                $get_project_task_staff_data = 'SELECT * from project_task_staff where task_id="' . $row5['id'] . '"';
                                $get_project_task_staff_result = mysqli_query($conn, $get_project_task_staff_data);
                                if (mysqli_num_rows($get_project_task_staff_result) > 0) {
                                    while ($row6 = mysqli_fetch_array($get_project_task_staff_result)) {
                                       $insert_project_task_staff_data = array(
                                                                      'task_id' => "'".$project_task_id_new."'",
                                                                      'staff_id' => "'".$row6['staff_id']."'"
                                                                       );
                                       $columns7 = implode(", ",array_keys($insert_project_task_staff_data));
                                        $escaped_values7 = array_values($insert_project_task_staff_data);
                                        $values7  = implode(", ", $escaped_values7);
                                        $insert_project_task_staff_sql = "INSERT INTO `project_task_staff`($columns7) VALUES ($values7)";
                                        mysqli_query($conn, $insert_project_task_staff_sql);
                                    }
                                }

                                //end project_task_staff table 
                            }
                        }

                        //end project_task table 
                    }
                }
            }
        }
    }
}
if(!empty($project_id_array)){
    echo count($project_id_array).' projects created successfully';
}else{
    echo 'No project created';
}
?>