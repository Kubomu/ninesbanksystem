<?php
include '../db_connect.php';

// Initialize the search query variable
$search_query = "";

// Check if the search form is submitted
if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
}

// Modify the SQL query to include the search filter
$sql = "SELECT accounts.account_id, accounts.account_number, accounts.account_balance, accounts.account_type, accounts.account_open_date, accounts.status, 
        customers.first_name, customers.last_name
        FROM accounts
        INNER JOIN customers ON accounts.customer_id = customers.customer_id
        WHERE customers.first_name LIKE '%$search_query%' 
        OR customers.last_name LIKE '%$search_query%' 
        OR accounts.account_number LIKE '%$search_query%'";

$result = $conn->query($sql);

// Fetch account types for the pie chart
$chart_sql = "SELECT account_type, COUNT(*) as count FROM accounts GROUP BY account_type";
$chart_result = $conn->query($chart_sql); 

// Prepare data for Chart.js
$account_types = [];
$account_counts = [];
if ($chart_result->num_rows > 0) {
    while ($row = $chart_result->fetch_assoc()) {
        $account_types[] = $row['account_type'];
        $account_counts[] = $row['count'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Accounts</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f4f4f4 30%, #e9ecef 100%);
            color: #2c3e50;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
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


        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e9e9e9;
        }

        .search-bar {
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
            text-align: center;
        }

        .search-bar input[type="text"] {
            padding: 10px;
            width: 80%;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-bar input[type="submit"] {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 5px;
        }

        .search-bar input[type="submit"]:hover {
            background-color: #45a049;
        }

        .chart-container {
            width: 50%;
            margin: 40px auto;
        }

    </style>
</head>
<body>
<div class="breadcrumbs">
    <a href="../index.php">Dashboard</a> > <a href="view_accounts.php">Accounts</a>
</div>

<h1>Account List</h1>

<!-- Search bar -->
<div class="search-bar">
    <form method="POST" action="">
        <input type="text" name="search_query" placeholder="Search customer name or account number" value="<?php echo htmlspecialchars($search_query); ?>">
        <br><br>
        <input type="submit" name="search" value="Search">
    </form>
</div>

<!-- Account table -->
<table>
    <tr>
        <th>Account Number</th>
        <th>Customer Name</th>
        <th>Balance</th>
        <th>Account Type</th>
        <th>Open Date</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['account_number']) . "</td>
                    <td>" . htmlspecialchars($row['first_name'] . " " . $row['last_name']) . "</td>
                    <td>" . htmlspecialchars(number_format($row['account_balance'])) . "</td>
                    <td>" . htmlspecialchars($row['account_type']) . "</td>
                    <td>" . htmlspecialchars($row['account_open_date']) . "</td>
                    <td>" . htmlspecialchars($row['status']) . "</td>
                    <td>
                        <a href='edit_account_form.php?id=" . $row['account_id'] . "'><i class='fas fa-edit icon'></i>Edit</a> |
                        <a href='delete_account.php?id=" . $row['account_id'] . "' onclick='return confirm(\"Are you sure you want to delete this account?\")'>
                        <i class='fas fa-trash icon'></i>Delete</a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No accounts found</td></tr>";
    }
    ?>
</table>

<!-- Pie chart container -->
<div class="chart-container">
    <canvas id="accountTypeChart"></canvas>
</div>

<script>
    const ctx = document.getElementById('accountTypeChart').getContext('2d');
    const accountTypeChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($account_types); ?>,
            datasets: [{
                label: 'Account Type Distribution',
                data: <?php echo json_encode($account_counts); ?>,
                backgroundColor: ['#4CAF50', '#f39c12', '#2c3e50', '#e74c3c'],
                borderColor: ['#fff'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Distribution of Account Types'
                }
            }
        }
    });
</script>

</body>
</html>

<?php
$conn->close();
?>
