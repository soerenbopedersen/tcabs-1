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
				$stmt->bind_param('ss', $userEmail, $value);
				
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
					$stmt->bind_result($procname);

					if($stmt->num_rows > 0) {
						while($stmt->fetch()) {
							echo $procname;
							$this->permissions[$procname] = true;
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

		// this function can be used to get all users with a particular role
		public function getUsersForRole($userRole) {

			$stmt = $GLOBALS['conn']->prepare("SELECT email FROM UserCat
								WHERE userType = ?");

			$stmt->bind_param('s', $userRole);

			try {
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($email);

				$userArr = array();

				if($stmt->num_rows > 0) {
					while($stmt->fetch()) {
						array_push($userArr, $email);
					}
				}
				return $userArr;
				$stmt->close();
			} catch(mysqli_sql_exception $e) {
				throw $e;
			}
		
		}

		// to add a user to a data base - updating Users and UserCat tables
		public function registerUser($fName, $lName, $gender, $pNum, $email, $pwd, $roles) {

			// convert pNum to ###-###-####
			// will only work on 10-digit number without country code
			$pNum = sprintf("%s-%s-%s", substr($pNum, 0, 3), substr($pNum, 3, 3), substr($pNum, 6, 4));

			// encrypt password
			$pwd = sha1($pwd);

			$stmt = $GLOBALS['conn']->prepare("call TCABS_User_register(?, ?, ?, ?, ?, ?)");
			$stmt->bind_param('ssssss', $fName, $lName, $gender, $pNum, $email, $pwd);

			try {
				$GLOBALS['conn']->begin_transaction();

				$stmt->execute();

				// to update userCat table
				$roleObj = new Role;
				$roleObj->assignRoles($email, $roles);

				$GLOBALS['conn']->commit();

			} catch(mysqli_sql_exception $e) {
				$GLOBALS['conn']->rollback();
				throw $e;
			}

			$stmt->close();
		}
	}

	class Unit {
		private $unitName;
		private $unitFaculty;

		protected $unitCode;

		public function searchUnit($searchQuery) {
			$searchResult = array();

			$stmt = $GLOBALS['conn']->prepare("SELECT unitCode, unitName FROM Unit
									WHERE unitCode LIKE ?");
			//$stmt = $GLOBALS['conn']->prepare("SELECT unitCode, unitName FROM Unit
			//					WHERE unitCode = ?");
			//$stmt = $GLOBALS['conn']->prepare("SELECT unitCode, unitName FROM Unit
			//					WHERE unitCode LIKE CONCAT('%', ?, '%')");
			//$stmt->bind_param('ss', $searchQuery, $searchQuery);
			$stmt->bind_param('s', $searchQuery);

			try {
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($unitCode, $unitName);

				$count = 0;
				echo $stmt->num_rows;
				exit();

				if($stmt->num_rows > 0) {
					// only runs for the first row
					while($stmt->fetch()) {
						if($count == 0) {
							$searchResult = array($unitCode => $unitName);
							$count++;
						}
						echo $unitCode . " - " . $unitName;
						array_merge($searchResult, array($unitCode => $unitName));
						print_r($searchResult);
					}
				}
				$stmt->close();
				//return $searchResult;
			} catch(mysqli_sql_exception $e) {
				throw $e;
				return null;
			}
		}

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

	class UnitOffering extends Unit {
		private $uOffID;
		private $cUserName;
		private $teachperiod;

		private $offerings;

		// initialize the object with all unit Offerings of a unit
		public function __construct($unitCode) {
			$offerings = array();

			$stmt = $GLOBALS['conn']->prepare("SELECT * FROM UnitOffering WHERE unitCode = ?");
			$stmt->bind_param('s', $unitCode);

			try {
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($uOffID, $unitCode, $cUserName, $term, $year, $censusDate);

				if($stmt->num_rows > 0) {
					while($stmt->fetch()) {
						$this->offerings['uOffID'] = $uOffID;
						$this->offerings['unitCode'] = $unitCode;
						$this->offerings['cUserName'] = $cUserName;
						$this->offerings['term'] = $term;
						$this->offerings['year'] = $year;
						$this->offerings['censusDate'] = $censusDate;
					}
				}
				$stmt->close();
			} catch(mysqli_sql_exception $e) {
				throw $e;
			}
		}

		// return offerings array
		public function getOfferings() {
			return $this->offerings;
		}

		// add unit offering
		public function addUnitOff($unitCode, $convenorEmail, $term, $year, $censusDate) {

			$stmt = $GLOBALS['conn']->prepare("CALL TCABS_UnitOff_add(?, ?, ?, ?, ?)");
			$stmt->bind_param("sssss", $unitCode, $convenorEmail, $term, $year, $censusDate);

			try {
				$stmt->execute();
				echo "<script type='text/javascript'>alert('Unit Offering added successfully');</script>";
			} catch(mysqli_sql_exception $e) {
				throw $e;
			}

			$stmt->close();
		}
	}

	class Enrolment {
		public function enrolUser($userEmail, $uOffID) {
			
		}
	}
?>
