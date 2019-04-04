<?php
  $conn = new mysqli("139.99.166.3", "tcabs_web", "Database1", "tcabs");
  
  if ($conn->connect_error) {
    die("ERROR: Unable to connect: " . $conn->connect_error);
  } 

  echo 'Connected to the database.<br>';

  $result = $conn->query("SELECT * FROM SUBJECTS");

  echo "Number of rows: $result->num_rows";

  $result->close();

  $conn->close();
?>
