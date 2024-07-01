<?php

// Include Visa API library
require_once('visa_api.php');

// Function to process Visa payment
function processVisaPayment($amount, $cardNumber, $expiryMonth, $expiryYear, $cvv) {
    // Initialize Visa API client
    $visaClient = new VisaClient();

    // Make payment request
    $paymentResponse = $visaClient->makePayment($amount, $cardNumber, $expiryMonth, $expiryYear, $cvv);

    // Check payment response
    if ($paymentResponse['status'] == 'success') {
        return true; // Payment successful
    } else {
        return false; // Payment failed
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get amount and card details from form
    $amount = $_POST["amount"];
    $cardNumber = $_POST["card_number"];
    $expiryMonth = $_POST["expiry_month"];
    $expiryYear = $_POST["expiry_year"];
    $cvv = $_POST["cvv"];

    // Process Visa payment
    $paymentSuccess = processVisaPayment($amount, $cardNumber, $expiryMonth, $expiryYear, $cvv);

    if ($paymentSuccess) {
        // Payment successful, redirect to success page
        header("Location: payment_success.php");
        exit;
    } else {
        // Payment failed, redirect to error page
        header("Location: payment_error.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chapa Payment</title>
</head>
<body>
    <h1>Chapa Payment</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="amount">Amount:</label>
        <input type="text" name="amount" id="amount" value="10"> <!-- Example amount, replace with dynamic value -->
        <br>
        <label for="card_number">Card Number:</label>
        <input type="text" name="card_number" id="card_number" required>
        <br>
        <label for="expiry_month">Expiry Month:</label>
        <input type="text" name="expiry_month" id="expiry_month" required>
        <br>
        <label for="expiry_year">Expiry Year:</label>
        <input type="text" name="expiry_year" id="expiry_year" required>
        <br>
        <label for="cvv">CVV:</label>
        <input type="text" name="cvv" id="cvv" required>
        <br>
        <input type="submit" value="Pay">
    </form>
</body>
</html>
