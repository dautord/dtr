
<?php

	require 'config/connection.php';

	class class_model{

		public $host = db_host;
		public $user = db_user;
		public $pass = db_pass;
		public $dbname = db_name;
		public $conn;
		public $error;
 
		public function __construct(){
			$this->connect();
		}
 
		private function connect(){
			$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
			if(!$this->conn){
				$this->error = "Fatal Error: Can't connect to database".$this->conn->connect_error;
				return false;
			}
		}

		public function login_admin($username, $password){
			$stmt = $this->conn->prepare("SELECT * FROM `tbl_admin` WHERE `username` = ? AND `password` = ?") or die($this->conn->error);
			$stmt->bind_param("ss", $username, $password);
			if($stmt->execute()){
				$result = $stmt->get_result();
				$valid = $result->num_rows;
				$fetch = $result->fetch_array();
				return array(
					'admin_id'=> htmlentities($fetch['admin_id']),
					'count'=>$valid
				);
			}
		}
 
		public function admin_account($admin_id){
			$stmt = $this->conn->prepare("SELECT * FROM `tbl_admin` WHERE `admin_id` = ?") or die($this->conn->error);
		    $stmt->bind_param("i", $admin_id);
			if($stmt->execute()){
				$result = $stmt->get_result();
				$fetch = $result->fetch_array();
				return array(
					'full_name'=> $fetch['full_name']

				);
			}	
		}


		public function add_employee($employee_idno, $password, $first_name, $middle_name, $last_name, $bdate, $caddress, $cnumber,  $gender, $civilstatus, $datehire, $designation, $department, $codeContents){
	       $stmt = $this->conn->prepare("INSERT INTO `tbl_employee` (`employee_idno`, `password`, `first_name`, `middle_name`, `last_name`, `bdate`, `complete_address`, `cnumber`,  `gender`, `civilstatus`, `datehire`, `designation`, `department`, `qr_code`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);
			$stmt->bind_param("ssssssssssssss", $employee_idno, $password, $first_name, $middle_name, $last_name, $bdate, $caddress, $cnumber,  $gender, $civilstatus, $datehire, $designation, $department, $codeContents);
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}

	    public function fetchAll_employees(){ 
            $sql = "SELECT * FROM  tbl_employee";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

        public function edit_employee($employee_idno,  $first_name, $middle_name, $last_name, $bdate, $caddress, $cnumber,  $gender, $civilstatus, $datehire, $designation, $department, $employee_id){

			$sql = "UPDATE `tbl_employee` SET  `employee_idno` = ?, `first_name` = ?, `middle_name` = ?,  `last_name` = ? ,  `bdate` = ?,  `complete_address` = ?,  `cnumber` = ?,  `gender` = ?,  `civilstatus` = ?,  `datehire` = ?,  `designation` = ?,  `department` = ? WHERE employee_id = ?";
			 $stmt = $this->conn->prepare($sql);
			$stmt->bind_param("isssssssssssi", $employee_idno,  $first_name, $middle_name, $last_name, $bdate, $caddress, $cnumber,  $gender, $civilstatus, $datehire, $designation, $department, $employee_id);
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}

		public function delete_employee($employee_id){
           error_reporting(0);
		   $sql="SELECT employee_idno FROM tbl_employee WHERE employee_id = ?";
			$stmt2=$this->conn->prepare($sql);
			$stmt2->bind_param("i", $employee_id);
			$stmt2->execute();
			$result2=$stmt2->get_result();
			$row=$result2->fetch_assoc();
			$imagepath = $_SERVER['DOCUMENT_ROOT']."DTR_Management_system/qrcode_images/".$row['employee_idno'].'.png';//delete the image inside a folder path
			unlink($imagepath);

				$sql = "DELETE FROM tbl_employee WHERE employee_id = ?";
				 $stmt = $this->conn->prepare($sql);
				$stmt->bind_param("i", $employee_id);
				if($stmt->execute()){
					$stmt->close();
					$this->conn->close();
					return true;
				}
			}

         public function fetchAll_attendance(){ 
            $sql = "SELECT * FROM tbl_attendance a INNER JOIN tbl_employee b ON a.employee_qrcode = b.qr_code  WHERE DATE(a.logdate) = CURDATE() ORDER BY a.attendance_id DESC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		 public function fetchAll_empAttendance(){ 
            $sql = "SELECT * FROM tbl_attendance a INNER JOIN tbl_employee b ON a.employee_qrcode = b.qr_code ORDER BY a.attendance_id DESC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		 public function fetchAll_department(){ 
            $sql = "SELECT * FROM tbl_department ORDER BY department_id DESC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		  public function add_department($department_name, $description){
	       $stmt = $this->conn->prepare("INSERT INTO `tbl_department` (`department_name`, `description`) VALUES(?, ?)") or die($this->conn->error);
			$stmt->bind_param("ss", $department_name, $description);
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}

		   public function edit_department($department_name, $description, $employee_id){

			$sql = "UPDATE `tbl_department` SET  `department_name` = ?, `description` = ? WHERE department_id = ?";
			 $stmt = $this->conn->prepare($sql);
			$stmt->bind_param("ssi", $department_name, $description, $employee_id);
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}


         public function delete_department($department_id){

				$sql = "DELETE FROM tbl_department WHERE department_id = ?";
				 $stmt = $this->conn->prepare($sql);
				$stmt->bind_param("i", $department_id);
				if($stmt->execute()){
					$stmt->close();
					$this->conn->close();
					return true;
				}
			}

	    public function login_employee($employee_idno, $password){
			$stmt = $this->conn->prepare("SELECT * FROM `tbl_employee` WHERE `employee_idno` = ? AND `password` = ?") or die($this->conn->error);
			$stmt->bind_param("is", $employee_idno, $password);
			if($stmt->execute()){
				$result = $stmt->get_result();
				$valid = $result->num_rows;
				$fetch = $result->fetch_array();
				return array(
					'employee_id'=> htmlentities($fetch['employee_id']),
					'count'=>$valid
				);
			}
		}
		public function update_employee_password($employee_id, $new_password) {
			// $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT); hash optional
			$sql = "UPDATE tbl_employee SET password = '$new_password' WHERE employee_id = '$employee_id'";
			$result = $this->conn->query($sql);
			if ($result === TRUE) {
					return true; // return true if the update was successful
			} else {
					return false; // return false if the update failed
			}
		}

		public function getEmployeeLeaves($employee_id) {
			$query = "SELECT department, gender, sick_leave, vacation_leave, paternal_leave, maternal_leave, emergency_leave, solo_parent_leave 
								FROM tbl_employee 
								WHERE employee_id = $employee_id";
			$result = $this->conn->query($query);
			$row = $result->fetch_assoc();
			$gender = $row['gender'];
			$department = $row['department'];
			return $row;
	}
	
		public function getLeaveRequests($employee_id) {
			$query = "SELECT leave_id, datetime_start, datetime_end, leave_type, reason, datetime_requested, status
								FROM tbl_leave_request JOIN tbl_employee ON tbl_leave_request.employee_id = tbl_employee.employee_id
								WHERE tbl_employee.employee_id = $employee_id";
			$result = $this->conn->query($query);
			$rows = array();
			while ($row = $result->fetch_assoc()) {
					$rows[] = $row;
			}
			return $rows;
		}

		public function submitLeaveRequest($employee_id, $datetime_start, $datetime_end, $leave_type, $reason, $datetime_requested, $status)
		{
				$stmt = $this->conn->prepare("INSERT INTO `tbl_leave_request` (`employee_id`, `datetime_start`, `datetime_end`, `leave_type`, `reason`, `datetime_requested`, `status` ) VALUES (?, ?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("issssss", $employee_id, $datetime_start, $datetime_end, $leave_type, $reason, $datetime_requested, $status);

				if ($stmt->execute()) {
						$stmt->close();
						$this->conn->close();
						return true;
				} else {
						return false;
				}
		}

		public function cancelLeaveRequest($leave_id){

			$sql = "DELETE FROM tbl_leave_request WHERE leave_id = ?";
			$stmt = $this->conn->prepare($sql);
		 	$stmt->bind_param("i", $leave_id);

			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}

		public function employee_account($employee_id){
			$stmt = $this->conn->prepare("SELECT * FROM `tbl_employee` WHERE `employee_id` = ?") or die($this->conn->error);
		    $stmt->bind_param("i", $employee_id);
			if($stmt->execute()){
				$result = $stmt->get_result();
				$fetch = $result->fetch_array();
				return array(
					'first_name'=> $fetch['first_name'],
					'last_name'=> $fetch['last_name']

				);
			}	
		}
		public function adminGetLeaveRequests($leave_id){
			$stmt = "SELECT tbl_leave_request.*,
			tbl_employee.first_name,
			tbl_employee.last_name,
			tbl_employee.sick_leave,
			tbl_employee.vacation_leave,
			tbl_employee.paternal_leave,
			tbl_employee.maternal_leave,
			tbl_employee.emergency_leave,
			tbl_employee.solo_parent_leave
			FROM tbl_leave_request
			INNER JOIN tbl_employee
			ON tbl_leave_request.employee_id = tbl_employee.employee_id";
			$result = $this->conn->query($stmt);
			$rows = array();
			while ($row = $result->fetch_assoc()) {
					$rows[] = $row;
			}
			return $rows;
		}

	
	    public function fetchindividual_employee($employee_id){ 
	            $sql = "SELECT * FROM  tbl_employee WHERE `employee_id` = ?";
					$stmt = $this->conn->prepare($sql);
					$stmt->bind_param("i", $employee_id);
					$stmt->execute();
					$result = $stmt->get_result();
			        $data = array();
			         while ($row = $result->fetch_assoc()) {
			                   $data[] = $row;
			            }
			         return $data;

			  }

         public function fetchindividual_empAttendance($employee_id){ 
            $sql = "SELECT * FROM tbl_attendance a INNER JOIN tbl_employee b ON a.employee_qrcode = b.qr_code WHERE b.employee_id = ? ORDER BY a.attendance_id DESC";
				$stmt = $this->conn->prepare($sql);
				$stmt->bind_param("i", $employee_id);
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		   public function count_numberofdepartment(){ 
            $sql = "SELECT COUNT(department_id) as department_id FROM tbl_department ORDER BY department_id DESC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }


		  public function count_numberofemployees(){ 
            $sql = "SELECT COUNT(employee_id) as employee_id FROM tbl_employee ORDER BY employee_id DESC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		  public function count_numberofattendance(){ 
            $sql = "SELECT COUNT(attendance_id) as attendance_id FROM tbl_attendance ORDER BY attendance_id DESC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		    public function count_numberoftimeInOutToday(){ 
            $sql = "SELECT COUNT(attendance_id) as attendance_ids  FROM tbl_attendance  WHERE DATE(logdate) = CURDATE() ORDER BY attendance_id DESC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		   public function count_numberofattendanceIndividualEmp($employee_id){ 
            $sql = "SELECT COUNT(a.attendance_id) as attendance_ids  FROM tbl_attendance a INNER JOIN tbl_employee b ON a.employee_qrcode = b.qr_code WHERE b.employee_id = ? ORDER BY a.attendance_id DESC";
				$stmt = $this->conn->prepare($sql);
				$stmt->bind_param("i", $employee_id);
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }

		  public function count_numberofemployeesIndividualEmp($employee_id){ 
            $sql = "SELECT COUNT(employee_id) as employee_id FROM tbl_employee WHERE employee_id = ? ORDER BY employee_id DESC";
				$stmt = $this->conn->prepare($sql);
				$stmt->bind_param("i", $employee_id);
				$stmt->execute();
				$result = $stmt->get_result();
		        $data = array();
		         while ($row = $result->fetch_assoc()) {
		                   $data[] = $row;
		            }
		         return $data;

		  }
	
	}	
?>