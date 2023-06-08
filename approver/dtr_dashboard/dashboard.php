<?php include 'header/main_header.php';?>
<?php 
    $conn = new class_model();  
    $adminFetchLeaveReqs = $conn->adminGetLeaveRequests();
    $buttonStatus = $conn->getLeaveButtonStatus();
    

    if (!isset($_SESSION['approver_id'])) {
      // if not, redirect them to the login page
      header('location: login.php');
      exit();
    }

    if (isset($_POST['approve'])) {
      // Get the leave ID and new status from the form data
      $leave_id = $_POST['leave_id'];
      $employee_id = $_POST['employee_id'];
      $leave_type = $_POST['leave_type'];
      $new_status = 'For Next Approval';
    
      // Update the leave status in your database using your adminSetLeaveStatus function
      $result = $conn->adminSetLeaveStatus($leave_id, $new_status); 
    
      // Check if the update was successful and redirect accordingly
      if ($result) {
        header("location: ".$_SERVER['PHP_SELF']);
        exit;
      } else {
        // Handle the error if the update failed
        echo "Error: Failed to update the leave status.";
      }
    }
    
    if (isset($_POST['reject'])) {
      // Get the leave ID and new status from the form data
      $leave_id = $_POST['leave_id'];
      $new_status = 'Rejected';
    
      // Update the leave status in your database using your adminSetLeaveStatus function
      $result = $conn->adminSetLeaveStatus($leave_id, $new_status);
    
      // Check if the update was successful and redirect accordingly
      if ($result) {
        header("location: ".$_SERVER['PHP_SELF']);
        exit;
      } else {
        // Handle the error if the update failed
        echo "Error: Failed to update the leave status.";
      }
    }

    if (isset($_POST['toggleButton'])) {
      $conn->toggleLeaveButtonStatus();
      header('Location: dashboard.php');
    }
    
?>

<?php include 'sidebar/leave_sidebar.php';?>
<html>
<head>
  <style>
    /* Style rows with "Pending" status */
    tr.status-pending {
      background-color: #fffccc !important; /* light yellow */
    }

    /* Style rows with "Rejected" status */
    tr.status-rejected {
      background-color: #FFCCCC !important; /* light red */
    }

    /* Style rows with "Approved" status */
    tr.status-approved {
      background-color: #D9FBD9 !important; /* light green */
    }

    td.reason{ /* truncates after 142 characters */
      max-width: 350px;
      word-wrap: break-word; 
      /* overflow: hidden; Optional: hide overflow content */
      /* text-overflow: ellipsis; Optional: show ellipsis for truncated content */
      /* white-space: nowrap; Optional: prevent line breaks */
    }
    .my-btn{
      width: 100px;
    }
  </style>
</head>
<body>
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
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-building"></i></span>
             <?php 
                  $conn = new class_model();
                  $dept = $conn->count_numberofdepartment();
             ?>
              <div class="info-box-content">
                <span class="info-box-text">Number of Department</span>
                <?php foreach ($dept as $row): ?>
                <span class="info-box-number">
                   <?= $row['department_id']; ?>
                </span>
               <?php endforeach;?>
              </div>

            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
            <?php 
                  $conn = new class_model();
                  $emp = $conn->count_numberofemployees();
             ?>

              <div class="info-box-content">
             <span class="info-box-text">Number of Employees</span>
                <?php foreach ($emp as $row): ?>
                   <span class="info-box-number">
                   <?= $row['employee_id']; ?>
                </span>
               <?php endforeach;?>
              </div>
            </div>
          </div>

          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-clock"></i></span>
            <?php 
                  $conn = new class_model();
                  $att = $conn->count_numberofattendance();
             ?>

              <div class="info-box-content">
               <span class="info-box-text">Number of Attendance</span>
                <?php foreach ($att as $row): ?>
                   <span class="info-box-number">
                   <?= $row['attendance_id']; ?>
                </span>
               <?php endforeach;?>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>
            <?php 
                  $conn = new class_model();
                  $att = $conn->count_numberoftimeInOutToday();
             ?>
              <div class="info-box-content">
                               <span class="info-box-text">Number of In/Out Today</span>
                <?php foreach ($att as $row): ?>
                   <span class="info-box-number">
                   <?= $row['attendance_ids']; ?>
                </span>
               <?php endforeach;?>

              </div>
            </div>
          </div>
        </div>
        <br>    
        <h3 class="m-0 text-dark">Leave Requests</h3>
        <br>          
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              <form method="post">
                  <button type="submit" name="toggleButton" class="btn <?php echo ($buttonStatus) ? 'btn-danger' : 'btn-primary' ?>">
                      <?php echo ($buttonStatus) ? 'Disable' : 'Enable' ?> Employee Leave Request Form
                  </button>
              </form>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th>Leave Request No.</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Leave Type</th>
                      <th>Reason</th>
                      <th>Requested On</th>
                      <th>Status</th>
                  </tr>
                </thead>
                  <tbody>
                    <?php foreach ($adminFetchLeaveReqs as $leaveRequest) { ?>
                      <?php
                        $statusClass = "";
                        switch ($leaveRequest['status']) {
                          case "Pending":
                            $statusClass = "status-pending";
                            break;
                          case "Rejected":
                            $statusClass = "status-rejected";
                            break;
                          case "Approved":
                            $statusClass = "status-approved";
                            break;
                          case "For Next Approval":
                            $statusClass = "status-pending";
                            break;
                        }
                      ?>
                      <tr class="<?php echo $statusClass; ?>">
                        <td><?php echo $leaveRequest['leave_id']; ?></td>
                        <td><?php echo $leaveRequest['first_name']; ?></td>
                        <td><?php echo $leaveRequest['last_name']; ?></td>
                        <td><?php echo $leaveRequest['datetime_start']; ?></td>
                        <td><?php echo $leaveRequest['datetime_end']; ?></td>
                        <td><?php echo $leaveRequest['leave_type']; ?></td>
                        <td class="reason"><?php echo $leaveRequest['reason']; ?></td>
                        <td><?php echo $leaveRequest['datetime_requested']; ?></td>
                        <td><?php echo $leaveRequest['status']; ?></td>
                        <td>
                        <?php if($leaveRequest["status"] == "Pending") { ?>
                          <form method="post" onsubmit="return confirmAction();">
                            <input type="hidden" name="leave_id" value="<?= $leaveRequest['leave_id'] ?>" />
                            <input type="hidden" name="employee_id" value="<?= $leaveRequest['employee_id'] ?>" />
                            <input type="hidden" name="leave_type" value="<?= $leaveRequest['leave_type'] ?>" />
                            <input type="hidden" name="confirm" id="confirm" />

                            <button type="submit" name="approve" class="btn btn-success btn-block my-btn">Approve</button>
                            <button type="submit" name="reject" class="btn btn-danger btn-block my-btn">Reject</button>
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
        
      </div>
    </section>
  </div>

  <aside class="control-sidebar control-sidebar-dark">
  </aside>

  <?php include 'footer/footer.php';?>
</div>
<script>
function confirmAction() {
    return confirm("Are you sure you want to accept or reject this leave request?");
}
</script>
<script>
function handleClick() {
  // Submit the form
  document.getElementById('toggleButton').submit();
}
</script>
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
