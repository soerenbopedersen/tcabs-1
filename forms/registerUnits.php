<?php
	require_once("../classes.php");
	session_start();
	if (!isset($_SESSION['logged_in'])) {
		header('Location: /tcabs/login.php');
		exit();
	} else {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {

		}
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Stylesheets -->
		<?php include "../styles/stylesheet.php"; ?>
  </head>

  <body class="loggedin">
		<?php include "../views/header.php"; ?>
		<div class="content">
			<h2>Add Units</h2><h2-date><?php echo date('d F, Y (l)'); ?></h2-date><br>
		<div>
		<form action="registerUnits.php" method ="post" class="was-validated">
  	  <p class="h4 mb-4 text-center">Add Unit into TCABS</p>
			<!--<a href="bulkImportUser.php"><p class="p text-center">Bulk Import</p></a><br>-->
			<input type="text" id="unitCode" name="unitCode" class="form-control" placeholder="Unit Code" required><br>
 	   	<input type="text" id="unitName" name="unitName" class="form-control" placeholder="Unit Name" required><br>
			<select class="browser-default custom-select" id="unitFaculty" name="unitFaculty" required>
 	  		<option value="" disabled="" selected="">Select Faculty</option>
 	    	<option value="FBL">Faculty of Business and Law</option>
 	    	<option value="FHAD">Faculty of Health, Arts and Design</option>
 	    	<option value="FSET">Faculty of Science, Engineering and Technology</option>
 	  	</select><br><br>
  		<button class="btn btn-info my-4 btn-block" type="submit">Add Unit</button>
		</form>
	</body>
  <?php include "../views/footer.php";  ?>  
</html>
