  <?php include 'header/main_header.php';?>
  <?php include 'sidebar/main_sidebar.php';?>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Manage Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Manage Report</li>
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
<!--               <div class="card-header">
                 <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modal-default">
                 <i class="fa fa-plus"></i> Add Attendance
                </button>
              </div> --><br>
              <div class = "form-inline" style="margin-left: 10px">
                <label>Date:</label>
                <input type = "text" class = "form-control" placeholder = "Start"  id = "date1" autocomplete="off" />
                <label>To</label>
                <input type = "text" class = "form-control" placeholder = "End"  id = "date2"  autocomplete="off"/>
                <button type = "button" class = "btn btn-primary" id = "btn_search"><i class = "fa fa-search"></i></button> <button type = "button" id = "reset" class = "btn btn-warning"><i class="fa fa-sync"></i></button>
              </div>

              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>QR Code</th>
                    <th>EmployeeID No.</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Log Date</th>        
                  </tr>
                  </thead>
                  <tbody id = "load_data">
                 <?php 
                      $conn = new class_model();
                      $emp = $conn->fetchAll_empAttendance();
                  ?>
                <?php foreach ($emp as $row) { ?>
                  <tr>
                    <td><?= $row['qr_code']; ?></td>
                    <td><?= $row['employee_idno']; ?></td>
                    <td><?= $row['first_name']; ?></td>
                    <td><?= $row['last_name']; ?></td>
                    <td><?= $row['time_in']; ?></td>
                    <td><?= $row['time_out']; ?></td>
                    <td><?= htmlentities(date("M d, Y",strtotime($row['logdate']))); ?></td>


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


<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/demo.js"></script>

<script src = "js/jquery-3.1.1.js"></script>
<script src = "js/jquery-ui.js"></script>
 <script type="text/javascript">
      $(document).ready(function(){
      $('#date1').datepicker();
      $('#date2').datepicker();
      $('#btn_search').on('click', function(){  
        if($('#date1').val() == "" || $('#date2').val() == ""){
          alert("Please enter Date 'From' and 'To' before submit");
        }else{
          $date1 = $('#date1').val();
          $date2 = $('#date2').val();
          $('#load_data').empty();
          $loader = $('<tr ><td colspan = "7"><center>Searching....</center></td></tr>');
          $loader.appendTo('#load_data');
          setTimeout(function(){
            $loader.remove();
            $.ajax({
              url: '../../init/controllers/attendance_report.php',
              type: 'POST',
              data: {
                date1: $date1,
                date2: $date2
              },
              success: function(res){
                $('#load_data').html(res);
              }
            });
          }, 1000);
        } 
      });
      
      $('#reset').on('click', function(){
        location.reload();
      });
    });
</script>

  <script>
  $( function() {
    $( "#date1" ).datepicker();
  } );
  </script>
  <script>
  $( function() {
    $( "#date2" ).datepicker();
  } );
  </script>

<!-- <script>
  $(function () {
    $("#example1").DataTable({
    });

  });

</script> -->
</body>
</html>
