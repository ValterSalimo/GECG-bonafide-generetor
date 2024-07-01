<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: welcomepage.php"); // Redirect to login page if not logged in
    exit();
}

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

// Fetch username from session
$request_id = $_GET['request_id'];

// Prepare and bind
$stmt = $conn->prepare("SELECT enrollment_number, name, purpose,branch FROM approval_request WHERE request_id = ?");
$stmt->bind_param("s", $request_id);
$stmt->execute();

$result = $stmt->get_result(); // get the mysqli result
if ($result->num_rows > 0) {
  // Output data of first row
  $row = $result->fetch_assoc();
  $data = array(
    'success' => true,
    'enrollment_number' => $row["enrollment_number"],
    'name' => $row["name"],
    'purpose' => $row["purpose"],
    'branch' => $row["branch"],
  );
} else {
  $data = array('success' => false);
}

// Close database connection
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="GECG_logo.png" type="image/x-icon">
  
    <title>Certificate</title>
    <style>


        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .certificate-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 2px solid #000;
            border-radius: 10px;
        
        }
        .certificate-header {
            text-align: center;
        }
        .certificate-header img {
            width: 100px;
            margin-bottom: 20px;
        }
        .certificate-body {
            text-align: justify;
            margin-top: 20px;
        }
        .signature {
            margin-top: 40px;
            text-align: center;
        }
        .stamp img {
            width: 100px;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            width:100%;
        }
        button:hover {
            background-color: #45a049;
        }
        #footer{
            text-align:right;
        }
        #left{
            text-align:left;
        }
    </style>
</head>
<body>
<button onclick='downloadCertificate();'>Download</button>
<br>
<button onclick='back();'>Go Back</button>

    <?php if ($data['success']): ?>
        <div class="certificate-container">
            <!-- Certificate content -->
            <div class="certificate-header">
                <img src="GECG_logo.png" alt="College Logo">
                <h1>GOVERNMENT ENGINEERING COLLEGE</h1>
                <p>(Government of Gujarat)</p>
                <p>Nr. Animal Vaccine Institute, Sector -28 Gandhinagar - 382 028</p>
            <p><a href="tel:07923216570">07923216570</a> (Office)   |   <a href="Email: principal_gecg@gov.in">principal_gecg@gov.in</a></p>
            <hr>
            <div class="certificate-body">
                <p>No. - GECG/TS/2019/CERT/019</p>
                <h2 style="text-align:center">CHARACTER CERTIFICATE</h2>
                <p>To Whom It May Concern,</p>
                <p>This is to certify that Mr./Ms. <strong><?php echo $data['name']; ?></strong> was a student of our college. He/She was studying in <strong><?php echo $data['branch']; ?></strong> Engineering branch of B.E./M.E. with Enrollment no. <strong><?php echo $data['enrollment_number']; ?></strong>.</p>
                <p>Mr./Ms. <strong><?php echo $data['name']; ?></strong> bears good moral character and to the best of our knowledge throughout his/her academic career. This certificate is issued to him/her for <strong><?php echo $data['purpose']; ?></strong> purpose.</p>
                <div class="signature">
                    <div id="footer">
                    <p id="left">Date: <strong id="date"></strong></p>
                    <p id="left">Place: <strong>GEC Gandhinagar, Sector 28</strong></p>
                    <p>Principal</p>
                    <p>Government Engineering College,</p>
                    <p>Sector -28, Gandhinagar</p>
                    </div>
                    <div class="stamp">
                        <img src="stamp.png" alt="Stamp">
                    </div>
                </div>
            </div>
        </div>
       

    <?php else: ?>
        <p>No data found.</p>
    <?php endif; ?>

    <script>
        function back() {
    window.location.href = "welcomepage.php";
}
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); 
        const day = String(today.getDate()).padStart(2, '0');
        const formattedDate = `${day}/${month}/${year}`;

        // Set the formatted date to the HTML element
        document.getElementById("date").innerHTML = formattedDate;

        function downloadCertificate() {
            const body = document.body.innerHTML;
            const certificateContent = document.querySelector('.certificate-container').innerHTML;
            document.body.innerHTML = certificateContent;
            window.print();
            document.getElementById('body').innerHTML = body;
        }
    </script>
</body>
</html>
