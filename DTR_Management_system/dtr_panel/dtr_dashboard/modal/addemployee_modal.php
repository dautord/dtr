
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-user"></i> New Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
        <div id="emp"></div>
        <form method = "POST" autocomplete="off">
                <?php 
                  $digits = 6;
                  $newNum = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
                ?>
            
              <div class = "form-group">
                  <label>Employee ID No.:</label>
                  <input type = "text"  id = "employee_idno" alt="employee_idno" value="<?php echo $newNum; ?>"  class = "form-control" readonly/>
                </div>
                  <div class = "form-group">
                  <label>Password:</label>
                  <input type = "password"  id = "password" alt="password"  maxlength="15" minlength="6" class = "form-control" placeholder="atleast 6 digit" />
                </div>
                <div class = "form-group">
                  <label>Firstname:</label>
                  <input type = "text" id="first_name" alt="first_name" class = "form-control" />
                </div>
                <div class = "form-group">
                  <label>Middlename:</label>
                  <input type = "text"  placeholder = "(Optional)" id="middle_name" alt="middle_name" class = "form-control" />
                </div>
                <div class = "form-group">
                  <label>Lastname:</label>
                  <input type = "text" id="last_name" alt="last_name"  class = "form-control" />
                </div>
                   <div class = "form-group">
                  <label>Birthday:</label>
                  <input type = "date"  id = "bdate" alt="bdate" class = "form-control" />
                </div>

               <div class = "form-group">
                  <label>Complete Address:</label>
                  <input type = "text" id="complete_address" alt="complete_address" class = "form-control" />
                </div>
                    <div class = "form-group">
                  <label>Contact Number:</label>
                  <input type = "Number" minlength="11" maxlength="11"  id = "cnumber" alt="cnumber" class = "form-control" />
                </div>
   
                <div class = "form-group">
                <label>Gender:</label>
                <select class = "form-control" id = "gender">
                   <option value = "">&larr; Select Gender &rarr;</option>
                    <option value = "Male">Male</option>
                    <option value = "Female">Female</option>
                </select>
                </div>
                  <div class = "form-group">
                <label>Civil status:</label>
                <select class = "form-control" id = "civilstatus">
                   <option value = "">&larr; Select Civil Status &rarr;</option>
                   <option value = "Single">Single</option>
                   <option value = "Married">Married</option>
                   <option value = "Divorce">Divorce</option>
                </select>
                </div>
                  <div class = "form-group">
                  <label>Date hire:</label>
                  <input type = "date" id="datehire"  alt = "datehire" class = "form-control" />
                </div>
            
                <div class = "form-group">
                  <label>Designation:</label>
                  <input type = "text" id="designation" alt="designation"  class = "form-control" />
                </div>

                <div class = "form-group">
                  <label>Department:</label>
                <select class = "form-control" id = "department" />
                  <option value=""> &larr; Select Department Option &rarr;</option>
                  <?php 
                    include '../../init/model/config/connection2.php';
                    $sql = "SELECT department_name FROM `tbl_department`";
                    $stmt = $conn->prepare($sql); 
                    $stmt->execute();
                    $result = $stmt->get_result();
                    foreach ($result as $row) {
                  ?>
                  <option value="<?php echo $row['department_name'] ?>"><?php echo $row['department_name'] ?></option>
                 <?php } ?>
                </select>

                </div>
        </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add-employee">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>

      <script>
          document.addEventListener('DOMContentLoaded', () => {
              let btn = document.querySelector('#add-employee');
              btn.addEventListener('click', () => {

                  const employee_idno = document.querySelector('input[alt=employee_idno]').value;
                  const password = document.querySelector('input[alt=password]').value;
                  const first_name = document.querySelector('input[alt=first_name]').value;
                  const middle_name = document.querySelector('input[alt=middle_name]').value;
                  const last_name = document.querySelector('input[alt=last_name]').value;
                  const bdate = document.querySelector('input[alt=bdate]').value;
                  const complete_address = document.querySelector('input[alt=complete_address]').value;
                  const cnumber = document.querySelector('input[alt=cnumber]').value;
                  const gender = $('#gender option:selected').val();
                  const civilstatus = $('#civilstatus option:selected').val();
                  const datehire = document.querySelector('input[alt=datehire]').value;
                  const designation = document.querySelector('input[alt=designation]').value;
                  const department = $('#department option:selected').val();


                  var data = new FormData(this.form);

                  data.append('employee_idno', employee_idno);
                  data.append('password', password);
                  data.append('first_name', first_name);
                  data.append('middle_name', middle_name);
                  data.append('last_name', last_name);
                  data.append('bdate', bdate);
                  data.append('complete_address', complete_address);
                  data.append('cnumber', cnumber);
                  data.append('gender', gender);
                  data.append('civilstatus', civilstatus);
                  data.append('datehire', datehire);
                  data.append('designation', designation);
                  data.append('department', department);


              if (first_name === '' ||  last_name ==='' ||  bdate ==='' ||  complete_address ===''||  cnumber ===''){
                      $('#emp').html('<div class="alert alert-danger"> Required All Fields!</div>');
                    }else{
                       $.ajax({
                        url: '../../init/controllers/add_employee.php',
                          type: "POST",
                          data: data,
                          processData: false,
                          contentType: false,
                          async: false,
                          cache: false,
                        success: function(response) {
                          $("#emp").html(response);
                           window.scrollTo(0, 0);
                          },
                          error: function(response) {
                            console.log("Failed");
                          }
                      });
                   }

              });
          });
      </script>
