<?php 

	include '../../../init/model/config/connection2.php';

	if(isset($_POST['employee_id'])){
		$id = $_POST['employee_id'];

	    $sql = "SELECT * FROM `tbl_employee` WHERE employee_id = ?";
	    $stmt = $conn->prepare($sql); 
	    $stmt->bind_param("i", $id);
	    $stmt->execute();
	    $result = $stmt->get_result();
        $row = $result->fetch_assoc();

	    echo json_encode($row);

	 }
?>