<?php
include_once 'functions/connection.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    switch ($action) {
        case 'add':
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $level = mysqli_real_escape_string($conn, $_POST['level']);
            
            $query = "INSERT INTO users (name, username, password, level) VALUES ('$name', '$username', '$password', '$level')";
            if (mysqli_query($conn, $query)) {
                echo json_encode(['status' => 'success', 'message' => 'User added successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error adding user']);
            }
            break;
            
        case 'update':
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $level = mysqli_real_escape_string($conn, $_POST['level']);
            
            $query = "UPDATE users SET name = '$name', username = '$username', level = '$level' WHERE id = '$id'";
            if (mysqli_query($conn, $query)) {
                echo json_encode(['status' => 'success', 'message' => 'User updated successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error updating user']);
            }
            break;
            
        case 'remove':
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            
            $query = "DELETE FROM users WHERE id = '$id'";
            if (mysqli_query($conn, $query)) {
                echo json_encode(['status' => 'success', 'message' => 'User removed successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error removing user']);
            }
            break;
            
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            break;
    }
}
?> 