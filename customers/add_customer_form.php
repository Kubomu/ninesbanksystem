<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Customer</title>
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

        a {
            color: #4CAF50; /* Primary green color for links */
            text-decoration: none; /* Remove underline */
            transition: color 0.3s;
        }

        a:hover {
            color: #f44336; /* Change color to secondary red on hover */
            text-decoration: underline; /* Underline on hover */
        }


        input[type="text"],
        input[type="email"],
        input[type="date"],
        select,
        textarea {
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
    </style>
</head>
<body>

    <div class="breadcrumbs">
        <a href="../index.php">Dashboard</a> > <a href="add_customer_form.php">Add Customer</a>
    </div>


<h1>Add New Customer</h1>
    <form action="save_customer.php" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
        
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="phone_number">Phone Number:</label>
        <div style="display: flex; align-items: center;">
            <select id="country_code" name="country_code" style="width: 30%; margin-right: 10px;">
                <option value="+1">USA (+1)</option>
                <option value="+44">UK (+44)</option>
                <option value="+256">Uganda (+256)</option>
                <!-- Add more country codes as needed -->
            </select>
            <input type="text" id="phone_number" name="phone_number" required placeholder="Phone number">
        </div>

        <label for="gender">Gender:</label>
        <div>
            <label><input type="radio" name="gender" value="Male" required> Male</label>
            <label><input type="radio" name="gender" value="Female" required> Female</label>
        </div>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea>
        
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" required>
        
        <label for="account_type">Account Type:</label>
        <select id="account_type" name="account_type" required>
        <option value="Savings">Savings</option>
        <option value="Current">Current</option>
        <option value="Fixed Deposit">Fixed Deposit</option>
        </select>
        
        <input type="submit" value="Add Customer">
    </form>
</body>
</html>
</body>
</html>
