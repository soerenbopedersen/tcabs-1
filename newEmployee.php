	<h2>Register New Employee</h2>

	<div class="container" id="container">
		<div class="form-container sign-up-container">
			<form action="signup.php" method="POST">
				<h1>New Employee</h1>
				<span>This can be done in this manual form</span>
				<br>

				<input type="text" name="UID" placeholder="User ID" required>
				<select name="Role" required>
					<option selected hidden value="">Role</option>
					<option value="Administrator">Administrator</option>
					<option value="Convenor">Convenor</option>
					<option value="Supervisor">Supervisor</option>
				</select>

				<input type="text" name="Fname" placeholder="First Name" required>
				<input type="text" name="Lname" placeholder="Last Name" required>
				<select name="Gender" required>
					<option selected hidden value="">Gender</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
					<option value="Unspecified">Unspecified</option>
				</select>

				<input type="email" name="Work_Email" placeholder="Work Email" required>
				<input type="text" name="phoneCode" placeholder="Country Code" required>

				<!--<select name="phoneCode" required>
					<option selected hidden value="">Country Code</option>
					<option value="+61">AU +61</option>
					<option value="+45">DK +45</option>
				</select>-->

			<input type="Phone" placeholder="Phone No." name="Phone" required>
			<input placeholder = "Start Date" type = "text" onfocus = "(this.type = 'date')"  name = "Start_Date">
			<input type="password" name="password" placeholder="Password" required>

			<br>

			<button>Upload Employee</button>
		</form>
	</div>

	<div class="form-container sign-in-container">
		<form action="" method="POST">
			<h1>New Employee</h1>
			<span>This can be done by uploading a .csv file</span>
			<br>
			<br>
			<br>
			<br>
			<button>Upload .csv</button>
		</form>
	</div>

	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>.csv file instead?</h1>
				<p>No worries, this can be done here</p>
				<button class="ghost" id="signIn">.csv file</button>
			</div>
	<div class="overlay-panel overlay-right">
		<h1>Manual Entry?</h1>
		<p>No worries, this can be done here</p>
		<button class="ghost" id="signUp">Manual Entry</button>
	</div>
</div>
</div>

<script type="text/javascript">
	const signUpButton = document.getElementById('signUp');
	const signInButton = document.getElementById('signIn');
	const container = document.getElementById('container');

	signUpButton.addEventListener('click', () => {
		container.classList.add("right-panel-active");
	});
	signInButton.addEventListener('click', () => {
		container.classList.remove("right-panel-active");
	});
</script>
</body>
</html>
