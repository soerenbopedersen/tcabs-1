<?php

session_start();
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$_SESSION['logged_in'] = FALSE;	
		header("location: login.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Stylesheets -->
	<?php include "stylesheet.php"; ?>
  </head>

<?php include "header.php"; ?>

  <body class="loggedin">
	
		<div class="content">
			<h2>Welcome, <?php echo $_SESSION['fName'] . " " .  $_SESSION['lName']; ?></h2>
			<div>
				<p>Your account details are below:</p>
				<table>
				<tr>
						<td>Name:</td>
						<td><?php echo $_SESSION['fName'] . " " .  $_SESSION['lName']; ?></td>
					</tr>
					<tr>
						<td>Username:</td>
						<td><?php echo $_SESSION['email']?></td>
					</tr>
					<tr>
						<td>Phone Number:</td>
						<td><?php echo $_SESSION['pNum']?></td>
					</tr>
				</table>
			</div>
		</div>
  </body>
  
  	<?php include "footer.php";  ?>  
</html>
