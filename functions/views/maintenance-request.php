<?php
include_once 'functions/connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userEmail = $_SESSION['username'];
$userLevel = $_SESSION['level'];

if ($userLevel == 2) {
    $sql = '
        SELECT mr.*, b.fullname, b.room
        FROM maintenance_request mr
        JOIN boarders b ON mr.boarder_id = b.id
        WHERE b.email = :email
    ';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $userEmail);
} else {
    $sql = '
        SELECT mr.*, b.fullname, b.room
        FROM maintenance_request mr
        JOIN boarders b ON mr.boarder_id = b.id
    ';
    $stmt = $db->prepare($sql);
}

$stmt->execute();
$results = $stmt->fetchAll();

foreach ($results as $row) {
    // Convert status number to readable label
    switch ($row['status']) {
        case 0:
            $statusLabel = 'Pending';
            $statusClass = 'bg-secondary';
            break;
        case 1:
            $statusLabel = 'Confirmed';
            $statusClass = 'bg-primary';
            break;
        case 2:
            $statusLabel = 'Completed';
            $statusClass = 'bg-success';
            break;
        default:
            $statusLabel = 'Unknown';
            $statusClass = 'bg-dark';
    }
?>
    <tr>
        <td><?= htmlspecialchars($row['fullname']) ?></td>
        <td><?= htmlspecialchars('Room #' . $row['room']) ?></td>
        <td><?= htmlspecialchars($row['requests']) ?></td>
        <td>
            <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($statusLabel) ?></span>
        </td>
    </tr>
<?php
}
?>