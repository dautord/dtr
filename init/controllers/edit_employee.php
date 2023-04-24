<?php
  require_once "../model/class_model.php";

	if(ISSET($_POST)){
		$conn = new class_model();

		$qr_codeno = trim($_POST['qr_codeno']);
		// $password = trim($_POST['password']);
	    $first_name = trim(ucfirst($_POST['first_name']));
		$middle_name = trim(ucfirst($_POST['middle_name']));
	    $last_name = trim(ucfirst($_POST['last_name']));
		$bdate = trim($_POST['bdate']);
	    $caddress = trim($_POST['complete_address']);
		$cnumber = trim($_POST['cnumber']);
	    $gender = trim($_POST['gender']);
		$civilstatus = trim($_POST['civilstatus']);
	    $datehire = trim($_POST['datehire']);
		$designation = trim($_POST['designation']);
	    $department = trim($_POST['department']);
	    $employee_id = trim($_POST['employee_id']);

		$sick_leave = trim($_POST['sick_leave']);
		$vacation_leave = trim($_POST['vacation_leave']);
		$paternal_leave = trim($_POST['paternal_leave']);
		$maternal_leave = trim($_POST['maternal_leave']);
		$emergency_leave = trim($_POST['emergency_leave']);
		$solo_parent_leave = trim($_POST['solo_parent_leave']);

		$edit = $conn->edit_employee($qr_codeno,  $first_name, $middle_name, $last_name, $bdate, $caddress, $cnumber,  $gender, $civilstatus, $datehire, $designation, $department, $sick_leave, $vacation_leave, $paternal_leave, $maternal_leave, $emergency_leave, $solo_parent_leave, $employee_id);
		if($edit == TRUE){
		      echo '<div class="alert alert-success">Update Employee Successfully!</div><script> setTimeout(function() {  location.replace("manage_employee.php"); }, 1000); </script>';
		    

		  }else{
		    echo '<div class="alert alert-danger">Update Employee Failed!</div><script> setTimeout(function() {  location.replace("manage_employee.php"); }, 1000); </script>';

	
		}
	}

?>

