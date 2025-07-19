<?php
include_once 'functions/connection.php';

// I-check ang level ng nakalogin na user
$userLevel = $_SESSION['level'];
$userEmail = $_SESSION['username']; // assuming nakalogin at ang email ng user ay nasa session

// Base SQL query
$sql = 'SELECT boarders.*, rooms.id as room, rooms.rent as rent, payments.total, payments.amount, payments.month_paid, payments.is_approved
        FROM boarders
        INNER JOIN rooms ON boarders.room = rooms.id
        INNER JOIN payments ON boarders.id = payments.boarder';

// Conditions array to build WHERE clause dynamically
$conditions = ['payments.is_approved IN (0, 1, 2)'];

// Kung level 2 ang nakalogin, i-filter din by email
if ($userLevel == 2) {
    $conditions[] = 'boarders.email = :email';
}

// Append WHERE clause if there are any conditions
if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

$stmt = $db->prepare($sql);

// Bind email if needed
if ($userLevel == 2) {
    $stmt->bindParam(':email', $userEmail);
}

$stmt->execute();
$results = $stmt->fetchAll();

foreach ($results as $row) {
?>
    <tr>
        <td><img class="rounded-circle me-2" width="30" height="30" src="functions/<?=$row['profile_picture']?>"><?=$row['fullname']?></td>
        <td>Room # <?=$row['room']?></td>
        <td><?=$row['type']?></td>
        <td>₱<?=number_format($row['rent'], 2)?></td>
        <td>₱<?=number_format($row['amount'], 2)?></td>
        <td><?=$row['month_paid']?></td>
        <td>
            <?php if ($row['is_approved'] == 1): ?>
                <span class="badge bg-success">Approved</span>
            <?php elseif ($row['is_approved'] == 2): ?>
                <span class="badge bg-danger">Rejected</span>
            <?php else: ?>
                <span class="badge bg-secondary">Pending</span>
            <?php endif; ?>
        </td>
    </tr>
<?php
}
?>
