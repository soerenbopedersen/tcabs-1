<?php
	session_start();
	require("db-conn.php");

	$userID = $_POST["UID"];
	$userRole = $_POST["Role"];
	$fName = $_POST["Fname"];
	$lName = $_POST["Lname"];
	$gender = $_POST["Gender"];
	$email = $_POST["Work_Email"];
	//$phoneCode = $_POST["phoneCode"]; //need to add this in ddl.sql
	$pNum = $_POST["Phone"];
	//$Start_Date = $_POST["Start_Date"]; // neet to add this in ddl.sql
	$pwd = $_POST["password"];

	$salt = "tcabs";
	$password_encrypted = sha1($pwd.$salt);

	/*
	if(mysqli_connect_error()) {
	  die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
	} else{
	  $SELECT = "SELECT UID From register Where UID = ? Limit 1";
	  $INSERT = "INSERT Into register (UID, Role, Fname, Lname, Gender, Work_Email, phoneCode, Phone, Start_Date, Password) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	 */

	$checkSql = "SELECT * FROM Users WHERE userID = " . $userID . ";";

	$insertSql = "INSERT INTO tcabs.Users (userID, fName, lName, gender, pNum, email, pwd) VALUES (" . $userID . ", " . $fName . ", " . $lName . ", " . $gender . ", " . $pNum . ", " . $email . ", " . $password_encrypted . ");";

	//Prepare Statement
	$stmt = $GLOBALS['conn']->query($checkSql) or die($GLOBALS['conn']->error);
	$rnum = $stmt->num_rows;
	if ($rnum == 0) {
		$stmt->close();
		$stmt = $GLOBALS['conn']->query($insertSql) or die ($GLOBALS['conn']->error);
	   // $stmt->bind_param("sssssssiss", $UID,  $Role, $Fname, $Lname, $Gender, $Work_Email, $phoneCode, $Phone, $Start_Date, $password_encrypted);
			echo "New record inserted succesfully";
	  	$stmt->close();
	  } else{
			echo "This ID is already registered. Try another one!";
	  	$stmt->close();
	  }

	  $conn->close();
?>
