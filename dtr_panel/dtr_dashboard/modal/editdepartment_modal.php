
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
                  <textarea  type = "text" rows="2" id="edit_description" alt="description" class = "form-control" /></textarea>
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
  


                  var data = new FormData(this.form);

                  data.append('department_name', department_name);
                  data.append('description', description);
                  data.append('employee_id', employee_id);



                       $.ajax({
                        url: '../../init/controllers/edit_department.php',
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
                //   }

              });
          });
      </script>
