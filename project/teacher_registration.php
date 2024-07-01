<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // This is empty assuming you're using a local environment
$database = "gecgdatabase"; // Change this to your actual database name

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $mobile = $_POST['mobile'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $branch = $_POST['branch'];

    // Check if passwords match
    $confirmPassword = $_POST['confirmPassword'];
    if ($password !== $confirmPassword) {
        die("Error: Passwords do not match");
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind the SQL statement
    $sql = "INSERT INTO teachers (first_name, last_name, mobile_number, username,password, branch) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $firstName, $lastName, $mobile,$username, $hashedPassword, $branch);

    if ($stmt->execute()) {
        echo "New record created successfully";
        header("Location:teacherlogin.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
<link rel="shortcut icon" href="GECG_logo.png" type="image/x-icon">
    <title>Sign Up Form</title>
    <style>
    
   
form {
    background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    padding: 40px;
    width: 300px;
    margin-left: 38%;
    margin-top: 150px;
    margin-bottom: 10%;
}

.form-group {
    margin-bottom: 20px;
}

label {
    color: #333;
    display: block;
    font-size: 14px;
    margin-bottom: 5px;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="password"]:focus {
    border-color: #007bff;
}

button {
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    padding: 10px 20px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}
    </style>

</head>
<body>
    
   
        <form action="teacher_registration.php" method="POST" onsubmit="return validateEmail()">
            <h1>Sign Up</h1>
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
                <label for="lastName">Surname:</label>
                <input type="text" id="lastName" name="lastName" required>
            </div>
           
            <div class="form-group">
                <label for="mobile">Mobile number:</label>
                <input type="text" id="mobile" name="mobile" required>
            </div>
            <div class="form-group">
                <label for="Email">Email address:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>
            <div class="form-group">
                <label for="Branch">Branch:</label>
                <select id="branch" name="branch" required>
                    <option value="CE">BE-Computer Engineering</option>
                    <option value="it">BE-Information Technology</option>
                    <option value="Bio_M">BE-Bio-Medical Engineering</option>
                    <option value="IC">BE-Instrumentation & Control Engineering</option>
                    <option value="EC">BE-Electronics & Communication Engineeting</option>
                    <option value="Met_E">BE-Metallurg Engineering</option>
                    <option value="MEch_E">BE-Metallurgy Engineering</option>
                    <option value="Civil_E">BE-Civil Engineering</option>
                    <option value="RAE">BE-Robotics and Automation Engineering</option>
                    <option value="EE">BE-Electrical Engineering</option>
                    
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit">Sign Up</button>
            </div>
            <p style="text-align: center;"><a href="teacherlogin.php">Go Back!</a></p>
        </form>
        <script>
            function validateEmail() {
    var email = document.getElementById('username').value;
    var emailPattern = /^[\w-]+@(gecg28\.ac\.in)$/;
    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address in the format: 210130107033@gecg28.ac.in');
        return false;
    }
    return true;
}
        </script>


 
</body>
</html>

