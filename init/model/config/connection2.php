<?php 
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$conn = new mysqli("localhost", "root", "", "dtr_system");
	// $conn = new mysqli("192.168.128.58", "admin", "", "dtr_system");
	if($conn->connect_error) {
	  exit('Error connecting to database'); //Should be a message a typical user could understand in production
	}

?>