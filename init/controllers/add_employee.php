<?php
require_once "../model/class_model.php";

if (isset($_POST)) {
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
    $codeContents = trim($_POST['employee_idno']);

    // Specify the directory where the QR code images will be stored
    $directory = "../../qrcode_images/";

    // Check if a file was uploaded successfully
    if (isset($_FILES['qrCode']) && $_FILES['qrCode']['error'] === UPLOAD_ERR_OK) {
        // Retrieve the original filename of the uploaded QR code
        $original_filename = $_FILES['qrCode']['name'];

        // Extract the employee ID from the original filename
        $filename = pathinfo($original_filename, PATHINFO_FILENAME);

        // Move the uploaded file to the designated directory with the modified filename
        if (move_uploaded_file($_FILES['qrCode']['tmp_name'], $directory . $original_filename)) {
            // Update the employee's QR code path in the database with the modified filename
            $update = $conn->add_employee($employee_idno, $password, $first_name, $middle_name, $last_name, $bdate, $caddress, $cnumber, $gender, $civilstatus, $datehire, $designation, $department, $filename, $codeContents);

            if ($update) {
                echo '<div class="alert alert-success">Add Employee Successfully!</div><script> setTimeout(function() {  location.replace("manage_employee.php"); }, 1000); </script>';
                exit();
            } else {
                echo '<div class="alert alert-danger">Add Employee Failed!</div><script> setTimeout(function() {  location.replace("manage_employee.php"); }, 1000); </script>';
                exit();
            }
        } else {
            echo '<div class="alert alert-danger">Failed to move the uploaded file to the designated directory!</div>';
            exit();
        }
    } else {
        echo '<div class="alert alert-danger">Error occurred while uploading the file: ' . $_FILES['qrCode']['error'] . '</div>';
        exit();
    }
}
?>
