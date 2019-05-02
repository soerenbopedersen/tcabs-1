<!-- Define different classes with relevant and useful functions here -->
<?php
	require("db-conn.php");	// connect to database

	class User {
		public $userID;
		public $fName;
		public $lName;
		public $email;
		public $gender;
		public $pwd;
		public $pNum;

		public static function getUser($userEmail) {
			$User = new User();
			// Use prepare statement to avoid SQL injection like Shannon's code
			$sql = "SELECT * FROM Users WHERE email = '$userEmail'" or die($GLOBALS['conn']->error);
			$result = $GLOBALS['conn']->query($sql);

			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$User->userID = $row['userID'];
					$User->fName = $row['fName'];
					$User->lName = $row['lName'];
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

?>
