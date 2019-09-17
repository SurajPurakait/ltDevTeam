<?php

//echo "hi";die;
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
$sql = "SELECT * FROM actions";
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($action = mysqli_fetch_array($result)) {
            if ($action['status'] != 2) {
                $cur_date = date("Y-m-d");
                if ($action['due_date'] != '0000-00-00') {
                    if (strtotime($cur_date) > strtotime($action['due_date'])) {
                        $department_id = $action['department'];
                        $notification_text = 'ACTION(#' . $action['id'] . ')';
                        $reference_id = $action['id'];
                        $reference = 'action';
                        $actions = 'reaches';
                        $assign_user = 0;
                        $added_by = 4;
                        $tracking_stat = '';
                        $added_user_id=$action['added_by_user'];
                        $sql3 = "INSERT INTO general_notifications (notification_text,reference,reference_id,action,tracking_status,user_id,added_by,assign_to_user,read_status)"
                                        . " VALUES('$notification_text','$reference','$reference_id','$actions','$tracking_stat','$added_user_id','$added_by','$assign_user','n')";
                                mysqli_query($conn, $sql3)or die("insert err");
                        $sql1 = "SELECT staff_id FROM department_staff WHERE department_id='$department_id'";
                        if ($result1 = mysqli_query($conn, $sql1)) {
                            while ($staff1 = mysqli_fetch_assoc($result1)) {
                                $staffs_id = $staff1['staff_id'];
                                $sql2 = "INSERT INTO general_notifications (notification_text,reference,reference_id,action,tracking_status,user_id,added_by,assign_to_user,read_status)"
                                        . " VALUES('$notification_text','$reference','$reference_id','$actions','$tracking_stat','$staffs_id','$added_by','$assign_user','n')";
                                mysqli_query($conn, $sql2)or die("insert err");
                            }
                        }
                    }
                }
            }
        }
    }
}
mysqli_close($conn);
?>