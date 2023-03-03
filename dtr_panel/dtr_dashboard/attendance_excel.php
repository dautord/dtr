<?php
	header("Content-Type: application/xls");    
    header("Content-Disposition: attachment; filename=attendance_report.xls");  
	header("Pragma: no-cache"); 
	header("Expires: 0");

	require('../../init/model/config/connection2.php');
	
	$output = "";
	
	if(ISSET($_POST['export']) ){
		$output .="
			<table>
				<thead>
					<tr>
                    <th>QR Code</th>
                    <th>EmployeeID No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Log Date</th>    
					</tr>
				<tbody>
		";
		
		$date1 = date("Y-m-d", strtotime($_POST['date1']));
		$date2 = date("Y-m-d", strtotime($_POST['date2']));

		$stmt = $conn->prepare("SELECT * FROM tbl_attendance a INNER JOIN tbl_employee b ON a.employee_qrcode = b.qr_code WHERE a.logdate BETWEEN ? AND ? ORDER BY a.attendance_id ASC");
		$stmt->bind_param("ss", $date1, $date2);
	    $stmt->execute();
        $result = $stmt->get_result();
			while($fetch = $result->fetch_assoc()){
			
		$output .= "
					<tr>
						<td>".$fetch['qr_code']."</td>
						<td>".$fetch['employee_idno']."</td>
					    <td>".$fetch['first_name']."</td>
						<td>".$fetch['last_name']."</td>
					    <td>".$fetch['time_in']."</td>
						<td>".$fetch['time_out']."</td>
						<td>". date("M d, Y",htmlentities(strtotime($fetch['logdate'])))."</td>
					</tr>
		          ";
		}
		
		$output .="
				</tbody>
				
			</table>
		";
		
		echo $output;
	}
	
?>