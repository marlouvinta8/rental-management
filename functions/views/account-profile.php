<?php
include_once 'functions/connection.php';

// I-check kung may naka-login na user
if (!isset($_SESSION['id'])) {
    echo "User not logged in.";
    exit;
}

$userId = $_SESSION['id'];

// Kunin ang user info mula sa users table
$sql = 'SELECT * FROM `users` WHERE id = :id';

$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $userId, PDO::PARAM_INT);
$stmt->execute();

$results = $stmt->fetch();

if ($results) {
    $fullname = $results['fullname'];
    $phone = $results['phone'];
    $address = $results['address'];
    $email = $results['email'];
    $level = $results['level'];
    $id = $results['id'];
} else {
    echo "User not found.";
}
