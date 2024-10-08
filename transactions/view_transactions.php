<?php
include '../db_connect.php';

// Initialize search variables
$search_term = "";

// Check if the search form is submitted
if (isset($_POST['search'])) {
    $search_term = $_POST['search_term'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #333;
            text-align: center;
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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
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
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }

        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="text"] {
            padding: 8px;
            font-size: 14px;
            width: 300px;
        }

        input[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="breadcrumbs">
        <a href="../index.php">Dashboard</a> > <a href="view_transactions.php">Transactions</a>
    </div>

    <h1>Transaction List</h1>

    <!-- Search form -->
    <div class="search-container">
        <form method="POST" action="">
            <input type="text" name="search_term" placeholder="Search by Transaction ID, Type, Account Number" value="<?php echo htmlspecialchars($search_term); ?>">
            <input type="submit" name="search" value="Search">
        </form>
    </div>

    <!-- Table for listing transactions -->
    <table>
        <tr>
            <th>Transaction ID</th>
            <th>Transaction Date</th>
            <th>Source Account Number</th>
            <th>Destination Account Number</th>
            <th>Transaction Type</th>
            <th>Amount</th>
            <th>Description</th>
        </tr>
        <?php
        // Modify query to include search functionality
        $sql = "SELECT t.transaction_id, 
                       t.transaction_date, 
                       a1.account_number AS source_account_number,
                       a2.account_number AS destination_account_number,
                       t.transaction_type, 
                       t.amount, 
                       t.description
                FROM transactions t
                LEFT JOIN accounts a1 ON t.source_account_id = a1.account_id
                LEFT JOIN accounts a2 ON t.destination_account_id = a2.account_id";

        // Add search conditions
        if (!empty($search_term)) {
            $sql .= " WHERE t.transaction_id LIKE '%$search_term%' 
                      OR a1.account_number LIKE '%$search_term%' 
                      OR a2.account_number LIKE '%$search_term%'
                      OR t.transaction_type LIKE '%$search_term%'";
        }

        $sql .= " ORDER BY t.transaction_date ASC";

        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['transaction_id'] . "</td>
                        <td>" . $row['transaction_date'] . "</td>
                        <td>" . htmlspecialchars($row['source_account_number']) . "</td>
                        <td>" . htmlspecialchars($row['destination_account_number']) . "</td>
                        <td>" . $row['transaction_type'] . "</td>
                        <td>" . number_format($row['amount']) . "</td>
                        <td>" . htmlspecialchars($row['description']) . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No transactions found</td></tr>";
        }
        ?>
    </table>

</body>
</html>

<?php
$conn->close();
?>
