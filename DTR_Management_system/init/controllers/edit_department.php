<?php
  require_once "../model/class_model.php";

	if(ISSET($_POST)){
		$conn = new class_model();

		$department_name = trim($_POST['department_name']);
		$description = trim($_POST['description']);
		$employee_id = trim($_POST['employee_id']);

		
		$edit = $conn->edit_department($department_name, $description, $employee_id);
		if($edit == TRUE){
		      echo '<div class="alert alert-success">Update Department Successfully!</div><script> setTimeout(function() {  location.replace("manage_department.php"); }, 1000); </script>';
		    

		  }else{
		    echo '<div class="alert alert-danger">Update Department Failed!</div><script> setTimeout(function() {  location.replace("manage_department.php"); }, 1000); </script>';

	
		}
	}

?>

