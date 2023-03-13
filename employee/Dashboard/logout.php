<?php
	session_start();
	session_destroy();
	//session_unset($_SESSION['employee_id']);
	session_unset();
	header('location:../index.php');
?>