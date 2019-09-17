<?php

$servername = "localhost";
$username = "root";
$password = "root";
$db = 'taxleaf';
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//echo "Connected successfully"; 

$sql = 'SELECT * from individual where status="1"';
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($ld = mysqli_fetch_array($result)) {
            $select = 'select id from individual where first_name="' . $ld['first_name'] . '" and last_name="' . $ld['last_name'] . '" and birth_date="' . $ld['birth_date'] . '" and id!="' . $ld['id'] . '"';
            $result_val = mysqli_query($conn, $select);
            if (mysqli_num_rows($result_val) > 0) {
                while ($ldval = mysqli_fetch_array($result_val)) {
                    $sql = 'delete from individual where id="' . $ldval['id'] . '"';
                    mysqli_query($conn, $sql);
                    $sql2 = 'delete from title where individual_id="' . $ldval['id'] . '"';
                    mysqli_query($conn, $sql2);
                }
            }
        }
    }
}