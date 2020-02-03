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
        'ord.id AS id',  
        'ord.status AS status',  
        'services.id AS services_id',  
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
        'srv_rq.id AS service_request_id',
        '(SELECT ofc.office_id FROM office as ofc WHERE ofc.id = indt.office) as office, services.description AS service_name',
        '(SELECT CONCAT(",",GROUP_CONCAT(`msg`), ",") FROM `sos_notification` WHERE reference_id = ord.id and reference = "order") as sos'
    ];
    
    $where['ord.reference'] = '`ord`.`reference` != \'invoice\' ';
    $where['ord.status'] = 'AND `ord`.`status` NOT IN ("7","10") ';

    $table = '`order` AS `ord` INNER JOIN `service_request` AS `srv` ON `srv`.order_id = `ord`.id WHERE `ord`.reference = "invoice"'; 
    $query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . ' WHERE ' . implode('', $where)  . 'GROUP BY ord.id ORDER BY ord.id DESC';
    // echo $query;exit;
    mysqli_query($conn,'TRUNCATE report_dashboard_service');
    mysqli_query($conn, 'SET SQL_BIG_SELECTS=1');
    $report_service_query = mysqli_query($conn,$query);
    $report_service_count = mysqli_num_rows($report_service_query);
    // $report_service_result = mysqli_fetch_assoc($report_service_query);
    
    if ($report_service_count > 0) {
        while($rsd = mysqli_fetch_assoc($report_service_query)) {
            $service_request_id = $rsd['service_request_id'];
            
            // date completed calculation 
            $sql_q_d_c = 'SELECT `created_time` FROM `tracking_logs` WHERE status_value ="1" AND section_id = "'.$service_request_id.'"';
            $sql_q_d_c_run = mysqli_query($conn,$sql_q_d_c);
            $sql_q_d_c_result = mysqli_fetch_assoc($sql_q_d_c_run);
            
            $get_service_end_days_query = "select * from target_days where service_id='" . $rsd['services_id'] . "'";
            $get_service_end_days_query_run = mysqli_query($conn,$get_service_end_days_query);
            $get_service_end_days = mysqli_fetch_assoc($get_service_end_days_query_run);
            $end_days = $get_service_end_days['end_days'];

            if (!empty($sql_q_d_c_result)) {
                $date_completed_b_c = $sql_q_d_c_result['created_time'];
                $date_completed = date('Y-m-d', strtotime($date_completed_b_c. '+' .$end_days));
            } else {
                $date_completed = "0001-01-01";
                $date_completed = addslashes($date_completed);
            }
            // actual date completed calculation 
            $sql_q_d_c_a = 'SELECT date_format(`created_time`,"%Y-%m-%d") as created_time FROM `tracking_logs` WHERE status_value ="0" AND section_id = "'.$service_request_id.'"';
            $sql_q_d_c_a_run = mysqli_query($conn,$sql_q_d_c_a);
            $sql_q_d_c_a_result = mysqli_fetch_assoc($sql_q_d_c_a_run);
            if (!empty($sql_q_d_c_a_result)) {
                $date_complete_actual = date('Y-m-d', strtotime($sql_q_d_c_a_result['created_time']));
            } else {
                $date_complete_actual = date('Y-m-d');
            }
            $service_name = addslashes($rsd['service_name']);
            $status = $rsd['status'];
            $late_status = $rsd['late_status'];
            $sos = addslashes($rsd['sos']);
            $category = $rsd['category_id'];
            // $department = 0;
            if($rsd['department_id'] != NULL) {
                $department = $rsd['department_id'];    
            } else {
                $department = 0;
            }
            
            $office = $rsd['office_id'];
            
            if(!empty($rsd['order_date'])) {
                if(date('Y-m-d', strtotime($rsd['order_date'])) == '0000-00-00' || str_split(date('Y-m-d', strtotime($rsd['order_date'])))[0] == '-') {
                    $order_date = '0001-01-01';
                } else {
                    $order_date = date('Y-m-d', strtotime($rsd['order_date']));    
                }
            } else {
                $order_date = '0001-01-01';
            }
            

            $insert_sql = "INSERT INTO `report_dashboard_service`(`service_name`, `status`,`order_date` ,`date_completed`, `date_complete_actual`, `late_status`, `sos`, `category`, `department`, `office`)
            VALUES ('$service_name','$status','$order_date','$date_completed', '$date_complete_actual', '$late_status', '$sos', '$category', '$department', '$office')";
            // echo $insert_sql;
            // echo "<hr>";
            mysqli_query($conn,$insert_sql)or die('Insert Error');
        }
    }
    echo "1";
?>