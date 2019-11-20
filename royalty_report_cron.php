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
	$sql = "SELECT * from royalty_report WHERE id != '1'";
	$result = mysqli_query($conn, $sql);
	
	if ($result = mysqli_query($conn, $sql)) {
	    if (mysqli_num_rows($result) > 0) {
	        while ($ld = mysqli_fetch_array($result)) {
				$staff_id = $ld['id'];
							
				$staffrole = ;
		        $staff_office = ;
		        $departments = ;        	
	        }
	    }
    }    	
?>