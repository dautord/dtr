<?php
require_once "../../init/model/class_model.php";
if (isset($_POST)) {
    $conn = new class_model();

    $employee_id = trim($_POST['employee_id']);
    $qr_code = $_FILES['qr_code'];

    // Specify the directory where the QR code images will be stored
    $directory = "../../qrcode_images/";

    // Check if a file was uploaded successfully
    if ($qr_code['error'] === UPLOAD_ERR_OK) {
        // Retrieve the original filename of the uploaded QR code
        $original_filename = $qr_code['name'];

        // Generate a unique filename for the uploaded QR code
        $filename = $original_filename;

        // Move the uploaded file to the designated directory
        if (move_uploaded_file($qr_code['tmp_name'], $directory . $filename)) {
            // Update the employee's QR code path in the database
            $update = $conn->update_qr_code($employee_id, $directory . $filename);

            if ($update) {
                echo '<div class="alert alert-success">QR Code uploaded successfully!</div>';
                // Redirect back to manage_employee.php after successful upload
                header("Location: manage_employee.php");
                exit();
            } else {
                echo '<div class="alert alert-danger">Failed to update QR Code path in the database!</div>';
            }
        } else {
            echo '<div class="alert alert-danger">Failed to move the uploaded file to the designated directory!</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Error occurred while uploading the file: ' . $qr_code['error'] . '</div>';
    }
}
?>
