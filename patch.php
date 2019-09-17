<?php

$conn=mysqli_connect('localhost','root','root','leafnet');
$data=mysqli_query($conn,"select * from `order` where service_id='12'");
while($res=mysqli_fetch_assoc($data)){

	$order_id=$res['id'];
	$service=mysqli_query($conn,"select * from service_request where order_id='$order_id' and services_id='42'");
	while($result=mysqli_fetch_assoc($service)){
		$update=mysqli_query($conn,"update service_request set services_id='12' where services_id='42'");
		
	}
}






?>