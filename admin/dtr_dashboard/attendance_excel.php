<?php
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename=attendance_report.csv');
	
	require('../../init/model/config/connection2.php');
	
	$output = fopen('php://output', 'w');
	
	if(ISSET($_POST['export'])){
		fputcsv($output, array('QR Code', 'EmployeeID No.', 'First Name', 'Last Name', 'Time In', 'Time Out', 'Log Date'));
		
		$date1 = date('Y-m-d', strtotime($_POST['date1']));
		$date2 = date('Y-m-d', strtotime($_POST['date2']));

		$stmt = $conn->prepare("SELECT * FROM tbl_attendance a INNER JOIN tbl_employee b ON a.employee_qrcode = b.qr_code WHERE a.logdate BETWEEN ? AND ? ORDER BY a.attendance_id ASC");
		$stmt->bind_param('ss', $date1, $date2);
	    $stmt->execute();
        $result = $stmt->get_result();
		
		while($fetch = $result->fetch_assoc()){
			fputcsv($output, array($fetch['qr_code'], $fetch['employee_idno'], $fetch['first_name'], $fetch['last_name'], $fetch['time_in'], $fetch['time_out'], date('M d, Y', strtotime($fetch['logdate']))));
		}
		
		fclose($output);
		exit();
	}
?>
