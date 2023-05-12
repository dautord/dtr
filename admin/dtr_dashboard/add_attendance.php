<?php include 'header/main_header.php';?>
<?php include 'sidebar/main_sidebar.php';?>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Attendance</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Add Attendance</li>
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
                <!-- <div class="card-header">
                  <h3 class="card-title">Add Attendance</h3>
                </div> -->
                <div class="card-body">
                <form method="post" action="handle_attendance_submission.php">
                <div class="form-group">
                  <label for="employee_qrcode">Employee QR Code:</label>
                  <input type="text" class="form-control" id="employee_qrcode" name="employee_qrcode" required>
                </div>
                <div class="form-group">
                  <label for="time_in">Time In:</label>
                  <input type="datetime-local" class="form-control" id="time_in" name="time_in" required>
                </div>
                <div class="form-group">
                  <label for="time_out">Time Out:</label>
                  <input type="datetime-local" class="form-control" id="time_out" name="time_out" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Attendance</button>
                </form>
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
