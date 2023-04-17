<?php
// Include your database class object model and other necessary files
require_once '../../init/model/class_model.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $department = $_POST['department'];
    $workDays = $_POST['workDays'];

    // Update the work_week column in tbl_department table
    $conn = new class_model(); // Instantiate your database object model
    $conn->updateDepartmentWorkWeek($department, $workDays); // Call the updateDepartmentWorkWeek method with department and workDays as parameters

    // Redirect to a success page or do any other necessary actions
    echo "Successfully updated department work week!";
    header('Location: manage_attendance.php');
    exit();
}
?>
