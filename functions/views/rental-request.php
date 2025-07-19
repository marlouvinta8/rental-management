<?php
include_once 'functions/connection.php';
$userLevel = $_SESSION['level'];
$userEmail = $_SESSION['username'];
$sql = 'SELECT b.*, r.rent, 
        (SELECT SUM(amount) FROM payments WHERE boarder = b.id) as total_paid,
        DATEDIFF(b.end_date, b.start_date) as total_days,
        (DATEDIFF(b.end_date, b.start_date) / 30) * r.rent as total_rent
        FROM `boarders` b
        INNER JOIN `rooms` r ON b.room = r.id';
$stmt = $db->prepare($sql);
if ($userLevel == 2) {
    $sql .= ' WHERE b.email = :email';
}

$stmt = $db->prepare($sql);

// Bind ang email ng nakalogin kung level 2
if ($userLevel == 2) {
    $stmt->bindParam(':email', $userEmail);
}
$stmt->execute();

$results = $stmt->fetchAll();

foreach ($results as $row) {
    $total_rent = number_format($row['total_rent'], 2);
    $total_paid = number_format($row['total_paid'] ?? 0, 2);
    $balance = number_format($row['total_rent'] - ($row['total_paid'] ?? 0), 2);
    
    // Assigning the room status label based on the value of room_status
    if ($row['status'] == 0) {
        $roomStatusLabel = 'Pending';
    } elseif ($row['status'] == 1) {
        $roomStatusLabel = 'Renting';
    } else {
        $roomStatusLabel = 'Disapproved'; // Default if other statuses exist
    }
?>
    <tr>
        <td><img class="rounded-circle me-2" width="30" height="30" src="functions/<?=$row['profile_picture']?>"><?=$row['fullname']?></td>
        <td>Room #<?= $row['room'] ?></td>
        <td><?= $row['type'] ?></td>
        <td>₱<?= number_format($row['rent'], 2) ?></td>
        <td>₱<?= $total_rent ?></td>
        <td><?= $row['start_date'] ?></td>
        <td><?= $row['end_date'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $roomStatusLabel ?></td>
    </tr>

<?php
}
?>
