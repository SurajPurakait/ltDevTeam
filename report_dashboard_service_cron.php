<?php
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
        'ord.id AS id',  
        'ord.status AS status',  
        'services.dept AS department_id',  
        'ord.order_date AS order_date', 
        'ord.late_status AS late_status', 
        'ord.start_date AS start_date', 
        'ord.complete_date AS complete_date', 
        'ord.target_start_date AS target_start_date', 
        'ord.target_complete_date AS target_complete_date',  
        'services.category_id AS category_id', 
        'services.id AS service_id', 
        'indt.office AS office_id',
        '(SELECT ofc.office_id FROM office as ofc WHERE ofc.id = indt.office) as office, services.description AS service_name',
        '(SELECT CONCAT(",",GROUP_CONCAT(`msg`), ",") FROM `sos_notification` WHERE reference_id = ord.id and reference = "order") as sos'


    ];
    
    $where['ord.reference'] = '`ord`.`reference` != \'invoice\' ';
    $where['ord.status'] = 'AND `ord`.`status` NOT IN ("7","10") ';

    $table = '`order` AS ord INNER JOIN company ON ord.reference_id = company.id INNER JOIN internal_data indt ON indt.reference_id = `ord`.`reference_id` AND indt.reference = `ord`.`reference` INNER JOIN services ON services.id = ord.service_id LEFT OUTER JOIN service_request AS srv_rq ON srv_rq.order_id = ord.id INNER JOIN staff st ON st.id = ord.staff_requested_service'; 
    $query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . ' WHERE ' . implode('', $where)  . 'GROUP BY ord.id ORDER BY ord.id DESC';
    // echo $query;exit;
    mysqli_query($conn,'TRUNCATE report_dashboard_service');
    mysqli_query($conn, 'SET SQL_BIG_SELECTS=1');
    $report_service_query = mysqli_query($conn,$query);
    $report_service_result = mysqli_fetch_assoc($report_service_query);
    

    if (!empty($report_service_result)) {
        while($rsd = mysqli_fetch_assoc($report_service_query)) {
            $service_name = $rsd['service_name'];
            $order_date = $rsd['order_date'];
            $start_date = $rsd['start_date'];
            $target_start_date = $rsd['target_start_date'];
            $complete_date = $rsd['complete_date'];
            $target_complete_date = $rsd['target_complete_date'];
            $status = $rsd['status'];
            $late_status = $rsd['late_status'];
            $sos = $rsd['sos'];
            $category = $rsd['category_id'];
            $department = $rsd['department_id'];
            $office = $rsd['office_id'];

            $insert_sql = "INSERT INTO `report_dashboard_service`(`service_name`, `order_date`, `start_date`, `target_start_date`, `complete_date`, `target_complete_date`, `status`, `late_status`, `sos`, `category`, `department`, `office`) VALUES ('$service_name', '$order_date', '$start_date', '$target_start_date', '$complete_date', '$target_complete_date', '$status', '$late_status', '$sos', '$category', '$department', '$office')";
            // echo $insert_sql;exit;
            mysqli_query($conn,$insert_sql);
        }
    }
    echo "successfully inserted";
?>