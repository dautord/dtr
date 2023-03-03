<?php


		require_once "../model/config/connection2.php";

		$date1 = date("Y-m-d", strtotime($_POST['date1']));
		$date2 = date("Y-m-d", strtotime($_POST['date2']));

		$stmt = $conn->prepare("SELECT * FROM tbl_attendance a INNER JOIN tbl_employee b ON a.employee_qrcode = b.qr_code WHERE a.logdate BETWEEN ? AND ? ORDER BY a.attendance_id ASC");
		$stmt->bind_param("ss", $date1, $date2);
	    $stmt->execute();
        $result = $stmt->get_result();
       if($result->num_rows > 0){
			while($row =  $result->fetch_assoc()){
			?>
			<tr>
                    <td><?= $row['qr_code']; ?></td>
                    <td><?= $row['employee_idno']; ?></td>
                    <td><?= $row['first_name']; ?></td>
                    <td><?= $row['last_name']; ?></td>
                    <td><?= $row['time_in']; ?></td>
                    <td><?= $row['time_out']; ?></td>
                    <td><?= htmlentities(date("M d, Y",strtotime($row['logdate']))); ?></td>


			</tr>
		

			<?php
			}
			echo '<td colspan="7">       
			    <form method="POST" action="attendance_excel.php">
			    <input type="hidden" name="date1" value='.$date1.'>
			    <input type="hidden" name="date2" value='.$date2.'>
			    <button class="btn btn-success pull-right" name="export"><span class="glyphicon glyphicon-print"></span><i class="fa fa-file-excel"></i> Export Excel</button>
			    </form></td>
			  </tr>';

		}else{

		echo '
		<tr>
			<td colspan = "7"><center>Record Not Found</center></td>
		</tr>
		';
	 }
	?>