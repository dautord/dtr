  <?php include 'header/main_header.php';?>
  <?php include 'sidebar/main_sidebar.php';?>
  <style>
        /* Add CSS styling for the specific table using a class or ID */
        .dashboard-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .dashboard-table th, .dashboard-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .dashboard-table th {
            background-color: #f2f2f2;
        }
  </style>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Attendance</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">My Attendance</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5><b>My Schedule</b></h5>
              </div>
              <div class="card-body">
                <table class="dashboard-table">
                  <thead>
                    <tr>
                      <th>Department</th>
                      <th>Work Week</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $employee_id = $_SESSION['employee_id'];
                        $conn = new class_model();
                        $departmentData = $conn->fetchIndividualEmpDeptData($employee_id);
                    ?>
                    <?php foreach ($departmentData as $row): ?>
                    <tr>
                      <td><?php echo $row['department_name']; ?></td>
                      <td><?php echo $row['work_week']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h5><b>My Attendance</b></h5>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Employee No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Log Date</th>        
                    <!-- <th>Status</th> -->
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                        date_default_timezone_set('Asia/Manila');
                        $employee_id = $_SESSION['employee_id'];
                        $conn = new class_model();
                        $emp = $conn->fetchindividual_empAttendance($employee_id);
                        $attempdept = $conn->fetchLateTime();
                  ?>
                  <?php foreach ($emp as $row) { ?>
                  <tr>
                    <td><?= $row['qr_code']; ?></td>
                    <td><?= $row['first_name']; ?></td>
                    <td><?= $row['last_name']; ?></td>
                    <td><?= $row['time_in']; ?></td>
                    <td><?= $row['time_out']; ?></td>
                    <td><?= htmlentities(date("M d, Y",strtotime($row['logdate']))); ?></td>

                    <!-- <td>
                      <?php
                        $Timein = $row['time_in'];
                        $Timein = str_replace(":AM", " AM", $Timein);
                        $Timein = str_replace(":PM", " PM", $Timein);
                        
                        $Timeout = $row['time_out'];
                        $Timeout = str_replace(":AM", " AM", $Timeout);
                        $Timeout = str_replace(":PM", " PM", $Timeout);

                        $department = $row['department'];
                        $late_time = '00:00:00';
                        $under_time = '00:00:00';
                        $status = $row['status'];


                        $logDate = date_parse($Timein);
                        $logDate = new DateTime(sprintf('%04d-%02d-%02d %02d:%02d:%02d', $logDate['year'], $logDate['month'], $logDate['day'], $logDate['hour'], $logDate['minute'], $logDate['second']), new DateTimeZone('Asia/Manila'));
                        $logDate->setTimezone(new DateTimeZone('Asia/Manila'));

                        $logOute = date_parse($Timeout);
                        $logOute = new DateTime(sprintf('%04d-%02d-%02d %02d:%02d:%02d', $logOute['year'], $logOute['month'], $logOute['day'], $logOute['hour'], $logOute['minute'], $logOute['second']), new DateTimeZone('Asia/Manila'));
                        $logOute->setTimezone(new DateTimeZone('Asia/Manila'));
                        
                        // Get the late_time for the department
                        foreach ($attempdept as $dept) {
                            if ($dept['department_name'] === $department) {
                                $late_time = $dept['late_time'];
                                break;
                            }
                        }
                        foreach ($attempdept as $dept) {
                          if ($dept['department_name'] === $department) {
                              $under_time = $dept['under_time'];
                              break;
                          }
                      }
                        // Get the under_time for the department
                        
                        // Check if employee is late or invalid 
                        if ($status != 1) {
                          echo "<button  class='btn btn-secondary btn-xs'><i class='fa fa-user-clock'></i> Invalid</button>";
                        } else {

                          $logTime = new DateTime($late_time, new DateTimeZone('Asia/Manila'));
                          $logDate = new DateTime($Timein, new DateTimeZone('Asia/Manila'));
                          $logDate->setTimezone(new DateTimeZone('Asia/Manila'));

                          $logUnder = new DateTime($under_time, new DateTimeZone('Asia/Manila'));
                          $logOute = new DateTime($Timeout, new DateTimeZone('Asia/Manila'));
                          $logOute->setTimezone(new DateTimeZone('Asia/Manila'));

                          if ($logDate > $logTime && $logOute < $logUnder) {
                            echo "<button class='btn btn-danger btn-xs'><i class='fa fa-user-clock'></i> Late and Undertime</button>";
                          } elseif ($logDate > $logTime) {
                              echo "<button class='btn btn-danger btn-xs'><i class='fa fa-user-clock'></i> Late</button>";
                          } elseif ($logOute < $logUnder) {
                              echo "<button class='btn btn-danger btn-xs'><i class='fa fa-user-clock'></i> Undertime</button>";
                          } else {
                              echo "<button class='btn btn-success btn-xs'><i class='fa fa-user-clock'></i> On Time</button>";
                          }
                        }
                      ?>
                    </td> -->
                  </tr>
                <?php }?>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php include 'footer/footer.php';?>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/demo.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
    });

  });

</script>
</body>
</html>
