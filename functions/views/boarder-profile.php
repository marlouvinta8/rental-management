<?php
include_once 'functions/connection.php';

$id = $_GET['id'] ?? null;

if ($id !== null) {
    $sql = 'SELECT b.*, r.rent 
            FROM `boarders` b
            INNER JOIN `rooms` r ON b.room = r.id
            WHERE b.id = :id';
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $results = $stmt->fetch();

    if ($results) {
        $fullname = $results['fullname'];
        $phone = $results['phone'];
        $address = $results['address'];
        $room = $results['room'];
        $rent = $results['rent'];
        $type = $results['type'];   
        $profile_picture = $results['profile_picture'];
        $proof_of_identity = $results['proof_of_identity'];
        $status = $results['status'];
        $id = $results['id'];
    } else {
        echo "No boarder found with ID: $id";
    }
} else {
    echo "ID not provided.";
}
