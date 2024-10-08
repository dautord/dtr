
      <div class="modal fade" id="delete-employee">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="fa fa-trash"></i> Delete Employee</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
           <form method="POST">              
            <div id="msg-del"></div>
              <div class="form-group">
                <label for="department" class="control-label">Full Name</label>
                <input type="text" id="delete_fullname" class="form-control form-control-sm" readonly="">
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-primary" data-dismiss="modal">NO</button>
              <input type="hidden" id="delete_employeeid" class="form-control form-control-sm">
              <button type="button" class="btn btn-danger" id="delete_emp">YES</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      <script>
          document.addEventListener('DOMContentLoaded', () => {
              let btn = document.querySelector('#delete_emp');
              btn.addEventListener('click', () => {

                 const employee_id = document.querySelector('input[id=delete_employeeid]').value;

                  var data = new FormData(this.form);

                  data.append('employee_id', employee_id);

                       $.ajax({
                        url: '../../init/controllers/delete_employee.php',
                          type: "POST",
                          data: data,
                          processData: false,
                          contentType: false,
                          async: false,
                          cache: false,
                        success: function(response) {
                          $("#msg-del").html(response);
                          console.log(response);
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
