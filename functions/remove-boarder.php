<?php
include_once 'connection.php';

$id = $_POST['id'];

// Step 1: Kunin muna ang room_id ng boarder
$sql = "SELECT room FROM boarders WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$boarder = $stmt->fetch(PDO::FETCH_ASSOC);

if ($boarder) {
    $room_id = $boarder['room'];

    // Step 2: I-delete ang boarder
    $sql = "DELETE FROM boarders WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Step 3: I-update ang rooms table (gawing available ang room)
    $sql = "UPDATE rooms SET is_available = 0 WHERE id = :room_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':room_id', $room_id);
    $stmt->execute();

    // Step 4: I-log ang action
    generate_logs('Remove boarder', 'Boarder ID: ' . $id . ' | Room ID: ' . $room_id . ' | Boarder details were removed');

    // Redirect
    header('Location: ../boarders.php?type=success&message=Boarder details were removed successfully');
    exit;
} else {
    header('Location: ../boarders.php?type=error&message=Boarder not found');
    exit;
}
