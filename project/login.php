<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="GECG_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">

    <title>GECG Login</title>
    <style>
 
        
    body {
      margin: 0;
      height: 100vh;
      background-image: linear-gradient(
        #000000, #080808, #101010, #181818, #202020, #282828, #303030, #383838, #404040, #484848,
        #505050, #585858, #606060, #686868, #696969, #707070, #787878, #808080, #888888, #909090,
        #989898, #A0A0A0, #A8A8A8, #A9A9A9, #B0B0B0, #B8B8B8, #BEBEBE, #C0C0C0, #C8C8C8, #D0D0D0,
        #D3D3D3, #D8D8D8, #DCDCDC, #E0E0E0, #E8E8E8, #F0F0F0, #F5F5F5, #F8F8F8, #FFFFFF);
    }
        #message{
            text-align:center;
            color:red;
        }
      form {
    background-color: white; /* Semi-transparent white background */
  border-radius: 10px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  padding: 40px;
  width: 300px;
  margin-left: 40%;
  margin-top: 2.5%;
  margin-bottom: 2.5%;
}

     
        form img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px; /* Adjust as needed */
        }
        
    </style>
</head>
<body>
    <form action="http://localhost/project/login.php" method="post">
        <img src="GECG_logo.png" alt="GECG Logo">
        <div class="form-container">
            <hr>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required placeholder="Enter Your Name Here">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required placeholder="Password">
            </div>
            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
            <div id="message"></div>
            <p  style="text-align: center"><a href="pro_registration.php">Create new account</a></p>
            <p style="text-align: center;"><a href="index.html">Go Home</a></p>
        </div>
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
    $sql = "SELECT username, password FROM users WHERE username = ?";
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
            header("Location: welcomepage.php");
            exit();
        } else {
            // Password is incorrect
            echo "<script>
            document.getElementById('message').innerHTML = 'Invalid password!';
       

            </script>";
        }
    } else {
        // Username doesn't exist
        echo "<script>
        document.getElementById('message').innerHTML = 'Invalid username';
        </script>";
    }


    $stmt->close();
}

$conn->close();
?>

</body>
</html>
