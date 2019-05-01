<!-- Login page for users -->
<?php 
	session_start();	// initailize session variable

	// Check if user is logged in, and redirect to dashboard (Causing an error)
	//if($_SESSION['logged_in'] == TRUE) {
	//	header("location: dashboard.php");
	//}
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		require("login-user.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

		<!-- Stylesheets -->
    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body>

		<form action="login.php" method="post">
	  	<div class="container">
				<label for="email">E-mail</label>
				<input type="text" placeholder="Enter Email" name="email" required>

				<label for="pwd">Password</label>
				<input type="password" placeholder="Enter Password" name="pwd" required>

				<button type="submit">Login</button>
			</div>
		</form>

  </body>
</html>
