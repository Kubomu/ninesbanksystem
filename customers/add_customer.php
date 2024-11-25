<?php
include '../db_connect.php'; // Include the database connection



// Prepare and bind the SQL statement
$stmt = $conn->prepare("INSERT INTO customers (first_name, last_name, email, phone_number, address, date_of_birth, account_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $first_name, $last_name, $email, $phone_number, $address, $date_of_birth, $account_type);

// Execute the query
if ($stmt->execute()) {
    // Show success message and redirect to the view customers page
    echo "<script>
            alert('New customer added successfully');
            window.location.href = 'view_customers.php'; // Change to the correct path if needed
          </script>";
} else {
    echo "<script>
            alert('Error: " . addslashes($stmt->error) . "');
            window.location.href = 'add_customer_form.php'; // Redirect to the add customer form
          </script>";
}

// Close the statement and connection
$stmt->close();
$conn->close();

