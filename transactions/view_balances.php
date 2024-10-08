<?php
include '../db_connect.php';

// Initialize search term
$search_term = isset($_POST['search_term']) ? trim($_POST['search_term']) : '';

// Fetch all accounts along with their balances, filtering by account number if a search term is provided
$sql = "SELECT account_id, account_number, account_balance FROM accounts";
if ($search_term) {
    $sql .= " WHERE account_number LIKE ?";
}
$stmt = $conn->prepare($sql);

if ($search_term) {
    $search_term = "%" . $search_term . "%"; // Prepare for LIKE clause
    $stmt->bind_param("s", $search_term);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Balances</title>
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
            border-collapse: collapse; /* Merge table borders */
            margin: 0 auto; /* Center the table */
            background-color: white; /* White background for table */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        th, td {
            padding: 12px; /* Padding inside cells */
            text-align: left; /* Align text to the left */
            border: 1px solid #ddd; /* Light border for cells */
        }

        th {
            background-color: #4CAF50; /* Green background for header */
            color: white; /* White text for header */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9; /* Light background for even rows */
        }

        tr:hover {
            background-color: #f1f1f1; /* Hover effect for rows */
        }

        .no-accounts {
            text-align: center; /* Center text */
            margin-top: 20px; /* Spacing above */
            color: #dc3545; /* Red color for error message */
        }

        .search-container {
            text-align: center; /* Center search box */
            margin-bottom: 20px; /* Spacing below search box */
        }

        .search-container input[type="text"] {
            padding: 10px; /* Padding for input */
            width: 200px; /* Fixed width */
            margin-right: 10px; /* Spacing to the right */
        }

        .search-container input[type="submit"] {
            padding: 10px 15px; /* Padding for button */
            background-color: #4CAF50; /* Green button */
            color: white; /* White text */
            border: none; /* No border */
            cursor: pointer; /* Pointer cursor */
        }

        .search-container input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="breadcrumbs">
        <a href="../index.php">Dashboard</a> > <a href="view_balances.php">Balances</a>
    </div>
    <h1>Account Balances</h1>

    <div class="search-container">
        <form method="POST" action="view_balances.php">
        <input type="text" name="search_term" placeholder="Search by account number" value="<?php echo htmlspecialchars(trim(str_replace('%', '', $search_term))); ?>">

            <input type="submit" value="Search">
        </form>
    </div>
    
    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Account ID</th><th>Account Number</th><th>Balance</th></tr>";

        // Output data for each account
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['account_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['account_number']) . "</td>";
            echo "<td>" . number_format($row['account_balance'], 2) . "</td>"; // Format balance to two decimal places
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<div class='no-accounts'>No accounts found.</div>";
    }

    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
