<?php
include '../db_connect.php'; // Include the database connection

// Check if the customer ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the DELETE SQL query
    $sql = "DELETE FROM customers WHERE customer_id = $id";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Customer deleted successfully! <a href='view_customers.php'>Go back to customer list</a>";
    } else {
        echo "Error deleting customer: " . $conn->error;
    }
} else {
    echo "No customer ID provided!";
}

// Close the database connection
$conn->close();
?>
