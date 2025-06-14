<?php
$conn = new mysqli("localhost", "root", "", "yourdietbuddy_db");
$social_links = [];
if (!$conn->connect_error) {
    $result = $conn->query("SELECT * FROM social_links");
    while ($row = $result->fetch_assoc()) {
        $social_links[] = $row;
    }
    $conn->close();
}
?>