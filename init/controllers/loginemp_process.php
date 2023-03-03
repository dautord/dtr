<?php
		require_once "../model/class_model.php";;
	if(ISSET($_POST)){
		$conn = new class_model();
		$employee_idno = trim($_POST['employee_idno']);
		$password = $_POST['password'];

		
		$get_eployeeID = $conn->login_employee($employee_idno, $password);
		if($get_eployeeID['count'] > 0){
			session_start();
			$_SESSION['employee_id'] = $get_eployeeID['employee_id'];

			echo 1;
		}else{
			echo 0;
		}
	}
?>

