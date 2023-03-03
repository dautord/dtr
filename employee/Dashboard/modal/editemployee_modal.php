
<div class="modal fade" id="edit-employee">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-edit"></i> Edit Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
        <div id="emp_edit"></div>
        <form method = "POST" autocomplete="off">
              <div class = "form-group">
                  <label>Employee ID No.:</label>
                  <input type = "text"  id = "edit_employeeidno" alt="employee_idno"  class = "form-control" readonly/>
                </div>
<!--                   <div class = "form-group">
                  <label>Password:</label>
                  <input type = "password"  id = "password" alt="password"  maxlength="15" minlength="6" class = "form-control" placeholder="atleast 6 digit" />
                </div> -->
                <div class = "form-group">
                  <label>Firstname:</label>
                  <input type = "text" id="edit_firstname" alt="first_name" class = "form-control" />
                </div>
                <div class = "form-group">
                  <label>Middlename:</label>
                  <input type = "text"  placeholder = "(Optional)" id="edit_middlename" alt="middle_name" class = "form-control" />
                </div>
                <div class = "form-group">
                  <label>Lastname:</label>
                  <input type = "text" id="edit_lastname" alt="last_name"  class = "form-control" />
                </div>
                   <div class = "form-group">
                  <label>Birthday:</label>
                  <input type = "date"  id = "edit_bdate" alt="bdate" class = "form-control" />
                </div>

               <div class = "form-group">
                  <label>Complete Address:</label>
                  <input type = "text" id="edit_completeaddress" alt="complete_address" class = "form-control" />
                </div>
                    <div class = "form-group">
                  <label>Contact Number:</label>
                  <input type = "Number" minlength="11" maxlength="11"  id = "edit_cnumber" alt="cnumber" class = "form-control" />
                </div>
   
                <div class = "form-group">
                <label>Gender:</label>
                <select class = "form-control" id = "edit_gender">
                   <option value = "">&larr; Select Gender &rarr;</option>
                    <option value = "Male">Male</option>
                    <option value = "Female">Female</option>
                </select>
                </div>
                  <div class = "form-group">
                <label>Civil status:</label>
                <select class = "form-control" id = "edit_civilstatus">
                   <option value = "">&larr; Select Civil Status &rarr;</option>
                   <option value = "Single">Single</option>
                   <option value = "Married">Married</option>
                   <option value = "Divorce">Divorce</option>
                </select>
                </div>
                  <div class = "form-group">
                  <label>Date hire:</label>
                  <input type = "date" id="edit_datehire"  alt = "datehire" class = "form-control" />
                </div>
            
                <div class = "form-group">
                  <label>Designation:</label>
                  <input type = "text" id="edit_designation" alt="designation"  class = "form-control" />
                </div>

                <div class = "form-group">
                  <label>Department:</label>
                <select class = "form-control" id = "edit_department" />
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
        <input type="hidden" id="edit_employeeid">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="update-employee">Update</button>
      </div>
    </form>
    </div>
  </div>
</div>

      <script>
          document.addEventListener('DOMContentLoaded', () => {
              let btn = document.querySelector('#update-employee');
              btn.addEventListener('click', () => {

                  const employee_idno = document.querySelector('input[id=edit_employeeidno]').value;
                  // const password = document.querySelector('input[id=password]').value;
                  const first_name = document.querySelector('input[id=edit_firstname]').value;
                  const middle_name = document.querySelector('input[id=edit_middlename]').value;
                  const last_name = document.querySelector('input[id=edit_lastname]').value;
                  const bdate = document.querySelector('input[id=edit_bdate]').value;
                  const complete_address = document.querySelector('input[id=edit_completeaddress]').value;
                  const cnumber = document.querySelector('input[id=edit_cnumber]').value;
                  const gender = $('#edit_gender option:selected').val();
                  const civilstatus = $('#edit_civilstatus option:selected').val();
                  const datehire = document.querySelector('input[id=edit_datehire]').value;
                  const designation = document.querySelector('input[id=edit_designation]').value;
                  const department = $('#edit_department option:selected').val();
                  const employee_id = document.querySelector('input[id=edit_employeeid]').value;


                  var data = new FormData(this.form);

                  data.append('employee_idno', employee_idno);
                  // data.append('password', password);
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
                  data.append('employee_id', employee_id);

                       $.ajax({
                        url: '../../init/controllers/edit_employee.php',
                          type: "POST",
                          data: data,
                          processData: false,
                          contentType: false,
                          async: false,
                          cache: false,
                        success: function(response) {
                          $("#emp_edit").html(response);
                           window.scrollTo(0, 0);
                          },
                          error: function(response) {
                            console.log("Failed");
                          }
                      });
                  // }

              });
          });
      </script>
