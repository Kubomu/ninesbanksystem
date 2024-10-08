<?php
include '../db_connect.php';

session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'Teller' && $_SESSION['role'] != 'Admin')) {
    header("Location: unauthorized.php");
    exit();
}

// Fetch all accounts to populate the account dropdowns along with the owner's name
$sql = "SELECT a.account_id, a.account_number, c.first_name, c.last_name, a.account_balance, a.status, a.account_type 
        FROM accounts a
        JOIN customers c ON a.customer_id = c.customer_id
        ORDER BY a.account_id ASC"; // Order by account_id in ascending order
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Funds</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4; /* Light grey background */
            color: #333; /* Dark text color */
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #2c3e50; /* Dark blue for the main heading */
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            max-width: 600px; /* Maximum width for the form */
            margin: 0 auto; /* Center the form */
            background: white; /* White background for form */
            padding: 20px; /* Padding inside the form */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        label {
            display: block; /* Block display for labels */
            margin: 10px 0 5px; /* Spacing around labels */
        }

        input[type="number"],
        input[type="text"],
        select {
            width: 100%; /* Full width for inputs */
            padding: 10px; /* Padding inside inputs */
            border: 1px solid #ccc; /* Light border */
            border-radius: 4px; /* Rounded corners for inputs */
            margin-bottom: 15px; /* Spacing below inputs */
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Green submit button */
            color: white; /* White text */
            border: none; /* No border */
            padding: 10px; /* Padding inside button */
            border-radius: 4px; /* Rounded corners for button */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 16px; /* Larger font size */
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }


        a {
            color: #4CAF50; /* Primary green color for links */
            text-decoration: none; /* Remove underline */
            transition: color 0.3s;
        }

        a:hover {
            color: #f44336; /* Change color to secondary red on hover */
            text-decoration: underline; /* Underline on hover */
        }

    </style>
    <script>
        function confirmTransfer(event) {
            var amount = parseFloat(document.querySelector('input[name="amount"]').value);
            var sourceAccount = document.querySelector('select[name="source_account"] option:checked').text;
            var destinationAccount = document.querySelector('select[name="destination_account"] option:checked').text;

            if (amount <= 0) {
                alert("Please enter a valid amount to transfer.");
                event.preventDefault();
                return;
            }

            if (document.querySelector('select[name="source_account"]').value === document.querySelector('select[name="destination_account"]').value) {
                alert("Source and Destination accounts cannot be the same.");
                event.preventDefault();
                return;
            }

            var confirmationMessage = `Are you sure you want to transfer ${amount.toFixed(2)} from ${sourceAccount} to ${destinationAccount}?`;
            if (!confirm(confirmationMessage)) {
                event.preventDefault(); // Prevent form submission if user cancels
            }
        }
    </script>
</head>
<body>

<div class="breadcrumbs">
    <a href="../index.php">Dashboard</a> > <a href="transfer.php">Transfer Funds</a>
</div>

<h1>Transfer Funds</h1>

<form action="process_transfer.php" method="POST" onsubmit="confirmTransfer(event)">
    <label for="source_account">Source Account:</label>
    <select name="source_account" required>
        <?php
        while ($row = $result->fetch_assoc()) {
            if ($row['status'] != 0) { // Check if the account is not closed
                echo "<option value='" . $row['account_id'] . "'>" . 
                     $row['account_number'] . " - " . 
                     $row['first_name'] . " " . $row['last_name'] . 
                     " (Balance: " . number_format($row['account_balance'], 2) . ", Type: " . $row['account_type'] . ")" .
                     "</option>";
            }
        }
        ?>
    </select>

    <label for="destination_account">Destination Account:</label>
    <select name="destination_account" required>
        <?php
        // Reset the result set to fetch accounts again for destination
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            if ($row['status'] != 0) { // Check if the account is not closed
                echo "<option value='" . $row['account_id'] . "'>" . 
                     $row['account_number'] . " - " . 
                     $row['first_name'] . " " . $row['last_name'] . 
                     " (Balance: " . number_format($row['account_balance'], 2) . ", Type: " . $row['account_type'] . ")" .
                     "</option>";
            }
        }
        ?>
    </select>

    <label for="amount">Amount:</label>
    <input type="number" name="amount" min="0" required>

    <label for="description">Description:</label>
    <input type="text" name="description" required>

    <input type="submit" value="Transfer Funds">
</form>
</body>
</html>

<?php
$conn->close();
?>
