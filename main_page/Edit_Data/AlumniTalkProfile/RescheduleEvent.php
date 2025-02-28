<?php

$Seminar_ID = filter_input(INPUT_POST, "Seminar_ID", FILTER_SANITIZE_SPECIAL_CHARS);
$New_Date = filter_input(INPUT_POST, "Seminar_ID", FILTER_SANITIZE_SPECIAL_CHARS);
$New_Start_Time = filter_input(INPUT_POST, "Seminar_ID", FILTER_SANITIZE_SPECIAL_CHARS);
$New_End_Time = filter_input(INPUT_POST, "Seminar_ID", FILTER_SANITIZE_SPECIAL_CHARS);

$sql = "";

//checking what to change
if($New_Date != NULL){
    $sql .= "UPDATE AlumniTalkProfile SET `Date` = '$New_Date' WHERE Seminar_ID = '$Seminar_ID'   ; ";
}

if($New_Start_Time != NULL){
    $sql .= "UPDATE AlumniTalkProfile SET Start_Time = '$New_Start_Time' WHERE Seminar_ID = '$Seminar_ID' ; ";
}

if($New_End_Time != NULL){
    $sql .= "UPDATE AlumniTalkProfile SET End_Time = '$New_End_Time' WHERE Seminar_ID = '$Seminar_ID'   ; ";
}

//query
if(mysqli_multi_query($conn,$sql)){
    $output = "Seminar successfully rescheduled";
}else{
    $output = "Error: " . $sql . "<br>" . $conn->error . "<br>";
}

?>