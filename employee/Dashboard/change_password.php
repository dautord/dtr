<?php include 'header/main_header.php';?>
<?php include 'sidebar/main_sidebar.php';?>
<?php
// start the session
session_start();

require_once('../../init/model/class_model.php');
$conn = new class_model();

// check if the user is logged in
if (!isset($_SESSION['employee_id'])) {
  // if not, redirect them to the login page
  header('location: login.php');
  exit();
}

// check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // get the user's input
  $new_password = $_POST['new_password'];
  
  // validate the user's input
  // $errors = array();
  // // check if the new password meets any requirements
  // if (strlen($new_password) < 8) {
  //   $errors[] = 'Your new password must be at least 8 characters long';
  // }
  // if (!preg_match('/\d/', $new_password)) {
  //   $errors[] = 'Your new password must contain at least one number';
  // }
  // if (!preg_match('/[A-Z]/', $new_password)) {
  //   $errors[] = 'Your new password must contain at least one uppercase letter';
  // }

  // if there are no errors, update the user's password in the database
  // if (empty($errors)) {
    // update the employee's password in the database
    if ($conn->update_employee_password($_SESSION['employee_id'], $new_password)) {
      // Password updated successfully
      $success = "Password updated successfully.";
      // redirect the employee to the account page
      // header('Location: dashboard.php');
      // exit();
    } else {
      // if the update fails, display an error message
      $error = 'There was an error changing your password. Please try again.';
    }
  // }
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
</style>

</head>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Change Password</h1>
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
                  <label for="new_password">New Password:</label>
                  <input type="password" name="new_password" id="new_password">
                  <br>
                  <input type="submit" value="Change Password">
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
<!-- <!DOCTYPE html>
<html>
<head>
  <title>Change Password</title>
</head>
<body>
  <h1>Change Password</h1>
// <php 
  // display any errors
  // if (!empty($errors)) {
  //   echo '<ul>';
  //   foreach ($errors as $error) {
  //     echo '<li>' . $error . '</li>';
  //   }
  //   echo '</ul>';
  // }
// >
  <form method="post">
    <label for="new_password">New Password:</label>
    <input type="password" name="new_password" id="new_password">
    <br>
    <input type="submit" value="Change Password">
  </form>
</body>
</html> -->
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

