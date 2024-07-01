<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

// Check if the enrollment number is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enrollment_number'])) {
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

    // Prepare and execute SQL query to retrieve status based on enrollment number
    $enrollment_number = $_POST['enrollment_number'];
    $sql = "SELECT status FROM approval_request WHERE enrollment_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $enrollment_number);
    $stmt->execute();
    $stmt->store_result();

    // Check if the enrollment number exists in the database
    if ($stmt->num_rows > 0) {
        // Bind result variables
        $stmt->bind_result($status);
        $stmt->fetch();

        echo "<h2>Status of Enrollment Number: $enrollment_number</h2>";
        echo "<p>Status: $status</p>";
    } else {
        // Enrollment number not found
        echo "<h2>No record found for Enrollment Number: $enrollment_number</h2>";
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to the check status page if the enrollment number is not submitted
    header("Location: check_status.html");
    exit();
}
?>
