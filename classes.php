<?php
	// Define different classes with relevant and useful functions here
	require("db-conn.php");	// connect to database

	class Permission {
		public $permissions;

		protected function __construct($userEmail) {
			$this->permissions = array();

			// might need to use sub queries in the future
			//$sql = "SELECT procName FROM Permission AS P 
			//				INNER JOIN UserRole AS UR ON P.userType = UR.userType  
			//				INNER JOIN UserCat AS UC ON UR.userType = UC.userType  
			//				WHERE P.userType = '" . $userType . "';";

			// using subquery
			$sql = "SELECT procName FROM Permission	
							WHERE userType IN (
								SELECT userType 
								FROM UserCat WHERE email = '" . $userEmail . "'
							);";

			$result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error) ;

			if($GLOBALS['conn']->error) {
				echo $GLOBALS['conn']->error;
			} else {
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$this->permissions[$row["procName"]] = true;
					}
				} else {
					$this->permissions = null;
				}
			}
		}

		// Pass in a stored procedure/function name to check if user has access -- get TRUE/FALSE
		public function hasPerm($procedureName) {
			return isset($this->permissions[$procedureName]);
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

		public $roles = array();

		public function __construct($userEmail) {

			// Populate basic user information to member variables
			$sql = "SELECT * FROM Users WHERE email = '" . $userEmail . "';";
			$result = $GLOBALS['conn']->query($sql);

			if($GLOBALS['conn']->error) {
				echo $GLOBALS['conn']->error;
			} else {
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$this->fName = $row['fName'];
						$this->lName = $row['lName'];
						$this->email = $row['email'];
						$this->gender = $row['gender'];
						$this->pwd = $row['pwd'];
						$this->pNum = $row['pNum'];
 	   			}
				} else {
					echo 'NO user found';
				}
			}

			// Populate the $roles array with all the roles a user has
			$sql = "SELECT userType 
							FROM UserCat WHERE email = '" . $userEmail . "';";

			$result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error) ;

			if($GLOBALS['conn']->error) {
				echo $GLOBALS['conn']->error;
			} else {
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$this->roles[$row['userType']] = TRUE;
					}
				} else {
					$this->permissions = null;
				}
			}

			// Get all the stored procedures/functions a user can access
			Permission::__construct($this->email);
		}

		function userExist() {
			if($this->email != null) {
				return TRUE;
			} else {
				echo 'User does not exist';
				return FALSE;
			}
		}

		public function checkPwd($userPwd) {
			// $salt = "tcabs";
			//$password_encrypted = sha1($_POST['pwd']);

			if($userPwd == $this->pwd) {
				return TRUE;
			} else {
				echo 'Wrong Password';
				return FALSE;
			}
		}
	}
?>
