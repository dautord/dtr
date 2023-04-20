<?php 
// include header and sidebar
include 'header/main_header.php';
include 'sidebar/main_sidebar.php';

// start the session
session_start();

// include class_model.php
require_once('../../init/model/class_model.php');
$conn = new class_model();
date_default_timezone_set('Asia/Manila');
$buttonStatus = $conn->getLeaveButtonStatus();


// check if the user is logged in
if (!isset($_SESSION['employee_id'])) {
  // if not, redirect them to the login page
  header('location: login.php');
  exit();
}

if ($buttonStatus == 0){
  http_response_code(404);
  header('location: dashboard.php');
  exit();
}

// get the employee ID
$employee_id = $_SESSION['employee_id'];
 // get the employee's gender, department
 $emp = $conn->getEmployeeLeaves($employee_id);
 $gender = $emp['gender'];
 $department = $emp['department'];
 $sickLeave = $emp['sick_leave'];
 $vacationLeave = $emp['vacation_leave'];
 $paternalLeave = $emp['paternal_leave'];
 $maternalLeave = $emp['maternal_leave'];
 $emergencyLeave = $emp['emergency_leave'];
 $soloParentLeave = $emp['solo_parent_leave'];
 $remainingBalance = 0;


// check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get the user's input
  $datetime_start = $_POST['start_date'];
  $datetime_end = $_POST['end_date'];
  $num_of_days = $_POST['num_of_days'];
  $leave_type = $_POST['leave_type']; 
  $reason = $_POST['reason'];
  $datetime_requested = date('Y-m-d H:i:s');
  $status = 'Pending';
  
  switch ($leave_type) {
    case 'sick':
        $remainingBalance = $sickLeave;
        break;
    case 'vacation':
        $remainingBalance = $vacationLeave;
        break;
    case 'paternal':
        $remainingBalance = $paternalLeave;
        break;
    case 'maternal':
        $remainingBalance = $maternalLeave;
        break;
    case 'emergency':
        $remainingBalance = $emergencyLeave;
        break;
    case 'solo parent':
        $remainingBalance = $soloParentLeave;
        break;
    default:
        // handle invalid leave type
        break;
  }
 
  if ($num_of_days <= $remainingBalance) {
    // submit the leave request
    $conn->submitLeaveRequest($employee_id, $datetime_start, $datetime_end, $num_of_days, $leave_type, $reason, $datetime_requested, $status);
    // display a success message
    $success = "Leave request submitted successfully.";
  } elseif ($num_of_days > $remainingBalance) {
    // if the submission fails, display an error message
    $error = 'There was an error submitting your leave request. Your requested number of days exceed your current leave balance for that type. Please double check your balance and try again.';
  } else {
    $error = 'There was an error submitting your leave request. Please try again.';
  }
}

?>

<html>
<head>

<style>
  .alert {
  font-size: 14px; /* set the font size */
  padding: 8px; /* add some padding */
  margin-bottom: 8px; /* add some margin */
}

.alert-success {
  background-color: #d4edda; /* set the background color */
  color: #155724; /* set the text color */
  border: 1px solid #c3e6cb; /* set the border color */
}

.alert-danger {
  background-color: #f8d7da; /* set the background color */
  color: #721c24; /* set the text color */
  border: 1px solid #f5c6cb; /* set the border color */
}
.reason-container {
    display: flex;
    flex-direction: column;
  }

  .reason-container label {
    margin-bottom: 0.5rem;
  }
</style>

</head>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Leave Request</h1>
          </div>
          <!-- <div class="col-sm-6"> TOP RIGHT, ALIGNED WITH HEADER -->
            <!-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">My Information</li>
            </ol> -->
          <!-- </div> -->
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                
                <form method="post">
                    <!-- gets the employee id in tbl_employee -->
                    <input type="hidden" name="employee_id" value="<?php echo $_SESSION['employee_id']; ?>">
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" required><br>

                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date" required><br>

                    <label for="num_of_days">No. of Days:</label>
                    <input type="decimal" id="num_of_days" name="num_of_days" placeholder="(e.g. 0.5 if half day)" required><br>

                    <label for="leave_type">Type of Leave:</label>
                    <select id="leave_type" name="leave_type" required>
                      <option value="">--Please select--</option>
                      <option value="sick">Sick Leave</option>
                      <?php if ($department === 'Non-Teaching Department'):  ?>
                      <option value="vacation">Vacation Leave</option>
                      <?php endif; ?>
                      <?php if ($gender === 'Male'):  ?>
                        <option value="paternal">Paternal Leave</option>
                      <?php endif; ?>
                      <?php if ($gender === 'Female'):  ?>
                        <option value="maternal">Maternal Leave</option>
                      <?php endif; ?>
                      <option value="vacation">Emergency Leave</option>
                      <option value="solo parent">Parental Leave (Solo Parent Act)</option>
                      <option value="other">Other</option>
                    </select><br>
                    <div class="reason-container">
                    <label for="reason">Reason:</label>
                    <textarea id="reason" name="reason" required></textarea><br>
                    </div>
                    <br>
                    <input type="submit" class="btn btn-primary" value="Submit">
                </form>
                <?php if(isset($success)): ?>
                  <div class="alert alert-success" id="success"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if(isset($error)): ?>
                  <div class="alert alert-danger" id="error"><?php echo $error; ?></div>
                <?php endif; ?>
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
<script>
    setTimeout(function() {
        $("#success").fadeOut();
        $("#error").fadeOut();
    }, 10000); // 5000 milliseconds = 5 seconds
</script>

