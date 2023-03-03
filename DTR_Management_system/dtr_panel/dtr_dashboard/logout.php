<?php
	session_start();
	session_destroy();
	session_unset($_SESSION['admin_id']);
	header('location:../index.php');
?>