<?php
include_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = trim($_POST['address']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $level = 2; // regular user

    // Check if username already exists
    $checkStmt = $db->prepare("SELECT id FROM users WHERE username = ?");
    $checkStmt->execute([$username]);

    if ($checkStmt->fetch()) {
        header("Location: ../register.php?type=error&message=Username already exists");
        exit();
    }

    // Insert user into DB
    $stmt = $db->prepare("INSERT INTO users (fullname, username, password, address, email, phone, level) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $result = $stmt->execute([$fullname, $username, $password, $address, $email, $phone, $level]);

    if ($result) {

        // You can redirect to index or login page
        header("Location: ../login.php?type=success&message=Registered successfully");
    } else {
        header("Location: ../register.php?type=error&message=Registration failed");
    }
}
?>
