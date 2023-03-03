<?php
  require_once "../model/class_model.php";

	if(ISSET($_POST)){
		$conn = new class_model();

	    $employee_id = trim($_POST['employee_id']);

		$del = $conn->delete_employee($employee_id);
		if($del == TRUE){
		      echo '<div class="alert alert-success">Delete Employee Successfully!</div><script> setTimeout(function() {  location.replace("manage_employee.php"); }, 1000); </script>';
		    

		  }else{
		    echo '<div class="alert alert-danger">Delete Employee Failed!</div><script> setTimeout(function() {  location.replace("manage_employee.php"); }, 1000); </script>';

	
		}
	}

?>

