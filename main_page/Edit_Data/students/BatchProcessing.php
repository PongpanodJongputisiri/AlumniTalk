<?php

    $fileName = $_FILES['file_csv']['tmp_name'];
    $column = $_POST["column"];

    $file = fopen($fileName, 'r');
        fgetcsv($file); // Skip the first line (headers)

        $row = 0;
        $errors = [];

        
        
        switch ($column){
            case "Name_Surname":
                $sql = "UPDATE students SET Name_Surname = ? WHERE Student_ID = ?";
                $columnName = "Name_Surname";
                $columnNo = 1;
                break;
            case "Student_Status":
                $sql = "UPDATE students SET Student_Status = ? WHERE Student_ID = ?";
                $columnName = "Student_Status";
                $columnNo = 2;
                break;
        }

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Failed to prepare SQL statement: " . $conn->error);
        }

        while (($rowData = fgetcsv($file, 1000, ',')) !== FALSE) {
            
            $Student_ID = $conn->real_escape_string($rowData[0]);

            if (!isset($rowData[$columnNo])) {
                $errors[] = "Missing data for Student_ID $Student_ID.";
                continue;
            }

            $data = $conn->real_escape_string($rowData[$columnNo]);

            // Bind and execute the statement
            $stmt->bind_param("ss", $data, $Student_ID);
            if ($stmt->execute()) {
                $row++;
            } else {
                $errors[] = "Error updating Student_ID $Student_ID: " . $stmt->error;
            }

        }
        fclose($file);


            //output
        $output = "CSV file successfully uploaded! $row row(s) updated.";
        if (!empty($errors)) {
            $output .= "<br>Some errors occurred: <br>" . implode("<br>", $errors);
        } 


?>