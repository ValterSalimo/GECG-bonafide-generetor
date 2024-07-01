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
    $enrolmentNumber = $_POST['enrolmentNumber'];
    $mobile = $_POST['mobile'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $branch = $_POST['branch'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $gender = $_POST['gender'];
    
     // Check if passwords match
     $confirmPassword = $_POST['confirmPassword'];
     if ($password !== $confirmPassword) {
         die("Error: Passwords do not match");
     }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (first_name, last_name, enrollment_number, mobile_number, username, password, branch, date_of_birth, gender)
    VALUES ('$firstName', '$lastName', '$enrolmentNumber', '$mobile', '$username', '$hashedPassword', '$branch', '$dateOfBirth', '$gender')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("location: login.php"); 
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
        form { background-color: rgba(255, 255, 255, 0.8); 
            border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
             padding: 40px; width: 300px;
            margin-left: 38%;
            margin-top: 80px; 
               margin-bottom: 5%; } 
             .form-group { margin-bottom: 20px; } 
             label { color: #333; display: block; font-size: 14px; margin-bottom: 5px; }
              input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; transition: border-color 0.3s ease; }
               input[type="text"]:focus, input[type="password"]:focus { border-color: #007bff; } 
               button { background-color: #007bff; 
                border: none; border-radius: 5px; 
                color: #fff; cursor: pointer; padding: 10px 20px; 
                transition: background-color 0.3s ease; }
                button:hover { background-color: #0056b3; }
                option{
                    background-color: grey; 
                border: none; border-radius: 5px; 
                color: #fff; cursor: pointer; padding: 10px 20px; 
                transition: background-color 0.3s ease;
                }
                select{
                    border:none;
                    border-radius:6px;
                }
    </style>
</head>
<body>
    <form action="pro_registration.php" method="POST" onsubmit="return validateEmail()">
        <h1>Sign Up</h1>
        <div class="form-group">
            <label for="firstName">Name:</label>
            <input type="text" id="firstName" name="firstName" required placeholder="First & Middle name">
        </div>
        <div class="form-group">
            <label for="lastName">Surname:</label>
            <input type="text" id="lastName" name="lastName" required placeholder="Surname">
        </div>
        <div class="form-group">
            <label for="enrol">Enrolment number:</label>
            <input type="text" id="enrolmentNumber" name="enrolmentNumber" required placeholder="21013010700">
        </div>
        <div class="form-group">
            <label for="mobile">Mobile number:</label>
            <input type="text" id="mobile" name="mobile" required placeholder="Mobile number">
        </div>
        <div class="form-group">
            <label for="username">Email address:</label>
            <input type="text" id="username" name="username" required placeholder="Example:210130107000@gecg28.ac.in">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required placeholder="Password">
        </div>
        <div class="form-group">
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Enter same Password">
        </div>
        <div class="form-group">
            <label for="branch">Branch:</label>
            <select id="branch" name="branch" required>
                <option value="Computer Engineering">BE-Computer Engineering</option>
                <option value="Information Technology">BE-Information technology</option>
                <option value="Bio-Medical Engineering">BE-Bio-Medical Engineering</option>
                <option value="Instrumentation & Control Engineering">BE-Instrumentation & Control Engineering</option>
                <option value="ECElectronics & Communication Engineeting">BE-Electronics & Communication Engineeting</option>
                <option value="Metallurg Engineering">BE-Metallurg Engineering</option>
                <option value="Metallurgy Engineering">BE-Metallurgy Engineering</option>
                <option value="Civil Engineering">BE-Civil Engineering</option>
                <option value="Robotics and Automation Engineering">BE-Robotics and Automation Engineering</option>
                <option value="Electrical Engineering">BE-Electrical Engineering</option>
            </select>
        </div>
        <div class="form-group">
            <label for="dateOfBirth">Date of birth:</label>
            <input type="date" id="dateOfBirth" name="dateOfBirth" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit">Sign Up</button>
        </div>
        <p style="text-align: center;"><a href="http://localhost/project/index.html">Go Home</a></p>
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
