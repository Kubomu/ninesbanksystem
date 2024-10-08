<?php
include '../db_connect.php';

session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'Loan Officer' && $_SESSION['role'] != 'Admin')) {
    header("Location: unauthorized.php");
    exit();
}



// Fetch all loans including total_amount_payable and balance_remaining
$sql = "SELECT loans.loan_id, 
               loan_amount, 
               (loan_amount + (loan_amount * interest_rate / 100)) AS total_amount_payable, 
               (loan_amount + (loan_amount * interest_rate / 100) - COALESCE(SUM(payments.payment_amount), 0)) AS balance_remaining 
        FROM loans 
        LEFT JOIN payments ON loans.loan_id = payments.loan_id
        WHERE loan_status != 'Paid Off' 
        GROUP BY loans.loan_id, loan_amount, interest_rate";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Payment</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* Your existing styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        select, input[type="number"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    
</head>

<body>


    <div class="breadcrumbs">
        <a href="../index.php">Dashboard</a> > <a href="payment_form.php">Payment Form</a>
    </div>

    <h1>Make a Payment</h1>
    <form action="add_payment.php" method="post">
        <label for="loan_id">Loan:</label>
        <select id="loan_id" name="loan_id" required onchange="updateBalance()">
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?php echo $row['loan_id']; ?>" 
                        data-total-payable="<?php echo $row['total_amount_payable']; ?>" 
                        data-previous-payments="<?php echo $row['balance_remaining']; ?>">
                    Loan ID: <?php echo $row['loan_id']; ?> - Total Amount Payable: <?php echo number_format($row['total_amount_payable'], 2); ?>
                </option>
            <?php endwhile; ?>
        </select>

    

        <label for="payment_amount">Payment Amount:</label>
        <input type="number" id="payment_amount" name="payment_amount" required>

        <input type="submit" value="Make Payment">
    </form>

</body>
</html>

<?php
$conn->close();
?>
