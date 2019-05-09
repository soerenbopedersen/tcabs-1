<?php

	// Define different classes with relevant and useful functions here

	require("db-conn.php");	// connect to database

	class Permission {
		public $permissions;

		public function __construct($userEmail) {
			$this->permissions = array();

			//$sql = "SELECT procName FROM Functions AS F 
			//				INNER JOIN Permission AS P ON F.functionID = P.functionID
			//				INNER JOIN UserRole AS UR ON P.userRoleID = UR.userRoleID  
			//				WHERE P.userRoleID = ?";

			//$result = $GLOBALS['conn']->prepare($sql);
			//$result->bind_param("i", $roleID);
			//$result->execute();

			$sql = "SELECT procName FROM Functions AS F 
							INNER JOIN Permission AS P ON F.functionID = P.functionID
							INNER JOIN UserRole AS UR ON P.userRoleID = UR.userRoleID  
							INNER JOIN  AS UR ON P.userRoleID = UR.userRoleID  
							WHERE P.userRoleID = '" . $userRoleID . "';";

			$result = $GLOBALS['conn']->query($sql);

			if($GLOBALS['conn']->error) {
				echo $GLOBALS['conn']->error;
				//return null;
			} else {
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$this->permissions[$row["procName"]] = true;
					}
					//return $userPermissions;
				} //else {
					//return null;
				//}
			}
		}

		//protected function getPermissions($roleID) {
	//		$userPermissions = new Permission();

	//	}
	}

	class User extends Permission{
		public $userID;
		public $fName;
		public $lName;
		public $userRoleID;
		public $email;
		public $gender;
		private $pwd;	// hidden to outside classes and functions
		public $pNum;

		public function __construct($userEmail) {

			// Cannot get this to work
			//$sql = "SELECT * FROM Users WHERE email = ?;";
			//$result = $GLOBALS['conn']->prepare($sql) or die($GLOBALS['conn']->error);
			//$result->bind_param('s', $userEmail);
			//$result->execute();

			$sql = "SELECT * FROM Users WHERE email = '" . $userEmail . "';";
			$result = $GLOBALS['conn']->query($sql);

			if($GLOBALS['conn']->error) {
				echo $GLOBALS['conn']->error;
				//return null;
			} else {
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$this->userID = $row['userID'];
						$this->fName = $row['fName'];
						$this->lName = $row['lName'];
						$this->userRoleID = $row['userRoleID'];
						$this->email = $row['email'];
						$this->gender = $row['gender'];
						$this->pwd = $row['pwd'];
						$this->pNum = $row['pNum'];
 	   			}
					//return $User;
				} //else {
					//return null;
				//}
			}
			parent::__construct($this->userRoleID);
		}

		public function userExist() {
			//$sql = "SELECT email FROM Users WHERE email = '" . $userEmail . "';";
			//$result = $GLOBALS['conn']->query($sql);

			//if($GLOBALS['conn']->error) {
				//return null;
			//} else {
				//if($result->num_rows > 0) {
					//return TRUE;
				//} else {
					//return null;
				//}
			//}
			if($this->userID != null) {
				return TRUE;
			} else {
				echo 'ljklasjdlkfj';
				return FALSE;
			}
		}

		public function checkPwd($userPwd) {
			//$user = new User();
			//$user = $user::getUser($userEmail);

			// $salt = "tcabs";
			//$password_encrypted = sha1($_POST['pwd']);

			if($userPwd == $this->pwd) {
				return TRUE;
			} else {
				return FALSE;
			}
		}

		//public static function getUser($userEmail) {
			//$User = new User();

		//}
	}
?>
