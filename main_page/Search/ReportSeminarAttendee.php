<?php

$Seminar_ID = filter_input(INPUT_POST, "Seminar_ID", FILTER_SANITIZE_SPECIAL_CHARS);

if ($Seminar_ID) {
    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM participants WHERE Seminar_ID = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $Seminar_ID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $output = "<table border='1'>";
            $output .= "<tr><th>Seminar ID</th><th>Student Name</th><th>Register Time</th></tr>";

            while ($row = $result->fetch_assoc()) {
                $output .= "<tr>";
                $output .= "<td>" . htmlspecialchars($row["SEMINAR_ID"]) . "</td>";
                $output .= "<td>" . htmlspecialchars($row["Student_ID"]) . "</td>";
                $output .= "<td>" . htmlspecialchars($row["Register_time"]) . "</td>";
                $output .= "</tr>";
            }
            $output .= "</table>";
        } else {
            $output = "No records found.";
        }

        $stmt->close();
    } else {
        $output = "Database error. Please try again later.";
        error_log("SQL Error: " . $conn->error); // Log error instead of displaying
    }
} else {
    $output = "Invalid Seminar ID.";
}

?>