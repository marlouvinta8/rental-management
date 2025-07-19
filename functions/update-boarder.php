<?php
include_once 'connection.php';

$id = $_POST['id'];
$fullname = $_POST['fullname'];
$phone = $_POST['phone'];
$sex = $_POST['sex'];
$address = $_POST['address'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$room = $_POST['room'];
$type = $_POST['type'];
$email = $_POST['email'];

// Get the current room of the boarder
$sql = "SELECT room FROM boarders WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$current_room = $stmt->fetchColumn();

$target_dir = "img/";
$profile = $target_dir . $fullname . basename($_FILES["profile"]["name"]);
$proof = $target_dir . $fullname . basename($_FILES["proof"]["name"]);

// Check if profile and proof are empty
if (!empty($_FILES["profile"]["name"]) && !empty($_FILES["proof"]["name"])) {
    move_uploaded_file($_FILES["profile"]["tmp_name"], $profile);
    move_uploaded_file($_FILES["proof"]["tmp_name"], $proof);
}

$sql = "SELECT * FROM boarders WHERE (email = :email) AND id != :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':id', $id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header('Location: ../boarders.php?type=error&message=' . $email . ' is already exist');
    exit;
}

$sql = "UPDATE boarders SET fullname = :fullname, phone = :phone, sex = :sex, address = :address, start_date = :start_date, end_date = :end_date, room = :room, type = :type, email = :email";

// Add profile_picture and proof_of_identity to the query if they are not empty
if (!empty($_FILES["profile"]["name"]) && !empty($_FILES["proof"]["name"])) {
    $sql .= ", profile_picture = :profile, proof_of_identity = :proof";
}

$sql .= " WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':sex', $sex);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':start_date', $start_date);
$stmt->bindParam(':end_date', $end_date);
$stmt->bindParam(':room', $room);
$stmt->bindParam(':type', $type);
$stmt->bindParam(':email', $email);

// Bind profile and proof parameters if they are not empty
if (!empty($_FILES["profile"]["name"]) && !empty($_FILES["proof"]["name"])) {
    $stmt->bindParam(':profile', $profile);
    $stmt->bindParam(':proof', $proof);
}

$stmt->execute();

// Update room availability
if ($current_room != $room) {
    // Set old room to available (0)
    $sql = "UPDATE rooms SET is_available = 0 WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $current_room);
    $stmt->execute();

    // Set new room to occupied (1)
    $sql = "UPDATE rooms SET is_available = 1 WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $room);
    $stmt->execute();
}

generate_logs('Updating boarder', $fullname . '| Boarder details were updated');
header('Location: ../boarders.php?type=success&message=Boarder details were updated successfully');
exit;
