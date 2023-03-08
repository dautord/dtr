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


// check if the user is logged in
if (!isset($_SESSION['employee_id'])) {
  // if not, redirect them to the login page
  header('location: login.php');
  exit();
}

// get the employee ID
$employee_id = $_SESSION['employee_id'];

// check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get the user's input
  $datetime_start = $_POST['start_date'];
  $datetime_end = $_POST['end_date'];
  $leave_type = $_POST['leave_type']; 
  $reason = $_POST['reason'];
  $datetime_requested = date('Y-m-d H:i:s');
  $status = 'Pending';

  // get the employee's gender
  $emp = $conn->getEmployeeLeaves($employee_id);
  $gender = $emp['gender'];
  
  // submit the leave request
  $sub = $conn->submitLeaveRequest($employee_id, $datetime_start, $datetime_end, $leave_type, $reason, $datetime_requested, $status);
  
  if ($sub) {
    // display a success message
    $success = "Leave request submitted successfully.";
  } else {
    // if the submission fails, display an error message
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
                    <input type="datetime-local" id="start_date" name="start_date" required><br>

                    <label for="end_date">End Date:</label>
                    <input type="datetime-local" id="end_date" name="end_date" required><br>

                    <label for="leave_type">Type of Leave:</label>
                    <select id="leave_type" name="leave_type" required>
                      <option value="">--Please select--</option>
                      <option value="sick">Sick Leave</option>
                      <option value="vacation">Vacation Leave</option>
                      <?php if ($gender === 'Male'):  ?>
                        <option value="personal">Paternal Leave</option>
                      <?php endif; ?>
                      <?php if ($gender === 'Female'):  ?>
                        <option value="personal">Maternal Leave</option>
                      <?php endif; ?>
                      <option value="vacation">Emergency Leave</option>
                      <option value="personal">Parental Leave (Solo Parent Act)</option>
                      <option value="vacation">Other</option>
                    </select><br>
                    <div class="reason-container">
                    <label for="reason">Reason:</label>
                    <textarea id="reason" name="reason" required></textarea><br>
                    </div>
                    <br>
                    <input type="submit" value="Submit">
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
    }, 5000); // 5000 milliseconds = 5 seconds
</script>

