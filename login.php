<!-- Login page for users -->
<?php 
	session_start();	// initailize session variable

 	if (isset($_SESSION['logged_in'])) {
  	header('Location: dashboard.php');
  	exit();
	} else {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {

			// User login process check if email and password exists and is correct
			require_once('classes.php');

			$email = $_POST['email'];
			$loginUser = new User();

			if(!$loginUser::userExist($email)) {
				header("location: login.php");
			} else {
				//$salt = "tcabs";
				//$pwdHash = sha1($_POST['pwd'].$salt);

				if(!$loginUser::checkPwd($email, $_POST['pwd'])) {
					header("location: login.php");
				} else {
					$_SESSION['logged_in'] = TRUE;	// to be checked before displaying dashboard

					$loginUser = $loginUser::getUser($email);

					$_SESSION['email'] = $loginUser->email;
					$_SESSION['fName'] = $loginUser->fName;
					$_SESSION['lName'] = $loginUser->lName;
					$_SESSION['userID'] = $loginUser->userID;

					//Retrive all the permissions of the uer logged in and redirect to dashboard.php
			
					while($loginUser->permissions) {
						echo $loginUser->permissions;
					}

					header("location: dashboard.php"); // login and redirect to main page
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Login</title>

		<!-- Stylesheets -->
    <link rel="stylesheet" href="public/style.css" />
  </head>

  <body>

    <div class="login">
       <h1>Team Contribution and <br> Budget System</h1>
       <form action="login.php" method="post">
         <label for="username">
           <i class="fas fa-user"></i>
         </label>
         <input type="text" name="email" placeholder="Enter E-mail" id="username" required>
         <label for="pwd">
           <i class="fas fa-lock"></i>
         </label>
         <input type="password" name="pwd" placeholder="Enter password" id="password" required>
         <input type="submit" value="Login">
       </form>
     </div>

  </body>
</html>
