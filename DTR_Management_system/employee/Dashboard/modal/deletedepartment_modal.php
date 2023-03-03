
      <div class="modal fade" id="delete-department">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><i class="fa fa-trash"></i> Delete Department</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
           <form method="POST">              
            <div id="msg-del"></div>
              <div class="form-group">
                <label for="department" class="control-label">Department Name</label>
                <input type="text" id="delete_departmentname" class="form-control form-control-sm" readonly="">
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
              <input type="hidden" id="delete_departmentid" class="form-control form-control-sm">
              <button type="button" class="btn btn-primary" id="delete_dept">YES</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      <script>
          document.addEventListener('DOMContentLoaded', () => {
              let btn = document.querySelector('#delete_dept');
              btn.addEventListener('click', () => {

                 const department_id = document.querySelector('input[id=delete_departmentid]').value;

                  var data = new FormData(this.form);

                  data.append('department_id', department_id);

                       $.ajax({
                        url: '../../init/controllers/delete_department.php',
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
