<?php
//teacher
// Start session to manage user login status
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: teacherlogin.php"); 
    exit();
}

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
$username = $_SESSION['username'];

// Fetch the first name and surname of the user from the database
$sql = "SELECT first_name, last_name FROM teachers WHERE username = ?";
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
    <title>Teacher Dashboard</title>
    <link rel="shortcut icon" href="GECG_logo.png" type="image/x-icon">
   <link rel="stylesheet" href="styleteacher.css">
   <style>
    table{
        margin-left:20px;
        border-radius:8px;
    }
    button{
        margin-left 30px;
    }
   </style>
</head>
<body>
    <!-- Content area -->
    <header class="logo">
            <img src="GECG_logo.png" alt="logo">
            <h1 style="margin-left: 300px;">GOVERNMENT ENGINEERING COLLEGE,<br> GANDHINAGAR</h1>
        
        </header>
        <section class="menu-bar">
    <ul>
        <li><a href="contact_us_teacher_view.php">View Queries</a></li>
        <li><a href="index.html">Student Page</a></li>
    </ul>
</section>
    <div>
        <h1>Welcome, <?php echo $fullName; ?>!</h1>
        <h2>List of Approval Requests</h2>
        <!-- PHP code to fetch data from the database and display in a table -->
        <?php
        // SQL query to fetch approval requests
        $sql = "SELECT * FROM approval_request WHERE status='pending'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output table header
            echo "<form action='submit_approval.php' method='post'>";
            echo "<table border='1'>";
            echo "<tr><th>Request ID</th><th>Name</th><th>Enrollment Number</th><th>Purpose</th><th>Status</th><th>Action</th><th>Comment</th></tr>";

            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["request_id"]."</td>";
                echo "<td>".$row["name"]."</td>";
                echo "<td>".$row["enrollment_number"]."</td>";
                echo "<td>".$row["purpose"]."</td>";
                echo "<td>".$row["status"]."</td>";
                echo "<td><input type='radio' name='action[".$row["request_id"]."]' value='approved'> Approve | <input type='radio' name='action[".$row["request_id"]."]' value='rejected'> Reject</td>";
                echo "<td><input type='text' name='comment[".$row["request_id"]."]'></td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<br>";
            echo "<button type='submit'>Submit</button>";
            echo "</form>";
        } else {
            echo "No approval requests found.";
        }
        ?>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
