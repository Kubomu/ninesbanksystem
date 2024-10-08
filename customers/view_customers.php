<?php
include '../db_connect.php'; // Include the database connection

// Initialize an empty search query
$search_query = '';

// Check if the form is submitted
if (isset($_POST['search'])) {
    // Sanitize the input
    $search_query = $conn->real_escape_string(trim($_POST['search_query']));
}

// Fetch all customer data from the customers table
$sql = "SELECT * FROM customers";
if ($search_query) {
    $sql .= " WHERE first_name LIKE '%$search_query%' OR last_name LIKE '%$search_query%' OR email LIKE '%$search_query%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ffffff; /* White background for the page */
            color: #333; /* Dark text color */
            margin: 0;
            padding: 20px;
        }

        h1 {
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
            margin-top: 20px; /* Spacing above the table */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Shadow for depth */
            background-color: white; /* White background for the table */
        }

        table, th, td {
            border: 1px solid #ccc; /* Lighter border color */
        }

        th, td {
            padding: 12px; /* Increased padding for better spacing */
            text-align: left;
        }

        th {
            background-color: #4CAF50; /* Green background for header */
            color: white; /* White text for header */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9; /* Light grey for even rows */
        }

        tr:hover {
            background-color: #e9e9e9; /* Slightly darker grey on row hover */
        }

        td a {
            color: #4CAF50; /* Green for action links */
            margin-right: 10px; /* Spacing between links */
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 24px; /* Adjust heading size */
            }
            th, td {
                font-size: 14px; /* Reduce font size on small screens */
            }
        }

        .search-container {
            text-align: center; /* Center the search bar */
            margin-bottom: 20px; /* Spacing below the search bar */
        }

        .search-container input[type="text"] {
            padding: 10px;
            width: 200px; /* Width of the search input */
            border: 1px solid #ccc; /* Border for input */
            border-radius: 5px; /* Rounded corners */
        }

        .search-container input[type="submit"] {
            padding: 10px 15px; /* Padding for button */
            border: none; /* Remove border */
            border-radius: 5px; /* Rounded corners */
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
            cursor: pointer; /* Pointer cursor on hover */
            margin-left: 5px; /* Spacing between input and button */
        }

        .search-container input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>


<div class="breadcrumbs">
    <a href="../index.php">Dashboard</a> > <a href="view_customers.php">View Customers</a>
</div>

<h1>Customer List</h1>

<div class="search-container">
    <form method="POST" action="">
        <input type="text" name="search_query" placeholder="Search customers..." value="<?php echo htmlspecialchars($search_query); ?>">
        <input type="submit" name="search" value="Search">
    </form>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Address</th>
        <th>Date of Birth</th>
        <th>Account Type</th>
        <th>Gender</th> <!-- Added Gender column -->
        <th>Actions</th> <!-- New column for actions -->
    </tr>

    <?php
    if ($result && $result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['customer_id'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['first_name'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['last_name'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['email'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['phone_number'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['address'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['date_of_birth'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['account_type'] ?? '') . "</td>
                    <td>" . htmlspecialchars($row['gender'] ?? '') . "</td> <!-- Display gender -->
                    <td>
                        <a href='edit_customer.php?id=" . $row['customer_id'] . "'>
                            <i class='fas fa-edit'></i> Edit
                        </a> |
                        <a href='delete_customer.php?id=" . $row['customer_id'] . "' onclick='return confirm(\"Are you sure you want to delete this customer?\")'>
                            <i class='fas fa-trash'></i> Delete
                        </a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='10'>No customers found</td></tr>"; // Adjust colspan to 10 to match the number of columns
    }
    ?>
</table>

</body>
</html>
