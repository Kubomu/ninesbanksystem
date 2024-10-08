<?php
include '../db_connect.php';

// Get the form data
$account_id = $_POST['account'];
$amount = $_POST['amount'];

// Check the current balance
$sql = "SELECT account_balance FROM accounts WHERE account_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $account_id);
$stmt->execute();
$stmt->bind_result($current_balance);
$stmt->fetch();
$stmt->close();

// Check if the withdrawal amount is valid
if ($amount > 0 && $amount <= $current_balance) {
    // Proceed with the withdrawal
    $new_balance = $current_balance - $amount;

    // Update the account balance
    $sql = "UPDATE accounts SET account_balance = ? WHERE account_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $new_balance, $account_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Withdrawal successful! New balance: " . number_format($new_balance, 2) . "');
                window.location.href='../transactions/view_balances.php'; // Redirect to view accounts
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "<script>
            alert('Insufficient balance or invalid amount.');
            window.location.href='withdraw.php'; // Redirect back to withdrawal page
          </script>";
}

$conn->close();
?>
