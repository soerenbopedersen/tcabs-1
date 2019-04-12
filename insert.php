<?php
$UID = $_POST['UID'];
$Role = $_POST['Role'];
$Fname = $_POST['Fname'];
$Lname = $_POST['Lname'];
$Gender = $_POST['Gender'];
$Work_Email = $_POST['Work_Email'];
$phoneCode = $_POST['phoneCode'];
$Phone = $_POST['Phone'];
$Start_Date = $_POST['Start_Date'];
$End_Date = $_POST['End_Date'];
$Password = $_POST['Password'];

if (!empty($UID) || !empty($Role) || !empty($Fname) || !empty($Lname) || !empty($Gender) || !empty($Work_Email) || !empty($phoneCode) || !empty($Phone) || !empty($Start_Date) || !empty($End_Date) || !empty($Password)) {
  $host = "localhost";
  $dbUsername = "root";
  $dbPassword = "";
  $dbname = "test";

  //create connection
  $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

  if(mysqli_connect_error()) {
    die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());
  } else{
    $SELECT = "SELECT UID From register Where UID = ? Limit 1";
    $INSERT = "INSERT Into register (UID, Role, Fname, Lname, Gender, Work_Email, phoneCode, Phone, Start_Date, End_Date, Password) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    //Prepare Statement
    $stmt = $conn->prepare($SELECT);
    $stmt->bind_param("i", $UID);
    $stmt->execute();
    $stmt->bind_result($UID);
    $stmt->store_result();
    $rnum = $stmt->num_rows;

    if ($rnum==0){
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("isssssiisss", $UID,  $Role, $Fname, $Lname, $Gender, $Work_Email, $phoneCode, $Phone, $Start_Date, $End_Date, $Password);
      $stmt->execute();
        echo "New record inserted succesfully";
    } else{
        echo "This ID is already registered. Try another one!";
    }
    $stmt->close();
    $conn->close();
  }
}

else{
  echo "All fields are required";
  die();
}
?>
