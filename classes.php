<?php
	// Define different classes with relevant and useful functions here
	require("db-conn.php");	// connect to database

	class Role {
		protected $roles;

		protected function __construct() {
			$this->roles = array();
		}

		protected function getRoles($userEmail) {

			// Populate the $roles array with all the roles a user has
			$sql = "SELECT userType 
							FROM UserCat WHERE email = '{$userEmail}'";

			$result = $GLOBALS['conn']->query($sql) or die($GLOBALS['conn']->error) ;

			if($GLOBALS['conn']->error) {
				echo $GLOBALS['conn']->error;
			} else {
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$this->roles[$row['userType']] = TRUE;
					}
				} else {
					$this->roles = null;
				}
			}
		}

	}

	class Permission extends Role{
		protected $permissions;

		protected function __construct() {
			Role::__construct();
			$this->permissions = array();
		}
		
		protected function getPerms($userEmail) {

			$roleObj = new Role;
			$roleObj->getRoles($userEmail);

			if($roleObj->roles == NULL) {
				echo "No roles assigned"; 
			} else {
				$subQuery = "";
				foreach($roleObj->roles as $userType => $access) {
					$subQuery = $subQuery . "'{$userType}', "; 
				}
				$subQuery = substr($subQuery, 0, -2);

				// using subquery
				$sql = "SELECT procName FROM Permission	
								WHERE userType IN ({$subQuery});";
	
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
		}

		// Pass in a stored procedure/function name to check if user has access -- get TRUE/FALSE
		public function hasPerm($procedureName) {
			return isset($this->permissions[$procedureName]);
		}
	}

	class User extends Permission {
		public $fName;
		public $lName;
		public $gender;
		public $pNum;
		public $email;
		private $pwd;	// hidden to outside classes and functions

		public function __construct() {
			Permission::__construct();
		}

		public function userExist() {
			if($this->email != null) {
				return TRUE;
			} else {
				return FALSE;
			}
		}

		public function checkPwd($userPwd) {
			// encrypt
			$userPwd = sha1($userPwd);

			if($userPwd == $this->pwd) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
		public function getUser($userEmail) {

			// Populate basic user information into member variables
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
					return NULL;
					exit(1);
				}
			}

			// Get all the stored procedures/functions a user can access
			Permission::getPerms($this->email);
		}

		public function registerUser($fName, $lName, $gender, $pNum, $email, $pwd) {

			// convert pNum to ###-###-####
			// will only work on 10-digit number without country code
			$pNum = sprintf("%s-%s-%s", substr($pNum, 0, 3), substr($pNum, 3, 3), substr($pNum, 6, 4));

			// encrypt password
			$pwd = sha1($pwd);

			$sql = "call TCABS_User_register('{$fName}', '{$lName}', '{$gender}', '{$pNum}', '{$email}', '{$pwd}')";

			try {
				$result = $GLOBALS['conn']->query($sql);
			} catch(Exception $e) {
				echo "<script type='text/javascript'>alert('{$e->error}');</script>";
			}
		}
	}

	class Unit {
		private unitCode;
		private unitName;
		private unitFaculty;

		public function registerUnit($uCode, $uName, $uFaculty) {
			$sql = "call TCABS_Unit_register($uCode, $uName, $uFaculty)";

			try {
				$result = $GLOBALS['conn']->query($sql);
			} catch(Exception $e) {
				echo "<script type='text/javascript'>alert('{$e->error}');</script>";
			}
		}
	}
?>
