<nav class="navtop">
	<div>
		<h1>Team Contribution and Budget System</h1>
		<!--Check $_SESSION['UserRole'] and display Admin/Student etc -->
		<a href="admin.php"><i class="fas fa-user-secret"></i>Insert User</a>
		<a href="profile.php"><i class="fas fa-user-circle"></i>Profile (<?php echo $_SESSION['fName']?>)</a>
		<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
	</div>
</nav>
