<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="GECG_logo.png" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #bac0c7;
        }
        #message{
            text-align: center;
            color:red;

        }
    </style>
    <title>GECG Teacher Login</title>
</head>
<body>
    
    <form action="http://localhost/project/teacherlogin.php" method="post">
        <div id="message"></div>
        <h1>LOGIN HERE:</h1>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required placeholder="Example@gecg28.ac.in">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required placeholder="Password">
        </div>
        <div class="form-group">
            <button type="submit">Submit</button>
        </div>
        <p style="text-align: center;"><a href="http://localhost/project/teacher_registration.php">Click here if you do not have account!</a></p>
    </form>
    <?php
    // Start session to manage user login status
    session_start();

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = ""; // This is empty assuming you're using a local environment
    $database = "gecgdatabase"; // Change this to your actual database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Form submission handling
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare and bind the SQL statement
        $sql = "SELECT username, password FROM teachers WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Check if username exists
        if ($stmt->num_rows == 1) {
            // Bind result variables
            $stmt->bind_result($dbUsername, $hashedPassword);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashedPassword)) {
                // Password is correct, start a new session
                $_SESSION['username'] = $username;
                // Redirect to teacher dashboard or any other page
                header("Location: http://localhost/project/teacher.php");
                exit();
            } else {
                // Password is incorrect
                echo "<script>document.getElementById('message').innerHTML = 'Invalid password!';</script>";
            }
        } else {
            // Username doesn't exist
            echo "<script>document.getElementById('message').innerHTML = 'Invalid username';</script>";
        }

        $stmt->close();
    }

    $conn->close();
    ?>
</body>
</html>
