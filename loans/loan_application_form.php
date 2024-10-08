<?php
include '../db_connect.php';

session_start();

// Ensure the user has the correct role to apply for loans (Loan Officer or Admin)
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'Loan Officer' && $_SESSION['role'] != 'Admin')) {
    header("Location: unauthorized.php");
    exit();
}

// Fetch all customers and their associated accounts to populate the customer dropdown
$sql = "SELECT c.customer_id, c.first_name, c.last_name, a.account_id, a.account_number, a.account_balance, a.account_type 
        FROM customers c 
        JOIN accounts a ON c.customer_id = a.customer_id 
        WHERE a.account_balance > 0"; // Only fetch accounts with positive balance (active)

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for a Loan</title>
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
            max-width: 500px; /* Max width for the form */
            margin: 0 auto; /* Center the form */
            background-color: white; /* White background for the form */
            padding: 20px; /* Padding inside the form */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
        }

        label {
            display: block; /* Block display for labels */
            margin: 10px 0 5px; /* Spacing around labels */
        }

        input[type="number"],
        select,
        input[type="date"] {
            width: 100%; /* Full width for inputs */
            padding: 10px; /* Padding inside inputs */
            border: 1px solid #ccc; /* Light border */
            border-radius: 4px; /* Rounded corners */
            margin-bottom: 15px; /* Spacing below inputs */
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Green button background */
            color: white; /* White text */
            border: none; /* No border */
            padding: 10px; /* Padding inside button */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            width: 100%; /* Full width for the button */
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="breadcrumbs">
        <a href="../index.php">Dashboard</a> > <a href="loan_application_form.php">Loan Forms</a>
    </div>

    <h1>Loan Application Form</h1>
    <form action="process_loan_application.php" method="post">

        <label for="customer_id">Customer:</label>
        <select name="customer_id" required>
            <?php
            while ($row = $result->fetch_assoc()) {
                if ($row['account_balance'] > 0) { // Only show customers with active accounts
                    echo "<option value='" . $row['customer_id'] . "'>" . 
                    $row['account_number'] . " - " . $row['first_name'] . " " . $row['last_name'] . 
                    " (Balance: " . number_format($row['account_balance'], 2) . ", Type: " . $row['account_type'] . ")" .
                    "</option>";
               }
            }
            ?>
        </select>

        <label for="loan_type">Loan Type:</label>
        <select name="loan_type" required>
            <option value="Personal">Personal</option>
            <option value="Mortgage">Mortgage</option>
            <option value="Auto">Auto</option>
            <option value="Education">Education</option>
        </select>

        <label for="loan_amount">Loan Amount:</label>
        <input type="number" step="0.01" name="loan_amount" min="0" required>

        <label for="interest_rate">Interest Rate (%):</label>
        <input type="number" step="0.01" name="interest_rate" min="0" max="100" required>

        <label for="loan_start_date">Start Date:</label>
        <input type="date" name="loan_start_date" required>

        <input type="submit" value="Apply for Loan">
    </form>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
