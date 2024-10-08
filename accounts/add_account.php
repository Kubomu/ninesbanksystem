<?php
include '../db_connect.php';

// Check if the form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $account_number = $_POST['account_number'];
    $balance = $_POST['account_balance'];
    $account_type = $_POST['account_type'];
    $account_open_date = $_POST['account_open_date'];
    $status = $_POST['status'];

    // Insert the account data into the accounts table
    $sql = "INSERT INTO accounts (customer_id, account_number, account_balance, account_open_date, status, account_type)
            VALUES ('$customer_id', '$account_number', '$balance', '$account_open_date', '$status', '$account_type')";

    if ($conn->query($sql) === TRUE) {
        // Display success message and redirect after 3 seconds
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
                    color: #2e7d32; /* Darker green text */
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
                Account added successfully! Redirecting to view accounts...
                <br>
                <a href='view_accounts.php'>Click here if you are not redirected</a>
            </div>
            <script>
                // Redirect after 3 seconds
                setTimeout(function() {
                    window.location.href = 'view_accounts.php';
                }, 3000);
            </script>
        </body>
        </html>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
