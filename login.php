<?php
session_start();
require('db_connect.php'); // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user details from the database
    $query = "SELECT * FROM admins WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password and set session variables
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['admin_id'];
        $_SESSION['role'] = $user['role'];  // Store role in session
        $_SESSION['username'] = $user['username']; // Store username in session

        // Set session cookie parameters before starting session
        session_set_cookie_params([
            'lifetime' => 0, // Session cookie
            'path' => '/',
            'domain' => '', // Set your domain if necessary
            'secure' => true, // Set true if using HTTPS
            'httponly' => true, // Prevent JavaScript access
            'samesite' => 'Strict' // Prevent CSRF
        ]);

        // Redirect to the dashboard
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .login-form {
            max-width: 500px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .bank-info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
            color: #555;
        }

        input[type="text"], input[type="password"] {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding-left: 40px; /* Add padding for icon space */
            position: relative; /* For positioning icons */
        }

        .icon {
            position: absolute;
            left: 10px;
            top: 10px;
            color: #999; /* Light grey color for icons */
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #f39c12;
        }

        .error-message {
            color: #e74c3c; /* Red color for error message */
            text-align: center;
            margin-bottom: 15px;
        }

        .remember-me {
            margin: 10px 0;
        }

        .forgot-password {
            text-align: center;
            margin-top: 10px;
        }

        .forgot-password a {
            color: #2c3e50;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h1><i class="fas fa-user-lock"></i> User Login</h1>
        <div class="bank-info">
            <h2>Nines Bank</h2>
            <p>Your trusted banking partner.</p>
        </div>
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div style="position: relative;">
                <i class="fas fa-user icon"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div style="position: relative;">
                <i class="fas fa-lock icon"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <br>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
