
<div class="modal fade" id="modal-department">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-building"></i> New Department</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-body">
        <div id="emp"></div>
        <form method = "POST" autocomplete="off">

                <div class = "form-group">
                  <label>Department Name:</label>
                  <input type = "text" id="department_name" alt="department_name" class = "form-control" />
                </div>
                <div class = "form-group">
                  <label>Description:</label>
                  <textarea  type = "text" rows="2" id="description" alt="description" class = "form-control" /></textarea>
                </div>

        </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add-depart">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>

      <script>
          document.addEventListener('DOMContentLoaded', () => {
              let btn = document.querySelector('#add-depart');
              btn.addEventListener('click', () => {

                  const department_name = document.querySelector('input[alt=department_name]').value;
                  const description = document.querySelector('textarea[alt=description]').value;
  


                  var data = new FormData(this.form);

                  data.append('department_name', department_name);
                  data.append('description', description);



              if (department_name === '' ||  description ===''){
                      $('#emp').html('<div class="alert alert-danger"> Required All Fields!</div>');
                    }else{
                       $.ajax({
                        url: '../../init/controllers/add_department.php',
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
