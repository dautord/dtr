  <?php include 'header/main_header.php';?>
  <?php include 'sidebar/main_sidebar.php';?>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Department</h1>
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

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
    
            <div class="card">
              <div class="card-header">
                 <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modal-department">
                 <i class="fa fa-plus"></i> Add Department
                </button>
              </div>

              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Department Name</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                 <?php 
                      $conn = new class_model();
                      $dep = $conn->fetchAll_department();
                  ?>
                <?php foreach ($dep as $row) { ?>
                  <tr>

                    <td><?= $row['department_name']; ?></td>
                    <td><?= $row['description']; ?></td>
                    <td class="align-right">
                        <i class="fa fa-edit edit_D" style="color: blue" data-toggle="modal" data-target="#edit-department" data-id="<?= htmlentities($row['department_id']); ?>"></i> | <i class="fa fa-trash-alt delete_D" style="color: red" data-toggle="modal" data-target="#delete-department" data-del="<?= htmlentities($row['department_id']); ?>"></i>
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
 <?php include 'modal/adddepartment_modal.php';?>
 <?php include 'modal/editdepartment_modal.php';?>
 <?php include 'modal/deletedepartment_modal.php';?>
 <script>
       $(document).ready(function() {   
           load_data();    
           var count = 1; 
           function load_data() {
               $(document).on('click', '.edit_D', function() {
                    var department_id = $(this).data("id");
                    console.log(department_id);
                      get_Id(department_id); //argument    
             
               });
            }

             function get_Id(department_id) {
                  $.ajax({
                      type: 'POST',
                      url: 'fetch_row/department_row.php',
                      data: {
                          department_id: department_id
                      },
                      dataType: 'json',
                      success: function(response) {
                      $('#edit_employeeid').val(response.department_id);
                      $('#edit_departmentname').val(response.department_name);
                      $('#edit_description').val(response.description);

                   }
                });
             }
       
       });
        
 </script>
  <script>
       $(document).ready(function() {   
           load_data();    
           var count = 1; 
           function load_data() {
               $(document).on('click', '.delete_D', function() {
                    var department_id = $(this).data("del");
                    console.log(department_id);
                      get_delId(department_id); //argument    
             
               });
            }

             function get_delId(department_id) {
                  $.ajax({
                      type: 'POST',
                      url: 'fetch_row/department_row.php',
                      data: {
                          department_id: department_id
                      },
                      dataType: 'json',
                      success: function(response2) {
                      $('#delete_departmentid').val(response2.department_id);
                      $('#delete_departmentname').val(response2.department_name);
      
                   }
                });
             }
       
       });
        
 </script>
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
