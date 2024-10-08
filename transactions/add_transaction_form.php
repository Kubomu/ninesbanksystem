<?php
include '../db_connect.php';


// Fetch all accounts to populate the account dropdown
$sql = "SELECT account_id, account_number FROM accounts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>
</head>
<body>
    <h1>Add New Transaction</h1>
    
    <form action="add_transaction.php" method="POST">
        <label for="account_id">Account:</label>
        <select name="account_id" required>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['account_id'] . "'>" . $row['account_number'] . "</option>";
            }
            ?>
        </select><br><br>

        <label for="transaction_date">Transaction Date:</label>
        <input type="datetime-local" name="transaction_date" required><br><br>

        <label for="transaction_type">Transaction Type:</label>
        <select name="transaction_type" required>
            <option value="Deposit">Deposit</option>
            <option value="Withdrawal">Withdrawal</option>
            <option value="Transfer">Transfer</option>
        </select><br><br>

        <label for="amount">Amount:</label>
        <input type="number" step="0.01" name="amount" required><br><br>

        <label for="description">Description:</label>
        <textarea name="description"></textarea><br><br>

        <input type="submit" value="Add Transaction">
    </form>

</body>
</html>

<?php
$conn->close();
?>
