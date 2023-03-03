  <?php 

       error_reporting(0);

       include 'init/model/config/connection2.php';
      if(isset($_POST['employee_qrcode'])){

            date_default_timezone_set("asia/manila");
             $emp = trim($_POST['employee_qrcode']);
             $date = date('Y-m-d');
            //$time = date('h:i A');
             $time =  date('h:i:A', strtotime("+0 HOURS"));
             $stat = 0;
             $stat2 = 1;


            $stmt1 = $conn->prepare("SELECT * FROM tbl_employee WHERE qr_code = ?");
            $stmt1->bind_param("s", $emp);
            $stmt1->execute();
            $result1 = $stmt1->get_result();

          if($result1->num_rows <= 0){
              echo "<div class='alert alert-warning' role='alert' style='font-size:18px'><p><b><i class='fas fa-exclamation-triangle'></i>  Your QR Code does not register</b></p></div>";

          }else{
          
            $stmt2 = $conn->prepare("SELECT * FROM tbl_attendance WHERE employee_qrcode = ? AND logdate = ? AND status = '0'") or die($conn->error);
            $stmt2->bind_param("ss", $emp, $date);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

          if($result2->num_rows > 0){


          }else{

              $stmt = $conn->prepare("INSERT INTO tbl_attendance(employee_qrcode,time_in,logdate, status) VALUES (?, ?, ?, ?)");
              $stmt->bind_param("sssi", $emp, $time, $date, $stat);
              $result = $stmt->execute();

              if($result === TRUE){
                echo "<div class='alert alert-success' role='alert' style='font-size:22px'><h4><i class='fa fa-clock'></i>  Time In</h4><b>Your Time In: </b> ".$time."</div>";

              }else{
                 echo "<div class='alert alert-danger' role='alert'>Error</div>";  
              }

           }

        }

     }
       $conn->close();

 ?>