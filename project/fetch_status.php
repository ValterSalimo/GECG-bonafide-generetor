<?php
$servername = "localhost";
$username = "root";
$password = ""; // Assuming you're using a local environment and the password is empty
$database = "gecgdatabase"; // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have the identifier value stored in $id
$id = $_GET['id']; // Retrieve the identifier value from the URL query parameter

// Fetch the status from the database based on your query
$sql = "SELECT status FROM approval_request WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // Assuming the identifier column type is integer (change 'i' if it's not)
$stmt->execute();
$stmt->bind_result($status);
$stmt->fetch();
$stmt->close();

// Echo the status as JSON so it can be accessed by JavaScript
echo json_encode(['status' => $status]);
?>
