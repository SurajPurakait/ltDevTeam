<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = 'taxleaf192';
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//echo "Connected successfully"; 

$sql = 'SELECT dsf.department_id,(select type from department where id=dsf.department_id) as department_type '
        . 'FROM actions a '
        . 'INNER JOIN action_staffs asf ON(a.id=asf.action_id) '
        . 'INNER JOIN department_staff dsf ON(asf.staff_id=dsf.staff_id) '
        . 'GROUP BY dsf.department_id';
$dept_staff_count_arr = array();
if ($result = mysqli_query($conn, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_array($result)) {
//            print_r($data);
            $sql2 = 'SELECT id FROM department_staff WHERE department_id=' . $data['department_id'];
            $dept_staff_count = mysqli_num_rows(mysqli_query($conn, $sql2));

            $dept_staff_count_arr[$data['department_id']][] = $dept_staff_count;
            $dept_staff_count_arr[$data['department_id']][] = $data['department_type'];
        }
    }
}
//print_r($dept_staff_count_arr);



foreach ($dept_staff_count_arr as $dept_id => $staff_count) {
    echo $sql3 = 'SELECT a.id,dsf.department_id,COUNT(asf.staff_id) as staff_count
                FROM actions a
                INNER JOIN action_staffs asf ON(a.id=asf.action_id)
                INNER JOIN department_staff dsf ON(asf.staff_id=dsf.staff_id) WHERE a.department=' . $dept_id . ' GROUP BY a.id';
    if ($result = mysqli_query($conn, $sql3)) {
        if (mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_array($result)) {
//                print_r($data);
                if($staff_count[0] == $data['staff_count']){
                    $sql4 = 'INSERT INTO action_assign_to_department_rel(action_id,department_id,department_type,is_all)VALUES('.$data['id'].','.$data['department_id'].','.$staff_count[1].',1)';
                }
                else{
                    $sql4 = 'INSERT INTO action_assign_to_department_rel(action_id,department_id,department_type,is_all)VALUES('.$data['id'].','.$data['department_id'].','.$staff_count[1].',0)';
                }
                mysqli_query($conn, $sql4);
            }
        }
    }
}
        