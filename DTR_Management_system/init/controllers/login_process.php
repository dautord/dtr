<?php
		require_once "../model/class_model.php";;
	if(ISSET($_POST)){
		$conn = new class_model();
		$username = trim($_POST['username']);
		$password = trim(md5($_POST['password']));

		
		$get_adminID = $conn->login_admin($username, $password);
		if($get_adminID['count'] > 0){
			session_start();
			$_SESSION['admin_id'] = $get_adminID['admin_id'];

			echo 1;
		}else{
			echo 0;
		}
	}
?>

