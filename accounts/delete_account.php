<?php
include '../db_connect.php';

// Check if the account ID is provided
if (isset($_GET['id'])) {
    $account_id = $_GET['id'];

    // Delete the account from the accounts table
    $sql = "DELETE FROM accounts WHERE account_id = $account_id";

    if ($conn->query($sql) === TRUE) {
        echo "Account deleted successfully! <a href='view_accounts.php'>View Accounts</a>";
    } else {
        echo "Error deleting account: " . $conn->error;
    }
} else {
    die("Account ID not specified.");
}

$conn->close();
?>
