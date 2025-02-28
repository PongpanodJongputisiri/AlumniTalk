<?php

$Certificate_ID = filter_input(INPUT_POST, "Certificate_ID", FILTER_SANITIZE_SPECIAL_CHARS);


$sql = "SELECT * FROM `certificate` WHERE Certificate_ID = '$Certificate_ID'";
$query = mysqli_query($conn, $sql);

if(mysqli_num_rows($query) == 1){
    
// Joining `certificate` with `students` , fetching 'name_surname' from `students`
    $sql = "SELECT * FROM `certificate` INNER JOIN students ON `certificate`.Student_ID = `students`.Student_ID  WHERE Certificate_ID = '$Certificate_ID'";
    $query = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($query);
    
    $output .=  "Student ID : ".$row['Student_ID'].'<br>'.
                "Name Surname : ".$row['Name_Surname'].'<br>'.
                "Status : ".$row['Student_Status'].'<br>'.
                "Sessions Joined : ".$row['Sessions_Joined'].'<br>'.
                "Tier : ".$row['Tier'];


}else{
    $output = "No certificate with that number has been issued!";
}

?>