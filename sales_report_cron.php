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
        '(SELECT CONCAT(",",GROUP_CONCAT(`services_id`), ",") FROM `service_request` WHERE `order_id` = ord.id) AS all_services',

        // 'indt.office as office_id',
        // '(SELECT ofc.name FROM office as ofc WHERE ofc.id = indt.office) as office',
        // '(SELECT ofc.office_id FROM office as ofc WHERE ofc.id = indt.office) as officeid',
        // '(SELECT concat(st.last_name, ", ", st.first_name) FROM staff as st WHERE st.id = indt.partner) as partner',

        // '(SELECT CONCAT(",",GROUP_CONCAT(`service_id`), ",") FROM `order` WHERE `invoice_id` = inv.id AND `reference` = "invoice") AS all_services',
        
        // '(SELECT CONCAT(",",GROUP_CONCAT(`total_of_order`), ",") FROM `order` WHERE `invoice_id` = inv.id AND `reference` = "invoice") AS all_services_override',
        // '(SELECT CONCAT(",",GROUP_CONCAT(`payment_type`), ",") FROM `payment_history` WHERE `invoice_id` = ord.invoice_id AND `order_id` = ord.id) AS payment_types',
    ];

    $table = '`order` AS `ord` ' .
            'INNER JOIN `service_request` AS `srv` ON `srv`.`order_id` = `ord`.`id` ' .
            'INNER JOIN `internal_data` AS `indt` ON `indt`.`reference_id` = `ord`.`reference_id`';     
    $query = 'SELECT ' . implode(', ', $select) . ' FROM ' . $table . ' GROUP BY `ord`.`id`';
        
    mysqli_query($conn, 'SET SQL_BIG_SELECTS=1');
    $reports_data = mysqli_query($conn,$query);
    $sales_reports_data = mysqli_fetch_assoc($reports_data); 
 
}

?>