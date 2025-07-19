<?php
include_once 'functions/connection.php';

// Kunin ang level ng user mula sa session (halimbawa, kung naka-login)
$loggedInUserLevel = $_SESSION['level']; // Depende kung paano naka-setup ang session mo

// Kung level 2 (Tenant) lang ang gustong makita
if ($loggedInUserLevel == 2) {
    // Query na magpapakita lang ng account ng naka-login na user
    $query = "SELECT * FROM users WHERE id = :userId ORDER BY fullname ASC";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':userId', $_SESSION['id'], PDO::PARAM_INT); // Assuming `user_id` ay naka-store sa session
} else {
    // Kung ibang level, ipakita ang lahat ng users
    $query = "SELECT * FROM users ORDER BY fullname ASC";
    $stmt = $db->prepare($query);
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $row) {
    // Bagong logic para sa role
    if ($row['level'] == 0) {
        $role = 'Admin';
    } elseif ($row['level'] == 1) {
        $role = 'Landlord';
    } elseif ($row['level'] == 2) {
        $role = 'Tenant';
    } else {
        $role = 'Unknown';
    }

    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['fullname']) . '</td>';
    echo '<td>' . htmlspecialchars($row['username']) . '</td>';
    echo '<td>' . $role . '</td>';
    echo '<td class="text-center">';
    echo '<button class="btn btn-primary btn-sm me-2" 
        data-bs-target="#update" 
        data-bs-toggle="modal" 
        data-id="' . htmlspecialchars($row['id']) . '" 
        data-name="' . htmlspecialchars($row['fullname']) . '" 
        data-username="' . htmlspecialchars($row['username']) . '" 
        data-level="' . htmlspecialchars($row['level']) . '" 
        data-phone="' . htmlspecialchars($row['phone']) . '" 
        data-email="' . htmlspecialchars($row['email']) . '" 
        data-address="' . htmlspecialchars($row['address']) . '">
        <i class="fas fa-edit"></i>
      </button>';

    echo '<button class="btn btn-danger btn-sm" data-bs-target="#remove" data-bs-toggle="modal" data-id="' . $row['id'] . '"><i class="fas fa-trash"></i></button>';
    echo '</td>';
    echo '</tr>';
}
