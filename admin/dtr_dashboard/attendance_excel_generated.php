<?php
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename=attendance_report.csv');
    header('Pragma: no-cache');
    header('Expires: 0');

    require('../../init/model/config/connection2.php');

    $output = "";

    if(ISSET($_POST['export'])) {
        // Initialize the output with the column headers
        $output .= "QR Code,EmployeeID No.,First Name,Last Name,Time In,Time Out,Log Date\n";

        // Get the date range from the form
        $date1 = date("Y-m-d", strtotime($_POST['date1']));
        $date2 = date("Y-m-d", strtotime($_POST['date2']));

        // Select the minimum time in and maximum time out for each employee and day
        $stmt = $conn->prepare("
        WITH RECURSIVE dates AS (
            SELECT ? AS logdate
            UNION ALL
            SELECT logdate + INTERVAL 1 DAY FROM dates WHERE logdate < ?
          )
          SELECT 
              a.employee_qrcode, 
              b.employee_idno, 
              b.first_name, 
              b.last_name, 
              COALESCE(MIN(a.time_in), '') AS min_time_in, 
              COALESCE(MAX(a.time_out), '') AS max_time_out, 
              d.logdate AS logdate
          FROM dates d
          CROSS JOIN tbl_employee b
          LEFT JOIN tbl_attendance a 
              ON a.employee_qrcode = b.qr_code 
              AND a.logdate = d.logdate
          GROUP BY a.employee_qrcode, b.employee_idno, b.first_name, b.last_name, d.logdate
          ORDER BY b.last_name ASC, b.first_name ASC, d.logdate ASC
          ");
        $stmt->bind_param("ss", $date1, $date2);
        $stmt->execute();
        $result = $stmt->get_result();

        // Loop through the result set and add each row to the output
        while($fetch = $result->fetch_assoc()){

            // Get the earliest time in and latest time out for the employee and day
            $time_in = $fetch['min_time_in'];
            $time_out = $fetch['max_time_out'];

            // Add the row to the output with the earliest time in and latest time out
            $output .= 
                $fetch['employee_qrcode'] . ',' .
                $fetch['employee_idno'] . ',' .
                $fetch['first_name'] . ',' .
                $fetch['last_name'] . ',' .
                $time_in . ',' .
                $time_out . ',' .
                date("M d, Y", strtotime($fetch['logdate'])) .
                "\n";
        }

        // Output the completed table to the browser as a CSV file
        echo $output;
    }
?>
