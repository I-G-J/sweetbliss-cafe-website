<?php
session_start();
include "db.php";

$cart = $_SESSION['cart'] ?? [];
$payment = $_POST['payment_method'] ?? 'cod';

// Get customer info
$name = $_SESSION['username'] ?? '';
$email = $_SESSION['email'] ?? '';
$address = $_POST['customeraddress'] ?? '';
$phonenumber = $_POST['customerphonenumber'] ?? '';

if (empty($cart)) {
    header("Location: checkout.php");
    exit;
}

$items = json_encode($cart);

// Insert order into database
$stmt = $conn->prepare("INSERT INTO orders 
    (items, payment_method, customer_name, customer_email, customer_address, customer_phonenumber, created_at) 
    VALUES (?, ?, ?, ?, ?, ?, NOW())");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters: 6 strings (s = string)
$stmt->bind_param("ssssss", $items, $payment, $name, $email, $address, $phonenumber);

if ($stmt->execute()) {
    // Clear cart after successful order
    $_SESSION['cart'] = [];
    echo "<h2>Order placed successfully!</h2><a href='index.php'>Back to Home</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
