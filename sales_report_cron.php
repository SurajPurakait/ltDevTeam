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
        'inv.id as invoice_id',
        'ord.id as order_id',
        'ord.order_date as order_date',
        'indt.practice_id as client_id',
        'indt.office as office_id',
        'srv.responsible_staff as created_by',
        '(SELECT CONCAT(",",GROUP_CONCAT(`service_id`), ",") FROM `order` WHERE `invoice_id` = inv.id AND `reference` = "invoice") AS all_services',
        '(SELECT CONCAT(",",GROUP_CONCAT(`total_of_order`), ",") FROM `order` WHERE `invoice_id` = inv.id AND `reference` = "invoice") AS all_override_price',
        '(SELECT COUNT(*) FROM `order` WHERE invoice_id = inv.id AND reference = \'invoice\') as services_count'
    ];
    
    $where['ord.reference'] = '`ord`.`reference` = \'invoice\' ';
    $where['inv.status'] = 'AND `inv`.`status` != 0 ';

    $table = '`invoice_info` AS `inv` ' .
            'INNER JOIN `order` AS `ord` ON `ord`.`invoice_id` = `inv`.`id` ' .
            'INNER JOIN `internal_data` AS `indt` ON (CASE WHEN `inv`.`type` = 1 THEN `indt`.`reference_id` = `inv`.`client_id` AND `indt`.`reference` = "company" ELSE `indt`.`reference_id` = `inv`.`client_id` AND `indt`.`reference` = "individual" END)'.
            'INNER JOIN `service_request` AS `srv` ON `srv`.`order_id` = `inv`.`order_id`'; 
    $query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . 'WHERE ' . implode('', $where)  . ' GROUP BY `ord`.`invoice_id`';

    mysqli_query($conn, 'SET SQL_BIG_SELECTS=1');
    $reports_data = mysqli_query($conn,$query);
    $reports_data_count = mysqli_num_rows($reports_data);

    if ($reports_data_count > 0) {
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
                $client_id = addslashes($srd['client_id']);
                $service_id = $srd['invoice_id']."-".$i;
                
                $service_name = $service_detail['service_name'];
                $retail_price = $service_detail['retail_price'];
                $override_price = explode(',',$srd['all_override_price'])[$i];
                $cost = $service_detail['cost'];

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

                $comparison_array = array(
                    'date' => $date,
                    'client_id' => $client_id,
                    'service_id' => $service_id,
                    'service_name' => $service_name,
                    'status' => $status,
                    'retail_price' => $retail_price,
                    'override_price' => $override_price,
                    'cost' => $cost,
                    'collected' => $collected,
                    'total_net' => $total_net,
                    'franchisee_fee' => $franchisee_fee,
                    'gross_profit' => $gross_profit,
                    'notes' => $notes,
                    'office_id' => $office_id,
                    'created_by' => $created_by
                );

                // fetching data from weekly sales report table
                $weekly_sales_sql = "SELECT * FROM `weekly_sales_report` WHERE service_id = '".$service_id."'";
                $weekly_sales_query_run = mysqli_query($conn,$weekly_sales_sql);
                $wsr = mysqli_fetch_assoc($weekly_sales_query_run);

                if ($service_id == $wsr['service_id']) {
                    unset($wsr['id']);
                    if (empty(array_diff($comparison_array,$wsr))) {
                        echo "No Difference with previous values";
                        echo "<hr>";
                    } else {
                        $update_sql = "UPDATE `weekly_sales_report` SET ";
                        if ($date != $wsr['date']) {
                            $update_sql .= "`date`='$date',";
                        } 
                        if ($client_id != $wsr['client_id']) {
                            $update_sql .= "`client_id`='$client_id',";
                        }
                        if ($service_name != $wsr['service_name']) {
                            $update_sql .= "`service_name`='$service_name',";
                        }
                        if ($status != $wsr['status']) {
                            $update_sql .= "`status`= '$status',";
                        }
                        if ($retail_price != $wsr['retail_price']) {
                            $update_sql .= "`retail_price`='$retail_price',";
                        }
                        if ($override_price != $wsr['override_price']) {
                            $update_sql .= "`override_price` = '$override_price',";
                        }
                        if ($cost != $wsr['cost']) {
                            $update_sql .= "`cost`='$cost',"; 
                        }
                        if ($collected != $wsr['collected']) {
                            $update_sql .= "`collected`='$collected',"; 
                        }
                        if ($total_net != $wsr['total_net']) {
                            $total_net_modified = (int)$override_price - (int)$wsr['cost']; 
                            // this logic is done because service cost would not be change for already purchased service  
                            $update_sql .= "`total_net`='$total_net_modified',";
                        }

                        if ($franchisee_fee != $wsr['franchisee_fee']) {
                            $update_sql .= "`franchisee_fee`='$franchisee_fee',";
                        }
                        if ($gross_profit != $wsr['gross_profit']) {
                            $update_sql .= "`gross_profit`='$gross_profit',";
                        }
                        if ($notes != $wsr['notes']) {
                            $update_sql .= "`notes`='$notes',";
                        }
                        if($office_id != $wsr['office_id']) {
                            $update_sql .= "`office_id`='$office_id',";
                        }
                        if (substr($update_sql, -1) == ',') {
                            $update_sql = substr($update_sql,0,-1);
                        } 
                        $update_sql .= " WHERE service_id = '".$service_id."'";
                        mysqli_query($conn,$update_sql);
                        echo $update_sql;
                        echo "<hr>";
                    }
                } else {    
                    $sql_query = "INSERT INTO `weekly_sales_report`(`date`, `client_id`, `service_id`, `service_name`, `status`, `retail_price`, `override_price`, `cost`, `collected`, `total_net`, `franchisee_fee`, `gross_profit`, `notes`,`office_id`,`created_by`) VALUES (
                        '" . $date . "','" . $client_id . "','".$service_id."','".$service_name."','".$status."','".$retail_price."','".$override_price."','".$cost."','".$collected."','".$total_net."','".$franchisee_fee."','".$gross_profit."','".$notes."','".$office_id."','".$created_by."')";
                    echo $sql_query;
                    mysqli_query($conn,$sql_query)or die('insert error');
                    echo "<hr>";
                }
            }
        }
    }
    echo "Success";
?>