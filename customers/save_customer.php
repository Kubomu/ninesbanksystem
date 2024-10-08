<?php
include '../db_connect.php'; // Include the database connection

// Get the form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$gender = $_POST['gender'];
$address = $_POST['address'];
$date_of_birth = $_POST['date_of_birth'];
$account_type = $_POST['account_type'];


// Prepare and bind the SQL statement
$stmt = $conn->prepare("INSERT INTO customers (first_name, last_name, gender, email, phone_number, address, date_of_birth, account_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $first_name, $last_name, $gender, $email, $phone_number, $address, $date_of_birth, $account_type);

// Execute the query
if ($stmt->execute()) {
    // Show success message and redirect after a delay
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Success</title>
        <style>
            body {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
                font-family: Arial, sans-serif;
                background-color: #e0f7fa; /* Light blue background */
            }
            .message {
                padding: 20px;
                border: 2px solid #4CAF50; /* Green border */
                background-color: #c8e6c9; /* Light green background */
                color: #2e7d32; /* Darker green text */
                border-radius: 5px;
                text-align: center;
            }
            a {
                display: inline-block;
                margin-top: 10px;
                padding: 10px 20px;
                background-color: #4CAF50; /* Green button */
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
            a:hover {
                background-color: #45a049; /* Darker green on hover */
            }
        </style>
    </head>
    <body>
        <div class='message'>
            New customer added successfully! 
            <br>
            <a href='view_customers.php'>View Customers</a>
        </div>
        <script>
            // Redirect after 3 seconds
            setTimeout(function() {
                window.location.href = 'view_customers.php';
            }, 3000);
        </script>
    </body>
    </html>";
} else {
    // Handle error
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Error</title>
        <style>
            body {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
                font-family: Arial, sans-serif;
                background-color: #f8d7da; /* Light red background */
            }
            .error-message {
                padding: 20px;
                border: 2px solid #dc3545; /* Red border */
                background-color: #f5c6cb; /* Light red background */
                color: #721c24; /* Darker red text */
                border-radius: 5px;
                text-align: center;
            }
            a {
                display: inline-block;
                margin-top: 10px;
                padding: 10px 20px;
                background-color: #dc3545; /* Red button */
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
            a:hover {
                background-color: #c82333; /* Darker red on hover */
            }
        </style>
    </head>
    <body>
        <div class='error-message'>
            Error: " . htmlspecialchars($stmt->error) . "
            <br>
            <a href='add_customer_form.php'>Go Back</a>
        </div>
    </body>
    </html>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
