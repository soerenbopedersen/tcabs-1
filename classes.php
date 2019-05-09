<?php

	// Define different classes with relevant and useful functions here

	require("db-conn.php");	// connect to database

	class Permission {
		public $permissions;

		public function __construct($userType) {
			$this->permissions = array();

			/*
			$sql = "SELECT procName FROM Functions AS F 
							INNER JOIN Permission AS P ON F.procName = P.procName
							INNER JOIN UserRole AS UR ON P.userType = UR.userType  
							INNER JOIN UserCat AS UC ON UR.userType = UC.userType  
							WHERE UC.email = '" . "?" . "';";

			$result = $GLOBALS['conn']->prepare($sql);
			$result->bind_param("s", $userEmail);
			$result->execute();
			*/

			// might need to use sub queries in the future
			$sql = "SELECT procName FROM Functions AS F 
							INNER JOIN Permission AS P ON F.functionID = P.functionID
							INNER JOIN UserRole AS UR ON P.userType = UR.userType  
							INNER JOIN UserCat AS UC ON UR.userType = UC.userType  
							WHERE P.userType = '" . $userType . "';";

			$result = $GLOBALS['conn']->query($sql);

			if($GLOBALS['conn']->error) {
				echo $GLOBALS['conn']->error;
			} else {
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$this->permissions[$row["procName"]] = true;
					}
				}
			}
		}
	}

	class User extends Permission{
		public $fName;
		public $lName;
		public $userType;
		public $email;
		public $gender;
		private $pwd;	// hidden to outside classes and functions
		public $pNum;

		public function __construct($userEmail) {

			// Cannot get this to work
			/*
			$sql = "SELECT * FROM Users WHERE email = '" . "?" . "';";
			$result = $GLOBALS['conn']->prepare($sql);
			$result->bind_param('s', $userEmail);
			$result->execute();
			*/

			$sql = "SELECT * FROM Users WHERE email = '" . $userEmail . "';";
			$result = $GLOBALS['conn']->query($sql);

			if($GLOBALS['conn']->error) {
				echo $GLOBALS['conn']->error;
			} else {
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$this->fName = $row['fName'];
						$this->lName = $row['lName'];
						$this->userType = $row['userRoleID'];
						$this->email = $row['email'];
						$this->gender = $row['gender'];
						$this->pwd = $row['pwd'];
						$this->pNum = $row['pNum'];
 	   			}
				}
			}
			//parent::__construct($this->userType);
		}

		function userExist() {
			if($this->email != null) {
				return TRUE;
			} else {
				echo 'ljklasjdlkfj';
				return FALSE;
			}
		}

		public function checkPwd($userPwd) {
			// $salt = "tcabs";
			//$password_encrypted = sha1($_POST['pwd']);

			if($userPwd == $this->pwd) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}
?>
