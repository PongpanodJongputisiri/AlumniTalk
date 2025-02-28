<?php

    $Seminar_ID = filter_input(INPUT_POST, "Seminar_ID", FILTER_SANITIZE_SPECIAL_CHARS);
    $New_Speaker_Name = filter_input(INPUT_POST, "New_Speaker_Name", FILTER_SANITIZE_SPECIAL_CHARS);

    $sql ="UPDATE AlumniTalkProfile SET Alumni_Speaker = ? WHERE Seminar_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$Seminar_ID,$New_Speaker_Name);


    if (!$stmt->execute()) {
        $output = "Error: " $sql."<br>". $conn->error . "<br>";
    }else{
    $output ="Speaker sucessfully changed";
    }
?>