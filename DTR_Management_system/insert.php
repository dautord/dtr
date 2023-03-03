<?php 
//error_reporting(0);
//session_start();
include 'connection/db_connect.php';
if(isset($_POST['text'])){

	    // $voice = new com("SAPI.SpVoice");
	    // $message = "Hi".$emp. "Your Time In has been successfully added!. Thank you";

    	date_default_timezone_set("asia/manila");
		$emp = $_POST['text'];
		$date = date('Y-m-d');
		//$time = date('h:i A');
	    $time =  date('h:i:A', strtotime("+0 HOURS"));


		$sql = "SELECT * FROM tbl_attendance WHERE employee_id = '$emp' AND logdate = '$date' AND status = '0'";
		$query = $conn->query($sql);
		if($query->num_rows > 0){
			$sql = "UPDATE tbl_attendance SET time_out = '$time', status = '1' WHERE employee_id = '$emp' AND logdate = '$date'";
			$query = $conn->query($sql);
              $msg="<b>Your Time Out</b>" .$time;
			//	$_SESSION['out'] = "<b>Your Time Out</b> " .$time;
		    	// $message2 = "Hi".$emp. "Your Time Out has been successfully added!. Thank you";
			    // $voice->speak($message2);
		}else{


				$sql = "INSERT INTO tbl_attendance(employee_id,time_in,logdate, status) VALUES('$emp', '$time','$date','0')";
				if($conn->query($sql) === TRUE){
					$msg="<b>Your Time In</b>" .$time;
					//$_SESSION['in'] = "<b>Your Time In</b> " .$time;
		            //$voice->speak($message);
				}else{
					$_SESSTION['error'] = $conn->error;
				}

		}

	}else{
		$error="Please scan your QR Code Number";  
			//$_SESSION['error'] = "Please scan your QR Code Number";

	}
		// header('Refresh: 1;url=index.php');
	header("location: index.php");
	$conn->close();

?>