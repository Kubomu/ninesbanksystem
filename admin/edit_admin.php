<?php
include '../db_connect.php'; // Include the database connection

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Retrieve and sanitize input
    $admin_id = $_POST['admin_id'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Update query
    $sql = "UPDATE admins SET username='$username', role='$role' WHERE admin_id='$admin_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Admin details updated successfully!";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Check if the admin ID is passed in the URL
if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    // Fetch the admin data
    $sql = "SELECT * FROM admins WHERE admin_id='$admin_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc(); // Fetch admin data as an associative array
    } else {
        echo "Admin not found!";
        exit();
    }
} else {
    echo "No admin ID specified!";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
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

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .cancel {
            background-color: #f44336;
        }

        .cancel:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <h1>Edit Admin</h1>

    <form action="edit_admin.php" method="POST">
        <input type="hidden" name="admin_id" value="<?php echo $admin['admin_id']; ?>">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $admin['username']; ?>" required>

        

        <label for="role">Role:</label>
        <input type="text" id="role" name="role" value="<?php echo $admin['role']; ?>" required>

        <input type="submit" name="submit" value="Update Admin">
        <a href="admin_management.php" class="cancel">Cancel</a>
    </form>
</body>
</html>
