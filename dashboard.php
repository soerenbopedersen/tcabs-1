<!-- The main page of the system will show relevant functionality according to user role -->
<?php
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
    <meta name="viewport" content="width=device-width, initial-scale=1" />

		<!-- Stylesheets -->
    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body>

		<form action="dashboard.php" method="post">
			<button type="submit">Logout</button>
		</form>

  </body>
</html>
