<?php

include 'database.php';

$invoice_info = mysqli_query($conn, "SELECT *  FROM `invoice_info` WHERE `payment_status` IN (1, 2) and `status` NOT IN (0, 7)");
while ($row = mysqli_fetch_object($invoice_info)) {
    if (strtotime('+30 days', strtotime(date('Y-m-d', strtotime($row->created_time)))) < strtotime(date('Y-m-d'))) {
        echo $row->id . 'Late<br>';
    }
}