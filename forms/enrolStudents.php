
<?php
	require_once("../classes.php");
	session_start();
	if (!isset($_SESSION['logged_in'])) {
		header('Location: /tcabs/login.php');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


		</div>
	</body>
  <?php include "../views/footer.php";  ?>  
</html>
