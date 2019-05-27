
<?php
	require_once("../classes.php");
	session_start();
	if (!isset($_SESSION['logged_in'])) {
		header('Location: /tcabs/login.php');
	} else {
	
		// if there was a post request
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				// if button presses with name attribute = submit
				if(isset($_POST['submit'])) {
					// if Add Single User submit button pressed
					if($_POST['submit'] === "addUser") {
						// validate if check boxes are ticked and no combination with student
						if(!isset($_POST['roles'])) {
							echo "<script type='text/javascript'>alert('No roles selected');</script>";
						} else {
							$nUser = new User;
							try {
								$nUser->registerUser(
									$_POST['fName'],
									$_POST['lName'],
									$_POST['gender'],
									$_POST['pNum'],
									$_POST['email'],
									$_POST['pwd'],
									$_POST['roles']
								);
							} catch(mysqli_sql_exception $e) {
								echo "<script type='text/javascript'>alert('{$e->getMessage()}');</script>";
							}
						}
					}
				}
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
		
		<title>Add User - TCABS</title>
  </head>

  <body class="loggedin">
		<?php include "../views/header.php"; ?>
  
		<div class="content">
			<h2>Manage Users > Add User</h2><h2-date><?php echo date('d F, Y (l)'); ?></h2-date><br>
			<div>
		<?php 
		//Check the Users role to see if they have access to this
		$roleFound = FALSE;						
		foreach($_SESSION['loggedUser']->uRoles as $userType => $access) {
			if($userType=='admin') {
				$roleFound = TRUE;
		?>
			
				<form style="width: 90%; margin: auto;" action="registerUser.php" method ="post" class="was-validated">
		<br>
  	  <p class="h4 mb-4 text-center">Add User</p>
			<input type="text" id="fName" name="fName" class="form-control" placeholder="First Name" required><br>
 	   	<input type="text" id="lName" name="lName" class="form-control" placeholder="Last Name" required><br>
			<select class="browser-default custom-select" id="gender" name="gender" required>
 	  		<option value="" disabled="" selected="">Gender</option>
 	    	<option value="M">Male</option>
 	    	<option value="F">Female</option>
 	  	</select><br><br>
			<input type="text" id="pNum" name="pNum" class="form-control" placeholder="Phone number" aria-describedby="defaultRegisterFormPhoneHelpBlock" required><br>
    	<input type="email" id="email" name="email" class="form-control" placeholder="E-mail" required><br>
    	<input type="password" id="pwd" name="pwd" class="form-control" placeholder="Password" aria-describedby="defaultRegisterFormPasswordHelpBlock" required><br>
	
			<p>User Roles</p>
			<div class="row">
				<div class="col">
					<label class="checkbox-inline"><input type="checkbox" name="roles[]" value="admin"> Admin</label>
    		</div>
				<div class="col">
  				<label class="checkbox-inline"><input type="checkbox" name="roles[]" value="convenor"> Convenor</label>
				</div>
				<div class="col">
   				<label class="checkbox-inline"><input type="checkbox" name="roles[]" value="supervisor"> Supervisor</label>
    		</div>
				<div class="col">
    			<label class="checkbox-inline"><input type="checkbox" name="roles[]" value="student"> Student</label>
    		</div>
			</div>
  		<button class="btn btn-info my-4 btn-block" type="submit" name="addUser" value="submit">Register</button>
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