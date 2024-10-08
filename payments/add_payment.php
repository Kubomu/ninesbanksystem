<?php
session_start(); // Start the session
include '../db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loan_id = $_POST['loan_id'];
    $payment_amount = $_POST['payment_amount'];
    $payment_date = date('Y-m-d H:i:s'); // Current date and time

    // Fetch the total payments made towards the loan
    $total_payments_sql = "SELECT COALESCE(SUM(payment_amount), 0) AS total_paid FROM payments WHERE loan_id = ?";
    $stmt = $conn->prepare($total_payments_sql);
    $stmt->bind_param("i", $loan_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_paid = $row['total_paid'];

    // Fetch the total amount payable for the loan
    $loan_sql = "SELECT loan_amount, total_amount_payable FROM loans WHERE loan_id = ?";
    $loan_stmt = $conn->prepare($loan_sql);
    $loan_stmt->bind_param("i", $loan_id);
    $loan_stmt->execute();
    $loan_result = $loan_stmt->get_result();
    $loan_row = $loan_result->fetch_assoc();
    $loan_amount = $loan_row['loan_amount'];
    $total_amount_payable = $loan_row['total_amount_payable'];

    // Calculate the remaining balance (total amount payable - total payments made + current payment)
    $remaining_balance = $total_amount_payable - ($total_paid + $payment_amount);

    // Insert the payment into the database
    $sql = "INSERT INTO payments (loan_id, payment_date, payment_amount, remaining_balance)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isds", $loan_id, $payment_date, $payment_amount, $remaining_balance);

    if ($stmt->execute()) {
        // Update the loan status if the payment is successful and the loan is fully paid
        if ($remaining_balance <= 0) {
            $update_sql = "UPDATE loans SET loan_status = 'Paid Off' WHERE loan_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("i", $loan_id);
            $update_stmt->execute();
        }

        // Set a success message in the session
        $_SESSION['success_message'] = "Payment made successfully! Remaining balance: " . number_format($remaining_balance, 2);

        // Redirect to payment_remaining_balances.php after successful payment processing
        header("Location: payment_remaining_balances.php");
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
