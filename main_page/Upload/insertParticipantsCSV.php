<?php
if (isset($_FILES['participants_csv']) && $_FILES['participants_csv']['size'] > 0) {

    $fileName = $_FILES['participants_csv']['tmp_name'];
    $file = fopen($fileName, 'r');
    fgetcsv($file); // Skip the first line (headers)

    $row = 0;
    $errors = [];

    while (($column = fgetcsv($file, 1000, ',')) !== FALSE) {
        $Seminar_ID = $conn->real_escape_string($column[0]);
        $Student_ID = $conn->real_escape_string($column[1]);
        $time = $conn->real_escape_string($column[2]);

        // Check if Seminar exist
        $check_sql =   "SELECT * FROM AlumniTalkProfile
                        WHERE Seminar_ID = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $Seminar_ID);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows == 0) {
            $errors[] = "Event ID: <b>$Seminar_ID</b> does not exist, skipping.";
            continue;
        }

        // Check if Seminar exist
        $check_sql =   "SELECT * FROM students
                        WHERE Student_ID = ?"; 
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $Student_ID);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows == 0) {
            $errors[] = "Student ID: <b>$Student_ID</b> does not exist, skipping.";
            continue;
        }

        // Check if student already registered
        $check_participant_sql = "SELECT * FROM participants WHERE Student_ID = ? AND Seminar_ID = ?";
        $check_participant_stmt = $conn->prepare($check_participant_sql);
        $check_participant_stmt->bind_param("ss", $Student_ID, $Seminar_ID);
        $check_participant_stmt->execute();
        $check_participant_result = $check_participant_stmt->get_result();

        if ($check_participant_result->num_rows > 0) {
            // Update register time
            $update_sql = "UPDATE participants SET Register_Time = ? WHERE Student_ID = ? AND Seminar_ID = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("sss", $time, $Student_ID, $Seminar_ID);
            $update_stmt->execute();
        } else {
            // Insert new participant
            $insert_sql = "INSERT INTO participants (Seminar_ID, Student_ID, Register_Time) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("sss", $Seminar_ID, $Student_ID, $time);

            if ($insert_stmt->execute()) {
                $row++;

                // Increment Sessions_Joined
                $update_student_sql = "UPDATE students SET Sessions_Joined = Sessions_Joined + 1 WHERE Student_ID = ?";
                $update_student_stmt = $conn->prepare($update_student_sql);
                $update_student_stmt->bind_param("s", $Student_ID);
                $update_student_stmt->execute();
                
            } else {
                $errors[] = "Error inserting Student ID: <b>$Student_ID</b> - " . $conn->error;
            }
        }
    }

    fclose($file);

    // Output summary
    $output = "CSV file successfully uploaded! $row row(s) added to the database.<br>";
    if (!empty($errors)) {
        $output .= "Some issues occurred:<br>" . implode("<br>", $errors);
    }
} else {
    $output = "Please select a valid CSV file.";
}

// Check attendance (fix the directory)
include('../Automate/CheckAttendance.php');
?>


<?php
    // $fileName = $_FILES['participants_csv']['tmp_name'];
    // $row = 0;

    // if ($_FILES['participants_csv']['size'] > 0) {
    //     $file = fopen($fileName, 'r');

    //     fgetcsv($file);       //skips the first line

    //     while (($column = fgetcsv($file, 1000, ',')) !== FALSE) {
    //         $Seminar_ID = $conn->real_escape_string($column[0]);
    //         $Student_ID = $conn->real_escape_string($column[1]);
    //         $time = $conn->real_escape_string($column[2]);


    //         //check if the event was actually held
    //         $sql = "SELECT * FROM AlumniTalkProfile WHERE Seminar_ID = '$Seminar_ID'";
    //         $query = mysqli_query($conn,$sql);
    //         if(mysqli_num_rows($query) == 0){
    //             $output .= "<br>Event ID : <b>" . $Seminar_ID . "</b> does not exist, skipping iterations";
    //             continue;
    //         }

    //         //check if the student ID exist in the database
    //         $sql = "SELECT * FROM students WHERE Student_ID = '$Student_ID'";
    //         $query = mysqli_query($conn,$sql);
    //         if(mysqli_num_rows($query) == 0){
    //             $output .= "<br>Student ID : <b>" . $Student_ID . "</b> does not exist in the database, skipping iterations";
    //             continue;
    //         }


    //         //Reassign register time instead if the attendee has register before
    //         $sql = "SELECT * FROM participants WHERE Student_ID = '$Student_ID' and Seminar_ID = '$Seminar_ID'";
    //         $query = mysqli_query($conn, $sql);
            
    //         if (mysqli_num_rows($query) == 1){
    //             //update register time
    //             $sql = "UPDATE participants SET Register_Time = '$time' WHERE Student_ID = '$Student_ID'";
    //             $query = mysqli_query($conn,$sql);
    //         } else if (mysqli_num_rows($query) == 0) {
    //             //add to participants data
    //             $sql = "INSERT INTO participants (Seminar_ID, Student_ID,Register_time) 
    //                         VALUES ('$Seminar_ID','$Student_ID','$time')";
    //             $row++;
    //             if (!$conn->query($sql)) {
    //                 $output = "Error: " . $sql . "<br>" . $conn->error . "<br>";
    //             }
                
    //             // increment sessions joined
    //             $sql = "SELECT * FROM students WHERE Student_ID = '$Student_ID'";
    //             $search = mysqli_query($conn, $sql);

    //             if (mysqli_num_rows($search) == 1){
    //                 $sql = "UPDATE students SET Sessions_Joined = Sessions_Joined + 1 WHERE Student_ID = '$Student_ID'";
                    
    //                 if (!$conn->query($sql)) {
    //                     $output = "Error: " . $sql . "<br>" . $conn->error . "<br>";
    //                 }
    //             }else{
    //                 $output .="<br><b>ALERT!</b> no data for student ID" . $Student_ID . "exist!";
    //             }

    //         }
    //     }
    //     fclose($file);
    //     $output = $output."<br>CSV file successfully uploaded and database updated! ". $row ." rows added to the database <br>";

    // } else {
    //     $output = "Please select a valid CSV file.";
    // }

    // //participants check (fix the directory)
    // include ('../Automate/CheckAttendance.php');


?>