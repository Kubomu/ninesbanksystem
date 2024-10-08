<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unauthorized Access</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f4f4f4 30%, #e9ecef 100%);
            color: #2c3e50;
            margin: 0;
            padding: 50px;
            text-align: center;
        }

        h1 {
            color: #e74c3c; /* Red color for error message */
            font-weight: 600;
            font-size: 2.5em;
        }

        p {
            font-size: 1.2em;
            margin: 20px 0;
        }

        .advice {
            font-size: 1.1em;
            color: #34495e; /* Darker color for advice text */
            margin: 20px 0;
            font-weight: 400;
        }

        a {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        a:hover {
            background-color: #f39c12;
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <h1><i class="fas fa-exclamation-triangle"></i> Access Denied</h1>
    <p>You do not have permission to view this page.</p>
    <p class="advice">Please log in as Admin to access this page.</p>
    <a href="index.php">Return to Dashboard</a>
</body>
</html>
