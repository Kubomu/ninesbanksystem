<?php
include '../db_connect.php'; // Include your database connection file




session_start();


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $_POST['role'];

    // Insert the admin into the database
    $sql = "INSERT INTO admins (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        // Redirect to the admin management page after successful addition
        header("Location: manage_admins.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

        form {
            background-color: white; /* White form background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto; /* Center form */
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            color: #2c3e50; /* Dark blue for labels */
        }

        input[type="text"], 
        input[type="password"], 
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Primary green color */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* Slightly darker green on hover */
        }

        select {
            background-color: #fff; /* White background for dropdown */
        }
    </style>
</head>
<body>


    



    
    <h1><i class="fas fa-user-plus"></i> Add New Admin</h1>
    <form action="add_admin.php" method="post">
        <label for="username"><i class="fas fa-user"></i> Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password"><i class="fas fa-lock"></i> Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="role"><i class="fas fa-user-shield"></i> Role:</label>
        <select id="role" name="role" required>
            <option value="Loan Officer">Loan Officer</option>
            <option value="Teller">Teller</option>
            <option value="Admin">Admin</option>
        </select>

        <input type="submit" value="Add Admin">
    </form>
</body>
</html>
