<?php
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=attendance_report.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    require('../../init/model/config/connection2.php');

    $output = "";

    if(ISSET($_POST['export'])) {
        // Initialize the output with the table headers
        $output .= "
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
                </thead>
                <tbody>
        ";

        // Get the date range from the form
        $date1 = date("Y-m-d", strtotime($_POST['date1']));
        $date2 = date("Y-m-d", strtotime($_POST['date2']));

        // Select the minimum time in and maximum time out for each employee and day
        $stmt = $conn->prepare("
            SELECT 
                a.employee_qrcode, 
                b.employee_idno, 
                b.first_name, 
                b.last_name, 
                MIN(a.time_in) AS min_time_in, 
                MAX(a.time_out) AS max_time_out, 
                a.logdate
            FROM tbl_attendance a 
            INNER JOIN tbl_employee b ON a.employee_qrcode = b.qr_code 
            WHERE a.logdate BETWEEN ? AND ? 
            GROUP BY a.employee_qrcode, a.logdate
            ORDER BY a.attendance_id ASC");
        $stmt->bind_param("ss", $date1, $date2);
        $stmt->execute();
        $result = $stmt->get_result();

        // Loop through the result set and add each row to the output
        while($fetch = $result->fetch_assoc()){

            // Get the earliest time in and latest time out for the employee and day
            $time_in = $fetch['min_time_in'];
            $time_out = $fetch['max_time_out'];

            // Add the row to the output with the earliest time in and latest time out
            $output .= "
                <tr>
                    <td>".$fetch['employee_qrcode']."</td>
                    <td>".$fetch['employee_idno']."</td>
                    <td>".$fetch['first_name']."</td>
                    <td>".$fetch['last_name']."</td>
                    <td>".$time_in."</td>
                    <td>".$time_out."</td>
                    <td>".date("M d, Y", strtotime($fetch['logdate']))."</td>
                </tr>
            ";
        }

        // Close the table
        $output .= "
                </tbody>
            </table>
        ";

        // Output the completed table to the browser as an Excel file
        echo $output;
    }
?>
