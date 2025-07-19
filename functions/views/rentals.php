<?php
include_once 'functions/connection.php';

// I-check ang level ng nakalogin na user
$userLevel = $_SESSION['level'];
$userEmail = $_SESSION['username']; // assuming nakalogin at ang email ng user ay nasa session

// Ang SQL query
$sql = 'SELECT b.*, r.rent, DATEDIFF(DATE_ADD(b.start_date, INTERVAL 1 MONTH), CURDATE()) AS days_due FROM boarders b
        INNER JOIN rooms r ON b.room = r.id';

// Kung level 2 ang nakalogin, i-filter ang query base sa email
if ($userLevel == 2) {
    $sql .= ' WHERE b.email = :email AND b.status = 1';
} else {
    $sql .= ' WHERE b.status = 1';
}

$stmt = $db->prepare($sql);

// Bind ang email ng nakalogin kung level 2
if ($userLevel == 2) {
    $stmt->bindParam(':email', $userEmail);
}

$stmt->execute();
$results = $stmt->fetchAll();

foreach ($results as $row) {
    $daysDue = $row['days_due'];
    $class = '';
    $text = '';
    $total = 0;
    if ($daysDue > 0) {
        $class = 'bg-success';
        $text = 'Due in ' . $daysDue . ' days';
    } elseif ($daysDue == 0) {
        $class = 'bg-warning';
        $text = 'Due Today';
        $total = round($row['rent'] + ($row['rent'] * abs($daysDue / 30)) );
    } else {
        $class = 'bg-danger';
        $text = 'Overdue ';
        $total = round($row['rent'] + ($row['rent'] * abs($daysDue / 30)) );
    }
?>
    <tr>
        <td><img class="rounded-circle me-2" width="30" height="30" src="functions/<?= $row['profile_picture'] ?>"><?= $row['fullname'] ?></td>
        <td>Room #<?= $row['room'] ?></td>
        <td>₱<?= $row['rent'] ?></td>
        <td><?= $row['start_date'] ?></td>
        <td><?= $row['end_date'] ?></td>
        <td class="<?= $class ?>"><?= $text ?></td>
        <td><?= abs($daysDue > 0 ? 0 : $daysDue)?></td>
        <td class="text-center">
            <a class="btn btn-primary mx-1" role="button" href="profile.php" data-bs-target="#pay" data-bs-toggle="modal" data-id="<?= $row['id'] ?>" data-room="<?= $row['room'] ?>" data-total="<?= $total ?>" data-start_date="<?= $row['start_date'] ?>" data-end_date="<?= $row['end_date'] ?>">
                <i class="far fa-money-bill-alt"></i>&nbsp;Payment
            </a>
        </td>
    </tr>
<?php
}
?>
