<?php

//count invoice
//count payment
//count referral partners

//order section

$conn = mysqli_connect('localhost', 'root', '', 'leafnet_test');
$truncate = mysqli_query($conn, 'TRUNCATE TABLE dashboard_count');
$sql = "SELECT o.staff_requested_service,o.id, o.tracking,
               company.name AS client_name,o.reference_id,o.reference,o.status,o.late_status,o.category_id,o.service_id,
               (SELECT ofc.name FROM office as ofc WHERE ofc.id = indt.office) as office,services.description AS service_name,
               CONCAT(',', (SELECT GROUP_CONCAT(department_staff.staff_id) FROM department_staff WHERE department_staff.department_id = services.dept OR department_staff.department_id IN (SELECT sr2.dept FROM services sr2 WHERE sr2.id IN (SELECT srq.services_id FROM `service_request` AS srq WHERE srq.`order_id` = o.id))), ',', COALESCE((SELECT GROUP_CONCAT(st1.id) FROM staff AS st1 WHERE st1.role = 2 AND st1.office_manager = indt.office AND st1.id IN(SELECT staff_id FROM office_staff WHERE office_staff.office_id = indt.office)),''), ',') AS all_staffs
	       FROM `order` AS o INNER JOIN company ON o.reference_id=company.id 
               INNER JOIN internal_data indt ON indt.reference_id = company.id
	       INNER JOIN services ON services.id=o.service_id
               INNER JOIN staff AS st ON st.id=o.staff_requested_service";
$where = $having = [];
$where[] = "o.reference = 'company'";


$where[] = "o.status NOT IN (10)";
$sql .= " WHERE " . implode(' AND ', $where);
//echo $sql; exit;
mysqli_query($conn,'SET SQL_BIG_SELECTS=1');
$data = mysqli_query($conn, $sql);
while ($res = mysqli_fetch_assoc($data)) {
    // echo '<pre>';	
    // print_r($res);
    $staff_requested_service = $res['staff_requested_service'];
    $category_id = $res['category_id'];
    $status = $res['status'];
    $all_staffs = $res['all_staffs'];
    $sub_sql = "select * from dashboard_count where type='order' and category='" . $category_id . "' and status='" . $status . "' and added_by_user='" . $staff_requested_service . "'";
    $sub_data = mysqli_query($conn, $sub_sql);
    $sub_rows = mysqli_num_rows($sub_data);
    if ($sub_rows == 0) {
        $insert_query = "insert into dashboard_count (`type`, `category`, `total`, `status`, `added_by_user`, `all_staffs`, `my_task`) VALUES ('order', '" . $category_id . "', '1', '" . $status . "', '" . $staff_requested_service . "', '" . $all_staffs . "', '0')";
        $insert = mysqli_query($conn, $insert_query);
    } else {
        while ($sub_res = mysqli_fetch_assoc($sub_data)) {
            $id = $sub_res['id'];
            $update_query = "update dashboard_count set total= total + 1 where id='" . $id . "'";
            $update = mysqli_query($conn, $update_query);
        }
    }
}

//action section


$sql_action = "select act.id,act.added_by_user,act.department,act.status,act.my_task,REPLACE(CONCAT(',',(SELECT GROUP_CONCAT(act_stf2.staff_id) FROM action_staffs AS act_stf2 WHERE act_stf2.action_id = act.id),','), ' ', '') AS all_action_staffs from actions AS act inner join action_assign_to_department_rel AS ass_dept on ass_dept.action_id = act.id inner join department AS dprt on dprt.id = act.department inner join staff AS st on st.id = act.added_by_user group by act.id";

mysqli_query($conn,'SET SQL_BIG_SELECTS=1');
$data_action = mysqli_query($conn, $sql_action);
while ($res_action = mysqli_fetch_assoc($data_action)) {
    // echo '<pre>';	
    // print_r($res_action); exit;
    $staff_requested_service = $res_action['added_by_user'];
    
    $status = $res_action['status'];
    $all_staffs = $res_action['all_action_staffs'];
    $my_task = $res_action['my_task'];
    $dept = $res_action['department'];
    $sub_sql_action = "select * from dashboard_count where type='action' and status='" . $status . "' and added_by_user='" . $staff_requested_service . "' and my_task='" . $my_task . "' and department_id='".$dept."'";
    $sub_data_action = mysqli_query($conn, $sub_sql_action);
    $sub_rows_action = mysqli_num_rows($sub_data_action);
    if ($sub_rows_action == 0) {
        $insert_query_action = "insert into dashboard_count (`type`, `category`, `total`, `status`, `added_by_user`, `all_staffs`, `my_task`,`department_id`) VALUES ('action', '0', '1', '" . $status . "', '" . $staff_requested_service . "', '" . $all_staffs . "', '" . $my_task . "', '" . $dept . "')";
        $insert_action = mysqli_query($conn, $insert_query_action);
    } else {
        while ($sub_res_action = mysqli_fetch_assoc($sub_data_action)) {
            $id_action = $sub_res_action['id'];
            $update_query_action = "update dashboard_count set total= total + 1 where id='" . $id_action . "'";
            $update_action = mysqli_query($conn, $update_query_action);
        }
    }
}


//invoice section

//office insert in all_staffs for this case

$sql_invoice = 'SELECT `inv`.id,`inv`.created_by,`inv`.status,`indt`.`office` FROM `invoice_info` `inv` JOIN `order` `ord` ON `ord`.`invoice_id` = `inv`.`id` JOIN `company` `co` ON `co`.`id` = `inv`.`reference_id` JOIN `internal_data` `indt` ON `indt`.`reference_id` = `inv`.`reference_id` WHERE `inv`.`type`=1 and `ord`.`reference` = "invoice" and `inv`.`status` not in(0,3) UNION SELECT `inv`.id,`inv`.created_by,`inv`.status,`indt`.`office` FROM `invoice_info` `inv` JOIN `order` as `ord` ON `ord`.`invoice_id` = `inv`.`id` JOIN `title` `t` ON `t`.`company_id` = `inv`.`reference_id` JOIN `individual` `ind` ON `ind`.`id` = `t`.`individual_id` JOIN `internal_data` `indt` ON `indt`.`reference_id` = `inv`.`reference_id` WHERE `inv`.`type`=2 and `ord`.`reference` = "invoice" and `t`.`status` = "1" and `inv`.`status` not in(0,3)';

mysqli_query($conn,'SET SQL_BIG_SELECTS=1');
$data_invoice = mysqli_query($conn, $sql_invoice);
while ($res_invoice = mysqli_fetch_assoc($data_invoice)) {
    // echo '<pre>';    
    // print_r($res_action); exit;
    $staff_requested_service = $res_invoice['created_by'];
    
    $status = $res_invoice['status'];
    $all_staffs = $res_invoice['office'];
    $my_task = '0';
     $sub_sql_invoice = "select * from dashboard_count where type='invoice' and status='" . $status . "' and added_by_user='" . $staff_requested_service . "'";
    $sub_data_invoice = mysqli_query($conn, $sub_sql_invoice);
    $sub_rows_invoice = mysqli_num_rows($sub_data_invoice);
    if ($sub_rows_invoice == 0) {
        $insert_query_invoice = "insert into dashboard_count (`type`, `category`, `total`, `status`, `added_by_user`, `all_staffs`, `my_task`) VALUES ('invoice', '0', '1', '" . $status . "', '" . $staff_requested_service . "', '" . $all_staffs . "', '" . $my_task . "')";
        $insert_invoice = mysqli_query($conn, $insert_query_invoice);
    } else {
        while ($sub_res_invoice = mysqli_fetch_assoc($sub_data_invoice)) {
            $id_invoice = $sub_res_invoice['id'];
            $update_query_invoice = "update dashboard_count set total= total + 1 where id='" . $id_invoice . "'";
            $update_invoice = mysqli_query($conn, $update_query_invoice);
        }
    }
}


//payment section

//office insert in all_staffs for this case

$sql_payment = 'SELECT `inv`.id,`inv`.created_by,`inv`.status,`inv`.payment_status,`indt`.`office` FROM `invoice_info` `inv` JOIN `order` `ord` ON `ord`.`invoice_id` = `inv`.`id` JOIN `company` `co` ON `co`.`id` = `inv`.`reference_id` JOIN `internal_data` `indt` ON `indt`.`reference_id` = `inv`.`reference_id` WHERE `inv`.`type`=1 and `ord`.`reference` = "invoice" and `inv`.`status` not in(0) UNION SELECT `inv`.id,`inv`.created_by,`inv`.status,`inv`.payment_status,`indt`.`office` FROM `invoice_info` `inv` JOIN `order` as `ord` ON `ord`.`invoice_id` = `inv`.`id` JOIN `title` `t` ON `t`.`company_id` = `inv`.`reference_id` JOIN `individual` `ind` ON `ind`.`id` = `t`.`individual_id` JOIN `internal_data` `indt` ON `indt`.`reference_id` = `inv`.`reference_id` WHERE `inv`.`type`=2 and `ord`.`reference` = "invoice" and `t`.`status` = "1" and `inv`.`status` not in(0)';

mysqli_query($conn,'SET SQL_BIG_SELECTS=1');
$data_payment = mysqli_query($conn, $sql_payment);
while ($res_payment = mysqli_fetch_assoc($data_payment)) {
    // echo '<pre>';    
    // print_r($res_action); exit;
    $invoice_id = $res_payment["id"];
    $staff_requested_service = $res_payment['created_by'];
    
    if($res_payment['payment_status']==1){
        $status = '4';
    }else{
       $sub_query = "select inv.id, ord.invoice_id,ord.reference,(CAST((SELECT sr.price_charged FROM service_request sr WHERE sr.order_id = ord.id AND sr.services_id = ord.service_id) AS Decimal(10,2)) * ord.quantity) as sub_total from invoice_info inv join `order` ord on ord.invoice_id = inv.id join services sr on sr.id = ord.service_id join category ct on ct.id = sr.category_id AND ct.id = ord.category_id where inv.id='".$invoice_id."' and ord.invoice_id='".$invoice_id."' and ord.reference='invoice'";
        
        mysqli_query($conn,'SET SQL_BIG_SELECTS=1');
        $sub_result = mysqli_query($conn, $sub_query);
        while ($sub_res = mysqli_fetch_assoc($sub_result)) { 

            $total_amount = number_format((float) array_sum(array_column($sub_res, 'sub_total')), 2, '.', '');
            $sub_q = "select SUM(pay_amount) AS pay_amount from payment_history where type='payment' and invoice_id='".$invoice_id."' and is_cancel='0'";
             mysqli_query($conn,'SET SQL_BIG_SELECTS=1');
            $q_result = mysqli_query($conn, $sub_q);
            while ($q_res = mysqli_fetch_assoc($q_result)) {
                $pay_amount = $q_res['pay_amount'];
                if ($pay_amount == 0) {
                   $status = '1';
                } else {
                    if ($total_amount > $pay_amount) {
                        $status = '2';
                    } else {
                        $status = '3';
                    }
                }
            }           
        }
    } //else payment status check
    
    $all_staffs = $res_payment['office'];
    $my_task = '0';
     $sub_sql_payment = "select * from dashboard_count where type='payment' and status='" . $status . "' and added_by_user='" . $staff_requested_service . "'";
    $sub_data_payment = mysqli_query($conn, $sub_sql_payment);
    $sub_rows_payment = mysqli_num_rows($sub_data_payment);
    if ($sub_rows_payment == 0) {
        $insert_query_payment = "insert into dashboard_count (`type`, `category`, `total`, `status`, `added_by_user`, `all_staffs`, `my_task`) VALUES ('payment', '0', '1', '" . $status . "', '" . $staff_requested_service . "', '" . $all_staffs . "', '" . $my_task . "')";
        $insert_payment = mysqli_query($conn, $insert_query_payment);
    } else {
        while ($sub_res_payment = mysqli_fetch_assoc($sub_data_payment)) {
            $id_payment = $sub_res_payment['id'];
            $update_query_payment = "update dashboard_count set total= total + 1 where id='" . $id_payment . "'";
            $update_payment = mysqli_query($conn, $update_query_payment);
        }
    }
}
?>