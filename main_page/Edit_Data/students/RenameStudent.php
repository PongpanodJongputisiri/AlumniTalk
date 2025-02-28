<?php

$Name_Surname = $_POST["Name_Surname"];
$Student_ID = $_POST["Student_ID"];

$sql = "UPDATE students SET Name_Surname = '$Name_Surname' WHERE Student_ID = '$Student_ID'";
mysqli_query($conn, $sql);

if (!$conn->query($sql)) {
    $output = "Error: " . $sql . "<br>" . $conn->error . "<br>";
}else{
$output ="student data successfully renamed";
}

?>