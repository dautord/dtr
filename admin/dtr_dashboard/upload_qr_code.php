<?php
require_once "../../init/model/class_model.php";
if (isset($_POST)) {
    $conn = new class_model();

    $employee_idno = trim($_POST['employee_idno']);
    $qr_code = $_FILES['qr_code'];

    // Specify the directory where the QR code images will be stored
    $directory = "../../qrcode_images/";

    // Check if a file was uploaded successfully
    if ($qr_code['error'] === UPLOAD_ERR_OK) {
        // Retrieve the original filename of the uploaded QR code
        $original_filename = $qr_code['name'];

        // Extract the file type extension
        $extension = pathinfo($original_filename, PATHINFO_EXTENSION);

        // Generate a unique filename for the uploaded QR code
        $filename = $employee_idno . '.' . $extension;

        // Move the uploaded file to the designated directory with the modified filename
        if (move_uploaded_file($qr_code['tmp_name'], $directory . $filename)) {
            // Update the employee's QR code path in the database with the modified filename
            $update = $conn->update_qr_code($employee_idno, $filename);

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
