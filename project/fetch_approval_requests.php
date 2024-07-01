<?php
// Start session to manage user login status
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Your database password
$database = "gecgdatabase"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch approval requests
$sql = "SELECT * FROM approval_request";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $approval_requests = array();
    while ($row = $result->fetch_assoc()) {
        $approval_requests[] = $row;
    }
    echo json_encode($approval_requests);
} else {
    echo json_encode(array()); // Return an empty array if no approval requests found
}

// Close connection
$conn->close();
?>
