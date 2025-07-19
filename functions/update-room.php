<?php
include_once 'connection.php';

$id = $_POST['id'];
$pax = $_POST['pax'];
$rent = $_POST['rent'];

// Update room details
$sql = "UPDATE rooms SET pax = :pax, rent = :rent WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':pax', $pax);
$stmt->bindParam(':rent', $rent);
$stmt->bindParam(':id', $id);
$stmt->execute();

// Handle image uploads
if (!empty($_FILES['images']['name'][0])) {
    $upload_dir = '../assets/img/rooms/';
    
    // Delete old images from database and filesystem
    $sql = "SELECT image_path FROM room_images WHERE room_id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $old_images = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Delete old images from filesystem
    foreach ($old_images as $old_image) {
        $old_image_path = $upload_dir . $old_image;
        if (file_exists($old_image_path)) {
            unlink($old_image_path);
        }
    }
    
    // Delete old images from database
    $sql = "DELETE FROM room_images WHERE room_id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    // Upload new images
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['images']['name'][$key];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_file_name = uniqid() . '.' . $file_ext;
        $target_path = $upload_dir . $new_file_name;
        
        if (move_uploaded_file($tmp_name, $target_path)) {
            // Insert new image into database
            $sql = "INSERT INTO room_images (room_id, image_path) VALUES (:room_id, :image_path)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':room_id', $id);
            $stmt->bindParam(':image_path', $new_file_name);
            $stmt->execute();
        }
    }
}

generate_logs('Update Room', $pax.'| Room was updated successfully');
header('Location: ../rooms.php?type=success&message=Room was updated successfully');
?>