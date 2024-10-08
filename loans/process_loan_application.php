<?php
include '../db_connect.php';

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data and sanitize inputs
    $customer_id = (int)$_POST['customer_id']; // Ensure this is an integer
    $loan_type = $conn->real_escape_string($_POST['loan_type']);
    $loan_amount = (float)$_POST['loan_amount']; // Ensure this is a float
    $interest_rate = (float)$_POST['interest_rate']; // Ensure this is a float
    $loan_start_date = $conn->real_escape_string($_POST['loan_start_date']); // Sanitize input

    // Calculate total interest and amount payable
    $total_interest = ($loan_amount * $interest_rate) / 100;
    $total_amount_payable = $loan_amount + $total_interest;

    // Insert loan application into the database
    $sql = "INSERT INTO loans (customer_id, loan_type, loan_amount, interest_rate, loan_start_date, total_amount_payable) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }

    // Bind parameters (i = integer, s = string, d = double/float)
    $stmt->bind_param("isddss", $customer_id, $loan_type, $loan_amount, $interest_rate, $loan_start_date, $total_amount_payable);

    // Execute the statement and handle success or failure
    if ($stmt->execute()) {
        // Success - Display success message and redirect
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Success</title>
            <style>
                body {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                    margin: 0;
                    font-family: Arial, sans-serif;
                    background-color: #e0f7fa; /* Light blue background */
                }
                .message {
                    padding: 20px;
                    border: 2px solid #4CAF50; /* Green border */
                    background-color: #c8e6c9; /* Light green background */
                    color: #2e7d32; /* Dark green text */
                    border-radius: 5px;
                    text-align: center;
                }
                a {
                    display: inline-block;
                    margin-top: 10px;
                    padding: 10px 20px;
                    background-color: #4CAF50; /* Green button */
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                }
                a:hover {
                    background-color: #45a049; /* Darker green on hover */
                }
            </style>
        </head>
        <body>
            <div class='message'>
                Loan added successfully! The total amount payable is: " . number_format($total_amount_payable, 2) . " <br> Redirecting to view loans...
                <br>
                <a href='view_loans.php?customer_id=" . urlencode($customer_id) . "'>Click here if you are not redirected</a>
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = 'view_loans.php?customer_id=" . urlencode($customer_id) . "';
                }, 3000);
            </script>
        </body>
        </html>";
    } else {
        // Failure - Display error message
        echo "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Error</title>
            <style>
                body {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                    margin: 0;
                    font-family: Arial, sans-serif;
                    background-color: #f8d7da; /* Light red background */
                }
                .error {
                    padding: 20px;
                    border: 2px solid #dc3545; /* Red border */
                    background-color: #f5c6cb; /* Light pink background */
                    color: #721c24; /* Dark red text */
                    border-radius: 5px;
                    text-align: center;
                }
                a {
                    display: inline-block;
                    margin-top: 10px;
                    padding: 10px 20px;
                    background-color: #dc3545; /* Red button */
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                }
                a:hover {
                    background-color: #c82333; /* Darker red on hover */
                }
            </style>
        </head>
        <body>
            <div class='error'>
                Error: " . htmlspecialchars($stmt->error) . " <br>
                Please try again. <br>
                <a href='loan_application_form.php'>Back to Loan Application</a>
            </div>
        </body>
        </html>";
    }

    // Close the statement
    $stmt->close();
} else {
    // Redirect if the request method is not POST
    header("Location: loan_application_form.php");
    exit();
}

// Close the database connection
$conn->close();
?>
