<?php
include '../db_connect.php';
session_start();



// Get the form data
$source_account = $_POST['source_account'];
$destination_account = $_POST['destination_account'];
$amount = floatval($_POST['amount']);
$description = $_POST['description'];

// Check for sufficient balance
$balance_check_sql = "SELECT account_balance FROM accounts WHERE account_id = ?";
$balance_stmt = $conn->prepare($balance_check_sql);
$balance_stmt->bind_param("i", $source_account);
$balance_stmt->execute();
$balance_stmt->bind_result($current_balance);
$balance_stmt->fetch();
$balance_stmt->close();

if ($current_balance < $amount) {
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
                background-color: #e0f7fa; /* Light blue background */
            }
            .error-message {
                padding: 20px;
                border: 2px solid #f44336; /* Red border */
                background-color: #ffcdd2; /* Light red background */
                color: #d32f2f; /* Darker red text */
                border-radius: 5px;
                text-align: center;
            }
            a {
                display: inline-block;
                margin-top: 10px;
                padding: 10px 20px;
                background-color: #f44336; /* Red button */
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
            a:hover {
                background-color: #e53935; /* Darker red on hover */
            }
        </style>
    </head>
    <body>
        <div class='error-message'>
            Error: Insufficient funds in the source account.
            <br>
            <a href='transfer_funds.php'>Go Back</a>
        </div>
    </body>
    </html>";
    exit;
}

// Begin transaction
$conn->begin_transaction();

try {
    // Update balances
    $sql = "UPDATE accounts SET account_balance = account_balance - ? WHERE account_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $amount, $source_account);
    $stmt->execute();

    $sql2 = "UPDATE accounts SET account_balance = account_balance + ? WHERE account_id = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("di", $amount, $destination_account);
    $stmt2->execute();

    // Insert transaction record
    $transaction_sql = "INSERT INTO transactions (source_account_id, destination_account_id, transaction_date, transaction_type, amount, description) VALUES (?, ?, NOW(), 'transfer', ?, ?)";
    $transaction_stmt = $conn->prepare($transaction_sql);
    $transaction_stmt->bind_param("ssds", $source_account, $destination_account, $amount, $description);
    
    if (!$transaction_stmt->execute()) {
        throw new Exception('Transaction insertion failed');
    }

    // Commit the transaction
    $conn->commit();

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Transfer Successful</title>
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
            Funds transferred successfully! 
            <br>
            <a href='view_transactions.php'>View Transactions</a>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = 'view_transactions.php';
            }, 3000);
        </script>
    </body>
    </html>";
} catch (Exception $e) {
    $conn->rollback(); // Rollback in case of error
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
                background-color: #e0f7fa; /* Light blue background */
            }
            .error-message {
                padding: 20px;
                border: 2px solid #f44336; /* Red border */
                background-color: #ffcdd2; /* Light red background */
                color: #d32f2f; /* Darker red text */
                border-radius: 5px;
                text-align: center;
            }
            a {
                display: inline-block;
                margin-top: 10px;
                padding: 10px 20px;
                background-color: #f44336; /* Red button */
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
            a:hover {
                background-color: #e53935; /* Darker red on hover */
            }
        </style>
    </head>
    <body>
        <div class='error-message'>
            Error: " . $e->getMessage() . "
            <br>
            <a href='transfer_funds.php'>Go Back</a>
        </div>
    </body>
    </html>";
}

// Close the statements and connection
$stmt->close();
$stmt2->close();
$transaction_stmt->close();
$conn->close();
?>
