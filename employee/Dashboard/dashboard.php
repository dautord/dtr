<?php include 'header/main_header.php';?>
<?php include 'sidebar/main_sidebar.php';?>
<?php 
  $employee_id = $_SESSION['employee_id'];
  $conn = new class_model();
  $emp = $conn->getEmployeeLeaves($employee_id);
  $leaveRequests = $conn->getLeaveRequests($employee_id);
  
  // Fetch the gender data
  $gender = $emp['gender'];

  //var_dump($leaveRequests);

  // var_dump($gender);
  // check if the user is logged in
  if (!isset($_SESSION['employee_id'])) {
    // if not, redirect them to the login page
    header('location: login.php');
    exit();
  }

  if (isset($_POST['cancel'])){
    $leave_id = $_POST["leave_id"];
    $cancelLeave = $conn->cancelLeaveRequest($leave_id);
    if($cancelLeave) {
      echo "<script>alert('Leave request canceled successfully.')</script>";
      header('location: dashboard.php');
      exit();
    } else {
      echo "<script>alert('Error canceling leave request.')</script>";
    }
  }



?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
  <div class="container-fluid">
    <div class="row">

      <!-- Sick Leave Info Box -->
      <div class="col-md-4">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-syringe"></i></span>
          
          <div class="info-box-content">
            <span class="info-box-text">Sick Leave</span>
            <span class="info-box-number"><?= $emp['sick_leave'] ?></span>
          </div>
        </div>
      </div>

      <!-- Vacation Leave Info Box -->
      <div class="col-md-4">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-island-tropical"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Vacation Leave</span>
            <span class="info-box-number"><?= $emp['vacation_leave'] ?></span>
          </div>
        </div>
      </div>

      <!-- Paternal Leave Info Box -->
      <?php if ($gender === 'Male'): ?>
        <div class="col-md-4">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-baby-carriage"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Paternal Leave</span>
              <span class="info-box-number"><?= $emp['paternal_leave'] ?></span>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Maternal Leave Info Box -->
      <?php if ($gender === 'Female'): ?>
        <div class="col-md-4">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-baby-carriage"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Maternal Leave</span>
              <span class="info-box-number"><?= $emp['maternal_leave'] ?></span>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Emergency Leave Info Box -->
      <div class="col-md-4">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-hospital"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Emergency Leave</span>
            <span class="info-box-number"><?= $emp['emergency_leave'] ?></span>
          </div>
        </div>
      </div>
      <!-- Solo Parent Leave Info Box -->
        <div class="col-md-4">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-baby-carriage"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Parental Leave (Solo Parent Act)</span>
              <span class="info-box-number"><?= $emp['solo_parent_leave'] ?></span>
            </div>
          </div>
        </div>

    </div>
    <br>    
    <h3 class="m-0 text-dark">Leave History</h3>
    <br>
  </div>

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th>Leave Request No.</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Leave Type</th>
                      <th>Reason</th>
                      <th>Requested On</th>
                      <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($leaveRequests as $leaveRequest) { ?>
                      <tr>
                          <td><?php echo $leaveRequest['leave_id']; ?></td>
                          <td><?php echo $leaveRequest['datetime_start']; ?></td>
                          <td><?php echo $leaveRequest['datetime_end']; ?></td>
                          <td><?php echo $leaveRequest['leave_type']; ?></td>
                          <td><?php echo $leaveRequest['reason']; ?></td>
                          <td><?php echo $leaveRequest['datetime_requested']; ?></td>
                          <td><?php echo $leaveRequest['status']; ?></td>
                          <td>
                          <?php if($leaveRequest["status"] == "Pending") { ?>
                          <form method="post">
                            <input type="hidden" name="leave_id" value="<?php echo $leaveRequest["leave_id"]; ?>">
                            <button type="submit" name="cancel">Cancel</button>
                          </form>
                          <?php } ?>
                          </td>
                      </tr>
                  <?php } ?>
                </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <a href="leave_request.php" class="btn btn-md btn-primary text-center" style="height: 40px; display: flex; align-items: center; justify-content: center; max-width: 200px;">Request for Leave</a>
      </div>
    </section>
  </div>




<aside class="control-sidebar control-sidebar-dark">
</aside>

<?php include 'footer/footer.php';?>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="dist/js/demo.js"></script>

<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="dist/js/pages/dashboard2.js"></script>
</body>
</html>
