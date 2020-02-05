<?php
$servername = "localhost";
$username = "leafnet_db_user";
$password = "leafnet@123";
$db = 'leafnet_stagings';

//$servername = "localhost";
//$username = "root";
//$password = "root";
//$db = 'leafnet_new';
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);
// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
} else {
    //echo "Connected successfully"; 
}
$sql = 'SELECT * from project_recurrence_main where generation_type="1" and generated_by_cron=0';
//echo $sql;die;
$project_id_array = array();
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($pattern_details = mysqli_fetch_array($result)) {
            $recurDate = $pattern_details['generation_date'];
            $curDate = date('Y-m-d');
            if (strtotime($curDate) >= strtotime($recurDate)) {   //this condition is off for past recurrence date
                $project_id = $pattern_details['project_id'];
                //update old table
                $updatesql = "update `project_recurrence_main` set generated_by_cron= 1 where id = " . $pattern_details['id'];
                mysqli_query($conn, $updatesql);
                //insert projects table
                $get_projects_data = 'SELECT * from projects where id="' . $project_id . '"';
                $get_projects_result = mysqli_query($conn, $get_projects_data);
                if (mysqli_num_rows($get_projects_result) > 0) {
                    while ($row = mysqli_fetch_array($get_projects_result)) {
                        $insert_projects_data = array('template_id' => "'" . $row['template_id'] . "'",
                            'client_type' => "'" . $row['client_type'] . "'",
                            'office_id' => "'" . $row['office_id'] . "'",
                            'client_id' => "'" . $row['client_id'] . "'",
                            'status' => 0
                        );
                        $columns = implode(", ", array_keys($insert_projects_data));
                        $escaped_values = array_values($insert_projects_data);
                        $values = implode(", ", $escaped_values);
                        $insert_projects_sql = "INSERT INTO `projects`($columns) VALUES ($values)";
                        mysqli_query($conn, $insert_projects_sql);
                        $project_id_new = mysqli_insert_id($conn);
                        //end projects table
                        array_push($project_id_array, $project_id_new);
                        //insert project_main table
                        $get_project_main_data = 'SELECT * from project_main where project_id="' . $project_id . '"';
                        $get_project_main_result = mysqli_query($conn, $get_project_main_data);
                        if (mysqli_num_rows($get_project_main_result) > 0) {
                            while ($row1 = mysqli_fetch_array($get_project_main_result)) {
                                $template_cat_id=$row1['template_cat_id'];
                                if($row1['responsible_staff']==''){
                                    $responsible_staff='null';
                                }else{
                                    $responsible_staff=$row1['responsible_staff'];
                                }
                                if($row1['partner_id']==''){
                                    $partner_id='null';
                                }else{
                                    $partner_id=$row1['partner_id'];
                                }
                                if($row1['manager_id']==''){
                                    $manager_id='null';
                                }else{
                                    $manager_id=$row1['manager_id'];
                                }
                                if($row1['associate_id']==''){
                                    $associate_id='null';
                                }else{
                                    $associate_id=$row1['associate_id'];
                                }
                                if($row1['ofc_is_all']==''){
                                    $office_is_all='NULL';
                                }else{
                                    $office_is_all=$row1['ofc_is_all'];
                                }
                                if($row1['responsible_department']==''){
                                    $responsible_department='NULL';
                                }else{
                                    $responsible_department=$row1['responsible_department'];
                                }
                                $insert_project_main_data = array('template_cat_id'=>"'".$row1['template_cat_id']."'",
                                    'added_by_user' => "'" . $row1['added_by_user'] . "'",
                                    'template_id' => "'" . $row1['template_id'] . "'",
                                    'project_id' => "'" . $project_id_new . "'",
                                    'title' => "'" . $row1['title'] . "'",
                                    'description' => "'" . $row1['description'] . "'",
                                    'category_id' => "'" . $row1['category_id'] . "'",
                                    'service_id' => "'" . $row1['service_id'] . "'",
                                    'status' => 0,
                                    'department_id' => "'" . $row1['department_id'] . "'",
                                    'ofc_is_all' => $office_is_all,
                                    'dept_is_all' => "'" . $row1['dept_is_all'] . "'",
                                    'office_id' => "'" . $row1['office_id'] . "'",
                                    'responsible_department' =>$responsible_department,
                                    'responsible_staff' => $responsible_staff,
                                    'partner_id' => $partner_id,
                                    'manager_id' => $manager_id,
                                    'associate_id' =>$associate_id
                                );
                                $columns1 = implode(", ", array_keys($insert_project_main_data));
                                $escaped_values1 = array_values($insert_project_main_data);
                                $values1 = implode(", ", $escaped_values1);
                                $insert_project_main_sql = "INSERT INTO `project_main`($columns1) VALUES ($values1)";
//                                echo $insert_project_main_sql;die;                     
                                mysqli_query($conn, $insert_project_main_sql)or die('project main insert err');
                            }
                        }

                        //end project_main table
                        //insert project_note table
                        $get_project_note_data = 'SELECT * from project_note where project_id="' . $project_id . '"';
                        $get_project_note_result = mysqli_query($conn, $get_project_note_data);
                        if (mysqli_num_rows($get_project_note_result) > 0) {
                            while ($row2 = mysqli_fetch_array($get_project_note_result)) {
                                $insert_project_note_data = array(
                                    'project_id' => "'" . $project_id_new . "'",
                                    'added_by_user' => "'" . $row2['added_by_user'] . "'",
                                    'note' => "'" . $row2['note'] . "'",
                                    'read_status' => 0
                                );
                                $columns2 = implode(", ", array_keys($insert_project_note_data));
                                $escaped_values2 = array_values($insert_project_note_data);
                                $values2 = implode(", ", $escaped_values2);
                                $insert_project_note_sql = "INSERT INTO `project_note`($columns2) VALUES ($values2)";
                                mysqli_query($conn, $insert_project_note_sql);
                                $note_id_new = mysqli_insert_id($conn);

                                //insert notes_log table
                                $insert_project_note_log_data = array(
                                    'note_id' => "'" . $project_id_new . "'",
                                    'user_id' => "'" . $row2['added_by_user'] . "'",
                                    'related_table_id' => 9
                                );
                                $columns3 = implode(", ", array_keys($insert_project_note_log_data));
                                $escaped_values3 = array_values($insert_project_note_log_data);
                                $values3 = implode(", ", $escaped_values3);
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
                                $old_due_date = $row3['due_date'];
                                $old_next_due_date= $row3['next_due_date'];
                                $old_generation_date= $row3['generation_date'];
                                $start_month=date('n',strtotime($old_generation_date));
                                if (strlen($row3['actual_due_month']) == 1) {
                                    $row3['actual_due_month'] = '0' . $row3['actual_due_month'];
                                }
                                if (strlen($row3['actual_due_day']) == 1) {
                                    $row3['actual_due_day'] = '0' . $row3['actual_due_day'];
                                }

                                if ($row3['pattern'] == 'annually' || $row3['pattern'] == 'none') {
                                    $current_due = $row3['actual_due_day'] . '-' . $row3['actual_due_month'] . '-' . $row3['actual_due_year'];
                                    $date = strtotime($current_due);
                                    $date = strtotime("+1 year", $date);
                                    $actual_due_day = date('d', $date);
                                    $actual_due_month = date('m', $date);
                                    $actual_due_year = date('Y', $date);
                                } elseif ($row3['pattern'] == 'monthly') {
                                    $current_due = $row3['actual_due_day'] . '-' . $row3['actual_due_month'] . '-' . $row3['actual_due_year'];
                                    $date = strtotime($current_due);
                                    $date = strtotime("+1 month", $date);
                                    $actual_due_day = date('d', $date);
                                    $actual_due_month = date('m', $date);
                                    $actual_due_year = date('Y', $date);
                                } elseif ($row3['pattern'] == 'weekly') {
                                    $current_due = $row3['actual_due_day'] . '-' . $row3['actual_due_month'] . '-' . $row3['actual_due_year'];
                                    $date = strtotime($current_due);
                                    $date = strtotime("+7 days", $date);
                                    $actual_due_day = date('d', $date);
                                    $actual_due_month = date('m', $date);
                                    $actual_due_year = date('Y', $date);
                                } elseif ($row3['pattern'] == 'quarterly') {
                                    $current_due = $row3['actual_due_day'] . '-' . $row3['actual_due_month'] . '-' . $row3['actual_due_year'];
                                    $date = strtotime($current_due);
                                    $date = strtotime("+3 months", $date);
                                    $actual_due_day = date('d', $date);
                                    $actual_due_month = date('m', $date);
                                    $actual_due_year = date('Y', $date);
                                }
                                if($row3['due_year_1']==''){
                                    $due_year_1='null';
                                }else{
                                    $due_year_1=$row3['due_year_1'];
                                }
                                if($row3['end_occurrence']==''){
                                    $end_occurrence='';
                                }else{
                                    $end_occurrence=$row3['end_occurrence'];
                                }

                                $insert_project_recurrence_main_data = array(
                                    'template_id' => "'" . $row3['template_id'] . "'",
                                    'project_id' => "'" . $project_id_new . "'",
                                    'pattern' => "'" . $row3['pattern'] . "'",
                                    'occur_weekdays' => "'" . $row3['occur_weekdays'] . "'",
                                    'client_fiscal_year_end' => "'" . $row3['client_fiscal_year_end'] . "'",
                                    'fye_type' => "'" . $row3['fye_type'] . "'",
                                    'fye_day' => "'" . $row3['fye_day'] . "'",
                                    'fye_is_weekday' => "'" . $row3['fye_is_weekday'] . "'",
                                    'fye_month' => "'" . $row3['fye_month'] . "'",
                                    'due_type' => "'" . $row3['due_type'] . "'",
                                    'due_day' => "'" . $row3['due_day'] . "'",
                                    'due_month' => "'" . $row3['due_month'] . "'",
                                    'due_year_1' => $due_year_1,
                                    'target_start_days' => "'" . $row3['target_start_days'] . "'",
                                    'target_start_months'=>"'".$row3['target_start_months']."'",
                                    'target_start_day' => "'" . $row3['target_start_day'] . "'",
                                    'target_end_days' => "'" . $row3['target_end_days'] . "'",
                                    'target_end_months'=>"'".$row3['target_end_months']."'",
                                    'target_end_day' => "'" . $row3['target_end_day'] . "'",
                                    'expiration_type' => "'" . $row3['expiration_type'] . "'",
                                    'end_occurrence' => "'". $end_occurrence."'",
                                    'generation_type' => "'" . $row3['generation_type'] . "'",
                                    'generation_day' => "'" . $row3['generation_day'] . "'",
                                    'generation_month' => "'" . $row3['generation_month'] . "'",
                                    'actual_due_day' => "'" . $actual_due_day . "'",
                                    'actual_due_month' => "'" . $actual_due_month . "'",
                                    'actual_due_year' => "'" . $actual_due_year . "'"
                                );
//                                $insert_project_recurrence_main_data['pattern']=$row3['pattern'];

                                if ($row3['pattern'] == 'monthly') {
                                    $cur_day = date('d');
                                    if ($cur_day <= $insert_project_recurrence_main_data['actual_due_day']) {
                                        $insert_project_recurrence_main_data['actual_due_month'] = date('m');
                                    }
                                }
//                                this due date is closed for some changing
//                                $due_date = $insert_project_recurrence_main_data['actual_due_year'] . '-' . $insert_project_recurrence_main_data['actual_due_month'] . '-' . $insert_project_recurrence_main_data['actual_due_day'];

                                if ($row3['generation_month'] == '') {
                                    $insert_project_recurrence_main_data['generation_month'] = '0';
                                }

                                if ($row3['generation_day'] == '') {
                                    $insert_project_recurrence_main_data['generation_day'] = '0';
                                }
                                
//                              for lots of changing it will created
                                if($template_cat_id==1){
                                    $due_date=date('Y-m-d',strtotime('+ 2 month',strtotime($old_generation_date)));
                                }elseif($template_cat_id==3){
                                    $due_date=date('Y-m-d',strtotime('+ 1 month',strtotime($old_generation_date)));
                                }
                                if($template_cat_id==1){
                                    $due_date_ptrn=date('Y',strtotime($due_date)).'-'.date('m',strtotime($due_date)).'-01';
                                    $insert_project_recurrence_main_data['due_date']="'".$due_date_ptrn."'";
                                }else{
                                    $due_date_ptrn=date('Y',strtotime($due_date)).'-'.date('m',strtotime($due_date)).'-19';
                                    $insert_project_recurrence_main_data['due_date']="'".$due_date_ptrn."'";
                                }
//                                end of lots of chang
                                

                                if ($row3['pattern'] == 'monthly') {
                                    $next_due_date = date("Y-m-d", strtotime("+1 month", strtotime($due_date)));
                                    if($template_cat_id==1){
                                        $next_due_month=date('m',strtotime($next_due_date));
                                        $next_due_year=date('Y',strtotime($next_due_date));
                                        $next_due_date=$next_due_year.'-'.$next_due_month.'-01';
                                    }elseif($template_cat_id==3){
                                        $next_due_month=date('m',strtotime($next_due_date));
                                        $next_due_year=date('Y',strtotime($next_due_date));
                                        $next_due_date=$next_due_year.'-'.$next_due_month.'-19';
                                    }
                                    $insert_project_recurrence_main_data['next_due_date'] = "'".$next_due_date."'";
                                } elseif ($row3['pattern'] == 'annually') {
                                    $next_due_date = date("Y-m-d", strtotime("+1 year", strtotime($due_date)));
                                    $insert_project_recurrence_main_data['next_due_date'] = $next_due_date;
                                } elseif ($row3['pattern'] == 'weekly') {
                                    $next_due_date = date("Y-m-d", strtotime("+7 days", strtotime($due_date)));
                                    $insert_project_recurrence_main_data['next_due_date'] = $next_due_date;
                                } elseif ($row3['pattern'] == 'quarterly') {
                                    $next_due_date = date("Y-m-d", strtotime("+3 months", strtotime($due_date)));
                                    $insert_project_recurrence_main_data['next_due_date'] = $next_due_date;
                                } else {
                                    $insert_project_recurrence_main_data['next_due_date'] = '0000-00-00';
                                }
                                if($template_cat_id==1){
                                    $actual_month = date('m', strtotime('-1 month', strtotime($next_due_date)));
                                }else{
                                    $actual_month = date('m', strtotime($next_due_date));
                                }
                                $actual_year = date('Y', strtotime($next_due_date));
                                $total_days = cal_days_in_month(CAL_GREGORIAN, $actual_month, $actual_year);
                                if($actual_year=='2019'){
                                    $generation_days = ((int) $row3['generation_month'] * 30) + (int) $row3['generation_day']-1;
                                }else{
                                    if($template_cat_id==1){
                                        $generation_days = ((int) $row3['generation_month'] * 30) + (int) $row3['generation_day'];    
                                    }else{
                                        $generation_days = ((int) $row3['generation_month'] * $total_days) + (int) $row3['generation_day']-2;    
                                    }
                                }
                                
                                $generation_date = date('Y-m-d', strtotime('-' . $generation_days . ' days', strtotime($next_due_date)));
                                if($template_cat_id==1|| $template_cat_id==3){
                                    $generation_date=date('Y',strtotime($generation_date)).'-'.date('m',strtotime($generation_date)).'-01';
                                }
//                                echo $generation_date;die;
                                $insert_project_recurrence_main_data['generation_date'] = "'".$generation_date."'";
                                $insert_project_recurrence_main_data['start_month']="'".$start_month."'";
                                $columns4 = implode(", ", array_keys($insert_project_recurrence_main_data));
                                $escaped_values4 = array_values($insert_project_recurrence_main_data);
                                $values4 = implode(", ", $escaped_values4);
                                $insert_project_recurrence_main_sql = "INSERT INTO `project_recurrence_main`($columns4) VALUES ($values4)";
//                                echo $insert_project_recurrence_main_sql;die;
                                mysqli_query($conn, $insert_project_recurrence_main_sql)or die('recurrence insert error');
                            }
                        }

                        //end project_recurrence table
                        //insert project_staff table
                        $get_project_staff_data = 'SELECT * from project_staff_main where project_id="' . $project_id . '"';
                        $get_project_staff_result = mysqli_query($conn, $get_project_staff_data);
                        if (mysqli_num_rows($get_project_staff_result) > 0) {
                            while ($row4 = mysqli_fetch_array($get_project_staff_result)) {
                                $insert_project_staff_data = array(
                                    'template_id' => "'" . $row4['template_id'] . "'",
                                    'project_id' => "'" . $project_id_new . "'",
                                    'staff_id' => "'" . $row4['staff_id'] . "'",
                                    'type' => "'" . $row4['type'] . "'"
                                );
                                $columns5 = implode(", ", array_keys($insert_project_staff_data));
                                $escaped_values5 = array_values($insert_project_staff_data);
                                $values5 = implode(", ", $escaped_values5);
                                $insert_project_staff_sql = "INSERT INTO `project_staff_main`($columns5) VALUES ($values5)";
                                mysqli_query($conn, $insert_project_staff_sql)or die('project staff insert error');
                            }
                        }

                        //end project_staff table
                        //insert project_task table
                        $get_project_task_data = 'SELECT * from project_task where project_id="' . $project_id . '"';
                        $get_project_task_result = mysqli_query($conn, $get_project_task_data);
                        if (mysqli_num_rows($get_project_task_result) > 0) {
                            while ($row5 = mysqli_fetch_array($get_project_task_result)) {
                                if($row5['office_id']==''){
                                    $task_office_id='null';
                                }else{
                                    $task_office_id=$row5['office_id'];
                                }
                                if($row5['responsible_task_staff']==''){
                                    $responsible_task_staff='NULL';
                                }else{
                                    $responsible_task_staff=$row5['responsible_task_staff'];
                                }
                                if($row5['is_all']==''){
                                    $is_all_task_staff='NULL';
                                }else{
                                    $is_all_task_staff=$row5['is_all'];
                                }
                                $insert_project_task_data = array(
                                    'template_main_id' => "'" . $row5['template_main_id'] . "'",
                                    'project_id' => "'" . $project_id_new . "'",
                                    'added_by_user' => "'" . $row5['added_by_user'] . "'",
                                    'task_order' => "'" . $row5['task_order'] . "'",
                                    'task_title'=>"'".$row5['task_title']."'",
                                    'description' => "'" . $row5['description'] . "'",
                                    'target_start_date' => "'" . $row5['target_start_date'] . "'",
                                    'target_start_day' => "'" . $row5['target_start_day'] . "'",
                                    'target_complete_date' => "'" . $row5['target_complete_date'] . "'",
                                    'target_complete_day' => "'" . $row5['target_complete_day'] . "'",
                                    'tracking_description' => 0,
                                    'is_all' => $is_all_task_staff,
                                    'department_id' => "'" . $row5['department_id'] . "'",
                                    'office_id' => $task_office_id,
                                    'responsible_task_staff' => $responsible_task_staff,
                                    'date_started' => 'NULL',
                                    'date_completed' => 'NULL',
                                    'is_input_form'=>"'".$row5['is_input_form']."'",
                                    'input_form_type'=>"'".$row5['input_form_type']."'",
                                    'bookkeeping_input_type'=>"'".$row5['bookkeeping_input_type']."'"
                                );
                                $columns6 = implode(", ", array_keys($insert_project_task_data));
                                $escaped_values6 = array_values($insert_project_task_data);
                                $values6 = implode(", ", $escaped_values6);
                                $insert_project_task_sql = "INSERT INTO `project_task`($columns6) VALUES ($values6)";
                                // echo '<pre>';
//                                 echo $insert_project_task_sql; die;
                                mysqli_query($conn, $insert_project_task_sql)or die('project task insert error');
                                $project_task_id_new = mysqli_insert_id($conn);

                                //insert project_task_staff table
                                $get_project_task_staff_data = 'SELECT * from project_task_staff where task_id="' . $row5['id'] . '"';
                                $get_project_task_staff_result = mysqli_query($conn, $get_project_task_staff_data);
                                if (mysqli_num_rows($get_project_task_staff_result) > 0) {
                                    while ($row6 = mysqli_fetch_array($get_project_task_staff_result)) {
                                        $insert_project_task_staff_data = array(
                                            'task_id' => "'" . $project_task_id_new . "'",
                                            'staff_id' => "'" . $row6['staff_id'] . "'"
                                        );
                                        $columns7 = implode(", ", array_keys($insert_project_task_staff_data));
                                        $escaped_values7 = array_values($insert_project_task_staff_data);
                                        $values7 = implode(", ", $escaped_values7);
                                        $insert_project_task_staff_sql = "INSERT INTO `project_task_staff`($columns7) VALUES ($values7)";
                                        mysqli_query($conn, $insert_project_task_staff_sql)or die('project task_staff insert error');
                                    }
                                }

                                //end project_task_staff table 
                            }
                        }

                        //end project_task table 
                    }
                }
            }// current day condition is off for past recurrence date
        }
    }
}
if(!empty($project_id_array)){
    echo count($project_id_array).' projects created successfully';
}else{
    echo 'No project created';
}
?>