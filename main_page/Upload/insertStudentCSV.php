<?php

    $fileName = $_FILES['student_csv']['tmp_name'];
    if($file = fopen($fileName, 'r') !== FALSE){
        fgetcsv($file); // Skip the first line (headers)

        $row = 0;
        $errors = [];

        while (($column = fgetcsv($file, 1000, ',')) !== FALSE) {
            $Student_ID = $conn->real_escape_string($column[0]);
            $Name_Surname = $conn->real_escape_string($column[1]);
            $Student_Status = $conn->real_escape_string($column[2]);
            $Sessions_Joined = $column[3];
            $Tier = $column[4];

            // Check if Student_ID already exists
            $sql = "SELECT * FROM students WHERE Student_ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $Student_ID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                // Insert new student
                $insert_sql = "INSERT INTO students (Student_ID, Name_Surname, Student_Status, Sessions_Joined, Tier)
                            VALUES (?, ?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("sssss", $Student_ID,, $Name_Surname, $Student_Status, $Sessions_Joined, $Tier);

                if ($insert_stmt->execute()) {
                    $row++;
                } else {
                    $errors[] = "Error inserting Student_ID $Student_ID: " . $conn->error;
                }
            }
        }
        fclose($file);

        $output = "CSV file successfully uploaded! $row row(s) added to the database.";
        if (!empty($errors)) {
            $output .= "<br>Some errors occurred: <br>" . implode("<br>", $errors);
        }
    } else {
        $output = "Please select a valid CSV file.";
    }
?>