<!-- User login process check if email and password exists and is correct -->
<?php 
	session_start();
	require_once('classes.php');

	$email = $_POST['email'];
	$loginUser = new User();
	$loginUser = $loginUser::getUser($email);

	if($loginUser == null) {
		echo 'User does not exist';
	} else {
		if($_POST['pwd'] == $loginUser->pwd) {
			$_SESSION['email'] = $loginUser->email;
			$_SESSION['fName'] = $loginUser->fName;
			$_SESSION['lName'] = $loginUser->lName;
			$_SESSION['logged_in'] = TRUE;	// to be checked before displaying dashboard

			header("location: dashboard.php"); // login and redirect to main page
		} else {
				$_SESSION['logged_in'] = FALSE;
				echo '<script type="text/javascript">alert("Wrong password, try again!")</script>';
		}
	}

	$conn->close();
?>
