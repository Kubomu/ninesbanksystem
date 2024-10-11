<?php
include '../db_connect.php';   // Enables interaction with the database


// Fetch all customers to populate the customer dropdown
$sql = "SELECT customer_id, first_name, last_name, account_type FROM customers";
$result = $conn->query($sql);

// Fetch the latest account number from the accounts table
$accountSql = "SELECT MAX(account_number) AS max_account_number FROM accounts";
$accountResult = $conn->query($accountSql);
$maxAccountNumber = $accountResult->fetch_assoc()['max_account_number'];

// Generate the new account number
if ($maxAccountNumber) {
    // Increment the max account number
    $newAccountNumber = str_pad((int)$maxAccountNumber + 2, 10, '0', STR_PAD_LEFT);
} else {
    // Start from 0210820000  if there are no accounts
    $newAccountNumber = '0210820000';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Account</title>

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
            background-color: white; /* White form background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto; /* Center form */
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            color: #2c3e50; /* Dark blue for labels */
        }

        input[type="text"], 
        input[type="number"], 
        input[type="date"], 
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Primary green color */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* Slightly darker green on hover */
        }

        select {
            background-color: #fff; /* White background for dropdown */
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
        function validateAccountNumber() {
            const accountNumberInput = document.getElementById('account_number');
            const accountNumber = accountNumberInput.value;
            const regex = /^[0-9]{10}$/; // Regular expression for 10 digits

            if (!regex.test(accountNumber)) {
                accountNumberInput.setCustomValidity('Account number must be exactly 10 digits.');
            } else {
                accountNumberInput.setCustomValidity('');
            }
        }

        function updateAccountType() {
            const customerSelect = document.getElementById('customer_id');
            const accountTypeInput = document.getElementById('account_type');

            // Get the selected option
            const selectedOption = customerSelect.options[customerSelect.selectedIndex];
            
            // Check if the selected option has an account type
            if (selectedOption && selectedOption.dataset.accountType) {
                accountTypeInput.value = selectedOption.dataset.accountType; // Set account type from data attribute
            } else {
                accountTypeInput.value = ''; // Reset if no valid customer selected
            }
        }
    </script>
</head>
<body>
    <div class="breadcrumbs">
        <a href="../index.php">Dashboard</a> > <a href="add_account_form">Add Accounts</a>
    </div>

    <h1>Add New Bank Account</h1>
    
    <form action="add_account.php" method="post">
        <label for="account_number">Account Number:</label>
        <input type="text" id="account_number" name="account_number" value="<?php echo $newAccountNumber; ?>" readonly oninput="validateAccountNumber()">

        <label for="customer_id">Customer:</label>
        <select id="customer_id" name="customer_id" required onchange="updateAccountType()">
            <option value="">Select Customer</option>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['customer_id'] . "' data-account-type='" . $row['account_type'] . "'>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
                }
            } else {
                echo "<option value=''>No customers available</option>";
            }
            ?>
        </select>

        <label for="account_balance">Account Balance:</label>
        <input type="text" id="account_balance" name="account_balance" required>

        <label for="account_type">Account Type:</label>
        <input type="text" id="account_type" name="account_type" required readonly> <!-- Make it readonly -->

        <label for="account_open_date">Open Date:</label>
        <input type="date" id="account_open_date" name="account_open_date" required>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>

        <input type="submit" value="Create Account">
    </form>

</body>
</html>

<?php
$conn->close();
?>
