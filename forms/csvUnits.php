
<?php
	require_once("../classes.php");
	session_start();
	if (!isset($_SESSION['logged_in'])) {
		header('Location: /tcabs/login.php');
	} else {
	
		// if there was a post request
			if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['submit'] === "upload") {
				// do something
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
		
		<title>Bulk Upload via CSV - TCABS</title>
  </head>

  <body class="loggedin">
		<?php include "../views/header.php"; ?>
  
		<div class="content">
			<h2>Manage Units > Bulk Upload via CSV</h2><h2-date><?php echo date('d F, Y (l)'); ?></h2-date><br>
			<div>
		<?php 
		//Check the Users role to see if they have access to this
		$roleFound = FALSE;						
		foreach($_SESSION['loggedUser']->uRoles as $userType => $access) {
			if($userType=='admin') {
				$roleFound = TRUE;
		?>
			
				<form style="width: 90%; margin: auto;" action="csvUnits.php" method ="post" class="was-validated">
		<br>
  	  <p class="h4 mb-4 text-center">Bulk Upload via CSV</p>
	  <p class="p mb-4 text-center">Please choose your CSV file to upload.</p>


  <div class="custom-file">
    <input type="file" class="custom-file-input" id="customFile" required>
    <label class="custom-file-label" for="customFile">Choose file</label>
  </div>

<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>
  
    		<button class="btn btn-info my-4 btn-block" type="submit" name="submit" value="upload">Upload</button>
  </div>
		</form>
				
		<?php  } }
		
		//If they dont have correct permission
		if ($roleFound == FALSE) { ?>
		
			<h2>Permission Denied</h2>
			<div>
			<p>Sorry, you do not have access to this page. Please contact your administrator.</p>
			</div>
		<?php  }  ?>
			</div>
		</div>
  </body>
  <?php include "../views/footer.php"; ?>  
</html>