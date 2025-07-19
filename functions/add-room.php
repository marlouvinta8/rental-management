<?php
include_once 'connection.php';

$pax = $_POST['pax'];
$rent = $_POST['rent'];

// First insert the room details
$sql = "INSERT INTO rooms (pax, rent) VALUES (:pax, :rent)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':pax', $pax);
$stmt->bindParam(':rent', $rent);
$stmt->execute();

$room_id = $db->lastInsertId();

// Handle multiple image uploads
$target_dir = "img/rooms/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$upload_errors = array();
$uploaded_files = array();

foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
    $file_name = $_FILES['images']['name'][$key];
    $file_size = $_FILES['images']['size'][$key];
    $file_tmp = $_FILES['images']['tmp_name'][$key];
    $file_type = $_FILES['images']['type'][$key];
    
    $image = $target_dir . $room_id . '_' . basename($file_name);
    $imageFileType = strtolower(pathinfo($image,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($file_tmp);
    if($check === false) {
        $upload_errors[] = "File $file_name is not an image";
        continue;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $upload_errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed for $file_name";
        continue;
    }

    // Upload the image
    if (move_uploaded_file($file_tmp, $image)) {
        $uploaded_files[] = $image;
        
        // Insert image path into database
        $sql = "INSERT INTO room_images (room_id, image_path) VALUES (:room_id, :image_path)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':room_id', $room_id);
        $stmt->bindParam(':image_path', $image);
        $stmt->execute();
    } else {
        $upload_errors[] = "Sorry, there was an error uploading $file_name";
    }
}

if (!empty($upload_errors)) {
    $error_message = implode("<br>", $upload_errors);
    header('Location: ../rooms.php?type=error&message=' . urlencode($error_message));
    exit;
}

generate_logs('Adding Room', $pax.'| Room was added successfully with ' . count($uploaded_files) . ' images');
header('Location: ../rooms.php?type=success&message=Room was added successfully with ' . count($uploaded_files) . ' images');
?>