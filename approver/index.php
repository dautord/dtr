<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }

    .button {
      background-color: #d6a92b; /* Green */
      border: none;
      color: white;
      padding: 16px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      transition-duration: 0.4s;
      cursor: pointer;
    }

    .button1 {
      background-color: white; 
      color: black; 
      border: 2px solid #d6a92b;
    }

    .button1:hover {
      background-color: #d6a92b;
      color: white;
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
      <div class="card">
          <div class="card-header text-center">Approver Login</div>
          <div class="card-body">
              <form method="post" action="login_approver.php" name="login_form">
                  <div class="form-group">
                      <input class="form-control form-control-lg" id="username" name="username" type="text" placeholder="Username" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                      <input class="form-control form-control-lg" id="password" name="password" type="password" placeholder="Password" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                      <label class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" id="remember" onclick="myFunction()">
                          <span class="custom-control-label">Show Password</span>
                      </label>
                  </div>
                  <div class="form-group">
                      <button class="btn btn-lg btn-block button1" type="submit" value="Sign in" id="btn-approver" name="btn-approver">Sign in</button>
                  </div>
                  <div class="form-group" id="alert-msg"></div>
              </form>
          </div>
      </div>
  </div>

  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script type="text/javascript">
      document.oncontextmenu = document.body.oncontextmenu = function() {return false;} //disable right click
    </script>
    <script>
            function myFunction() {
              var x = document.getElementById("password");
              if (x.type === "password") {
                x.type = "text";
              } else {
                x.type = "password";
              }
            }
     </script>
    </body>
</html>