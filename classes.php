<?php

	// Define different classes with relevant and useful functions here

	require("db-conn.php");	// connect to database

	class Permission {
		public $permissions;

		protected function __construct() {
			$this->permissions = array();
		}

		protected function getPermissions($roleID) {
			//$userPermissions = new Permission();

			$sql = "SELECT procName FROM Functions AS F 
							INNER JOIN Permission AS P ON F.functionID = P.functionID
							INNER JOIN UserRole AS UR ON P.userRoleID = UR.userRoleID  
							WHERE P.userRoleID = ?";

			$result = $GLOBALS['conn']->prepare($sql);
			$result->bind_param("i", $roleID);
			$result->execute();

			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					//$userPermissions->permissions[$row["procName"] = true];
					permissions[$row["procName"] = true];
				}
				//return $userPermissions;
			} else {
				//return null;
			}
		}
	}

	class User extends Permission{
		public $userID;
		public $fName;
		public $lName;
		public $email;
		public $gender;
		public $pwd;
		public $pNum;

		public function __construct() {
			parent::__construct();
		}

		public static function userExist($userEmail) {
			$sql = "SELECT email FROM Users WHERE email = '" . $userEmail . "';";
			$result = $GLOBALS['conn']->query($sql);

			if($GLOBALS['conn']->error) {
				return null;
			} else {
				if($result->num_rows > 0) {
					return TRUE;
				} else {
					return null;
				}
			}
		}

		public static function checkPwd($userEmail, $pwd) {
			$user = new User();
			$user = $user::getUser($userEmail);

			// $salt = "tcabs";
			//$password_encrypted = sha1($_POST['pwd']);

			if($pwd == $user->pwd) {
				return TRUE;
			} else {
				return FALSE;
			}
		}

		public static function getUser($userEmail) {
			$User = new User();

			// Cannot get this to work
			//$sql = "SELECT * FROM Users WHERE email = ?;";
			//$result = $GLOBALS['conn']->prepare($sql) or die($GLOBALS['conn']->error);
			//$result->bind_param('s', $userEmail);
			//$result->execute();

			$sql = "SELECT * FROM Users WHERE email = '" . $userEmail . "';";
			$result = $GLOBALS['conn']->query($sql);

			if($GLOBALS['conn']->error) {
				return null;
			} else {
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$User->userID = $row['userID'];
						$User->fName = $row['fName'];
						$User->lName = $row['lName'];
						$User->userRoleID = $row['userRoleID'];
						$User->email = $row['email'];
						$User->gender = $row['gender'];
						$User->pwd = $row['pwd'];
						$User->pNum = $row['pNum'];

						//$User->initPermissions();
 	   			}
					return $User;
				} else {
					return null;
				}
			}
		}

		private static function initPermissions() {
			Permission::getPermissions($User->userRoleID);
		}
	}

/*
	class User extends Permission {
		public $userID;
		public $fName;
		public $lName;
		public $email;
		public $gender;
		public $pwd;
		public $pNum;


		public static function getUser($userEmail) {
			$User = new User();

			$sql = "SELECT * FROM Users WHERE email = ?";
			$result = $GLOBALS['conn']->prepare($sql);
			$result->bind_param("s", $userEmail);
			$result->execute();

			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$User->userID = $row['userID'];
					$User->fName = $row['fName'];
					$User->lName = $row['lName'];
					$User->userRoleID = $row['userRoleID'];
					$User->email = $row['email'];
					$User->gender = $row['gender'];
					$User->pwd = $row['pwd'];
					$User->pNum = $row['pNum'];

    		}
				return $User;
			} else {
				return null;
			}
		}

	}
*/
?>
