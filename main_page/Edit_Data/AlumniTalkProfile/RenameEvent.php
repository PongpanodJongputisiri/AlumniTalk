<?php

    $Seminar_ID = filter_input(INPUT_POST, "Seminar_ID", FILTER_SANITIZE_SPECIAL_CHARS);
    $New_Event_Name = filter_input(INPUT_POST, "New_Event_Name", FILTER_SANITIZE_SPECIAL_CHARS);

    $sql = "UPDATE AlumniTalkProfile SET Event_Name = ? WHERE Seminar_ID = ?";
    $stmt =  $conn->prepare($sql);
    $stmt->bind_param("ss",$New_Event_Name,$Seminar_ID);


    if (!$stmt->execute()) {
        $output = "Error: " . $sql . "<br>" . $conn->error . "<br>";
    }else{
    $output ="Event successfully renamed";
    }
?>