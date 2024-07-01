<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Establish connection to the database
$servername = "localhost";
$username = "root";
$password = ""; // Your database password
$database = "gecgdatabase"; // Your database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];

// Fetch the first name and surname of the user from the database
$sql = "SELECT first_name, last_name FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

// Check if the user exists
if ($stmt->num_rows == 1) {
    // Bind result variables
    $stmt->bind_result($firstName, $lastName);
    $stmt->fetch();

    // Combine first name and surname to display full name
    $fullName = $firstName . " " . $lastName;
} else {
    // Default to displaying username if first name and surname are not found
    $fullName = $username;
}

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="GECG_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styleteacher.css">
    <title>Welcome</title>
    <style>
     
        th{
            background-color:grey;

        }
        tr:hover{
            background-color:	#D3D3D3;
        }
    </style>
   
</head>
<body>
    <header class="logo">
        <img src="GECG_logo.png" alt="logo">
        <h1 style="margin-left: 300px;">GOVERNMENT ENGINEERING COLLEGE,<br> GANDHINAGAR</h1>
    </header>
    <section class="menu-bar">
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="apply.html">Apply</a></li>
            <li><a href="logout.php">Logout</a></li>
            
        </ul>
    </section>
        <h1>Welcome, <?php echo $fullName; ?>!</h1>
    
        <article><h1 style="text-align:center;">Here is your application history:</h1></article>

    <?php
  
    $username = $_SESSION['username'];
        // SQL query to fetch approval requests
        $sql = "SELECT * FROM approval_request WHERE status='pending' AND username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        

        if ($result->num_rows > 0) {
            
            echo "<h2>Pending Requests</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Request ID</th><th>Name</th><th>Enrollment Number</th><th>Purpose</th><th>Status</th><th>Comment</th></tr>";

            
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["request_id"]."</td>";
                echo "<td>".$row["name"]."</td>";
                echo "<td>".$row["enrollment_number"]."</td>";
                echo "<td>".$row["purpose"]."</td>";
                echo "<td>".$row["status"]."</td>";
                echo "<td>".$row["comment"]."</td>";
            }
            echo "</table>";
            echo "<br>";
        } else {
            echo "No Pending requests found.";
        }

        $sql = "SELECT * FROM approval_request WHERE status='approved' AND username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        

        if ($result->num_rows > 0) {
            
            echo "<h2>Approved Requests</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Request ID</th><th>Name</th><th>Enrollment Number</th><th>Purpose</th><th>Status</th><th>Comment</th><th>Dowloand Certificate</th></tr>";

            
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["request_id"]."</td>";
                echo "<td>".$row["name"]."</td>";
                echo "<td>".$row["enrollment_number"]."</td>";
                echo "<td>".$row["purpose"]."</td>";
                echo "<td>".$row["status"]."</td>";
                echo "<td>".$row["comment"]."</td>";
                echo "<td><a href='generate_certificate.php?request_id=".$row["request_id"]."'><div>Download<div></a></td>";
            }
            echo "</table>";
            echo "<br>";
        } else {
            echo "No approved requests found.";
        }

        $sql = "SELECT * FROM approval_request WHERE status='rejected' AND username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        

        if ($result->num_rows > 0) {
            
            echo "<h2>Rejected Requests</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Request ID</th><th>Name</th><th>Enrollment Number</th><th>Purpose</th><th>Status</th><th>Comment</th></tr>";

            
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["request_id"]."</td>";
                echo "<td>".$row["name"]."</td>";
                echo "<td>".$row["enrollment_number"]."</td>";
                echo "<td>".$row["purpose"]."</td>";
                echo "<td>".$row["status"]."</td>";
                echo "<td>".$row["comment"]."</td>";
            }
            echo "</table>";
            echo "<br>";
        } else {
            echo "<br>";
            echo "<p>No Rejected Application found.</p>";
        }
        ?>

</body>
</html>
