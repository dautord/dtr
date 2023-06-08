  <?php include 'header/main_header.php';?>
  <?php include 'sidebar/main_sidebar.php';?>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Employee</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Manage Employee</li>
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
                 <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modal-default">
                 <i class="fa fa-plus"></i> Add Employee
                </button>
                <!-- Button to trigger the modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
                  Upload QR Code
                </button>
                

                <!-- Modal -->
                <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Upload QR Code</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Form to upload QR code -->
                        <p>Note: Make sure to add the employee first before uploading their QR code.</p>
                        <p>Note: Filename of QR Code must be identical to employee number to reflect their respective QR codes in the QR Image column (e.g. 0911.png for employee 0911).</p>
                        <form action="upload_qr_code.php" method="POST" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="employeeId">Employee ID</label>
                            <input type="text" class="form-control" id="employeeId" name="employee_id" required>
                          </div>
                          <div class="form-group">
                            <label for="qrCode">QR Code</label>
                            <input type="file" class="form-control-file" id="qrCode" name="qr_code" required accept=".png, .jpg, .jpeg">
                          </div>
                          <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>QR Image</th>
                    <th>EmployeeID No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Password</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                 <?php 
                      $conn = new class_model();
                      $emp = $conn->fetchAll_employees();
                  ?>
                <?php foreach ($emp as $row) { ?>
                  <tr>
                    <td><center><img src="../../qrcode_images/<?= $row['employee_idno']; ?>.png" width="50px" height="50px"></center></td>
                    <td><?= $row['qr_code']; ?></td>
                    <td><?= $row['first_name']; ?></td>
                    <td><?= $row['last_name']; ?></td>
                    <td><?= $row['designation']; ?></td>
                    <td><?= $row['department']; ?></td>
                    <td><?= $row['password']; ?></td>
                    <td class="align-right">
                        <i class="fa fa-edit edit_E" style="color: blue" data-toggle="modal" data-target="#edit-employee" data-id="<?= htmlentities($row['employee_id']); ?>"></i> | <i class="fa fa-trash-alt delete_E" style="color: red" data-toggle="modal" data-target="#delete-employee" data-del="<?= htmlentities($row['employee_id']); ?>"></i>
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
 <?php include 'modal/addemployee_modal.php';?>
 <?php include 'modal/editemployee_modal.php';?>
 <?php include 'modal/deleteemployee_modal.php';?>

<script>
  $(document).ready(function() {
    // Handle the click event for the upload QR code icon
    $('.upload_QR').click(function() {
      var employeeId = $(this).data('id');
      $('#employee-id').val(employeeId);
    });

    // Handle the form submission for uploading QR code
    $('#upload-qr-form').submit(function(event) {
      event.preventDefault();

      var employeeId = $('#employee-id').val();
      var qrCodeFile = $('#qr-code').prop('files')[0];
      var formData = new FormData();
      formData.append('employee_id', employeeId);
      formData.append('qr_code', qrCodeFile);

      $.ajax({
        url: 'upload_qr_code.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          // Reload the page after successful upload
          location.reload();
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
      });
    });
  });
</script>
 <script>
       $(document).ready(function() {   
           load_data();    
           var count = 1; 
           function load_data() {
               $(document).on('click', '.edit_E', function() {
                    var employee_id = $(this).data("id");
                    console.log(employee_id);
                      get_Id(employee_id); //argument    
             
               });
            }

             function get_Id(employee_id) {
                  $.ajax({
                      type: 'POST',
                      url: 'fetch_row/employee_row.php',
                      data: {
                          employee_id: employee_id
                      },
                      dataType: 'json',
                      success: function(response) {
                      $('#edit_employeeid').val(response.employee_id);
                      $('#edit_employeeidno').val(response.employee_idno);
                      $('#edit_password').val(response.password);
                      $('#edit_firstname').val(response.first_name);
                      $('#edit_middlename').val(response.middle_name);
                      $('#edit_lastname').val(response.last_name);
                      $('#edit_bdate').val(response.bdate);
                      $('#edit_completeaddress').val(response.complete_address);
                      $('#edit_cnumber').val(response.cnumber);
                      $('#edit_gender').val(response.gender);
                      $('#edit_civilstatus').val(response.civilstatus);
                      $('#edit_datehire').val(response.datehire);
                      $('#edit_designation').val(response.designation);
                      $('#edit_department').val(response.department);
                      $('#edit_sickleave').val(response.sick_leave);    
                      $('#edit_vacationleave').val(response.vacation_leave); 
                      $('#edit_paternalleave').val(response.paternal_leave); 
                      $('#edit_maternalleave').val(response.maternal_leave);
                      $('#edit_magnacartaleave').val(response.magna_carta_leave);
                      $('#edit_emergencyleave').val(response.emergency_leave);
                      $('#edit_soloparentleave').val(response.solo_parent_leave);

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
               $(document).on('click', '.delete_E', function() {
                    var employee_id = $(this).data("del");
                    console.log(employee_id);
                      get_delId(employee_id); //argument    
             
               });
            }

             function get_delId(employee_id) {
                  $.ajax({
                      type: 'POST',
                      url: 'fetch_row/employee_row.php',
                      data: {
                          employee_id: employee_id
                      },
                      dataType: 'json',
                      success: function(response2) {
                      $('#delete_employeeid').val(response2.employee_id);
                      $('#delete_fullname').val(response2.first_name + ' '+ response2.last_name);
      
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
