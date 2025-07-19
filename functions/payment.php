<?php
include_once 'connection.php';
session_start();

$id = $_POST['id'];
$room = $_POST['room'];
$total = $_POST['total'];
$amount = $_POST['amount'];
$month_paid = $_POST['month_paid'];
$is_approved = $_POST['is_approved'];

// Step 0: Validate amount must equal rent from room
$sql = "SELECT rent FROM rooms WHERE id = :room_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':room_id', $room);
$stmt->execute();
$roomData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$roomData) {
    header('Location: ../rentals.php?type=error&message=Room not found');
    exit;
}

$expectedRent = $roomData['rent'];

if ($amount != $expectedRent) {
    header('Location: ../rentals.php?type=error&message=Amount must be exactly equal to room rent');
    exit;
}

$change = $amount - $total;

if ($change < 0) {
    header('Location: ../rentals.php?type=error&message=Amount is not enough');
    exit;
}

// Step 1: Check for existing pending payment for the same month
$sql = "SELECT * FROM payments WHERE boarder = :boarder AND month_paid = :month_paid AND is_approved = 0";
$stmt = $db->prepare($sql);
$stmt->bindParam(':boarder', $id);
$stmt->bindParam(':month_paid', $month_paid);
$stmt->execute();
$pendingPayment = $stmt->fetch(PDO::FETCH_ASSOC);

if ($pendingPayment) {
    header('Location: ../index.php?type=error&message=You have a pending request for this month');
    exit;
}

// Step 2: Check for consecutive month payments
$sql = "SELECT month_paid FROM payments WHERE boarder = :boarder AND is_approved = 1 ORDER BY month_paid DESC LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->bindParam(':boarder', $id);
$stmt->execute();
$lastPaid = $stmt->fetch(PDO::FETCH_ASSOC);

if ($lastPaid) {
    $lastPaidDate = new DateTime($lastPaid['month_paid']);
    $currentPaidDate = new DateTime($month_paid);

    $lastPaidDate->modify('+1 month');
    if ($lastPaidDate->format('Y-m') !== $currentPaidDate->format('Y-m')) {
        header('Location: ../index.php?type=error&message=Payment must be for the next consecutive month');
        exit;
    }
}

// Step 3: Handle Image Upload
$imageName = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageTmpName = $_FILES['image']['tmp_name'];
    $imageName = 'payment_' . time() . '_' . $_FILES['image']['name'];
    $uploadDir = '../uploads/';
    $imagePath = $uploadDir . $imageName;

    if (!move_uploaded_file($imageTmpName, $imagePath)) {
        header('Location: ../rentals.php?type=error&message=Failed to upload image');
        exit;
    }
}

// Step 4: Insert the payment into the database
$sql = "INSERT INTO payments (boarder, room, amount, total, month_paid, is_approved, payment_method)
        VALUES (:boarder, :room, :amount, :total, :month_paid, :is_approved, :payment_method)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':boarder', $id);
$stmt->bindParam(':room', $room);
$stmt->bindParam(':amount', $amount);
$stmt->bindParam(':total', $total);
$stmt->bindParam(':month_paid', $month_paid);
$stmt->bindParam(':payment_method', $imageName);
$stmt->bindParam(':is_approved', $is_approved);
$stmt->execute();

$paymentId = $db->lastInsertId();

// Generate logs
generate_logs('Payment', $id . '| Payment was made');

// Step 5: Redirect based on user level
if (isset($_SESSION['level']) && $_SESSION['level'] == 2) {
    $loggedInUsername = $_SESSION['username'];

    // Check if the username exists in boarders table
    $sql = "SELECT * FROM boarders WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$loggedInUsername]);
    $boarder = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($boarder) {
        generate_logs('Payment', $id . '| Payment was made');
        // Redirect to index.php for boarders
        header('Location: ../index.php?type=success&message=Payment was made successfully');
        exit;
    }
}

generate_logs('Payment', $id . '| Payment was made');
header('Location: ../rentals.php?type=success&message=Payment was made successfully');
// Default redirect (for admin or staff level 0 or 1)
exit;
?>
