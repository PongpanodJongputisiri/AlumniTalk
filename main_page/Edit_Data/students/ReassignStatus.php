<?php

    $Student_Status = $_POST["Student_Status"];
    $Student_ID = $_POST["Student_ID"];

    $sql = "SELECT * FROM students WHERE Student_ID = '$Student_ID'";
    $search = mysqli_query($conn, $sql);

    if(mysqli_num_rows($search) == 1){
        $sql = "UPDATE students SET Student_Status = '$Student_Status' WHERE Student_ID = '$Student_ID'";
        mysqli_query($conn, $sql);
        
        if (!$conn->query($sql)) {
            $output = "Error: " . $sql . "<br>" . $conn->error . "<br>";
        }else{
        $output = "status successfully reassigned";
        }
    }
    else if((mysqli_num_rows($search) > 1)){
        $output = "Duplicates data are found";
    }
    else{
        $output = "No data found";
    }

?>