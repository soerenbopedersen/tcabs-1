<!-- The main page of the system will show relevant functionality according to user role -->
<?php
	require_once("../classes.php");
	session_start();
	if (!isset($_SESSION['logged_in'])) {
		header('Location: /tcabs/login.php');
		exit();
	} else {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {

			// validate if check boxes are ticked and no combination with student
			if(empty($_POST['roles'])) {
				echo "<script type='text/javascipt'>alert('No roles selected!');</script>";
			} else {

				$nUser = new User;

				try {
					$nUser->registerUser(
						$_POST['fName'],
						$_POST['lName'],
						$_POST['gender'],
						$_POST['pNum'],
						$_POST['email'],
						$_POST['pwd']
					);


					$nUser->assignRoles($_POST['email'], $_POST['roles']);
				} catch(mysqli_sql_exception $e) {
					//echo "<script type='text/javascript'>alert('{$e->getMessage()}');</script>";
				}
					foreach($_POST['roles'] as $role => $value) {
						echo $role;
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
  </head>

  <body class="loggedin">
		<?php include "../views/header.php"; ?>
		<div class="content">
			<h2>Register User</h2><h2-date><?php echo date('d F, Y (l)'); ?></h2-date><br>
		<div>
		<form action="registerUser.php" method ="post" class="was-validated">
  	  <p class="h4 mb-4 text-center">Register User into TCABS</p>
			<a href="bulkImportUser.php"><p class="p text-center">Bulk Import</p></a><br>
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
					<label class="checkbox-inline"><input name="roles[]" type="checkbox" value="admin">Admin</label>
    		</div>
				<div class="col">
  				<label class="checkbox-inline"><input name="roles[]" type="checkbox" value="convenor">Convenor</label>
				</div>
				<div class="col">
   				<label class="checkbox-inline"><input name="roles[]" type="checkbox" value="supervisor">Supervisor</label>
    		</div>
				<div class="col">
    			<label class="checkbox-inline"><input name="roles[]" type="checkbox" value="student">Student</label>
    		</div>
			</div>
  		<button class="btn btn-info my-4 btn-block" type="submit">Register</button>
		</form>
	</body>
  <?php include "../views/footer.php";  ?>  
</html>
