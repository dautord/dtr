<?php
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=' . date("Y-m-d", strtotime($_POST['date1'])) . ' - ' . date("Y-m-d", strtotime($_POST['date2'])) . ' Attendance Report.csv');
header('Pragma: no-cache');
header('Expires: 0');

require('../../init/model/config/connection2.php');

$output = "";

if (isset($_POST['export'])) {
    // Initialize the output with the column headers
    $output .= "EmployeeID No.,Last Name,First Name,Time In,Time Out,Log Date,Remarks\n";

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
              b.employee_idno, 
              b.last_name,
              b.first_name, 
              COALESCE(MIN(a.time_in), '') AS min_time_in, 
              COALESCE(MAX(a.time_out), '') AS max_time_out, 
              d.logdate AS logdate,
              '' AS remarks
          FROM dates d
          CROSS JOIN tbl_employee b
          LEFT JOIN tbl_attendance a 
              ON a.employee_qrcode = b.qr_code 
              AND a.logdate = d.logdate
          GROUP BY b.employee_idno, b.first_name, b.last_name, d.logdate
          ORDER BY b.last_name ASC, b.first_name ASC, d.logdate ASC
          ");
    $stmt->bind_param("ss", $date1, $date2);
    $stmt->execute();
    $result = $stmt->get_result();

    // Loop through the result set and add each row to the output
    while ($fetch = $result->fetch_assoc()) {

        // Get the earliest time in and latest time out for the employee and day
        $time_in = $fetch['min_time_in'];
        $time_out = $fetch['max_time_out'];

        // Add the row to the output with the earliest time in and latest time out
        $output .=
            $fetch['employee_idno'] . ',' .
            $fetch['last_name'] . ',' .
            $fetch['first_name'] . ',' .
            $time_in . ',' .
            $time_out . ',' .
            date("M d", strtotime($fetch['logdate'])) . ',' .
            $fetch['remarks'] .
            "\n";
    }

    // Output the completed table to the browser as a CSV file
    echo $output;
}
?>
