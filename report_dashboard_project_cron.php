<?php

    // $servername = "localhost";
    // $username = "leafnet_db_user";
    // $password = "leafnet@123";
    // $db = 'leafnet_stagings';

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = 'leafnet';

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
        'pro.created_at as project_creation_date'
    ];

    $table = ' `project_task` as prt INNER JOIN projects as pro ON prt.project_id = pro.id INNER JOIN project_main as prm ON pro.id = prm.project_id ';

    $project_get_query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . ' GROUP BY prt.id ORDER BY prt.id ASC';

    mysqli_query($conn,'TRUNCATE `report_dashboard_project`');
    mysqli_query($conn, 'SET SQL_BIG_SELECTS=1');
    $project_query_response = mysqli_query($conn,$project_get_query);
    $project_data_count = mysqli_num_rows($project_query_response);

    if ($project_data_count > 0) {
        while ($prod = mysqli_fetch_assoc($project_query_response)) {
            $task_id = $prod['task_id'];
            $project_id = $prod['project_id'];
            $task_status = $prod['task_status'];
            $project_status = $prod['project_status'];
            $task_office = $prod['task_office'];
            $project_office = $prod['project_office'];
            $task_department = $prod['task_department'];
            $project_department = $prod['project_department'];
            if (!empty($prod['project_creation_date'])) {
                $project_creation_date = date('Y-m-d',strtotime($prod['project_creation_date']));
            } else {
                $project_creation_date = '0001-01-01';
            }    
            
            $insert_sql = "INSERT INTO `report_dashboard_project`(`task_id`, `project_id`, `task_status`, `project_status`, `task_office`, `project_office`, `task_department`, `project_department`, `project_creation_date`) VALUES ('$task_id', '$project_id', '$task_status', '$project_status', '$task_office', '$project_office', '$task_department', '$project_department', '$project_creation_date')";

            echo $insert_sql;
            echo "<hr>";
            mysqli_query($conn,$insert_sql)or die('Insert Error!!!');

        }
        echo "success";    
    }    






?>