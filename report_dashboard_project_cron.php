<?php

    $servername = "localhost";
    $username = "leafnet_db_user";
    $password = "leafnet@123";
    $db = 'leafnet_stagings';

    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $db = 'leafnet';

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $db);

    // Check connection
    if($conn === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $select = [
        'prt.id as task_id',
        'prt.project_id as project_id',
        'prt.tracking_description as task_status',
        'prm.status as project_status',
        'pro.office_id as task_office',
        'pro.office_id as project_office',
        'prt.department_id as task_department',
        'prm.department_id as project_department',
        'pro.created_at as project_creation_date',
        'snf.msg AS sos',
        '(SELECT prom.due_date FROM project_recurrence_main as prom WHERE prom.project_id = pro.id) as project_due_date'
    ];

    $table = ' `project_task` as prt INNER JOIN projects as pro ON prt.project_id = pro.id INNER JOIN project_main as prm ON pro.id = prm.project_id LEFT JOIN sos_notification AS snf ON pro.id = snf.reference_id and `snf`.reference="projects"';

    $project_get_query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . ' GROUP BY prt.id ORDER BY prt.id ASC';
    
    mysqli_query($conn, 'SET SQL_BIG_SELECTS=1');
    $project_query_response = mysqli_query($conn,$project_get_query);
    $project_data_count = mysqli_num_rows($project_query_response);

    if ($project_data_count > 0) {
        while ($prod = mysqli_fetch_assoc($project_query_response)) {
            $task_id = ($prod['task_id'] != 0) ? $prod['task_id']:'0';
            $project_id = ($prod['project_id'] != 0) ? $prod['project_id']:'0';
            $task_status = $prod['task_status'];
            $project_status = $prod['project_status'];
            $task_office = ($prod['task_office'] != 0) ? $prod['task_office']:'0';
            $project_office = ($prod['project_office'] != 0) ? $prod['project_office'] : '0';
            $task_department = ($prod['task_department'] != 0) ? $prod['task_department'] : '0';
            $project_department = ($prod['project_department'] != 0) ? $prod['project_department'] : '0';
            
            if($prod['project_due_date'] == '0000-00-00' || $prod['project_due_date'] == '') {
                $project_due_date = '0001-01-01';
            } else {
                $project_due_date = $prod['project_due_date'];
            }
   
            if (!empty($prod['project_creation_date'])) {
                $project_creation_date = date('Y-m-d',strtotime($prod['project_creation_date']));
            } else {
                $project_creation_date = '0001-01-01';
            }    
            $sos = $prod['sos'];
            
            $comparison_array = array(
                'task_id' => $task_id, 
                'project_id' => $project_id, 
                'task_status' => $task_status, 
                'project_status' => $project_status, 
                'task_office' => $task_office, 
                'project_office' => $project_office, 
                'task_department' => $task_department, 
                'project_department' => $project_department, 
                'project_creation_date' => $project_creation_date,
                'project_due_date' => $project_due_date,
                'sos' => $sos
            );

            // fetching data from report_dashboard_billing table
            $project_sql = "SELECT * FROM `report_dashboard_project` WHERE task_id = '".$task_id."'";
            $project_query_run = mysqli_query($conn,$project_sql);
            $pqr = mysqli_fetch_assoc($project_query_run);

            if($task_id == $pqr['task_id']) {
                unset($pqr['id']);
                if (empty(array_diff($comparison_array,$pqr))) {
                    echo "No difference with previuos values";
                    echo "<hr>";
                } else {
                    $update_sql = "UPDATE `report_dashboard_project` SET ";
                    if ($task_status != $pqr['task_status']) {
                        $update_sql .= "`task_status`='$task_status',";
                    }
                    if ($project_status != $pqr['project_status']) {
                        $update_sql .= "`project_status`='$project_status',";
                    }
                    if ($task_office != $pqr['task_office']) {
                        $update_sql .= "`task_office`='$task_office',";
                    }
                    if ($project_office != $pqr['project_office']) {
                        $update_sql .= "`project_office`='$project_office',";
                    }
                    if ($task_department != $pqr['task_department']) {
                        $update_sql .= "`task_department`='$task_department',";
                    }
                    if ($project_department != $pqr['project_department']) {
                        $update_sql .= "`project_department`='$project_department',";
                    }
                    if ($project_creation_date != $pqr['project_creation_date']) {
                        $update_sql .= "`project_creation_date`='$project_creation_date',";
                    }
                    if ($project_due_date != $pqr['project_due_date']) {
                        $update_sql .= "`project_due_date`='$project_due_date',";
                    }
                    if ($sos != $pqr['sos']) {
                        $update_sql .= "`sos`='$sos',";
                    }
                    if (substr($update_sql, -1) == ',') {
                        $update_sql = substr($update_sql,0,-1);
                    }

                    $update_sql .= " WHERE task_id = '".$task_id."'";
                    mysqli_query($conn,$update_sql);
                    echo $update_sql;
                    echo "<hr>";
                }
            } else {
                $insert_sql = "INSERT INTO `report_dashboard_project`(`task_id`, `project_id`, `task_status`, `project_status`, `task_office`, `project_office`, `task_department`, `project_department`, `project_creation_date`,`project_due_date`,`sos`) VALUES ('$task_id', '$project_id', '$task_status', '$project_status', '$task_office', '$project_office', '$task_department', '$project_department', '$project_creation_date','$project_due_date','$sos')";

                echo $insert_sql;
                echo "<hr>";
                mysqli_query($conn,$insert_sql)or die('Insert Error!!!');    
            }
        }
        echo "success";    
    }    






?>