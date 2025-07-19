<?php
include_once 'functions/connection.php';

$sql = 'SELECT b.*, r.rent, 
        (SELECT SUM(amount) FROM payments WHERE boarder = b.id AND is_approved = 1) as total_paid,
        DATEDIFF(b.end_date, b.start_date) as total_days,
        (DATEDIFF(b.end_date, b.start_date) / 30) * r.rent as total_rent
        FROM `boarders` b
        INNER JOIN `rooms` r ON b.room = r.id
          WHERE b.status IN (0, 1)';

$stmt = $db->prepare($sql);
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
        $roomStatusLabel = 'Unknown'; // Default if other statuses exist
    }
?>
    <tr>
        <td><img class="rounded-circle me-2" width="30" height="30" src="functions/<?=$row['profile_picture']?>"><?=$row['fullname']?></td>
        <td>Room #<?= $row['room'] ?></td>
        <td><?= $row['type'] ?></td>
        <td>₱<?= number_format($row['rent'], 2) ?></td>
        <td>₱<?= $total_rent ?></td>
        <td>₱<?= $total_paid ?></td>
        <td>₱<?= $balance ?></td>
        <td><?= $row['start_date'] ?></td>
        <td><?= $row['end_date'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $roomStatusLabel ?></td> <!-- Displaying room status as Pending or Renting -->
        <td class="text-center">
            <a class="btn btn-primary mx-1" role="button" href="profile.php?id=<?=$row['id']?>">View</a>
            <button class="btn btn-warning mx-1" type="button" data-bs-target="#update" data-bs-toggle="modal" data-id="<?=$row['id']?>" data-fullname="<?=$row['fullname']?>" data-room="<?=$row['room']?>" data-type="<?=$row['type']?>" data-sex="<?=$row['sex']?>" data-start_date="<?=$row['start_date']?>"  data-phone="<?=$row['phone']?>"  data-address="<?=$row['address']?>">Update</button>
            <button class="btn btn-danger mx-1" type="button" data-bs-target="#remove" data-bs-toggle="modal" data-id="<?=$row['id']?>">Remove</button>
        </td>
    </tr>

<?php
}
?>
