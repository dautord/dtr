<?php
	require_once "../model/class_model.php";
	require_once '../../log_helper.php';
	if(ISSET($_POST)){
		$conn = new class_model();

		$department_name = trim($_POST['department_name']);
		$description = trim($_POST['description']);
		$employee_id = trim($_POST['employee_id']);
		$late_time = $_POST['late_time'];
		$under_time = $_POST['under_time'];
		$dateLateTime = new DateTime($late_time);
		$dateUnderTime = new DateTime($under_time);


		$formatted_late_time = $dateLateTime->format('H:i:s');
		$formatted_under_time = $dateUnderTime->format('H:i:s');
		write_log("Recieved Late Time: " . $formatted_late_time);
		write_log("Recieved Under Time: " . $formatted_under_time);

		
		$edit = $conn->edit_department($department_name, $description, $employee_id, $formatted_late_time, $formatted_under_time);
		if($edit == TRUE){
		      echo '<div class="alert alert-success">Update Department Successfully!</div><script> setTimeout(function() {  location.replace("manage_department.php"); }, 1000); </script>';
		    

		  }else{
		    echo '<div class="alert alert-danger">Update Department Failed!</div><script> setTimeout(function() {  location.replace("manage_department.php"); }, 1000); </script>';

	
		}
	}

?>

