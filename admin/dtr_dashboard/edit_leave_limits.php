<?php include 'header/main_header.php';?>
<!-- headers already sent fix: bring include sidebar to AFTER redirecting -->
<?php 

$conn = new class_model();
$departments = $conn->getDepartmentLeaveLimits();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $deptId = '';
  $sickLimit = '';
  $vacationLimit = '';
  $paternalLimit = '';
  $maternalLimit = '';
  $magnaCartaLimit = '';
  $emergencyLimit = '';
  $soloParentLimit = '';

  if(!is_null($departments)) {

    foreach ($departments as $dept) {

      $deptId = $dept['department_id'];

      if(isset($_POST['sickLimit'][$deptId])) {
        $sickLimit = $_POST['sickLimit'][$deptId];
      }
      if(isset($_POST['vacationLimit'][$deptId])) {
        $vacationLimit = $_POST['vacationLimit'][$deptId];
      }
      if(isset($_POST['paternalLimit'][$deptId])) {
        $paternalLimit = $_POST['paternalLimit'][$deptId];
      }
      if(isset($_POST['maternalLimit'][$deptId])) {
        $maternalLimit = $_POST['maternalLimit'][$deptId];
      }
      if(isset($_POST['magnaCartaLimit'][$deptId])) {
        $magnaCartaLimit = $_POST['magnaCartaLimit'][$deptId];
      }
      if(isset($_POST['emergencyLimit'][$deptId])) {
        $emergencyLimit = $_POST['emergencyLimit'][$deptId];
      }
      if(isset($_POST['soloParentLimit'][$deptId])) {
        $soloParentLimit = $_POST['soloParentLimit'][$deptId];
      }

		$success = $conn->updateDepartmentLeaveLimits($deptId, $sickLimit, $vacationLimit, $paternalLimit, $maternalLimit, $magnaCartaLimit, $emergencyLimit, $soloParentLimit);
      
	  } 
  }
  
  if ($success){
    header('location: manage_department.php');
    exit();
  }
}   
?>
<?php include 'sidebar/main_sidebar.php';?>


<style>
  .limit-table {
    border-collapse: collapse;
    width: 100%;
  }

  .limit-table th, .limit-table td {
    text-align: left;
    padding: 8px;
  }

  .limit-table tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  .limit-table th {
    background-color: #f2f2f2;
    border-bottom: 2px solid #ddd;
    border-top: 2px solid #ddd;
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
  }

  .limit-table td {
    border-bottom: 1px solid #ddd;
    border-left: 1px solid #ddd;
  }

  
</style>


  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Department Leave Limits</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Manage Department</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <!-- Edit -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12"> 
            <div class="card">
              <div class="card-header">
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <form method="post">
                    <table class="limit-table">
                      <tr>
                        <th>Department Name</th>
                        <th>Sick Leave Limit</th>
                        <th>Vacation Leave Limit</th>
                        <th>Paternal Leave Limit</th>
                        <th>Maternal Leave Limit</th>
                        <th>Magna Carta For Women Leave Limit</th>
                        <th>Emergency Leave Limit</th>
                        <th>Solo Parent Leave Limit</th>
                      </tr>
                      <?php foreach ($departments as $dept): ?>
                      <tr>
                        <td><?php echo $dept['department_name'] ?></td>
                        <td><input type="number" name="sickLimit[<?php echo $dept['department_id'] ?>]" value="<?php echo $dept['sick_leave_limit'] ?>"></td>
                        <td><input type="number" name="vacationLimit[<?php echo $dept['department_id'] ?>]" value="<?php echo $dept['vacation_leave_limit'] ?>"></td>
                        <td><input type="number" name="paternalLimit[<?php echo $dept['department_id'] ?>]" value="<?php echo $dept['paternal_leave_limit'] ?>"></td>
                        <td><input type="number" name="maternalLimit[<?php echo $dept['department_id'] ?>]" value="<?php echo $dept['maternal_leave_limit'] ?>"></td>
                        <td><input type="number" name="magnaCartaLimit[<?php echo $dept['department_id'] ?>]" value="<?php echo $dept['magna_carta_leave_limit'] ?>"></td>
                        <td><input type="number" name="emergencyLimit[<?php echo $dept['department_id'] ?>]" value="<?php echo $dept['emergency_leave_limit'] ?>"></td>
                        <td><input type="number" name="soloParentLimit[<?php echo $dept['department_id'] ?>]" value="<?php echo $dept['solo_parent_leave_limit'] ?>"></td>
                      </tr>
                      <?php endforeach; ?>
                    </table>   
                  <button type="submit" class="btn btn-primary float-sm-left">Save</button>
                  </form>
                </div>
              </div>
              <div class="card-footer">
                
              </div>
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
