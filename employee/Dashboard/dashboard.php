<?php include 'header/main_header.php';?>
<?php include 'sidebar/main_sidebar.php';?>
<?php 
  
  $employee_id = $_SESSION['employee_id'];
  $conn = new class_model();
  $emp = $conn->getEmployeeLeaves($employee_id);
  $leaveRequests = $conn->getLeaveRequests($employee_id);
  $buttonStatus = $conn->getLeaveButtonStatus();
  
  // Fetch the gender data
  $gender = $emp['gender'];
  $department = $emp['department'];

  // check if the user is logged in
  if (!isset($_SESSION['employee_id'])) {
    // if not, redirect them to the login page
    header('location: login.php');
    exit();
  }

  if (isset($_POST['cancel'])){
    $leave_id = $_POST["leave_id"];
    $confirm = $_POST["confirm"];
  
    if ($confirm == "yes") {
      $cancelLeave = $conn->cancelLeaveRequest($leave_id);
  
      if($cancelLeave) {
        echo "<script>alert('Leave request canceled successfully.')</script>";
        header('location: dashboard.php');
        exit();
      } else {
        echo "<script>alert('Error canceling leave request.')</script>";
      }
    }
  }

  
?>

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

    #leave-button.disabled {
      background-color: #ccc; 
      color: #000;
      cursor: not-allowed;
      text-decoration: none;
      pointer-events: none;
    }

  </style>
</head>
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

      <!-- Paternal Leave Info Box -->
      <?php if ($gender === 'Male'): ?>
        <div class="col-md-4">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-baby-carriage"></i></span>
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

      <!-- Vacation Leave Info Box -->
      <?php if ($department === 'Non-Teaching Department'): ?>
      <div class="col-md-4">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-island-tropical"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Vacation Leave</span>
            <span class="info-box-number"><?= $emp['vacation_leave'] ?></span>
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
      

    </div>
    <br>    
    <h3 class="m-0 text-dark">Leave History</h3>
    <br>
   
    <br>
  </div>

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div style="display:flex; justify-content:space-between;">
                  <a href="leave_request.php" id="leave-button" class="btn btn-md btn-primary text-center" style="height: 40px; max-width: 200px;">Request for Leave</a>
                  <a href="lwop_request.php" id="leave-button" class="btn btn-md btn-primary text-center" style="height: 40px; max-width: 200px;">Request for LWOP</a>
                </div>
              </div>
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
                        }
                      ?>
                      <tr class="<?php echo $statusClass; ?>">
                        <td><?php echo $leaveRequest['leave_id']; ?></td>
                        <td><?php echo $leaveRequest['datetime_start']; ?></td>
                        <td><?php echo $leaveRequest['datetime_end']; ?></td>
                        <td><?php echo $leaveRequest['leave_type']; ?></td>
                        <td class="reason"><?php echo $leaveRequest['reason']; ?></td>
                        <td><?php echo $leaveRequest['datetime_requested']; ?></td>
                        <td><?php echo $leaveRequest['status']; ?></td>
                        <td>
                          <?php if($leaveRequest["status"] == "Pending") { ?>
                            <form method="post" onsubmit="return confirmCancel();">
                            <input type="hidden" name="leave_id" value="<?= $leaveRequest['leave_id'] ?>" />
                            <input type="hidden" name="confirm" id="confirm" />

                            <button type="submit" name="cancel" class="btn btn-danger">Cancel</button>
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
<script>
  var leaveButton = document.getElementById('leave-button');
  if (<?php echo $buttonStatus ?> == 0) {
    leaveButton.classList.add('disabled');
    leaveButton.onclick = function(event) {
      event.preventDefault();
    };
  } else {
    leaveButton.classList.remove('disabled');
    leaveButton.onclick = null;
  }
</script>
<script>
function confirmCancel() {
  if (confirm("Are you sure you want to cancel this leave request?")) {
    document.getElementById("confirm").value = "yes";
    return true;
  } else {
    return false;
  }
}
</script>
<script>
  $(document).ready(function() {
  // Disable the leave request button if the leave button status is disabled
  if (<?php echo $buttonStatus ?> === 0) {
    $("#leaveRequestButton").prop("disabled", true);
  }
});
</script>

</body>
</html>
