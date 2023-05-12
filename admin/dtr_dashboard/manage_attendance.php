  <?php include 'header/main_header.php';?>
  <?php include 'sidebar/main_sidebar.php';?>
  <?php 
    $conn = new class_model();
    $dept = $conn->fetchAll_departmentName();
  
  ?>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Attendance</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Manage Attendance</li>
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
                <!-- Set Work Days Form -->
                <div class="card-header">
                  <h3 class="card-title">Set Work Day/s</h3>
                </div>
                <div class="card-body">
                  <form method="post" action="process_attendance.php">
                    <div class="form-group">
                      <label for="department">Department</label>
                      <select class="form-control" id="department" name="department">
                        <?php foreach ($dept as $department_name): ?>
                          <option value="<?php echo $department_name; ?>"><?php echo $department_name; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="attendanceDays">Work Day/s:</label>
                        <input type="text" class="form-control" id="workDays" name="workDays" placeholder="Enter work days (e.g. Monday to Saturday, Tuesday to Thursday, Saturdays)">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </form>

                  <hr>

                  <h5>Department Work Week</h5>
                  <table class="table">
                      <thead>
                          <tr>
                              <th>Department Name</th>
                              <th>Work Week</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          // Call the function to fetch all departments and display in the table
                          $dept = $conn->fetchAll_department();
                          foreach ($dept as $row) {
                              echo '<tr>';
                              echo '<td>' . $row['department_name'] . '</td>';
                              echo '<td>' . $row['work_week'] . '</td>';
                              echo '</tr>';
                          }
                          ?>
                      </tbody>
                  </table>
                </div>
              </div>
          
              <!-- End Set Work Days Form -->
                          
              <div class="card">
              <div class="card-header">
                <a href="add_attendance.php" class="btn btn-primary float-sm-right"><i class="fa fa-plus"></i> Add Attendance</a>
              </div>

              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Log Date</th>        
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            date_default_timezone_set('Asia/Manila');
                            $conn = new class_model();
                            $emp = $conn->fetchAll_empAttendance();
                            $attempdept = $conn->fetchLateTime();
                        ?>
                        <?php foreach ($emp as $row) { ?>
                            <tr>
                                <td><?= $row['first_name']; ?></td>
                                <td><?= $row['last_name']; ?></td>
                                <td><?= $row['time_in']; ?></td>
                                <td><?= $row['time_out']; ?></td>
                                <td><?= htmlentities(date("M d, Y",strtotime($row['logdate']))); ?></td>
                                <td>
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

                                          $late_minutes = round(($logDate->getTimestamp() - $logTime->getTimestamp()) / 60);
                                          $under_minutes = round(($logUnder->getTimestamp() - $logOute->getTimestamp()) / 60);

                                          if ($late_minutes > 0 && $under_minutes > 0) {
                                              echo "<button class='btn btn-danger btn-xs'><i class='fa fa-user-clock'></i> Late ({$late_minutes} minutes) and Undertime ({$under_minutes} minutes)</button>";
                                          } elseif ($late_minutes > 0) {
                                              echo "<button class='btn btn-danger btn-xs'><i class='fa fa-user-clock'></i> Late ({$late_minutes} minutes)</button>";
                                          } elseif ($under_minutes > 0) {
                                              echo "<button class='btn btn-danger btn-xs'><i class='fa fa-user-clock'></i> Undertime ({$under_minutes} minutes)</button>";
                                          } else {
                                              echo "<button class='btn btn-success btn-xs'><i class='fa fa-user-clock'></i> On Time</button>";
                                          }
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
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
