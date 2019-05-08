<!-- Login page for users -->
<?php 
	session_start();	// initailize session variable

 	if (isset($_SESSION['logged_in'])) {
     header('Location: dashboard.php');
     exit();
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		require("login-user.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Login</title>

		<!-- Stylesheets -->
    <?php include "stylesheet.php"; ?>
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
