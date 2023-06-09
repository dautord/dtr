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
        <form id="add-employee-form" autocomplete="off">
          <div class="form-group">
            <label>Employee ID No.:</label>
            <input type="text" id="employee_idno" alt="employee_idno" value="" class="form-control">
          </div>
          <div class="form-group">
            <label for="qrCode">QR Code</label>
            <input type="file" class="form-control-file" id="qrCode" name="qrCode" required accept=".png, .jpg, .jpeg">
          </div>
          <div class="form-group">
            <label>Password:</label>
            <input type="password" id="password" alt="password" maxlength="15" minlength="6" class="form-control" placeholder="at least 6 digits, optional" />
          </div>
          <div class="form-group">
            <label>Firstname:</label>
            <input type="text" id="first_name" alt="first_name" class="form-control" />
          </div>
          <div class="form-group">
            <label>Middlename:</label>
            <input type="text" placeholder="(Optional)" id="middle_name" alt="middle_name" class="form-control" />
          </div>
          <div class="form-group">
            <label>Lastname:</label>
            <input type="text" id="last_name" alt="last_name" class="form-control" />
          </div>
          <div class="form-group">
            <label>Birthday:</label>
            <input type="date" id="bdate" alt="bdate" class="form-control" />
          </div>
          <div class="form-group">
            <label>Complete Address:</label>
            <input type="text" id="complete_address" alt="complete_address" class="form-control" />
          </div>
          <div class="form-group">
            <label>Contact Number:</label>
            <input type="Number" minlength="11" maxlength="11" id="cnumber" alt="cnumber" class="form-control" />
          </div>
          <div class="form-group">
            <label>Gender:</label>
            <select class="form-control" id="gender">
              <option value="">&larr; Select Gender &rarr;</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <div class="form-group">
            <label>Civil status:</label>
            <select class="form-control" id="civilstatus">
              <option value="">&larr; Select Civil Status &rarr;</option>
              <option value="Single">Single</option>
              <option value="Married">Married</option>
              <option value="Divorce">Divorce</option>
            </select>
          </div>
          <div class="form-group">
            <label>Date hire:</label>
            <input type="date" id="datehire" alt="datehire" class="form-control" />
          </div>
          <div class="form-group">
            <label>Designation:</label>
            <input type="text" id="designation" alt="designation" class="form-control" />
          </div>
          <div class="form-group">
            <label>Department:</label>
            <select class="form-control" id="department">
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
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('#add-employee-form');
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      addEmployee();
    });

    function addEmployee() {
      const employee_idno = document.querySelector('input[alt=employee_idno]').value;
      const password = document.querySelector('input[alt=password]').value;
      const first_name = document.querySelector('input[alt=first_name]').value;
      const middle_name = document.querySelector('input[alt=middle_name]').value;
      const last_name = document.querySelector('input[alt=last_name]').value;
      const bdate = document.querySelector('input[alt=bdate]').value;
      const complete_address = document.querySelector('input[alt=complete_address]').value;
      const cnumber = document.querySelector('input[alt=cnumber]').value;
      const gender = document.querySelector('#gender').value;
      const civilstatus = document.querySelector('#civilstatus').value;
      const datehire = document.querySelector('input[alt=datehire]').value;
      const designation = document.querySelector('input[alt=designation]').value;
      const department = document.querySelector('#department').value;

      const qrCodeInput = document.querySelector('input[name=qrCode]');
      const qrCodeFile = qrCodeInput.files[0];

      if (
        first_name.trim() === '' ||
        last_name.trim() === '' ||
        employee_idno.trim() === '' ||
        department.trim() === '' ||
        gender.trim() === ''
      ) {
        document.querySelector('#emp').innerHTML = '<div class="alert alert-danger">ID, QR Code, First Name, Last Name, Gender, and Department fields are required.</div>';
      } else if (!qrCodeFile) {
        document.querySelector('#emp').innerHTML = '<div class="alert alert-danger">QR Code field is required.</div>';
      } else {
        const formData = new FormData();
        formData.append('employee_idno', employee_idno);
        formData.append('password', password);
        formData.append('first_name', first_name);
        formData.append('middle_name', middle_name);
        formData.append('last_name', last_name);
        formData.append('bdate', bdate);
        formData.append('complete_address', complete_address);
        formData.append('cnumber', cnumber);
        formData.append('gender', gender);
        formData.append('civilstatus', civilstatus);
        formData.append('datehire', datehire);
        formData.append('designation', designation);
        formData.append('department', department);
        formData.append('qrCode', qrCodeFile);

        $.ajax({
          url: '../../init/controllers/add_employee.php',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          async: false,
          cache: false,
          success: function (response) {
            // Check if the employee was added successfully
            if (response.indexOf('alert-success') !== -1) {
              // Redirect back to manage_employee.php after successful add
              window.location.href = 'manage_employee.php';
            } else {
              // If there was an error while adding the employee, display the error message
              $('#emp').html(response);
              window.scrollTo(0, 0);
            }
          },
          error: function (response) {
            console.log('Failed');
          },
        });
      }
    }
  });
</script>

