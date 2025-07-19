<?php
include_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $date = date('Y-m-d H:i:s');

    try {
        $query = "INSERT INTO contacts (name, email, message, date_created) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$name, $email, $message, $date]);

        echo json_encode(['status' => 'success', 'message' => 'Thank you for your message. We will get back to you soon!']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Something went wrong. Please try again later.']);
    }
    exit;
}
?> 