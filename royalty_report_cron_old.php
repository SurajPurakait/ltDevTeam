<?php
    $servername = "localhost";
    $username = "leafnet_db_user";
    $password = "leafnet@123";
    $db = 'leafnet_live';
    
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
        'inv.id as invoice_id',
        'inv.reference_id as reference_id',
        'inv.order_id as order_id',
        'inv.new_existing as new_existing',
        'inv.created_time as created_time',
        'srv.price_charged as override_price',
        'srv.services_id as service_id',
        // 'srv.id as service_request_id',
        'inv.existing_reference_id as existing_reference_id',
        'inv.type as invoice_type',
        'inv.is_order as is_order',
        'inv.created_by AS created_by',
        'inv.payment_status AS payment_status',
        'inv.total_amount AS sub_total',
        'inv.client_id as client_id',
        'indt.practice_id as practice_id',
        '(CASE WHEN inv.type = 1 THEN (SELECT `company`.`name` FROM `company` WHERE `company`.`id` = `inv`.`client_id`) ELSE (SELECT CONCAT(individual.last_name,", ",individual.first_name) FROM `individual` WHERE `individual`.`id` = `inv`.`client_id`) END) as client_name',
        'inv.start_month_year as start_month_year',
        'inv.existing_practice_id as existing_practice_ID',
        'inv.status as invoice_status',
        '(SELECT COUNT(*) FROM `order` WHERE invoice_id = inv.id AND reference = \'invoice\') as services',
        'indt.office as office_id',
        '(SELECT ofc.name FROM office as ofc WHERE ofc.id = indt.office) as office',
        '(SELECT ofc.office_id FROM office as ofc WHERE ofc.id = indt.office) as officeid',
        '(SELECT concat(st.last_name, ", ", st.first_name) FROM staff as st WHERE st.id = indt.partner) as partner',
        '(SELECT concat(st.last_name, ", ", st.first_name) FROM staff as st WHERE st.id = indt.manager) as manager',
        '(SELECT concat(st.last_name, ", ", st.first_name) FROM staff as st WHERE st.id = inv.created_by) as created_by_name',
        '(SELECT CONCAT(",",GROUP_CONCAT(`service_id`), ",") FROM `order` WHERE `invoice_id` = inv.id AND `reference` = "invoice") AS all_services',
        '(SELECT CONCAT(",",GROUP_CONCAT(`id`), ",") FROM `order` WHERE `invoice_id` = inv.id AND `reference` = "invoice") AS all_orders',
        '(SELECT CONCAT(",",GROUP_CONCAT(`total_of_order`), ",") FROM `order` WHERE `invoice_id` = inv.id AND `reference` = "invoice") AS all_services_override',
        '(SELECT CONCAT(",",GROUP_CONCAT(`payment_type`), ",") FROM `payment_history` WHERE `invoice_id` = ord.invoice_id AND `order_id` = ord.id) AS payment_types',
        '(SELECT SUM(pay_amount) FROM payment_history WHERE payment_history.type = \'payment\' AND payment_history.invoice_id = inv.id AND payment_history.is_cancel = 0) AS pay_amount',
    ];
    $where['ord.reference'] = '`ord`.`reference` = \'invoice\' ';
    $where['status'] = 'AND `inv`.`status` != 0 ';

    $table = '`invoice_info` AS `inv` ' .
        'INNER JOIN `order` AS `ord` ON `ord`.`invoice_id` = `inv`.`id` ' .
        'INNER JOIN `internal_data` AS `indt` ON (CASE WHEN `inv`.`type` = 1 THEN `indt`.`reference_id` = `inv`.`client_id` AND `indt`.`reference` = "company" ELSE `indt`.`reference_id` = `inv`.`client_id` AND `indt`.`reference` = "individual" END)'.
        'INNER JOIN `service_request` AS `srv` ON `srv`.`order_id` = `inv`.`order_id`'. 
        'LEFT JOIN `payment_history` AS `pyh` ON `pyh`.`invoice_id` = `inv`.`id`';

    $query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . 'WHERE ' . implode('', $where) . ' GROUP BY `ord`.`invoice_id`';
    // echo $query;exit; 
    mysqli_query($conn, 'SET SQL_BIG_SELECTS=1');
    $reports_data = mysqli_query($conn,$query); 
    $reports_data_count = mysqli_num_rows($reports_data);
    mysqli_query($conn,'TRUNCATE royalty_report');
    if ($reports_data_count > 0) {
        while ($rpd = mysqli_fetch_assoc($reports_data)) { 
            for($i=1; $i <= $rpd['services']; $i++) {
                $services_id = explode(',',$rpd['all_services'])[$i];
                $services_query = "select s.id, s.category_id, s.fixed_cost as cost, c.name as category_name, c.description as category_description, s.description, s.ideas, s.tutorials, s.dept AS service_department, s.retail_price from services s inner join category c on c.id = s.category_id where s.id ='".$services_id."'";
                $services_query_run = mysqli_query($conn,$services_query);
                $service_detail = mysqli_fetch_assoc($services_query_run);

                $sql_p = "select percentage from office_service_fees where service_id = '".$services_id."' and office_id = '".$rpd['office_id']."'";
                // echo $sql_p;
                $office_fees_qry = mysqli_query($conn,$sql_p);
                $office_fees_result=mysqli_fetch_assoc($office_fees_qry);
                $office_fees=$office_fees_result['percentage'];
                $order_id = explode(',',$rpd['all_orders'])[$i];
                $p_h_sql = "select pay.reference_no AS reference,pay.authorization_id,typ.name AS payment_type,pay.pay_amount AS collected from payment_history pay inner join payment_type typ on typ.id = pay.payment_type where type = 'payment' and is_cancel != '1' and invoice_id = '".$rpd['invoice_id']."' and order_id = '".$order_id."'";
                $pay_history = mysqli_query($conn,$p_h_sql);
                $payment_history = [];
                while ($payment = mysqli_fetch_assoc($pay_history)) {
                    array_push($payment_history,$payment);
                } 
                $reference = implode(',',array_column($payment_history,'reference'));
                $authorization_id_without_slash = implode(',',array_column($payment_history,'authorization_id'));
                $authorization_id = addslashes($authorization_id_without_slash);
                $payment_type = implode(',',array_column($payment_history,'payment_type'));
                $collected = array_sum(array_column($payment_history,'collected')); 
                $override_price = explode(',',$rpd['all_services_override'])[$i];
                $total_net = ($override_price != '') ? (int)$override_price - (int)$service_detail['cost'] : (int)$service_detail['retail_price'] - (int)$service_detail['cost'];
                $date_val = date('Y-m-d', strtotime($rpd['created_time']));
                $fee_with_cost = (((int)$total_net * (int)$office_fees)/100); 
                $fee_without_cost = (((int)$override_price * (int)$office_fees)/100);
                if (($override_price - $collected) == 0) {
                    $payment_status = 'Paid';
                } elseif (($override_price - $collected) == $override_price) {
                    $payment_status = 'Unpaid';
                } elseif (($override_price - $collected) > 0 && ($override_price - $collected) < $override_price) {
                    $payment_status = 'Partial';
                } else {
                    $payment_status = 'Late';
                }
                $practice_id = $rpd['practice_id'];
                $invoice_id = $rpd['invoice_id'];
                $services_ids = $rpd['invoice_id'].'-'.$i;
                
                if (!empty($service_detail['description'])) {
                    $service_details = $service_detail['description'];
                } else {
                    $service_details = "N/A";
                }
                $retail_price = $service_detail['retail_price'];
                $service_cost = $service_detail['cost'];
                $office_id = $rpd['office_id'];
                $office_id_name = $rpd['officeid'];
                $created_by = $rpd['created_by'];
                // $service_request_id = $rpd['service_request_id'];

                $sql_query = "INSERT INTO `royalty_report`(`date`, `client_id`, `invoice_id`, `service_id`, `service_name`, `retail_price`, `override_price`, `cost`, `payment_status`, `collected`, `payment_type`, `authorization_id`, `reference`, `total_net`, `office_fee`, `fee_with_cost`, `fee_without_cost`, `office_id`,`office_id_name` ,`created_by`) VALUES (
                '$date_val', '$practice_id','$invoice_id',
                '$services_ids','$service_details','$retail_price',
                '$override_price','$service_cost','$payment_status',
                '$collected','$payment_type','$authorization_id',
                '$reference','$total_net','$office_fees',
                '$fee_with_cost','$fee_without_cost','$office_id','$office_id_name',
                '$created_by')";
                mysqli_query($conn,$sql_query)or die('insert error');
            }
            echo $sql_query;
            echo "<hr>";
        } 
    echo "Success";exit;
    } 

?>
