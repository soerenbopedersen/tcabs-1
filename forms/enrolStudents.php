<?php
	require_once("../classes.php");
	session_start();
	if (!isset($_SESSION['logged_in'])) {
		header('Location: /tcabs/login.php');
		exit();
	} else {

		// check if user has permission to access the page
		if(!$_SESSION['loggedUser']->uRoles['admin']) {
			header('Location: /tcabs/dashboard.php');
		} else {
		
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
			
				if(isset($_POST['submit'])) {

					$enrolObj = new Enrolment;

					// ernol single student
					if($_POST['submit'] === "enrol") {
						try {
							$enrolObj->enrolUser($_POST['email'], $_POST['unitCode'], $_POST['term'], $_POST['year']);
						} catch(mysqli_sql_exception $e) {
							echo "<script type='text/javascript'>alert('{$e->getMessage()}');</script>";
						}
					} else if($_POST['submit'] === "bulkEnrol") {

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
  </head>

  <body class="loggedin">
		<?php include "../views/header.php"; ?>
		<div class="content">
			<h2>Manage Enrolment</h2><h2-date><?php echo date('d F, Y (l)'); ?></h2-date><br>
		<div>

		<ul class="nav nav-tabs">
  		<li class="nav-item">
    		<a class="nav-link active" data-toggle="tab" href="#home">Enrol Student</a>
  		</li>
  		<li class="nav-item">
    		<a class="nav-link" data-toggle="tab" href="#menu1">Bulk Import via CSV</a>
  		</li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">

			<!-- Tab 1 -->
  		<div class="tab-pane container active" id="home">
				<form action="enrolStudents.php" method ="post" class="was-validated"><br/>
  	  		<p class="h4 mb-4 text-center">Enrol Students into a Unit</p>
					<input type="text" id="email" name="email" class="form-control" placeholder="Student Email" required><br>
 	   			<input type="text" id="unitCode" name="unitCode" class="form-control" placeholder="Unit Code" required><br>
 	   			<input type="text" id="year" name="year" class="form-control" placeholder="Enter Year" required><br>
					<select class="browser-default custom-select" id="term" name="term" required>
 	  				<option value="" disabled="" selected="">Select Term</option>
 	    			<option value="sem-1">Semester 1</option>
 	    			<option value="sem-2">Semester 2</option>
 	   		 		<option value="winter">Winter</option>
 	   		 		<option value="summer">Summer</option>
 	  			</select><br><br>
  				<button class="btn btn-info my-4 btn-block" type="submit" name="submit" value="enrol">Enrol Student</button>
				</form>
			</div>

			<!-- Tab 2 -->
  		<div class="tab-pane container fade" id="menu1">
				<form action="enrolStudents.php" method ="post" class="was-validated"><br/>
  	  		<p class="h4 mb-4 text-center">Bulk Import</p>
  				<div class="form-group">
    				<label for="csvFileForm">Please choose a CSV file to upload</label>
   			 		<input type="file" class="form-control-file" id="csvFileForm">
  				</div>
  				<button class="btn btn-info my-4 btn-block" type="submit" name="submit" value="bulkEnrol">Enrol Students</button>
				</form>
			</div>

		</div>
	</body>
  <?php include "../views/footer.php";  ?>  
</html>
