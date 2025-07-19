<?php
include_once 'functions/connection.php';

// Ang SQL query na may JOIN para makuha ang fullname
$sql = '
    SELECT mr.*, b.fullname 
    FROM maintenance_request mr
    JOIN boarders b ON mr.boarder_id = b.id
';

$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

foreach ($results as $row) {
    // Convert status number to readable label
    switch ($row['status']) {
        case 0:
            $statusLabel = 'Pending';
            break;
        case 1:
            $statusLabel = 'Confirmed';
            break;
        case 2:
            $statusLabel = 'Completed';
            break;
        default:
            $statusLabel = 'Unknown';
    }
?>
    <tr>
        <td><?= htmlspecialchars($row['fullname']) ?></td>
        <td><?= htmlspecialchars('Room #' . $row['room']) ?></td>
        <td><?= htmlspecialchars($row['requests']) ?></td>
        <td><?= htmlspecialchars($statusLabel) ?></td>
    </tr>
<?php
}
?>
