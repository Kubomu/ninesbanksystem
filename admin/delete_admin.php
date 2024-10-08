<?php
include '../db_connect.php'; // Include the database connection

// Check if the admin ID is passed in the URL
if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];
} else {
    echo "No admin ID specified!";
    exit();
}

// Perform deletion if confirmed
if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    // Delete query
    $sql = "DELETE FROM admins WHERE admin_id='$admin_id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Admin deleted successfully!";
    } else {
        $message = "Error deleting record: " . $conn->error;
    }
} else {
    $message = "Are you sure you want to delete this admin?";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Admin</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
        }

        .message {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #45a049;
        }

        .cancel {
            background-color: #f44336;
        }

        .cancel:hover {
            background-color: #e53935;
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this admin? This action cannot be undone.");
        }
    </script>
</head>
<body>
    <div class="message">
        <h1>Admin Deletion</h1>
        <p><?php echo $message; ?></p>
        
        <?php if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes'): ?>
            <a href="manage_admins.php">Back to Dashboard</a>
        <?php else: ?>
            <a href="delete_admin.php?id=<?php echo $admin_id; ?>&confirm=yes" onclick="return confirmDelete();">Confirm Delete</a>
            <a href="admin_management.php" class="cancel">Cancel</a>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
