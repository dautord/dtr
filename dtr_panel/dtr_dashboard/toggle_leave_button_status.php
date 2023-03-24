<?php
  $conn = new class_model();

  // // Get the status from the AJAX request
  // $status = $_POST['status'];
  if (isset($_POST['toggleButton'])) {
    $conn->toggleLeaveButtonStatus();
  }
  header('Location: dashboard.php');
?>