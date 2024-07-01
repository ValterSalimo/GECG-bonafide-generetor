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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through each approval request
    foreach ($_POST['action'] as $request_id => $action) {
        $comment = $_POST['comment'][$request_id];

        // Update the status and comment of the approval request
        $sql = "UPDATE approval_request SET status = ?, comment = ? WHERE request_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $action, $comment, $request_id);
        $stmt->execute();
    }

    // Redirect back to the dashboard
    header("Location: teacher.php");
    exit();
}

// Close connection
$conn->close();
?>
