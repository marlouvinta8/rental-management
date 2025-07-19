<?php
include_once 'functions/connection.php';

function calculateMonthlyEarnings() {
    global $db;
    $sql = 'SELECT SUM(amount) AS monthlyEarnings 
            FROM payments 
            WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) 
            AND is_approved = 1';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    $monthlyEarnings = $result['monthlyEarnings'];
    return $monthlyEarnings;
}

function calculateYearlyEarnings() {
    global $db;
    $sql = 'SELECT SUM(amount) AS yearlyEarnings FROM payments WHERE YEAR(created_at) = YEAR(CURRENT_DATE())AND is_approved = 1';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    $yearlyEarnings = $result['yearlyEarnings'];
    return $yearlyEarnings;
}

function countTotalBoarders() {
    global $db;
    $sql = 'SELECT COUNT(*) AS totalBoarders FROM boarders WHERE status IN (0, 1)';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    $totalBoarders = $result['totalBoarders'];
    return $totalBoarders;
}
function countTotalRooms() {
    global $db;
    $sql = 'SELECT COUNT(*) AS totalRooms FROM rooms';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    $totalRooms = $result['totalRooms'];
    return $totalRooms;
}
