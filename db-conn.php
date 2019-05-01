<?php

	//main server
  //$conn = new mysqli("139.99.166.3", "tcabs_web", "Database1", "tcabs");

	//local server
  $conn = new mysqli("127.0.0.1", "root", "", "tcabs");
  
  if ($conn->connect_error) {
    die("ERROR: Unable to connect: " . $conn->connect_error);
  } 

/*
	echo '| EnrolmentID | StudentID | StudenName | UnitCode | UnitName | UnitPeriod |<br>';

	$mysql = "select Enrolment.enrolmentID, Student.studentID, Users.fName, Users.lName, Unit.unitCode, Unit.unitName, UnitOffering.period
						from Enrolment
						inner join Student on Student.studentID = Enrolment.studentID
						inner join UserUserRole on UserUserRole.uurID = Student.uurID
						inner join Users on Users.userID = UserUserRole.uurID
						inner join UnitOffering on UnitOffering.unitOfferingID = Enrolment.unitOfferingID
						inner join Unit on Unit.unitID = UnitOffering.unitID";

  $result = $conn->query($mysql);

	if ($result->num_rows > 0) {

    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "$row[enrolmentID].$row[studentID].$row[fName].$row[lName].$row[unitCode].$row[unitName].$row[period].<br>";
    }
	} else {
    echo "0 results";
	}

*/
?>
