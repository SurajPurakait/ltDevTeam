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
        'invr.pattern AS pattern',
        'indt.office AS office_id',
        'indt.practice_id AS client_id',

        '(SELECT concat(stf.first_name, " ", stf.last_name) FROM staff as stf WHERE stf.id = indt.manager) as manager',
        '(SELECT ofc.name FROM office as ofc WHERE ofc.id = indt.office) as office',
        '(SELECT SUM(pay_amount) FROM payment_history WHERE payment_history.type = \'payment\' AND payment_history.invoice_id = inv.id AND payment_history.is_cancel = 0) AS pay_amount'
    ];
    // $where['status'] = '`inv`.`status` NOT IN(0,7)';
    $where['id'] = '`inv`.`id` = "3941"';

    $table = '`invoice_recurence` AS `invr` INNER JOIN `invoice_info` AS `inv` ON `inv`.`id` = `invr`.`invoice_id`' .
        'INNER JOIN `internal_data` AS `indt` ON (CASE WHEN `inv`.`type` = 1 THEN `indt`.`reference_id` = `inv`.`client_id` AND `indt`.`reference` = "company" ELSE `indt`.`reference_id` = `inv`.`client_id` AND `indt`.`reference` = "individual" END)'.' LEFT JOIN `payment_history` AS `pyh` ON `pyh`.`invoice_id` = `inv`.`id`';

    $query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . 'WHERE ' . implode('', $where);
    echo $query;exit;
?>    