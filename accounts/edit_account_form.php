<?php
include '../db_connect.php';

// Check if the account ID is provided
if (isset($_GET['id'])) {
    $account_id = $_GET['id'];

    // Fetch account data based on the ID
    $sql = "SELECT * FROM accounts WHERE account_id = $account_id";
    $result = $conn->query($sql);
    $account = $result->fetch_assoc();

    // Fetch all customers to populate the customer dropdown
    $customers_sql = "SELECT customer_id, first_name, last_name FROM customers";
    $customers_result = $conn->query($customers_sql);
} else {
    die("Account ID not specified.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
    
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: white;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #4CAF50;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        select {
            background-color: #fff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group select {
            background-color: white;
        }

        .error {
            color: #f44336;
            text-align: center;
        }

        .success {
            color: #4CAF50;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Edit Account</h1>
    <form action="update_account.php" method="POST">
        <input type="hidden" name="account_id" value="<?php echo $account['account_id']; ?>">

        <div class="form-group">
            <label for="customer_id">Customer:</label>
            <select name="customer_id" required>
                <?php
                while ($row = $customers_result->fetch_assoc()) {
                    $selected = ($row['customer_id'] == $account['customer_id']) ? "selected" : "";
                    echo "<option value='" . $row['customer_id'] . "' $selected>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="account_number">Account Number:</label>
            <input type="text" name="account_number" value="<?php echo $account['account_number']; ?>" required>
        </div>

        <div class="form-group">
            <label for="account_balance">Balance:</label>
            <input type="number" step="0" name="account_balance" value="<?php echo $account['account_balance']; ?>" required>
        </div>

        <div class="form-group">
            <label for="account_type">Account Type:</label>
            <select name="account_type" required>
                <option value="Savings" <?php echo ($account['account_type'] == 'Savings') ? 'selected' : ''; ?>>Savings</option>
                <option value="Current" <?php echo ($account['account_type'] == 'Current') ? 'selected' : ''; ?>>Current</option>
                <option value="Fixed Deposit" <?php echo ($account['account_type'] == 'Fixed Deposit') ? 'selected' : ''; ?>>Fixed Deposit</option>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" required>
                <option value="Active" <?php echo ($account['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                <option value="Closed" <?php echo ($account['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>

        <input type="submit" value="Update Account">
    </form>
</body>
</html>

<?php
$conn->close();
?>
