<?php
include_once 'connection.php';

$id = $_GET['id']; // boarder id

$stmt = $db->prepare("SELECT month_paid FROM payments WHERE boarder = :id AND is_approved = 1");
$stmt->bindParam(':id', $id);
$stmt->execute();

$months = $stmt->fetchAll(PDO::FETCH_COLUMN); // returns array of paid month values
echo json_encode($months);
?>
