  <?php include 'header/main_header.php';?>
  <?php include 'sidebar/main_sidebar.php';?>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Attendance</h1>
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
<!--               <div class="card-header">
                 <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modal-default">
                 <i class="fa fa-plus"></i> Add Attendance
                </button>
              </div> -->

              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>QR Code</th>
                    <th>EmployeeID No.</th>
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
                      $employee_id = $_SESSION['employee_id'];
                      $conn = new class_model();
                      $emp = $conn->fetchindividual_empAttendance($employee_id);
                      $attempdept = $conn->fetchLateTime();
                  ?>
                <?php foreach ($emp as $row) { ?>
                  <tr>
                    <td><?= $row['qr_code']; ?></td>
                    <td><?= $row['employee_idno']; ?></td>
                    <td><?= $row['first_name']; ?></td>
                    <td><?= $row['last_name']; ?></td>
                    <td><?= $row['time_in']; ?></td>
                    <td><?= $row['time_out']; ?></td>
                    <td><?= htmlentities(date("M d, Y",strtotime($row['logdate']))); ?></td>

                    <td>
                      <?php
                        $Timein = $row['time_in'];
                        $department = $row['department'];
                        $late_time = null;
                                      
                        // Get the late_time for the department
                        foreach ($attempdept as $dept) {
                          if ($dept['department_name'] === $department) {
                            $late_time = $dept['late_time'];
                            break;
                          }
                        }
                                      
                        // Check if employee is late
                        if ($Timein <= $late_time){
                          echo "<button class='btn btn-success btn-xs'><i class='fa fa-user-clock'></i> On Time</button>";
                        }else{
                          echo "<button  class='btn btn-danger btn-xs'><i class='fa fa-user-clock'></i> Late</button>";
                        }
                      ?>
                    </td>
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
