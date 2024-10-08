<?php
include '../db_connect.php'; // Include the database connection
session_start();

// Check if the user is logged in and is an Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') {
    header("Location: ../unauthorized.php");
    exit();
}

// Admin-only content

// Query to get the list of admins
$query = "SELECT admin_id, username FROM admins";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));  // Error handling
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CSS -->
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
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px; /* Space below the table */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Shadow for depth */
            background-color: white; /* White background for the table */
        }

        table, th, td {
            border: 1px solid #ddd; /* Light border color */
        }

        th, td {
            padding: 10px; /* Padding for better spacing */
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

        a {
            color: #4CAF50; /* Primary green color for links */
            text-decoration: none; /* Remove underline */
            transition: color 0.3s;
        }

        a:hover {
            color: #f44336; /* Change color to secondary red on hover */
            text-decoration: underline; /* Underline on hover */
        }

        .delete-btn {
            color: #f44336; /* Red for delete button */
        }

        .delete-btn:hover {
            background-color: #f44336; /* Red background on hover */
            color: white; /* White text on hover */
        }

        .add-btn {
            display: inline-block;
            margin-bottom: 20px; /* Space below the button */
            background-color: #4CAF50; /* Green background */
            color: white; /* White text */
            padding: 10px 15px; /* Padding */
            text-decoration: none; /* Remove underline */
            border-radius: 5px; /* Rounded corners */
            transition: background-color 0.3s ease;
        }

        .add-btn:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        

    </style>
</head>
<body>
    <div class="breadcrumbs">
        <a href="../index.php">Dashboard</a> > <a href="manage_admins.php">Admin List</a>
    </div>

    <h1>Admin List</h1>
    <a href="add_admin.php" class="add-btn">Add New Admin</a>
    <table>
        <tr>
            <th>Admin ID</th>
            <th>Username</th>
            <th>Actions</th> <!-- Column for Edit/Delete actions -->
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            // Output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['admin_id']) . "</td>
                        <td>" . htmlspecialchars($row['username']) . "</td>
                        <td>
                            <a href='edit_admin.php?id=" . $row['admin_id'] . "'>Edit</a> |
                            <a href='delete_admin.php?id=" . $row['admin_id'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this admin?\")'>Delete</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No admins found</td></tr>"; // Adjust colspan to 3 to match the number of columns
        }
        ?>
    </table>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
