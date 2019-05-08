<!-- The main page of the system will show relevant functionality according to user role -->
<?php
	session_start();

	if($_SESSION['logged_in'] = FALSE) {
		header("location: login.php");
		exit();
	}	else if($_SESSION['logged_in'] == TRUE) {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			require("signup.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

		<!-- Stylesheets -->
    <link href="public/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="public/newEmployeeStyle.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
  </head>

  <body class="loggedin">
  
	<?php include "header.php"; ?>
	
	<div class="content">
		<h2>Welcome, <?php echo $_SESSION['fName']?></h2><h2-date><?php echo date('d F, Y (l)'); ?></h2-date>
	<?php require("newEmployee.php") ?>
	</div>

	<?php include "footer.php";  ?>  
<!-- 
		<form action="dashboard.php" method="post">
			<button type="submit">Logout</button>
		</form>
-->
  </body>
</html>
