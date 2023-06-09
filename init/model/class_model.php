
<?php

	require 'config/connection.php';
	// require_once '../../log_helper.php';
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

		public function login_approver($username, $password){
			$stmt = $this->conn->prepare("SELECT * FROM `tbl_approver` WHERE `username` = ? AND `password` = ?") or die($this->conn->error);
			$stmt->bind_param("ss", $username, $password);
			if ($stmt->execute()) {
					$result = $stmt->get_result();
					$valid = $result->num_rows;
					$fetch = $result->fetch_array();
					return array(
							'approver_id' => htmlentities($fetch['approver_id']),
							'count' => $valid
					);
			}
		}
		public function approver_account($approver_id){
			$stmt = $this->conn->prepare("SELECT * FROM `tbl_approver` WHERE `approver_id` = ?") or die($this->conn->error);
			$stmt->bind_param("i", $approver_id);
			if($stmt->execute()){
					$result = $stmt->get_result();
					$fetch = $result->fetch_array();
					return array(
							'fullname'=> $fetch['fullname']
					);
			}   
		}
	




		public function add_employee($employee_idno, $password, $first_name, $middle_name, $last_name, $bdate, $caddress, $cnumber,  $gender, $civilstatus, $datehire, $designation, $department, $qr_code, $codeContents) {
			$stmt = $this->conn->prepare("INSERT INTO `tbl_employee` (`employee_idno`, `password`, `first_name`, `middle_name`, `last_name`, `bdate`, `complete_address`, `cnumber`,  `gender`, `civilstatus`, `datehire`, `designation`, `department`, `qr_code`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);
			$stmt->bind_param("ssssssssssssss", $employee_idno, $password, $first_name, $middle_name, $last_name, $bdate, $caddress, $cnumber,  $gender, $civilstatus, $datehire, $designation, $department, $qr_code);
			if ($stmt->execute()) {
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

      public function edit_employee($employee_idno, $password, $first_name, $middle_name, $last_name, $bdate, $caddress, $cnumber,  $gender, 
			$civilstatus, $datehire, $designation, $department, $sick_leave, $vacation_leave, $paternal_leave, $maternal_leave, $magna_carta_leave,
			$emergency_leave, $solo_parent_leave, $employee_id){

			$sql = "UPDATE `tbl_employee` SET  `employee_idno` = ?, `password` = ?, `first_name` = ?, `middle_name` = ?,  `last_name` = ? ,  `bdate` = ?,  `complete_address` = ?,  `cnumber` = ?,  `gender` = ?,  `civilstatus` = ?,  `datehire` = ?,  `designation` = ?,  `department` = ?, `sick_leave` = ?, `vacation_leave` = ?, `paternal_leave` = ?, `maternal_leave` = ?, `magna_carta_leave` = ?, `emergency_leave` = ?, `solo_parent_leave` = ? WHERE employee_id = ?";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("sssssssssssssiiiiiiii", $employee_idno, $password, $first_name, $middle_name, $last_name, $bdate, $caddress, $cnumber,  $gender, $civilstatus, $datehire, $designation, $department, $sick_leave, $vacation_leave, $paternal_leave, $maternal_leave, $magna_carta_leave, $emergency_leave, $solo_parent_leave, $employee_id);
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
		}
			public function update_qr_code($employee_idno, $qr_code_path) {
				$sql = "UPDATE `tbl_employee` SET `qr_code` = ? WHERE `employee_idno` = ?";
				$stmt = $this->conn->prepare($sql);
				$stmt->bind_param("si", $qr_code_path, $employee_idno);
				if ($stmt->execute()) {
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
			$imagepath = $_SERVER['DOCUMENT_ROOT']."dtr/qrcode_images/".$row['employee_idno'].'.png';//delete the image inside a folder path
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
		
		public function fetchLateTime(){ 
			$sql = "SELECT c.department_name, c.late_time, c.under_time FROM tbl_attendance a 
					INNER JOIN tbl_employee b ON a.employee_qrcode = b.qr_code 
					INNER JOIN tbl_department c ON b.department = c.department_name
					ORDER BY a.attendance_id DESC";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->get_result();
			$data = array();
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
			return $data;
		}

		public function fetchAll_departmentName(){ 
			$sql = "SELECT department_name FROM tbl_department ORDER BY department_id DESC";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->get_result();
			$data = array();
			while ($row = $result->fetch_assoc()) {
				$data[] = $row['department_name']; // Fetch only the "department_name" column
			}
			return $data;
		}

		public function updateDepartmentWorkWeek($department, $workDays) {
			$sql = "UPDATE tbl_department SET work_week = ? WHERE department_name = ?";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("ss", $workDays, $department);
			$stmt->execute();
			$stmt->close();
		}

		public function fetchIndividualEmpDeptData($employeeId) {
			$sql = "SELECT b.department_name, b.late_time, b.work_week 
					FROM tbl_employee a 
					INNER JOIN tbl_department b ON a.department = b.department_name
					WHERE a.employee_id = ?";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("i", $employeeId); // Bind the employeeId parameter
			$stmt->execute();
			$result = $stmt->get_result();
			$data = array();
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
			$stmt->close();
			return $data;
		}
		public function add_attendance($employee_qrcode, $time_in, $time_out, $logdate, $status) {
			$stmt = $this->conn->prepare("INSERT INTO `tbl_attendance` (`employee_qrcode`, `time_in`, `time_out`, `logdate`, `status`) VALUES (?, ?, ?, ?, ?)") or die($this->conn->error);
			$stmt->bind_param("ssssi", $employee_qrcode, $time_in, $time_out, $logdate, $status);
			if ($stmt->execute()) {
					$stmt->close();
					$this->conn->close();
					return true;
			}
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

		public function edit_department($department_name, $description, $employee_id, $late_time, $under_time){

			$sql = "UPDATE `tbl_department` SET  `department_name` = ?, `description` = ?, `late_time` = TIME(?), `under_time` = TIME(?) WHERE department_id = ?";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("sssss", $department_name, $description, $late_time, $under_time, $employee_id);
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
			$query = "SELECT department, gender, sick_leave, vacation_leave, paternal_leave, maternal_leave, magna_carta_leave, emergency_leave, solo_parent_leave 
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
								WHERE tbl_employee.employee_id = $employee_id ORDER BY tbl_leave_request.datetime_requested DESC";
						
			$result = $this->conn->query($query);
			$rows = array();
			while ($row = $result->fetch_assoc()) {
					$rows[] = $row;
			}
			return $rows;
		}

		public function submitLeaveRequest($employee_id, $datetime_start, $datetime_end, $num_of_days, $leave_type, $reason, $datetime_requested, $status)
		{
				$stmt = $this->conn->prepare("INSERT INTO `tbl_leave_request` (`employee_id`, `datetime_start`, `datetime_end`, `num_of_days`, `leave_type`, `reason`, `datetime_requested`, `status` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("issdssss", $employee_id, $datetime_start, $datetime_end, $num_of_days, $leave_type, $reason, $datetime_requested, $status);

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
		public function adminGetLeaveRequests(){
			$stmt = "SELECT tbl_leave_request.*,
			tbl_employee.first_name,
			tbl_employee.last_name,
			tbl_employee.sick_leave,
			tbl_employee.vacation_leave,
			tbl_employee.paternal_leave,
			tbl_employee.maternal_leave,
			tbl_employee.magna_carta_leave,
			tbl_employee.emergency_leave,
			tbl_employee.solo_parent_leave
			FROM tbl_leave_request
			INNER JOIN tbl_employee
			ON tbl_leave_request.employee_id = tbl_employee.employee_id
			ORDER BY tbl_leave_request.datetime_requested DESC";
			$result = $this->conn->query($stmt);
			$rows = array();
			while ($row = $result->fetch_assoc()) {
					$rows[] = $row;
			}
			return $rows;
		}

		public function adminSetLeaveStatus($leave_id, $new_status){
			$sql = "UPDATE tbl_leave_request SET status = '$new_status' WHERE leave_id = '$leave_id'";
			$stmt = $this->conn->prepare($sql);
			if($stmt->execute()){
					$stmt->close();
					$this->conn->close();
					return true;
			} else {
					return false;
			}
		}

		public function getDepartmentLeaveLimits() {
		// retrieve leave limits for all departments
			$stmt = $this->conn->prepare("SELECT department_id, department_name, sick_leave_limit, vacation_leave_limit, paternal_leave_limit, maternal_leave_limit, magna_carta_leave_limit, emergency_leave_limit, solo_parent_leave_limit FROM tbl_department");
			$stmt->execute();
			$result = $stmt->get_result();
			$rows = array();
			while ($row = $result->fetch_assoc()) {
				$rows[] = $row;
			}
			return $rows;
		}


		public function updateDepartmentLeaveLimits($deptId, $sickLimit, $vacationLimit, $paternalLimit, $maternalLimit, $magnaCartaLimit, $emergencyLimit, $soloParentLimit) {
			// update leave limits for specified department
			$stmt = $this->conn->prepare("UPDATE tbl_department SET sick_leave_limit=?, vacation_leave_limit=?, paternal_leave_limit=?, maternal_leave_limit=?, magna_carta_leave_limit=?, emergency_leave_limit=?, solo_parent_leave_limit=? WHERE department_id=?");
			$stmt->bind_param("iiiiiiii", $sickLimit, $vacationLimit, $paternalLimit, $maternalLimit, $magnaCartaLimit, $emergencyLimit, $soloParentLimit, $deptId);
			return $stmt->execute();
		}

		public function updateEmployeeLeaveBalance($empId, $sickLimit, $vacationLimit, $paternalLimit, $maternalLimit, $magnaCartaLimit, $emergencyLimit, $soloParentLimit) {
			// update leave balance for specified employee
			$stmt = $this->conn->prepare("UPDATE tbl_employee SET sick_leave=?, vacation_leave=?, paternal_leave=?, maternal_leave=?, magna_carta_leave=?, emergency_leave=?, solo_parent_leave=? WHERE employee_id=?");
			$stmt->bind_param("iiiiiiii", $sickLimit, $vacationLimit, $paternalLimit, $maternalLimit, $magnaCartaLimit, $emergencyLimit, $soloParentLimit, $empId);
			return $stmt->execute();
		}

		public function setDepartmentLeaveBalances() {
			// retrieve leave limits for all departments
			$deptLimits = $this->getDepartmentLeaveLimits();
		
			// loop through departments
			foreach ($deptLimits as $dept) {
				// get employees in department
				$stmt = $this->conn->prepare("SELECT employee_id FROM tbl_employee WHERE department = ?");
				$stmt->bind_param("s", $dept['department_name']);
				$stmt->execute();
				$result = $stmt->get_result();
		
				// loop through employees and update leave balance
				while ($row = $result->fetch_assoc()) {
					$empId = $row['employee_id'];
					$this->updateEmployeeLeaveBalance($empId, $dept['sick_leave_limit'], $dept['vacation_leave_limit'], $dept['paternal_leave_limit'], $dept['maternal_leave_limit'], $dept['magna_carta_leave_limit'], $dept['emergency_leave_limit'], $dept['solo_parent_leave_limit']);
				}
			}
		}
		//function for updating employee leave balance on approved request by admin
		public function calculateEmpLeaveBalanceOnLeaveApproval($empId, $leaveType, $leaveId) {
    
			// get the employee's current leave balance
			$stmt = $this->conn->prepare("SELECT sick_leave, vacation_leave, paternal_leave, maternal_leave, magna_carta_leave, emergency_leave, solo_parent_leave FROM tbl_employee WHERE employee_id = ?");
			$stmt->bind_param("i", $empId);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			// define selected rows for determining leave type based on leave_type, joining tbl_leave_request with tbl_employee
			$sickLeave = $row['sick_leave'];
			$vacationLeave = $row['vacation_leave'];
			$paternalLeave = $row['paternal_leave'];
			$maternalLeave = $row['maternal_leave'];
			$magnaCartaLeave = $row['magna_carta_leave'];
			$emergencyLeave = $row['emergency_leave'];
			$soloParentLeave = $row['solo_parent_leave'];

			// Subtract the number of leave days to the leave balance
			$stmt = $this->conn->prepare("SELECT num_of_days FROM tbl_leave_request WHERE employee_id = ? AND leave_type = ? AND leave_id = ?");
			$stmt->bind_param("isi", $empId, $leaveType, $leaveId);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$numDays = $row['num_of_days'];

			switch ($leaveType) {
					case 'sick':
							$sickLeave -= $numDays;
							break;
					case 'vacation':
							$vacationLeave -= $numDays;
							break;
					case 'paternal':
							$paternalLeave -= $numDays;
							break;
					case 'maternal':
							$maternalLeave -= $numDays;
							break;
					case 'magna carta':
							$magnaCartaLeave -= $numDays;
							break;
					case 'emergency':
							$emergencyLeave -= $numDays;
							break;
					case 'solo parent':
							$soloParentLeave -= $numDays;
							break;
					default:
							// handle invalid leave type
							break;
			}

			// update the employee's leave balance
			$stmt = $this->conn->prepare("UPDATE tbl_employee SET sick_leave = ?, vacation_leave = ?, paternal_leave = ?, maternal_leave = ?, magna_carta_leave = ?, emergency_leave = ?, solo_parent_leave = ? WHERE employee_id = ?");
			$stmt->bind_param("dddddddi", $sickLeave, $vacationLeave, $paternalLeave, $maternalLeave, $magnaCartaLeave, $emergencyLeave, $soloParentLeave, $empId);
			return $stmt->execute();
}
		

		public function getLeaveButtonStatus() {
			$sql = "SELECT status FROM leave_button_status WHERE id = 1";
			$result = $this->conn->query($sql);
			$row = $result->fetch_assoc();
			return $row['status'];
		}
		
		public function toggleLeaveButtonStatus() {
			$query = "SELECT status FROM leave_button_status WHERE id = 1";
			$result = $this->conn->query($query);
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$new_status = $row['status'] == 1 ? 0 : 1;
				$query = "UPDATE leave_button_status SET status = $new_status WHERE id = 1";
				$result = $this->conn->query($query);
				if (!$result) {
					die("Error updating status: " . $this->conn->error);
				}
			}
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
		        while ($row = $result->fetch_assoc()){
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