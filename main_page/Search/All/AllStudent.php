<?php

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM students";
$query = $conn->query($sql);
$records = $query->num_rows;

if ($records > 0) {

    $output .= "<b style='font-size:20px;'> Found $records row(s) of record(s) </b><br><br>";

    $output .= "<table border='1' >";
    $output .= "<tr><th>Student ID</th><th>Alumni Batch</th><th>Name-Surname</th><th>Student Status</th><th>Session(s) Joined</th><th>Tier</th></tr>";
    while ($row = $query->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . $row["Student_ID"] . "</td>";
        $output .= "<td>" . $row["Name_Surname"] . "</td>";
        $output .= "<td>" . $row["Student_Status"] . "</td>";
        $output .= "<td>" . $row["Sessions_Joined"] . "</td>";
        $output .= "<td>" . $row["Tier"] . "</td>";
        $output .= "</tr>";
    }
    $output .=  "</table>";
} else {
    $output = "No records found.";
}


?>