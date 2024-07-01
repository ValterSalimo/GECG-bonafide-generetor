<?php
//this is reject.php
$servername = "localhost";
$username = "root";
$password = ""; // Your database password
$database = "gecgdatabase"; // Your database name

// Get request ID from URL parameter
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $request_id = $_GET['id'];

    // Update status to "Rejected"
    $sql = "UPDATE approval_request SET status='rejected' WHERE request_id=$request_id";

    if ($conn->query($sql) === TRUE) {
        echo "Request rejected successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
