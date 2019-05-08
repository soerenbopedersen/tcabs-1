<!-- The main page of the system will show relevant functionality according to user role -->
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
		<h2>Welcome, <?php echo $_SESSION['fName']?></h2><h2-date><?php echo date('d F, Y (l)'); ?></h2-date><br>
		<div>
	<p> Here </p>
	</div>
	</div>

<!-- 
		<form action="dashboard.php" method="post">
			<button type="submit">Logout</button>
		</form>
-->
  </body>
  
  	<?php include "footer.php";  ?>  
</html>
