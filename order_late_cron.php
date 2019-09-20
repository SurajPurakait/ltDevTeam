<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = 'leafnet_db';
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
   //echo "Connected successfully"; 
 
        $sql = "select o.id, o.order_date, o.start_date, o.complete_date, o.total_of_order, o.tracking, c.name as client_name,o.reference_id,o.reference,o.status,o.start_date,o.complete_date,o.target_start_date,o.target_complete_date,
                concat(st.last_name, ', ', st.first_name) as requested_staff
                from `order` o
                inner join company c on c.id = o.reference_id
                inner join staff st on st.id = o.staff_requested_service
                where o.status not in(0,7,10)
                order by o.order_date desc";
        if($result = mysqli_query($conn, $sql)){
           if(mysqli_num_rows($result) > 0){  
                while($ld = mysqli_fetch_array($result)){
                       $sql_service = "select * from service_request where order_id='".$ld['id']."'";
                       if($result_service = mysqli_query($conn, $sql_service)){ 
                          if(mysqli_num_rows($result_service) > 0){  
                                while($sd = mysqli_fetch_array($result_service)){
                                    $target_end_date = $sd['date_completed'];
                                    if (strtotime($target_end_date) < strtotime(date('Y-m-d h:i:s')) ) {
                                        $updatesql = "update `order` set late_status= 1 where id = " . $ld['id'];
                                            mysqli_query($conn, $updatesql);
                                    }
                                }
                           }
                       }
                    }       

                }
           }
mysqli_close($conn);       
            
?>