<?php
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

// Fetch data from the database
$sql = "SELECT name, email, message FROM contact_messages";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages</title>
    <link rel="stylesheet" href="styleteacher.css">
    <link rel="shortcut icon" href="GECG_logo.png" type="image/x-icon">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
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
        <li><a href="teacher.php">Teachers page</a></li>
    </ul>
</section>
    <h2>Contact Messages</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["message"] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No messages found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
