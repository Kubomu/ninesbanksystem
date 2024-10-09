<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

// Initialize session counter if not already set
if (!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 0; // Initialize counter
}
$_SESSION['counter']++; // Increment counter

$role = $_SESSION['role'];
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User'; // Ensure this is set correctly
$counter = $_SESSION['counter']; // Get the current counter value

// Get the current date and time in PHP
$currentDateTime = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nines Bank Plus</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f4f4f4 30%, #e9ecef 100%);
            color: #2c3e50;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #34495e;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 2.5em;
        }

        nav {
            background-color: #34495e;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        nav:hover {
            transform: scale(1.01);
        }

        h2 {
            color: #f39c12;
            font-size: 1.5em;
            font-weight: 600;
            border-bottom: 2px solid #f39c12;
            margin-bottom: 15px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 15px 0;
        }

        a {
            color: #ecf0f1;
            text-decoration: none;
            background-color: #2c3e50;
            padding: 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        a:hover {
            background-color: #f39c12;
            color: white;
            transform: translateX(5px);
        }

        a i {
            margin-right: 10px;
            font-size: 1.3em;
        }

        .logout {
            margin-top: 30px;
            padding: 15px;
            background-color: #e74c3c;
            border-radius: 8px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .logout:hover {
            background-color: #c0392b;
        }

        .logout a {
            color: white;
            font-weight: 600;
        }

        .logout i {
            margin-right: 0;
        }

        .user-info, .session-counter, .date-time {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.2em;
            color: #34495e;
        }
    </style>
</head>
<body>
    <h1>Welcome to the Nines Bank System Dashboard</h1>
    <div class="date-time">
        <p id="currentDateTime"></p>
    </div>

    <div class="user-info">
        <p>Logged in as: <strong><?php echo htmlspecialchars($username); ?></strong></p>
        <p>Session Counter: <strong><?php echo $counter; ?></strong></p>
    </div>
    <nav>
        <?php if ($role == 'Admin') { ?>
            <h2>Admin</h2>
            <ul>
                <li><a href="admin/manage_admins.php"><i class="fas fa-cogs"></i>Manage Admins</a></li>
            </ul>
            <h2>Customers</h2>
            <ul>
                <li><a href="customers/view_customers.php"><i class="fas fa-address-card"></i>View Customers</a></li>
                <li><a href="customers/add_customer_form.php"><i class="fas fa-user-plus"></i>Add Customer</a></li>
            </ul>
            <h2>Accounts</h2>
            <ul>
                <li><a href="accounts/view_accounts.php"><i class="fas fa-users"></i>View Accounts</a></li>
                <li><a href="accounts/add_account_form.php"><i class="fas fa-plus"></i>Add Account</a></li>
            </ul>
            <h2>Transactions</h2>
            <ul>
                <li><a href="transactions/transfer.php"><i class="fas fa-exchange-alt"></i>Transfer Funds</a></li>
                <li><a href="transactions/view_transactions.php"><i class="fas fa-list-alt"></i>View Transactions</a></li>
                <li><a href="transactions/withdraw.php"><i class="fas fa-money-bill-wave-alt"></i>Withdraw</a></li>
                <li><a href="transactions/deposit.php"><i class="fas fa-money-bill-wave"></i>Deposit</a></li>
                <li><a href="transactions/view_balances.php"><i class="fas fa-wallet"></i>View Balances</a></li>
            </ul>
            <h2>Loans</h2>
            <ul>
                <li><a href="loans/view_loans.php"><i class="fas fa-file-invoice-dollar"></i>View Loans</a></li>
                <li><a href="loans/loan_application_form.php"><i class="fas fa-plus-circle"></i>Add Loan</a></li>
            </ul>
            <h2>Payments</h2>
            <ul>
                <li><a href="payments/payment_remaining_balances.php"><i class="fas fa-dollar-sign"></i>View Payments</a></li>
                <li><a href="payments/payment_form.php"><i class="fas fa-plus-circle"></i>Add Payment</a></li>
            </ul>

        <?php } elseif ($role == 'Teller') { ?>
            <h2>Teller</h2>
            <ul>
                <li><a href="customers/add_customer_form.php"><i class="fas fa-user-plus"></i>Add Customer</a></li>
                <li><a href="accounts/add_account_form.php"><i class="fas fa-plus"></i>Add Account</a></li>
                <li><a href="customers/view_customers.php"><i class="fas fa-address-card"></i>View Customers</a></li>
                <li><a href="accounts/view_accounts.php"><i class="fas fa-users"></i>View Accounts</a></li>
            </ul>
            <h2>Transactions</h2>
            <ul>
                <li><a href="transactions/transfer.php"><i class="fas fa-exchange-alt"></i>Transfer Funds</a></li>
                <li><a href="transactions/view_transactions.php"><i class="fas fa-list-alt"></i>View Transactions</a></li>
                <li><a href="transactions/withdraw.php"><i class="fas fa-money-bill-wave"></i>Withdraw</a></li>
                <li><a href="transactions/view_balances.php"><i class="fas fa-wallet"></i>View Balances</a></li>
            </ul>
            <h2>Loans</h2>
            <ul>
                <li><a href="loans/view_loans.php"><i class="fas fa-file-invoice-dollar"></i>View Loans</a></li>
            </ul>
            <h2>Payments</h2>
            <ul>
                <li><a href="payments/payment_remaining_balances.php"><i class="fas fa-dollar-sign"></i>View Payments</a></li>
            </ul>

        <?php } elseif ($role == 'Loan Officer') { ?>
            <h2>Loans</h2>
            <ul>
                <li><a href="transactions/view_balances.php"><i class="fas fa-wallet"></i>View Balances</a></li>
                <li><a href="loans/loan_application_form.php"><i class="fas fa-plus-circle"></i>Add Loan</a></li>
                <li><a href="loans/view_loans.php"><i class="fas fa-file-invoice-dollar"></i>View Loans</a></li>
            </ul>
            <h2>Payments</h2>
            <ul>
                <li><a href="payments/payment_form.php"><i class="fas fa-plus-circle"></i>Add Payment</a></li>
                <li><a href="payments/payment_remaining_balances.php"><i class="fas fa-dollar-sign"></i>View Payments</a></li>
            </ul>
        <?php } ?>

        <div class="logout">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </div>
    </nav>

    <script>
        // Display current date and time
        function updateDateTime() {
            const now = new Date();
            document.getElementById("currentDateTime").innerText = now.toLocaleString();
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();
    </script>
</body>
</html>
