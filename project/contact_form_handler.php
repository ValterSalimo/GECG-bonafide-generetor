!
<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gecgdatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Prepare SQL statement to insert data into the table
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        // If the data is inserted successfully, redirect back to the contact page with a success message
        header("Location: contact_us.html?status=success");
        exit();
    } else {
        // If there is an error inserting the data, redirect back to the contact page with an error message
        header("Location: contact_us.html?status=error");
        exit();
    }
} else {
    // If the form is not submitted, redirect back to the contact page
    header("Location: contact_us.html");
    exit();
}

// Close the database connection
$conn->close();
?>
