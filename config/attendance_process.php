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


            $stmt1 = $conn->prepare("SELECT * FROM tbl_employee WHERE employee_idno = ?");
            $stmt1->bind_param("s", $emp);
            $stmt1->execute();
            $result1 = $stmt1->get_result();

            $stmt4 = $conn->prepare("SELECT * FROM tbl_employee WHERE employee_idno = ?");
            $stmt4->bind_param("s", $emp);
            $stmt4->execute();
            $result4 = $stmt4->get_result();

            // GET NAME
            // $stmt = $conn->prepare("SELECT qr_codeno FROM tbl_employee");
            // // $stmt->bind_param("ss", $date, $date);
            // $stmt->execute();
            // $result5 = $stmt->get_result();
            // if($result5->num_rows > 0)
            // {
            //   while($row =  $result5->fetch_assoc())
            //   {
            //     $fName = $row['first_name'];
            //     $lastName = $row['last_name'];
            //     $emp_ID = $row['qr_codeno'];
            //   }
            // }

              //      <?= $row['qr_codeno'];
            //        <?= $row['first_name']; 
                 //   <?= $row['last_name']; 
                //    <?= $row['time_in']; 
               //     <?= $row['time_out']; 
                //    <?= htmlentities(date("M d, Y",strtotime($row['logdate'])));




          if($result1->num_rows <= 0){
              echo "<div class='alert alert-warning' role='alert' style='font-size:18px'><p><b><i class='fas fa-exclamation-triangle'></i>  Your QR Code does not register</b></p></div>";

          }else{
          
            $stmt2 = $conn->prepare("SELECT * FROM tbl_attendance WHERE employee_qrcode = ? AND logdate = ? AND status = '0'") or die($conn->error);
            $stmt2->bind_param("ss", $emp, $date);
            $stmt2->execute();
            $result2 = $stmt2->get_result();



          if($result2->num_rows > 0){
              while($row2 =  $result4->fetch_assoc())
              {
                $fName = $row2['first_name'];
                $lastName = $row2['last_name'];
                $emp_ID = $row2['qr_codeno'];
              }

              $sql = "UPDATE tbl_attendance SET time_out = '$time', status = '1' WHERE employee_qrcode = '$emp' AND logdate = '$date'";
              $query = $conn->query($sql);

              

              

              // $result = $stmt->execute();

              if($query === TRUE){
                echo "<div class='alert alert-success' role='alert' style='font-size:22px'><h4><i class='fa fa-clock'></i>  Time Out</h4><b>Your Time Out: </b> ".$time."<br>".$lastName.", ".$fName."</div>";

              }else{
                 echo "<div class='alert alert-danger' role='alert'>Error</div>";  
              }

           }else{

            while($row2 =  $result4->fetch_assoc())
              {
                $fName = $row2['first_name'];
                $lastName = $row2['last_name'];
                $emp_ID = $row2['qr_codeno'];
              }

              $stmt = $conn->prepare("INSERT INTO tbl_attendance(employee_qrcode,time_in,logdate, status) VALUES (?, ?, ?, ?)");
              $stmt->bind_param("sssi", $emp, $time, $date, $stat);
              $result = $stmt->execute();

              if($result === TRUE){
                echo "<div class='alert alert-success' role='alert' style='font-size:22px'><h4><i class='fa fa-clock'></i>  Time In</h4><b>Your Time In: </b> ".$time."<br>".$lastName.", ".$fName."</div>";

              }else{
                 echo "<div class='alert alert-danger' role='alert'>Error</div>";  
              }

           }

        }

     }
       $conn->close();

 ?>