<?php
  $conn = new class_model();

  // Get the status from the AJAX request
  $status = $_POST['status'];

  // Update the leave button status in the database
  $conn->toggleLeaveButtonStatus();

  // Return a success response
  $response = array("success" => true, "status" => $status);
  echo json_encode($response);
?>