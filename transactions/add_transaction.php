<?php
include '../db_connect.php';



// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_id = $_POST['account_id'];
    $transaction_date = $_POST['transaction_date']; // Get the transaction date
    $transaction_type = $_POST['transaction_type'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];

    // Insert the transaction into the database
    $sql = "INSERT INTO transactions (account_id, transaction_date, transaction_type, amount, description)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issds", $account_id, $transaction_date, $transaction_type, $amount, $description);

    if ($stmt->execute()) {
        // Initialize update_sql to avoid undefined variable warning
        $update_sql = "";

        // Update the account balance if the transaction is successful
        if ($transaction_type === 'Deposit') {
            $update_sql = "UPDATE accounts SET account_balance = account_balance + ? WHERE account_id = ?";
        } else if ($transaction_type === 'Withdrawal') {
            $update_sql = "UPDATE accounts SET account_balance = account_balance - ? WHERE account_id = ?";
        }

        // Only execute the update if the transaction type is valid
        if ($update_sql) {
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("di", $amount, $account_id);
            $update_stmt->execute();
            $update_stmt->close();
        }

        echo "Transaction added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
