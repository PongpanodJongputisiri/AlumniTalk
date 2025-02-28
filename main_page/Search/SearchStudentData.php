<?php
// Get user input and sanitize it
$keyword = filter_input(INPUT_POST, 'search_keyword', FILTER_SANITIZE_SPECIAL_CHARS);
$keyword = trim($keyword); // Trim whitespace

if (empty($keyword)) {
    $output = "Please enter a search keyword.";
    exit;
}

// Initialize SQL statement
$sql = "";
$stmt = null;

if (stripos($keyword, " ") !== false) { 
    // Case: Full Name (contains space)
    $sql = "SELECT * FROM students WHERE Name_Surname = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $keyword);

} elseif (is_numeric($keyword) && strlen($keyword) == 10) { 
    // Case: Student ID (exact 10-digit number)
    $sql = "SELECT * FROM students WHERE Student_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $keyword);

} elseif (ctype_alpha($keyword) || preg_match('/^\p{Thai}+$/u', $keyword)) { 
    // Case: Name (Thai or English)
    $sql = "SELECT * FROM students WHERE Name_Surname LIKE ?";
    $stmt = $conn->prepare($sql);
    
    $searchValue = "%$keyword%"; // Add wildcards for LIKE search
    $stmt->bind_param("s", $searchValue);

} else {
    echo "Couldn't search for that keyword.";
    exit();
}

// Execute the query
if ($stmt->execute()) {
    $result = $stmt->get_result(); // Fetch result set

    if ($result->num_rows == 0) {
        $output = "No student found";
    } elseif ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $output = '<b>Name: </b>'. $row['Name_Surname'] . "<br>".
                  '<b>Student ID: </b>'. $row['Student_ID'] . "<br>".
                  '<b>Status: </b>'. $row['Student_Status'] . "<br>".
                  '<b>Sessions Joined: </b>'. $row['Sessions_Joined'] . "<br>";
    } else {
        // Handle multiple results
        $output = "Multiple results found:<br>";
        while ($row = $result->fetch_assoc()) {
            $output .= '<hr><b>Name: </b>'. $row['Name_Surname'] . "<br>".
                       '<b>Student ID: </b>'. $row['Student_ID'] . "<br>".
                       '<b>Status: </b>'. $row['Student_Status'] . "<br>".
                       '<b>Sessions Joined: </b>'. $row['Sessions_Joined'] . "<br>";
        }
    }
} else {
    $output = "Error: " . $stmt->error;
}

// Close the statement
$stmt->close();

?>

    <!-- // $Student_ID = filter_input(INPUT_POST, "Student_ID", FILTER_SANITIZE_SPECIAL_CHARS);

    // $sql = "SELECT * FROM students WHERE Student_ID = ?";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("s",$Student_ID);
    
    // if (!$stmt->execute()) {
    //     $result = "Error: " . $sql . "<br>" . $conn->error . "<br>";
    // }else{

    //     $stmt->store_result();
    //     $stmt->bind_result($Name_Surname,$Student_ID,$Student_Status,$Sessions_Joined,$Alumni_Batch);
    //     $stmt->fetch();

    //     if($stmt->num_rows == 1){
    //         $result = '<b>Name: </b>'. $Name_Surname . "<br>".
    //                   '<b>Student ID: </b>'. $Student_ID . "<br>".
    //                   '<b>Status: </b>'. $Student_Status . "<br>".
    //                   '<b>Sessions Joined: </b>'. $Sessions_Joined . "<br>";
    //     }
    //     else if($stmt->num_rows > 1){
    //         $result = "Duplicates data are found";
    //     }
    //     else{
    //         $result = "No user found";
    //     }
    // } -->

