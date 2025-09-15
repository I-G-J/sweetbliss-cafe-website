<?php


ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if POST data is coming
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
        die("❌ Form data is missing. POST data: " . print_r($_POST, true));
    }

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // DB connection
    include "db.php";

    if (!$conn) {
        die("❌ Database connection failed: " . mysqli_connect_error());
    }

    // Prepare insert
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("❌ Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Your message has been sent successfully!'); window.location.href='index.php#contact';</script>";
    } else {
        die("❌ Insert failed: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    die("❌ Invalid request method.");
}
?>
