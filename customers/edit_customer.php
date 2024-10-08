<?php
include '../db_connect.php'; // Include the database connection

// Get the customer ID from the URL
$id = $_GET['id'];

// Fetch the customer data based on ID
$sql = "SELECT * FROM customers WHERE customer_id = $id";
$result = $conn->query($sql);

// Check if the customer exists
if ($result->num_rows > 0) {
    $customer = $result->fetch_assoc();
} else {
    echo "Customer not found!";
    exit();
}

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated data from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $date_of_birth = $_POST['date_of_birth'];
    $account_type = $_POST['account_type'];
    $gender = $_POST['gender']; // Get the gender from the form

    // Update the customer in the database
    $sql = "UPDATE customers SET 
        first_name = '$first_name', 
        last_name = '$last_name', 
        email = '$email', 
        phone_number = '$phone_number', 
        address = '$address', 
        date_of_birth = '$date_of_birth', 
        account_type = '$account_type', 
        gender = '$gender' 
        WHERE customer_id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to customer list after successful update
        header("Location: view_customers.php");
        exit(); // Terminate the script after redirection
    } else {
        echo "Error updating customer: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="../css/styles.css">
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
            max-width: 600px; /* Maximum width for the form */
            margin: 0 auto; /* Center the form */
            background: white; /* White background for form */
            padding: 20px; /* Padding inside the form */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        label {
            display: block; /* Block display for labels */
            margin: 10px 0 5px; /* Spacing around labels */
        }

        input[type="text"],
        input[type="email"],
        input[type="date"] {
            width: 100%; /* Full width for inputs */
            padding: 10px; /* Padding inside inputs */
            border: 1px solid #ccc; /* Light border */
            border-radius: 4px; /* Rounded corners for inputs */
            margin-bottom: 15px; /* Spacing below inputs */
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Green submit button */
            color: white; /* White text */
            border: none; /* No border */
            padding: 10px; /* Padding inside button */
            border-radius: 4px; /* Rounded corners for button */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 16px; /* Larger font size */
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        a {
            display: block; /* Block display for the back link */
            text-align: center; /* Center align the link */
            margin-top: 20px; /* Spacing above the link */
        }
    </style>
</head>
<body>
    <h1>Edit Customer</h1>

    <form method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?php echo $customer['first_name']; ?>" required>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?php echo $customer['last_name']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $customer['email']; ?>" required>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" value="<?php echo $customer['phone_number']; ?>" required>

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo $customer['address']; ?>" required>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" name="date_of_birth" value="<?php echo $customer['date_of_birth']; ?>" required>

        <label for="account_type">Account Type:</label>
        <input type="text" name="account_type" value="<?php echo $customer['account_type']; ?>" required>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="Male" <?php echo ($customer['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($customer['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
        </select>
        <br><br><br>
        <input type="submit" value="Update Customer">
    </form>

    <a href="view_customers.php">Back to Customer List</a>
</body>
</html>

<?php
$conn->close();
?>
