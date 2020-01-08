<?php
    $servername = "localhost";
    $username = "leafnet_db_user";
    $password = "leafnet@123";
    $db = 'leafnet_staging';

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
        'act.id AS action_id',  
        'act.created_office AS by_office',  
        'act.office AS to_office',  
        'act.created_department AS by_department',  
        'act.department AS to_department',  
        'act.status AS status',  
        'act.due_date AS due_date',  
        'snf.msg AS sos',
        '(SELECT ofc.name FROM office as ofc WHERE ofc.id = act.created_office) as by_office_name',
        '(SELECT ofc.name FROM office as ofc WHERE ofc.id = act.office) as to_office_name',
        '(SELECT dept.name FROM department as dept WHERE dept.id = act.created_department) as by_department_name',
        '(SELECT dept.name FROM department as dept WHERE dept.id = act.department) as to_department_name'
    ];

    $table = '`actions` AS act LEFT JOIN sos_notification AS snf ON act.id = snf.reference_id and `snf`.reference="action"';

    $action_get_query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . ' GROUP BY act.id ORDER BY act.id ASC';
    mysqli_query($conn,'TRUNCATE `report_dashboard_action`');
    mysqli_query($conn, 'SET SQL_BIG_SELECTS=1');
    $action_query_response = mysqli_query($conn,$action_get_query);
    $action_data_count = mysqli_num_rows($action_query_response);
     
    if ($action_data_count > 0) {
        while ($actd = mysqli_fetch_assoc($action_query_response)) {
        	$action_id = $actd['action_id'];
        	$by_office = $actd['by_office'];
        	$to_office = $actd['to_office'];
        	$by_department = $actd['by_department'];
        	$to_department = $actd['to_department'];
        	$by_office_name = $actd['by_office_name'];
        	$to_office_name = $actd['to_office_name'];
        	$by_department_name = $actd['by_department_name'];
        	$to_department_name = $actd['to_department_name'];
        	$status = $actd['status'];
        	$due_date = $actd['due_date'];
        	$sos = addslashes($actd['sos']);

        	$action_insert_sql = "INSERT INTO `report_dashboard_action`(`action_id`, `by_office`, `by_office_name`, `to_office`, `to_office_name`, `by_department`, `by_department_name`, `to_department`, `to_department_name`, `status`, `due_date`, `sos`) VALUES ('$action_id',' $by_office', '$by_office_name', '$to_office', '$to_office_name', '$by_department', '$by_department_name', '$to_department', '$to_department_name', '$status', '$due_date', '$sos')";
      
        	echo $action_insert_sql;
      		echo "<hr>";  	
        	mysqli_query($conn,$action_insert_sql)or die('Insert Error!');
        }
        echo "Success";
        exit;
    }    	
?>