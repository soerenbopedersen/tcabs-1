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
					$unitObj = new Unit;
					if($_POST['submit'] === "addUnit") {
						try {
							$unitObj->registerUnit($_POST['unitCode'], $_POST['unitName'], $_POST['unitFaculty']);
						} catch(mysqli_sql_exception $e) {
							echo "<script type='text/javascript'>alert('{$e->getMessage()}');</script>";
						}
					} else if($_POST['submit'] === "bulkAddUnits") {
				
					} else if($_POST['submit'] === "search") {
						if($_POST['searchQuery'] == null) {
							echo "<script type='text/javascript'>alert('Search Box empty');</script>";
						} else {
							try {
								$searchResults = $unitObj->searchUnit("%{$_POST['searchQuery']}%");
								if($searchResults == null) {
									echo "<script type='text/javascript'>alert('Oops nothing found!');</script>";
								} else {
									// adding search results to frontend goes here
									print_r($searchResults);
								}
							} catch(mysqli_sql_exception $e) {
								echo $e->getMessage();
								exit();
								echo "<script type='text/javascript'>alert('{$e->getMessage()}');</script>";
							}
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
  </head>

  <body class="loggedin">
		<?php include "../views/header.php"; ?>
		<div class="content">
			<h2>Add Units</h2><h2-date><?php echo date('d F, Y (l)'); ?></h2-date><br>
		<div>

		<ul class="nav nav-tabs">
  		<li class="nav-item">
    		<a class="nav-link <?php if((isset($_POST['submit']) && $_POST['submit'] == 'addUnit') || $_SERVER['REQUEST_METHOD'] == 'GET') { echo 'active';} ?>" data-toggle="tab" href="#home">Add</a>
  		</li>
  		<li class="nav-item>">
				<a class="nav-link <?php if(isset($_POST['submit']) && $_POST['submit'] == 'bulkAddUnits') { echo 'active';} ?>" data-toggle="tab" href="#menu1">Bulk Import via CSV</a>
  		</li>
    	<li class="nav-item">
    		<a class="nav-link <?php if(isset($_POST['submit']) && $_POST['submit'] == 'search') { echo 'active';} ?>" data-toggle="tab" href="#menu2">Search</a>
  		</li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">

			<!-- Tab 1 -->
  		<div class="tab-pane container <?php if((isset($_POST['submit']) && $_POST['submit'] == 'addUnit') || $_SERVER['REQUEST_METHOD'] == 'GET') { echo 'active show';} ?>" id="home">
				<form action="registerUnits.php" method ="post" class="was-validated"><br/>
  	  		<p class="h4 mb-4 text-center">Add Unit into TCABS</p>
					<input type="text" id="unitCode" name="unitCode" class="form-control" placeholder="Unit Code" required><br>
 	   			<input type="text" id="unitName" name="unitName" class="form-control" placeholder="Unit Name" required><br>
					<select class="browser-default custom-select" id="unitFaculty" name="unitFaculty" required>
 	  				<option value="" disabled="" selected="">Select Faculty</option>
 	    			<option value="FBL">Faculty of Business and Law</option>
 	    			<option value="FHAD">Faculty of Health, Arts and Design</option>
 	   		 		<option value="FSET">Faculty of Science, Engineering and Technology</option>
 	  			</select><br><br>
  				<button class="btn btn-info my-4 btn-block" type="submit" name="submit" value="addUnit">Add Unit</button>
				</form>
			</div>

			<!-- Tab 2 -->
  		<div class="tab-pane container fade <?php if(isset($_POST['submit']) && $_POST['submit'] == 'bulkAddUnits') { echo 'active show';} ?>" id="menu1">
				<form action="registerUnits.php" method ="post" class="was-validated"><br/>
  	  		<p class="h4 mb-4 text-center">Bulk Import</p>
  				<div class="form-group">
    				<label for="csvFileForm">Please choose a CSV file to upload</label>
   			 		<input type="file" class="form-control-file" id="csvFileForm">
  				</div>
  				<button class="btn btn-info my-4 btn-block" type="submit" name="submit" value="bulkAddUnits">Register Units</button>
				</form>
			</div>

			<!-- Tab 3 -->
  		<div class="tab-pane container fade <?php if(isset($_POST['submit']) && $_POST['submit'] == 'search') { echo 'active show';} ?>" id="menu2">
				<form method="POST" class="was-validated"><br/>
  	 		 	<p class="h4 mb-4 text-center">Update/Delete Unit</p>
					<div class="search-box">
						<input type="text" name="searchQuery" autocomplete="off" placeholder="Enter Unit Code or Name" />
  					<button class="btn btn-primary" name="submit" value="search">Search</button>
						<div class="result"></div>
					</div>
				</form><br>

				<!-- Show Search Results -->
			<?php 
				if(isset($_POST['submit']) && $_POST['submit'] == 'search') {
			?>		

			<div>
				<form action="registerUser.php" method="post">
					<table style="width: 100%;">
						<tr>
    					<th style="width: 40%;">Unit Code</th>
							<th style="width: 35%;">Unit Name</th>
							<th style="width: 15%;"></th>
    					<th style="width: 15%;"></th>
    				</tr>

						<?php 

							foreach($searchResults as $key => $value) {
								$name = $value['unitCode'];
								$email = $value['unitName'];
						?>

						<tr style="border-top: 1px solid lightgrey;">
							<td><?php echo $name;?></td>
							<td><?php echo $email;?></td>
							<td><button type="submit" class="btn btn-primary" name="update" value="<?php echo $resultEmail;?>" >Update</button></td>
							<td><button type="submit" class="btn btn-danger" name="delete" value="<?php echo $resultEmail;?>" >Delete</button></td>
						</tr>

						<?php  }?>

					</table>
				</form><br>
			</div>
			<?php  }?>
			</div>
		</div>
	</body>
  <?php include "../views/footer.php";  ?>  
</html>
