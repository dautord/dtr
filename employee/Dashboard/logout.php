<?php
	session_start();
	session_destroy();
	session_unset($_SESSION['employee_id']);
	header('location:../../index.php');
?>