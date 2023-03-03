<?php
  require_once "../model/class_model.php";

	if(ISSET($_POST)){
		$conn = new class_model();

		$department_name = trim($_POST['department_name']);
		$description = trim($_POST['description']);

		
		$add = $conn->add_department($department_name, $description);
		if($add == TRUE){
		      echo '<div class="alert alert-success">Add Department Successfully!</div><script> setTimeout(function() {  location.replace("manage_department.php"); }, 1000); </script>';
		    

		  }else{
		    echo '<div class="alert alert-danger">Add Department Failed!</div><script> setTimeout(function() {  location.replace("manage_department.php"); }, 1000); </script>';

	
		}
	}

?>

