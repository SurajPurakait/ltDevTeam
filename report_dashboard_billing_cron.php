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
        'inv.id as invoice_id',
        'inv.created_by AS created_by',
        'inv.created_time AS created_date',
        'inv.payment_status AS payment_status',
        'inv.total_amount AS total_amount',
        'indt.office AS office_id',
        '(SELECT ofc.name FROM office as ofc WHERE ofc.id = indt.office) as office',
        '(SELECT SUM(pay_amount) FROM payment_history WHERE payment_history.type = \'payment\' AND payment_history.invoice_id = inv.id AND payment_history.is_cancel = 0) AS pay_amount'
    ];
    $where['status'] = '`inv`.`status` NOT IN(0,7)';

    $table = '`invoice_info` AS `inv` ' .
        'INNER JOIN `internal_data` AS `indt` ON (CASE WHEN `inv`.`type` = 1 THEN `indt`.`reference_id` = `inv`.`client_id` AND `indt`.`reference` = "company" ELSE `indt`.`reference_id` = `inv`.`client_id` AND `indt`.`reference` = "individual" END)'.'LEFT JOIN `payment_history` AS `pyh` ON `pyh`.`invoice_id` = `inv`.`id`';

    $query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . 'WHERE ' . implode('', $where) . ' GROUP BY `inv`.`id`';
    mysqli_query($conn, 'SET SQL_BIG_SELECTS=1');
    $billing_reports_data = mysqli_query($conn,$query);
    mysqli_query($conn,'TRUNCATE report_dashboard_billing');
    while ($brd = mysqli_fetch_assoc($billing_reports_data)) {
    	$invoice_id = $brd['invoice_id'] ;
    	$payment_status = $brd['payment_status'] ;
        if ($brd['payment_status'] == 1) {
            $payment_status = 'Unpaid';
        } elseif ($brd['payment_status'] == 2) {
            $payment_status = 'Partial';
        } elseif ($brd['payment_status'] == 3) {
            $payment_status = 'Paid';
        } else {
            $payment_status = 'Late';
        } 
    	$amount_collected = $brd['pay_amount'] ;
    	$total_amount = $brd['total_amount'] ;
    	$office_id = $brd['office_id'] ;
    	$office_name = $brd['office'] ;
        if (date('Y-m-d', strtotime($brd['created_date'])) == '1970-01-01') {
            $created_date = 'N/A';
        } else {
            $created_date = date('Y-m-d', strtotime($brd['created_date']));
        }

    	$insert_sql = "INSERT INTO `report_dashboard_billing`(`invoice_id`, `payment_status`, `amount_collected`, `total_amount`, `office_id`, `office_name`, `created_date`) VALUES ('$invoice_id', '$payment_status', '$amount_collected', '$total_amount', '$office_id', '$office_name','$created_date')";
        echo $insert_sql;echo "<hr>";
    	mysqli_query($conn,$insert_sql)or die('insert error');
    }
    echo "Successfully Inserted";
?>