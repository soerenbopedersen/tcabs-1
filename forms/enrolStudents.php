<!-- The main page of the system will show relevant functionality according to user role -->
<?php
	require_once("../classes.php");
	session_start();
	if (!isset($_SESSION['logged_in'])) {
		header('Location: /tcabs/login.php');
	} else {
		// Add User
		if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['addUser'])) {

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
		
		// Bulk CSV Import
		if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['bulkCSVImport'])) {
		// do something
	} 
		
		// Update User
		if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['updateUser'])) {
		// do something
	} 
		
		// Delete User
		if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['deleteUser'])) {
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
	<title>Manage Enrolments - TCABS</title>
		<!-- Stylesheets -->
		<?php include "../styles/stylesheet.php"; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
		localStorage.setItem('activeTab', $(e.target).attr('href'));
	});
	var activeTab = localStorage.getItem('activeTab');
	if(activeTab){
		$('#myTab a[href="' + activeTab + '"]').tab('show');
	}
});
</script>
		
		
  </head>

   <body class="loggedin">
		<?php include "../views/header.php"; ?>
		<div class="content">
			<h2>Manage Enrolments</h2><h2-date><?php echo date('d F, Y (l)'); ?></h2-date><br>
		<div>
		
		<?php 
		//print_r($_SESSION['roles']);
		//foreach($_SESSION['roles'] as $key => $value){
							//if($key=='admin') {
		$roleFound = FALSE;						
		foreach($_SESSION['loggedUser']->uRoles as $userType => $access) {
			if($userType=='admin') {
				$roleFound = TRUE;
		?>

		<!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a data-toggle="tab" href="#home">Section A</a></li>
        <li><a data-toggle="tab" href="#menu1">Section B</a></li>
        <li><a data-toggle="tab" href="#menu2">Section C</a></li>
		<li><a data-toggle="tab" href="#menu3">Delete</a></li>
    </ul>

<!-- Tab panes -->
<div class="tab-content">

<!-- Tab 1 -->
        <div id="home" class="tab-pane fade in active">
		<form action="enrolStudents.php" method ="post" class="was-validated">
		<br>
  	  <p class="h4 mb-4 text-center">Add Enrolment into TCABS</p>

			<input type="text" id="unitCode" name="unitCode" class="form-control" placeholder="Unit Code" required><br>
			<input type="text" id="unitCode" name="unitCode" class="form-control" placeholder="Unit Code" required><br>
 	   	<input type="text" id="unitName" name="unitName" class="form-control" placeholder="Unit Name" required><br>
			<select class="browser-default custom-select" id="unitFaculty" name="unitFaculty" required>
 	  		<option value="" disabled="" selected="">Select Faculty</option>
 	    	
			<!-- Populate based on units table here -->
			
			
			
 	  	</select><br><br>
  		<button class="btn btn-info my-4 btn-block" type="submit">Add Unit</button>
		</form>
		</div>
		
<!-- Tab 2 -->	
        <div id="menu1" class="tab-pane fade">
  <form action="enrolStudents.php" method ="post" class="was-validated">
		<br>
  	  <p class="h4 mb-4 text-center">Bulk Import via CSV</p>
	<form>
  <div class="form-group">
    <label for="csvFileForm">Please choose a CSV file to upload</label>
    <input type="file" class="form-control-file" id="csvFileForm">
  </div>
</form>
		</form>
		</div>
		
		
		<!-- Tab 3 -->
        <div id="menu2" class="tab-pane fade">
	<form action="enrolStudents.php" method ="post" class="was-validated">
  <br>
  	  <p class="h4 mb-4 text-center">Update Enrolment</p>
			<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
			<script type="text/javascript">
			$(document).ready(function(){
			    $('.search-box input[type="text"]').on("keyup input", function(){
			        /* Get input value on change */
			        var inputVal = $(this).val();
			        var resultDropdown = $(this).siblings(".result");
			        if(inputVal.length){
			            $.get("units-backend-search.php", {term: inputVal}).done(function(data){
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
			</head>
			<body>
			    <div class="search-box">
			        <input type="text" autocomplete="off" placeholder="Search Units..." />
					
			        <div class="result"></div>
			    </div>
			</body>

</form>
		</form>
		</div>


				<!-- Tab 4 -->
  <div class="tab-pane container fade" id="menu3">
  <br>
  	  <p class="h4 mb-4 text-center">Delete Enrolment</p>
			<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
			<script type="text/javascript">
			$(document).ready(function(){
					$('.search-box input[type="text"]').on("keyup input", function(){
							/* Get input value on change */
							var inputVal = $(this).val();
							var resultDropdown = $(this).siblings(".result");
							if(inputVal.length){
									$.get("units-backend-search.php", {term: inputVal}).done(function(data){
											// Display the returned data in browser
											resultDropdown.html(data);
									});
							} else{
									resultDropdown.empty();
							}
					});

					// Set search input value on click of result item
					$(document).on("click", ".result p", function(){
							$(this).parents(".search-box").find('input[type="text" id="delUnitName" name="delUnitName"').val($(this).text());
							$(this).parent(".result").empty();
					});
			});
			</script>
			</head>
			<body>
					<div class="search-box">
					<form action="enrolStudents.php" method="post">
							<input type="text" id="delUnitName" name="delUnitName" class="form-control" placeholder="Unit Name" required>
							<input type="text" id="delStudentName" name="delStudentName" class="form-control" placeholder="User Name" required>
							<input type="submit" class="btn btn-primary" name="deleteUser" value="Delete Enrolment">
							<div class="result"></div>
							</form>
					</div>
			</body>


</form>
		</form>
		</div>
  </div>
  
  		<?php  } }
		if ($roleFound == FALSE) { ?>
		
			<h2>Permission Denied</h2>
			<div>
			<p>Sorry, you do not have access to this page. Please contact your administrator.</p>
			</div>
		<?php  }  ?>
  </div>
</div>

		</div>
	</body>
  <?php include "../views/footer.php";  ?>  
</html>
