<?php
include_once 'connection.php';
session_start(); // Siguraduhing naka-start ang session

$username = $_SESSION['username'];
$request = $_POST['request'];

// Kunin ang boarder_id at room gamit ang email (username)
$sqlBoarder = "SELECT id, room FROM boarders WHERE email = :email";
$stmtBoarder = $db->prepare($sqlBoarder);
$stmtBoarder->bindParam(':email', $username);
$stmtBoarder->execute();
$boarderData = $stmtBoarder->fetch(PDO::FETCH_ASSOC);

if ($boarderData) {
    $boarder_id = $boarderData['id'];
    $room = $boarderData['room'];

    // I-save ang maintenance request
    $sql = "INSERT INTO maintenance_request (boarder_id, requests, room) 
            VALUES (:boarder_id, :request, :room)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':boarder_id', $boarder_id);
    $stmt->bindParam(':request', $request);
    $stmt->bindParam(':room', $room);
    $stmt->execute();

    generate_logs('Adding request', $request . '|');
    header('Location: ../maintenance-request.php?type=success&message=Request submitted');
    exit;
} else {
    // Kung walang matching boarder
    header('Location: ../maintenance-request.php?type=error&message=Boarder not found');
    exit;
}
