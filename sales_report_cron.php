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
        'ord.id as order_id',
        'ord.order_date as order_date',
        'indt.practice_id as client_id',
        'indt.office as office_id',
        'srv.responsible_staff as created_by',
        '(SELECT CONCAT(",",GROUP_CONCAT(`services_id`), ",") FROM `service_request` WHERE `order_id` = ord.id) AS all_services',
        '(SELECT CONCAT(",",GROUP_CONCAT(`price_charged`), ",") FROM `service_request` WHERE `order_id` = ord.id) AS all_override_price',
        '(SELECT CONCAT(",",GROUP_CONCAT(`status`), ",") FROM `service_request` WHERE `order_id` = ord.id) AS all_services_status',
        '(SELECT CONCAT(",",GROUP_CONCAT(`pay_amount`),",") FROM `payment_history` WHERE `order_id` = ord.id AND `type` = "payment" AND `is_cancel`="0") AS all_collection',
        '(SELECT COUNT(*) FROM `service_request` WHERE order_id = ord.id ) as services_count',
        '(SELECT id FROM `invoice_info` WHERE order_id = ord.id ) as invoice_id'
    ];

    $table = '`order` AS `ord` ' .
            'INNER JOIN `service_request` AS `srv` ON `srv`.`order_id` = `ord`.`id` ' .
            'INNER JOIN `internal_data` AS `indt` ON `indt`.`reference_id` = `ord`.`reference_id`';     
    $query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . ' GROUP BY `ord`.`id`';
    mysqli_query($conn, 'SET SQL_BIG_SELECTS=1');
    $reports_data = mysqli_query($conn,$query);
    $sales_reports_data = mysqli_fetch_assoc($reports_data);
    mysqli_query($conn,'TRUNCATE weekly_sales_report');
    if (!empty($sales_reports_data)) {
        while($srd = mysqli_fetch_assoc($reports_data)) {
            for ($i=1; $i <= $srd['services_count'] ; $i++) { 
                $services_id = explode(',',$srd['all_services'])[$i];
                /* get service detail */
                $service_query = mysqli_query($conn,"select fixed_cost as cost ,retail_price, description as service_name from services where id ='".$services_id."'");
                $service_detail = mysqli_fetch_assoc($service_query);
                /* get notes */
                $note_sql = "select CONCAT(',',GROUP_CONCAT(`note`),',') as all_notes from notes where reference = 'service' and reference_id ='".$services_id."'";
                $notes_query = mysqli_query($conn,$note_sql);
                $notes = mysqli_fetch_assoc($notes_query);
                /* finalize variables */
                if (date('Y-m-d', strtotime($srd['order_date'])) == '1970-01-01') {
                    $date = 'N/A';
                } else {
                    $date = date('Y-m-d', strtotime($srd['order_date']));
                }
                $client_id = $srd['client_id'];
                if ($srd['invoice_id'] != '') {
                    $service_id = $srd['invoice_id']."-".$i;
                } else {
                    $service_id = 'N/A';    
                }
                
                $service_name = $service_detail['service_name'];
                $retail_price = $service_detail['retail_price'];
                $override_price = explode(',',$srd['all_override_price'])[$i];
                $cost = $service_detail['cost'];
                $payment_collection = explode(',',$srd['all_collection']);
                
                if (count($payment_collection) > 1 && !empty($payment_collection)) {
                    $collected = explode(',',$srd['all_collection'])[$i];
                } else {
                    $collected = 0;
                }
                $total_net = (int)$override_price - (int)$cost;
                $franchisee_fee = ((int)$override_price * 20) / 100;
                $gross_profit = (int)$total_net - (int)$franchisee_fee;
                
                if ($notes['all_notes'] != '') {
                    $notes = ltrim($notes['all_notes'],',');
                } else{
                    $notes = 'N/A';
                }
                $office_id = $srd['office_id'];
                $created_by = $srd['created_by'];
                
                $status = explode(',',$srd['all_services_status'])[$i];
                if ($status == 0) {
                    $status = 'Completed';
                } elseif ($status == 1) {
                    $status = 'Started';
                } elseif ($status == 2) {
                    $status = 'Not Started';
                } elseif($status == 3) {
                    $status = 'Late';
                }
                $sql_query = "INSERT INTO `weekly_sales_report`(`date`, `client_id`, `service_id`, `service_name`, `status`, `retail_price`, `override_price`, `cost`, `collected`, `total_net`, `franchisee_fee`, `gross_profit`, `notes`,`office_id`,`created_by`) VALUES (
                    '" . $date . "','" . $client_id . "','".$service_id."','".$service_name."','".$status."','".$retail_price."','".$override_price."','".$cost."','".$collected."','".$total_net."','".$franchisee_fee."','".$gross_profit."','".$notes."','".$office_id."','".$created_by."')";
                mysqli_query($conn,$sql_query);
            }
        }
    }
    echo "successfully inserted";
?>