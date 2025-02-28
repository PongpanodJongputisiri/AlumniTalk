<?php
// Get user input and sanitize it
$keyword = filter_input(INPUT_POST, 'search_keyword', FILTER_SANITIZE_SPECIAL_CHARS);
$keyword = trim($keyword); // Trim whitespace

if (empty($keyword)) {
    echo "Please enter a search keyword.";
    exit;
}

// Initialize SQL statement
$sql = "";
$stmt = null;

if (stripos($keyword, " ") !== false) { 
    // Case: Full Name (contains space)
    $sql = "SELECT * FROM AlumniTalkProfile WHERE Alumni_Speaker = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $keyword);

} elseif (stripos($keyword, "ATalk") !== false) { 
    // Case: Seminar ID (contains "ATalk")
    $sql = "SELECT * FROM AlumniTalkProfile WHERE Seminar_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $keyword);

} elseif (strpos($keyword, "-") !== false || strpos($keyword, "/") !== false || strtotime($keyword) !== false) { 
    // Case: Date format
    $sql = "SELECT * FROM AlumniTalkProfile WHERE `Date` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $keyword);

} elseif (ctype_alpha($keyword) || preg_match('/^\p{Thai}+$/u', $keyword) ||stripos($keyword, ".") !== false) { 
    // Case: Name (Thai or English)
    $sql = "SELECT * FROM AlumniTalkProfile WHERE Alumni_Speaker LIKE ? OR Event_Name LIKE ?";
    $stmt = $conn->prepare($sql);
    
    $searchValue = "%$keyword%"; // Add wildcards for LIKE search
    $stmt->bind_param("ss", $searchValue, $searchValue);

} else {
    echo "Couldn't search for that keyword.";
    exit;
}

// Execute the query
if ($stmt->execute()) {
    $result = $stmt->get_result(); // Fetch result set

    if ($result->num_rows == 0) {
        $output = "No profile found";
    } elseif ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $output = "<b>Seminar ID: </b>" . $row['Seminar_ID'] . "<br>" .
                  "<b>Speaker: </b>" . $row['Alumni_Speaker'] . "<br>" .
                  "<b>Event Name: </b>" . $row['Event_Name'] . "<br>" .
                  "<b>Date: </b>" . $row['Date'] . "<br>" .
                  "<b>Time Frame: </b>" . $row['Start_Time'] . " - " . $row['End_Time'] . "<br>";
    } else {
        // Handle multiple results
        $output = "Multiple results found:<br>";
        while ($row = $result->fetch_assoc()) {
            $output .= "<hr><b>Seminar ID: </b>" . $row['Seminar_ID'] . "<br>" .
                       "<b>Speaker: </b>" . $row['Alumni_Speaker'] . "<br>" .
                       "<b>Event Name: </b>" . $row['Event_Name'] . "<br>" .
                       "<b>Date: </b>" . $row['Date'] . "<br>" .
                       "<b>Time Frame: </b>" . $row['Start_Time'] . " - " . $row['End_Time'] . "<br>";
        }
    }
} else {
    $output = "Error: " . $stmt->error;
}

// Close the statement
$stmt->close();

?>