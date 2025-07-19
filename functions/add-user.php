<?php
include_once 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $level = $_POST['level'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Check if username already exists
    $check_query = "SELECT * FROM users WHERE username = :username";
    $stmt = $db->prepare($check_query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Username already exists!";
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <script src="../assets/js/sweetalert.min.js"></script>
        </head>
        <body>
            <script>
                swal({
                    title: "Error!",
                    text: "Username already exists!",
                    icon: "error"
                }).then(function() {
                     window.location.href = "../users.php";
                });
            </script>
        </body>
        </html>';
        exit();
    }

    // Insert new user
    $insert_query = "INSERT INTO users (fullname, username, password, level, phone, email, address) VALUES (:name, :username, :password, :level, :phone, :email, :address)";
    $stmt = $db->prepare($insert_query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':level', $level);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':address', $address);

    if ($stmt->execute()) {
        // Success - show SweetAlert
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <script src="../assets/js/sweetalert.min.js"></script>
        </head>
        <body>
            <script>
                swal({
                    title: "Success!",
                    text: "User added successfully!",
                    icon: "success"
                }).then(function() {
                     window.location.href = "../users.php";
                });
            </script>
        </body>
        </html>';
        exit();
    } else {
        // Error - show SweetAlert
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <script src="../assets/js/sweetalert.min.js"></script>
        </head>
        <body>
            <script>
                swal({
                    title: "Error!",
                    text: "Error adding user.",
                    icon: "error"
                }).then(function() {
                     window.location.href = "../users.php";
                });
            </script>
        </body>
        </html>';
        exit();
    }
} else {
    header("Location: ../users.php");
    exit();
}
?>
