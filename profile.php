<?php
	// We need to use sessions, so you should always start sessions using the below code.
	session_start();
	// If the user is not logged in redirect to the login page...
	if (!isset($_SESSION['logged_in'])) {
		header('Location: login.php');
		exit();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="public/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
	
		<?php include "header.php";  ?>
		
		<div class="content">
			<h2><?php echo $_SESSION['fName'] . " " .  $_SESSION['lName']; ?></h2>
			<div>
				<p>Your account details are below:</p>
				<table>
				<tr>
						<td>Name:</td>
						<td><?php echo $_SESSION['fName'] . " " .  $_SESSION['lName']; ?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?php echo $_SESSION['email']?></td>
					</tr>
					<!--<tr>
						<td>Date of Birth:</td>
						<td><//?=$dob?></td>
					</tr>-->
					<tr>
				</table>
			</div>
		</div>

		<?php include "footer.php";  ?>
	</body>
</html>
