<?php
require_once '../../init/model/class_model.php';
$conn = new class_model();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $employee_qrcode = $_POST['employee_qrcode'];
  $time_in = date('h:i:A', strtotime($_POST['time_in']));
  $time_out = date('h:i:A', strtotime($_POST['time_out']));
  $logdate = date('Y-m-d', strtotime($_POST['time_in']));
  $status = 1;
  // Call the add_attendance function
  $add = $conn->add_attendance($employee_qrcode, $time_in, $time_out, $logdate, $status);
  if($add == TRUE){
      echo '<div class="alert alert-success">Attendance added successfully!</div><script> setTimeout(function() {  location.replace("add_attendance.php"); }, 1000); </script>';
  }else{
    echo '<div class="alert alert-danger">Failed to add attendance.</div><script> setTimeout(function() {  location.replace("add_attendance.php"); }, 1000); </script>';
  }
}

?>
