<?php
  require_once "../model/class_model.php";


	if(ISSET($_POST)){
		$conn = new class_model();

	    $department_id = trim($_POST['department_id']);

		$del = $conn->delete_department($department_id);
		if($del == TRUE){
		      echo '<div class="alert alert-success">Delete Department Successfully!</div><script> setTimeout(function() {  location.replace("manage_department.php"); }, 1000); </script>';
		    

		  }else{
		    echo '<div class="alert alert-danger">Delete Department Failed!</div><script> setTimeout(function() {  location.replace("manage_department.php"); }, 1000); </script>';

	
		}
	}

?>

