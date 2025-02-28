<?php

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM AlumniTalkProfile";
$query = $conn->query($sql);
$records = $query->num_rows;

if ($records > 0) {

    $output .= "<b style='font-size:20px;'> Found $records row(s) of record(s) </b><br><br>";

    $output .= "<table border='1' >";
    $output .=  "<tr><th>Seminar ID</th><th>Event Name</th><th>Date</th><th>Start</th><th>End</th><th>Speaker</th></tr>";
    while ($row = $query->fetch_assoc()) {
        $output .= "<tr>";
        $output .= "<td>" . $row["Seminar_ID"] . "</td>";
        $output .= "<td>" . $row["Event_Name"] . "</td>";
        $output .= "<td>" . $row["Date"] . "</td>";
        $output .= "<td>" . $row["Start_Time"] . "</td>";
        $output .= "<td>" . $row["End_Time"] . "</td>";
        $output .= "<td>" . $row["Alumni_Speaker"] . "</td>";
        $output .= "</tr>";
    }
    $output .=  "</table>";
} else {
    $output = "No records found.";
}


?>