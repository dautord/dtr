  <?php include 'header/main_header.php';?>
  <?php include 'sidebar/main_sidebar.php';?>
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
