<!-- INSERT INTO `report_client`(`id`, `type`, `client_id`, `type_of_company`, `status`, `country_residence`, `office_id`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7]) -->
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
        '`ind`.id',
        '`ind`.country_residence',
        '`ind`.status',
        '`int`.office',
        '`int`.reference',
        '`int`.practice_id',
        '`ofc`.id',
        '`ofc`.office_id',
    ];
    
    $where['`ind`.first_name'] = '`ind`.`first_name` != NULL ';
    $where['`ind`.last_name'] = 'AND `ind`.`last_name` != NULL ';
    $where['`ind`.status'] = 'AND `ind`.`status` NOT IN ("0","3") ';

    $table = '`individual` AS `ind` INNER JOIN `internal_data` AS `int` ON `int`.reference_id = `ind`.id and `int`.reference="individual" INNER JOIN `office` AS `ofc` ON `ofc`.id = `int`.office';
 
    $query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . ' WHERE ' . implode('', $where)  . 'GROUP BY ind.id';
    echo $query;exit;
    // mysqli_query($conn,'TRUNCATE report_dashboard_service');
    // mysqli_query($conn, 'SET SQL_BIG_SELECTS=1');
    // $report_service_query = mysqli_query($conn,$query);
    // $report_service_result = mysqli_fetch_assoc($report_service_query);
    

    // if (!empty($report_service_result)) {
    //     while($rsd = mysqli_fetch_assoc($report_service_query)) {
    //         $service_request_id = $rsd['service_request_id'];
            
    //         // date completed calculation 
    //         $sql_q_d_c = 'SELECT `created_time` FROM `tracking_logs` WHERE status_value ="1" AND section_id = "'.$service_request_id.'"';
    //         $sql_q_d_c_run = mysqli_query($conn,$sql_q_d_c);
    //         $sql_q_d_c_result = mysqli_fetch_assoc($sql_q_d_c_run);
            
                        
    //         $get_service_end_days_query = "select * from target_days where service_id='" . $rsd['services_id'] . "'";
    //         $get_service_end_days_query_run = mysqli_query($conn,$get_service_end_days_query);
    //         $get_service_end_days = mysqli_fetch_assoc($get_service_end_days_query_run);
    //         $end_days = $get_service_end_days['end_days'];

    //         if (!empty($sql_q_d_c_result)) {
    //             $date_completed_b_c = $sql_q_d_c_result['created_time'];
    //             $date_completed = '"'.date('Y-m-d', strtotime($date_completed_b_c. '+' .$end_days)).'"';
    //         } else {
    //             $date_completed = "NULL";
    //             $date_completed = addslashes($date_completed);
    //         }
    //         // actual date completed calculation 
    //         $sql_q_d_c_a = 'SELECT date_format(`created_time`,"%Y-%m-%d") as created_time FROM `tracking_logs` WHERE status_value ="0" AND section_id = "'.$service_request_id.'"';
    //         $sql_q_d_c_a_run = mysqli_query($conn,$sql_q_d_c_a);
    //         $sql_q_d_c_a_result = mysqli_fetch_assoc($sql_q_d_c_a_run);
    //         if (!empty($sql_q_d_c_a_result)) {
    //             $date_complete_actual = date('Y-m-d', strtotime($sql_q_d_c_a_result['created_time']));
    //         } else {
    //             $date_complete_actual = date('Y-m-d');
    //         }
    //         $service_name = addslashes($rsd['service_name']);
    //         $status = $rsd['status'];
    //         $late_status = $rsd['late_status'];
    //         $sos = addslashes($rsd['sos']);
    //         $category = $rsd['category_id'];
    //         $department = $rsd['department_id'];
    //         $office = $rsd['office_id'];
    //         $insert_sql = "INSERT INTO `report_dashboard_service`(`service_name`, `status`, `date_completed`, `date_complete_actual`, `late_status`, `sos`, `category`, `department`, `office`)
    //         VALUES ('$service_name','$status',$date_completed, '$date_complete_actual', '$late_status', '$sos', '$category', '$department', '$office')";
    //         mysqli_query($conn,$insert_sql)or die('Insert Error');
    //     }
    // }
    // echo "successfully inserted";
?>