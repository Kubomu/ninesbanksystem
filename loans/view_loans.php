<?php
include '../db_connect.php'; // Adjust the path as needed

// Initialize search variables
$search_term = "";

// Check if the search form is submitted
if (isset($_POST['search'])) {
    $search_term = $_POST['search_term'];
}

// Modify query to include search functionality
$sql = "SELECT loans.loan_id, customers.first_name, customers.last_name, loans.loan_type, loans.loan_amount, 
               loans.loan_start_date, loans.loan_status,
               (loans.loan_amount + (loans.loan_amount * loans.interest_rate / 100)) AS total_amount_payable
        FROM loans
        JOIN customers ON loans.customer_id = customers.customer_id";

// Add search conditions
if (!empty($search_term)) {
    $sql .= " WHERE loans.loan_id LIKE '%$search_term%'
              OR customers.first_name LIKE '%$search_term%'
              OR customers.last_name LIKE '%$search_term%'
              OR loans.loan_type LIKE '%$search_term%'
              OR loans.loan_status LIKE '%$search_term%'";
}

$result = $conn->query($sql);

// Check for query execution error
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Loans</title>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f4f4f4 30%, #e9ecef 100%);
            color: #2c3e50;
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
        }

        th, td {
            border: 1px solid #ccc; /* Light border for table cells */
            padding: 10px; /* Padding inside cells */
            text-align: left; /* Align text to the left */
        }

        th {
            background-color: #4CAF50; /* Green header background */
            color: white; /* White text color for headers */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Zebra striping for rows */
        }

        tr:hover {
            background-color: #ddd; /* Highlight row on hover */
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
</head>
<body>

    <div class="breadcrumbs">
        <a href="../index.php">Dashboard</a> > <a href="view_loans.php">Loans</a>
    </div>

    <h1>Loan List</h1>

    <!-- Search form -->
    <div class="search-container">
        <form method="POST" action="">
            <input type="text" name="search_term" placeholder="Search by Loan ID, Customer Name, Loan Type, Status" value="<?php echo htmlspecialchars($search_term); ?>">
            <input type="submit" name="search" value="Search">
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Loan ID</th>
                <th>Customer Name</th>
                <th>Loan Type</th>
                <th>Loan Amount</th>
                <th>Total Amount Payable</th>
                <th>Loan Start Date</th>
                <th>Loan Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($loan = $result->fetch_assoc()) {
                    // Sanitize output to prevent XSS attacks
                    $loan_id = htmlspecialchars($loan['loan_id']);
                    $customer_name = htmlspecialchars($loan['first_name'] . ' ' . $loan['last_name']);
                    $loan_type = htmlspecialchars($loan['loan_type']);
                    $loan_amount = number_format($loan['loan_amount'], 2);
                    $total_amount_payable = number_format($loan['total_amount_payable'], 2);
                    $loan_start_date = htmlspecialchars($loan['loan_start_date']);
                    $loan_status = htmlspecialchars($loan['loan_status']);
                    
                    echo "<tr>
                            <td>{$loan_id}</td>
                            <td>{$customer_name}</td>
                            <td>{$loan_type}</td>
                            <td>{$loan_amount}</td>
                            <td>{$total_amount_payable}</td>
                            <td>{$loan_start_date}</td>
                            <td>{$loan_status}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No loans found.</td></tr>"; // Adjust column span
            }
            ?>
        </tbody>
    </table>

</body>
</html>

<?php
$conn->close();
?>
