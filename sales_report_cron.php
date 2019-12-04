<?php
    // $servername = "localhost";
    // $username = "leafnet_db_user";
    // $password = "leafnet@123";
    // $db = 'leafnet_staging';

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
        'inv.id as invoice_id',
        'ord.id as order_id',
        'ord.order_date as order_date',
        'indt.practice_id as client_id',
        'indt.office as office_id',
        'srv.responsible_staff as created_by',
        '(SELECT CONCAT(",",GROUP_CONCAT(`service_id`), ",") FROM `order` WHERE `invoice_id` = inv.id AND `reference` = "invoice") AS all_services',
        '(SELECT CONCAT(",",GROUP_CONCAT(`total_of_order`), ",") FROM `order` WHERE `invoice_id` = inv.id AND `reference` = "invoice") AS all_override_price',        
        // '(SELECT CONCAT(",",GROUP_CONCAT(`pay_amount`),",") FROM `payment_history` WHERE `order_id` = ord.id AND `type` = "payment" AND `is_cancel`="0") AS all_collection',
        '(SELECT COUNT(*) FROM `order` WHERE invoice_id = inv.id AND reference = \'invoice\') as services_count'
    ];
    
    $where['ord.reference'] = '`ord`.`reference` = \'invoice\' ';
    $where['inv.status'] = 'AND `inv`.`status` != 0 ';

    $table = '`invoice_info` AS `inv` ' .
            'INNER JOIN `order` AS `ord` ON `ord`.`invoice_id` = `inv`.`id` ' .
            'INNER JOIN `internal_data` AS `indt` ON (CASE WHEN `inv`.`type` = 1 THEN `indt`.`reference_id` = `inv`.`client_id` AND `indt`.`reference` = "company" ELSE `indt`.`reference_id` = `inv`.`client_id` AND `indt`.`reference` = "individual" END)'.
            'INNER JOIN `service_request` AS `srv` ON `srv`.`order_id` = `inv`.`order_id`'; 
            // 'INNER JOIN `payment_history` AS `pyh` ON `pyh`.`invoice_id` = `inv`.`id`';
    $query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . 'WHERE ' . implode('', $where)  . ' GROUP BY `ord`.`invoice_id`';
    // echo $query;exit;
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
                $service_id = $srd['invoice_id']."-".$i;
                
                $service_name = $service_detail['service_name'];
                $retail_price = $service_detail['retail_price'];
                $override_price = explode(',',$srd['all_override_price'])[$i];
                $cost = $service_detail['cost'];
                // $payment_collection = explode(',',$srd['all_collection']);
                


                // if (count($payment_collection) > 1 && !empty($payment_collection)) {
                //     $collected = explode(',',$srd['all_collection'])[$i];
                // } else {
                //     $collected = 0;
                // }
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
                
                 
                $s_id = explode(',',$srd['all_services'])[$i];                
                $collect_query = 'select SUM(pay_amount) as pay_amount from `payment_history` where type = "payment" and is_cancel = "0" and order_id = "'.$srd['order_id'].'" and service_id = "'.$s_id.'"';
                $collected_val = mysqli_query($conn,$collect_query);
                $collected = mysqli_fetch_assoc($collected_val)['pay_amount'];
                $status_query = 'select status from service_request where order_id = "'.$srd['order_id'].'" and services_id = "'.$s_id.'"';
                $status_val = mysqli_query($conn,$status_query);
                $status = mysqli_fetch_assoc($status_val)['status'];
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
                mysqli_query($conn,$sql_query)or die('insert error');
            }
        }
    }
    echo "Success";
?>