<?php

	if(ISSET($_POST)){
		$conn = new class_model();

		$employee_idno = trim($_POST['employee_idno']);
		$password = trim($_POST['password']);
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
	    // $qr_code = trim($_POST['qr_code']);
	     function rand_string( $length ) {
		    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		    return substr(str_shuffle($chars),0,$length);
	    }

        $codeContents = ''.rand_string(8); 
        QRcode::png($codeContents, $pathDir.''.$employee_idno.'.png', QR_ECLEVEL_L, 5);

		
		$add = $conn->add_employee($employee_idno, $password, $first_name, $middle_name, $last_name, $bdate, $caddress, $cnumber,  $gender, $civilstatus, $datehire, $designation, $department, $codeContents);
		if($add == TRUE){
		      echo '<div class="alert alert-success">Add Employee Successfully!</div><script> setTimeout(function() {  location.replace("manage_employee.php"); }, 1000); </script>';
		    

		  }else{
		    echo '<div class="alert alert-danger">Add Employee Failed!</div><script> setTimeout(function() {  location.replace("manage_employee.php"); }, 1000); </script>';

	
		}
	}

?>

