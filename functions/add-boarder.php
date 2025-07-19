<?php
include_once 'connection.php';

$fullname = $_POST['fullname'];
$phone = $_POST['phone'];
$sex = $_POST['sex'];
$address = $_POST['address'];
$start_date = $_POST['start_date'];
$month_paid = date('Y-m', strtotime($start_date));
$end_date = $_POST['end_date'];
$room = $_POST['room'];
$type = $_POST['type'];
$email = $_POST['email'];

$target_dir = "img/";
$profile = $target_dir . $fullname . basename($_FILES["profile"]["name"]);
$proof = $target_dir . $fullname . basename($_FILES["proof"]["name"]);

move_uploaded_file($_FILES["profile"]["tmp_name"], $profile);
move_uploaded_file($_FILES["proof"]["tmp_name"], $proof);

$sql = "SELECT * FROM boarders WHERE email = :email";
$stmt = $db->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header('Location: ../boarders.php?type=error&message=The username "' . urlencode($email) . '" has already been used for a different rental. Please create a new account with a different username.');
    exit;
}


$sql = "INSERT INTO boarders (fullname, phone, sex, address, start_date, end_date, room, type, profile_picture, proof_of_identity, email, status) 
        VALUES (:fullname, :phone, :sex, :address, :start_date, :end_date, :room, :type, :profile, :proof, :email, :status)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':sex', $sex);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':start_date', $start_date);
$stmt->bindParam(':end_date', $end_date);
$stmt->bindParam(':room', $room);
$stmt->bindParam(':type', $type);
$stmt->bindParam(':profile', $profile);
$stmt->bindParam(':proof', $proof);
$stmt->bindParam(':email', $email);

// Add status binding
$status = 1;
$stmt->bindParam(':status', $status);

$stmt->execute();

$boarder = $db->lastInsertId();

// Update room availability to 1 (occupied)
$sql = "UPDATE rooms SET is_available = 1 WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $room);
$stmt->execute();

$paymentId = $db->lastInsertId();

generate_logs('Adding boarder', $fullname . '| New boarder was added');
// header('Location: ../boarders.php?type=success&message=New boarder was added successfully');
header('Location: ../boarders.php?type=success&message=New boarder was added successfully');
exit;
