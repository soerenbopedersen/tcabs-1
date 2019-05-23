<?php
	require_once("../classes.php");
	session_start();
	if (!isset($_SESSION['logged_in'])) {
		header('Location: /tcabs/login.php');
		exit();
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
			
				} else if($_POST['submit'] === "updateSearch") {
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
				} else if($_POST['submit'] === "deleteSearch") {
			
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
    		<a class="nav-link active" data-toggle="tab" href="#home">Add</a>
  		</li>
  		<li class="nav-item">
    		<a class="nav-link" data-toggle="tab" href="#menu1">Bulk Import via CSV</a>
  		</li>
    	<li class="nav-item">
    		<a class="nav-link" data-toggle="tab" href="#menu2">Update</a>
  		</li>
      <li class="nav-item">
    		<a class="nav-link" data-toggle="tab" href="#menu3">Delete</a>
  		</li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">

			<!-- Tab 1 -->
  		<div class="tab-pane container active" id="home">
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
  		<div class="tab-pane container active" id="menu1">
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
  		<div class="tab-pane container active" id="menu2">
				<form method="POST" class="was-validated"><br/>
  	 		 	<p class="h4 mb-4 text-center">Update User</p>
				<!--	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
					<script type="text/javascript">
						$(document).ready(function(){
							$('.search-box input[type="text"]').on("keyup input", function(){
								/* Get input value on change */
								var inputVal = $(this).val();
								var resultDropdown = $(this).siblings(".result");
			        	if(inputVal.length){
			        		$.get("backend-search.php", {term: inputVal}).done(function(data){
			          		// Display the returned data in browser
										resultDropdown.html(data);
			          	});
			        	} else{
			          	resultDropdown.empty();
			        	}
			    		});

			    		// Set search input value on click of result item
			    		$(document).on("click", ".result p", function(){
			    			$(this).parents(".search-box").find('input[type="text"]').val($(this).text());
			    			$(this).parent(".result").empty();
			    		});
						});
					</script>-->
					<div class="search-box">
						<input type="text" name="searchQuery" autocomplete="off" placeholder="Enter Unit Code or Name" />
  					<button class="btn btn-primary" name="submit" value="updateSearch">Search</button>
						<div class="result"></div>
					</div>
				</form>
			</div>

			<!-- Tab 4 -->
  		<div class="tab-pane container active" id="menu3">
				<form action="registerUnits.php" method ="post" class="was-validated"><br>
  	 		 	<p class="h4 mb-4 text-center">Delete User</p>

					<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
					<script type="text/javascript">
					$(document).ready(function(){
						$('.search-box input[type="text"]').on("keyup input", function(){
							/* Get input value on change */
							var inputVal = $(this).val();
							var resultDropdown = $(this).siblings(".result");
							if(inputVal.length){
								$.get("backend-search.php", {term: inputVal}).done(function(data){
									// Display the returned data in browser
									resultDropdown.html(data);
								});
							} else{
								resultDropdown.empty();
							}
						});

						// Set search input value on click of result item
						$(document).on("click", ".result p", function(){
							$(this).parents(".search-box").find('input[type="text"]').val($(this).text());
							$(this).parent(".result").empty();
						});
					});
					</script>
					<div class="search-box">
						<input type="text" autocomplete="off" placeholder="Search Unit..." />
  					<button class="btn btn-primary" type="submit" name="submit" value="updateSearch">Search</button>
					<div class="result"></div>
				</div>
			</form>
		</div>

		</div>
	</body>
  <?php include "../views/footer.php";  ?>  
</html>
