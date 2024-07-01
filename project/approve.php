
<?php
//this is approve.php
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

// Get request ID from URL parameter
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $request_id = $_GET['id'];

    // Update status to "Approved"
    $sql = "UPDATE approval_request SET status='approved' WHERE request_id=$request_id";

    if ($conn->query($sql) === TRUE) {
        echo "Request approved successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>
