<?php
include_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requestId = $_POST['request_id'];
    $status = $_POST['status'];

    // SQL query to update the status of the maintenance request
    $sql = "UPDATE maintenance_request SET status = :status WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $requestId);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
