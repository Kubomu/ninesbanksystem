<?php
include '../db_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $account_id = $_POST['account_id'];
    $customer_id = $_POST['customer_id'];
    $account_number = $_POST['account_number'];
    $account_balance = $_POST['account_balance'];
    $account_type = $_POST['account_type'];
    $status = $_POST['status'];

    // Update the account in the database
    $sql = "UPDATE accounts SET 
                customer_id = '$customer_id',
                account_number = '$account_number',
                account_balance = '$account_balance',
                account_type = '$account_type',
                status = '$status'
            WHERE account_id = $account_id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the account list after successful update
        header("Location: view_accounts.php");
        exit(); // Terminate script to ensure no further output is sent
    } else {
        echo "Error updating account: " . $conn->error;
    }
}

$conn->close();
?>
