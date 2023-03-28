
<div class="modal fade" id="edit-department">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-building"></i> Edit Department</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
        <div id="emp_edit"></div>
        <form method = "POST" autocomplete="off">

                <div class = "form-group">
                  <label>Department Name:</label>
                  <input type = "text" id="edit_departmentname" alt="department_name" class = "form-control" />
                </div>
                <div class = "form-group">
                  <label>Description:</label>
                  <textarea  type = "text" rows="2" id="edit_description" alt="description" class = "form-control" ></textarea>
                </div>
                <div class = "form-group">
                  <label for="late_time">Late Time:</label>
                  <input type = "time" id="edit_latetime" alt="late_time" value="00:00" class = "form-control" />
                </div>

        </div>
      <div class="modal-footer justify-content-between">
        <input type="hidden" id="edit_employeeid">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="edit-depart">Update</button>
      </div>
    </form>
    </div>
  </div>
</div>

      <script>
          document.addEventListener('DOMContentLoaded', () => {
              let btn = document.querySelector('#edit-depart');
              btn.addEventListener('click', () => {

                  const department_name = document.querySelector('input[id=edit_departmentname]').value;
                  const description = document.querySelector('textarea[id=edit_description]').value;
                  const employee_id = document.querySelector('input[id=edit_employeeid]').value;
                  const late_time = document.querySelector('input[id=edit_latetime]').value;
                  // const formatted_late_time = late_time + ':00'; // Add seconds to the time value
                  console.log('Late Time: ' + late_time); // Log the late time value

                  


                  var data = new FormData(this.form);

                  data.append('department_name', department_name);
                  data.append('description', description);
                  data.append('employee_id', employee_id);
                  data.append('late_time', late_time);



                       // editdepartment_modal.php

                  $.ajax({
                      url: '../../init/controllers/edit_department.php',
                      type: "POST",
                      data: {
                          department_name: department_name,
                          description: description,
                          employee_id: employee_id,
                          late_time: late_time // Send the late_time value as a separate parameter
                      },
                      success: function(response) {
                          $("#emp_edit").html(response);
                          window.scrollTo(0, 0);
                      },
                      error: function(response) {
                          console.log("Failed");
                      }
                  });
                //   }
              });
          });
      </script>
