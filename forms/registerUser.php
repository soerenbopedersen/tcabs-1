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
					echo "<script type='text/javascript'>alert('{$e->getMessage()}');</script>";
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
			<h2>User Administration</h2><h2-date><?php echo date('d F, Y (l)'); ?></h2-date><br>
		<div>
		
		<?php 
		//print_r($_SESSION['roles']);
		//foreach($_SESSION['roles'] as $key => $value){
							//if($key=='admin') {
		?>

		<!-- Nav tabs -->
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
		<form action="registerUser.php" method ="post" class="was-validated">
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
  		<button class="btn btn-info my-4 btn-block" type="submit" name="singleUser" value="submit">Register</button>
		</form>
		</div>
		
<!-- Tab 2 -->	
  <div class="tab-pane container fade" id="menu1">
  <form action="registerUser.php" method ="post" class="was-validated">
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
  <div class="tab-pane container fade" id="menu2">
	<form action="registerUser.php" method ="post" class="was-validated">
  <br>
  	  <p class="h4 mb-4 text-center">Update User</p>
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
			</head>
			<body>
			    <div class="search-box">
			        <input type="text" autocomplete="off" placeholder="Search User..." />
			        <div class="result"></div>
			    </div>
			</body>

</form>
		</form>
		</div>


				<!-- Tab 4 -->
  <div class="tab-pane container fade" id="menu3">
  <br>
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
			</head>
			<body>
					<div class="search-box">
							<input type="text" autocomplete="off" placeholder="Search User..." />
							<input type="submit" class="btn btn-primary" name="deleteSubmit" value="DELETE">
							<div class="result"></div>
					</div>
			</body>


</form>
		</form>
		</div>
  </div>
  
  		<?php  //} else { ?>
		
		<!--	<h2>Admin Function</h2>
			<div>
			<p>Sorry, you do not have access to this function</p>
			</div>-->
		<?php  //} } ?>
  </div>
</div>

		</div>
	</body>
  <?php include "../views/footer.php";  ?>  
</html>
