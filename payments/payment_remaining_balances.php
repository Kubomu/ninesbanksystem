<?php  
include '../db_connect.php';


session_start();

if (!isset($_SESSION['role']) || 
    ($_SESSION['role'] != 'Loan Officer' && 
     $_SESSION['role'] != 'Admin' && 
     $_SESSION['role'] != 'Teller')) {
    header("Location: ../unauthorized.php");
    exit();
}




// Fetch all loans and their payments, calculating the remaining balance
$sql = "
    SELECT l.loan_id, 
           l.loan_amount, 
           COALESCE(SUM(p.payment_amount), 0) AS total_payments, 
           GREATEST(l.total_amount_payable - COALESCE(SUM(p.payment_amount), 0), 0) AS remaining_balance
    FROM loans l
    LEFT JOIN payments p ON l.loan_id = p.loan_id
    GROUP BY l.loan_id, l.loan_amount, l.total_amount_payable
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Payments</title>
    <link rel="stylesheet" href="../css/styles.css">
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

        table {
            width: 100%; /* Full width for the table */
            border-collapse: collapse; /* Collapse borders */
            margin: 0 auto; /* Center the table */
            background-color: white; /* White background for the table */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Shadow effect */
        }

        th, td {
            border: 1px solid #ccc; /* Light border for table cells */
            padding: 10px; /* Padding inside table cells */
            text-align: left; /* Left align text */
        }

        th {
            background-color: #4CAF50; /* Green header background */
            color: white; /* White text for header */
        }

        tr:hover {
            background-color: #f1f1f1; /* Light grey on row hover */
        }
    </style>
</head>
<body>


    <div class="breadcrumbs">
        <a href="../index.php">Dashboard</a> > <a href="payment_remaining_balances.php">Balances</a>
    </div>

    <h1>Loan Payments</h1>
    
    <table>
        <thead>
            <tr>
                <th>Loan ID</th>
                <th>Loan Amount</th>
                <th>Total Payments</th>
                <th>Remaining Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['loan_id']; ?></td>
                <td><?php echo number_format($row['loan_amount'], 2); ?></td>
                <td><?php echo number_format($row['total_payments'], 2); ?></td>
                <td><?php echo number_format($row['remaining_balance'], 2); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>

<?php
$conn->close();
?>
