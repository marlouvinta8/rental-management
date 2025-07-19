<?php
include_once 'functions/connection.php';

function room_lists() {
    global $db;
    $sql = 'SELECT * FROM rooms WHERE is_available = 0';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        $roomId = $row['id'];
        $roomRent = $row['rent'];
        ?>
        <option value="<?php echo $roomId; ?>">
            Room #<?php echo $roomId . ' - ₱' . $roomRent; ?>
        </option>
        <?php
    }
}

function username_list() {
    global $db;
    $sql = 'SELECT users.id, users.username 
            FROM users 
            LEFT JOIN boarders ON users.username = boarders.email 
            WHERE users.level = 2 AND boarders.email IS NULL';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        $userId = $row['id'];
        $username = $row['username'];
        ?>
        <option value="<?php echo htmlspecialchars($username); ?>">
            <?php echo htmlspecialchars($username); ?>
        </option>
        <?php
    }
}


