<?php
session_start();

// Check if user is not logged in, then redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: welcomepage.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $purpose = trim($_POST["purpose"]);
    // Assuming you also have $enrollment_number and $username available, otherwise retrieve them from the session

    // Check if all fields are filled
    if (empty($purpose)) {
        echo "Purpose is required";
        exit;
    }

    // Retrieve username from session
    $username = $_SESSION['username'];

    // Database connection
    $servername = "localhost";
    $susername = "root";
    $password = ""; // Your database password
    $database = "gecgdatabase"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $susername, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL statement to insert purpose and username into approval_request table
    $sql_insert = "INSERT INTO approval_request (purpose, username) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ss", $purpose, $username);

    if ($stmt_insert->execute()) {
        // Application submitted successfully
        echo "Purpose submitted successfully.";
    } else {
        // Error handling
        echo "Error: " . $stmt_insert->error;
        exit;
    }

    // Close the insert statement
    $stmt_insert->close();

    // Prepare and execute SQL statement to fetch user details from the users table
    $sql_fetch_user_details = "SELECT first_name, last_name,branch, enrollment_number FROM users WHERE username = ?";
    $stmt_fetch_user_details = $conn->prepare($sql_fetch_user_details);
    $stmt_fetch_user_details->bind_param("s", $username);
    $stmt_fetch_user_details->execute();
    $stmt_fetch_user_details->store_result();

    // Check if the user exists
    if ($stmt_fetch_user_details->num_rows == 1) {
        // Bind result variables
        $stmt_fetch_user_details->bind_result($firstName, $lastName, $branch,$enrollment_number);
        $stmt_fetch_user_details->fetch();

        // Combine first name and last name to create the full name
        $fullName = $firstName . " " . $lastName;

        // Close the fetch user details statement
        $stmt_fetch_user_details->close();

        // Prepare and execute SQL statement to update the approval_request table with the fetched user details
        $sql_update_user_details = "UPDATE approval_request SET name = ?,branch=?, enrollment_number = ? WHERE username = ?";
        $stmt_update_user_details = $conn->prepare($sql_update_user_details);
        $stmt_update_user_details->bind_param("ssss", $fullName, $branch,$enrollment_number, $username);

        if ($stmt_update_user_details->execute()) {
            // User details updated successfully
            echo "User details updated successfully.";
            header("Location: welcomepage.php");
            exit;
        } else {
            // Error handling
            echo "Error: " . $stmt_update_user_details->error;
            exit;
        }

        // Close the update user details statement
        $stmt_update_user_details->close();
    } else {
        // Handle the case when user details are not found
        echo "User details not found";
        exit;
    }

    // Close the connection
    $conn->close();
} else {
    // Redirect to the form page if accessed directly
    header("Location: index.html");
    exit;
}
?>
