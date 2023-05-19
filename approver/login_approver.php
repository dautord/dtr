<?php
require_once '../init/model/class_model.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $conn = new class_model();
    $get_approverID = $conn->login_approver($username, $password);
    if ($get_approverID['count'] > 0) {
        session_start();
        $_SESSION['approver_id'] = $get_approverID['approver_id'];
        header("Location: dtr_dashboard/dashboard.php");
        exit();
    } else {
        header("Location: login.php?error=1");
        exit();
    }
}
?>
