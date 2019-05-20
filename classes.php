<?php
	// Define different classes with relevant and useful functions here
	require("db-conn.php");	// connect to database

	class Role {
		public $roles;

		public function __construct() {
			$this->roles = array();
		}

		public function getRoles($userEmail) {

			// Populate the $roles array with all the roles a user has
			$stmt = $GLOBALS['conn']->prepare("SELECT userType 
							FROM UserCat WHERE email = ?");

			$stmt->bind_param('s', $userEmail);

			try {
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($userType);

				while($stmt->fetch()) {
					$this->roles[$userType] = TRUE;
				}
			} catch(mysqli_sql_exception $e) {
				echo "<script type='text/javascript'>alert('{$e}');</script>";
			}
		}

		public function assignRoles($userEmail, $userRoleArr) {
			// how to roll back if error occurs for some role
			$stmt = $GLOBALS['conn']->prepare("call TCABSUserCatAssignUserARole(?, ?)");

			foreach($userRoleArr as $userRole => $value) {
				$stmt->bind_param('ss', $userEmail, $userRole);
				
				try {
					$stmt->execute();
				} catch(mysqli_sql_exception $e) {
					throw $e;
				}
			}
			$stmt->close();
		}

	}

	class Permission extends Role{
		protected $permissions;

		protected function __construct() {
			Role::__construct();
			$this->permissions = array();
		}
		
		protected function getPerms($userRoles) {

			if($userRoles == NULL) {
				echo "No roles assigned"; 
			} else {

				$subQuery = "";

				foreach($userRoles as $userType => $access) {
					$subQuery = $subQuery . "'{$userType}', "; 
				}
				$subQuery = substr($subQuery, 0, -2);

				// using subquery
				$stmt = $GLOBALS['conn']->prepare("SELECT procName FROM Permission	
								WHERE userType IN (?)");

				$stmt->bind_param("s", $subQuery);

				try {
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($procName);

					if($stmt->num_rows > 0) {
						while($stmt->fetch()) {
							echo $procName;
							$this->permissions[$procName] = TRUE;
						}
					}
				} catch(mysqli_sql_exception $e) {
					echo "<script type='text/javascript'>alert('{$e}');</script>";
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

		public $uRoles;
		public $uPerms;

		public function __construct() {
			Permission::__construct();
			$uRoles = array();
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

			// get all roles of user and store it in uRoles
			$roleObj = new Role;
			$roleObj->getRoles($this->email);
			$this->uRoles = $roleObj->roles;

			// Get all the stored procedures/functions a user can access
			//Permission::getPerms($this->uRoles);
			//$this->uPerms = $this->permissions;

		}

		public function registerUser($fName, $lName, $gender, $pNum, $email, $pwd) {

			// convert pNum to ###-###-####
			// will only work on 10-digit number without country code
			$pNum = sprintf("%s-%s-%s", substr($pNum, 0, 3), substr($pNum, 3, 3), substr($pNum, 6, 4));

			// encrypt password
			$pwd = sha1($pwd);

			$stmt = $GLOBALS['conn']->prepare("call TCABS_User_register(?, ?, ?, ?, ?, ?)");
			$stmt->bind_param('ssssss', $fName, $lName, $gender, $pNum, $email, $pwd);

			try {
				$stmt->execute();
			} catch(mysqli_sql_exception $e) {
				throw $e;
			}

			$stmt->close();
		}
	}

	class Unit {
		private $unitCode;
		private $unitName;
		private $unitFaculty;

		public function registerUnit($uCode, $uName, $uFaculty) {

			$stmt = $GLOBALS['conn']->prepare("call TCABS_Unit_register(?, ?, ?)");
			$stmt->bind_param("sss", $uCode, $uName, $uFaculty);

			try {
				$stmt->execute();
				echo "<script type='text/javascript'>alert('Unit added successfully!');</script>";
			} catch(mysqli_sql_exception $e) {
				throw $e;
			}

			$stmt->close();
		}
	}
?>
