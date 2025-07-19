<?php
include_once 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Check if user exists
    $check_query = "SELECT * FROM users WHERE id = :id";
    $stmt = $db->prepare($check_query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        // Display SweetAlert error for user not found
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
                    text: "User not found!",
                    icon: "error"
                }).then(function() {
                     window.location.href = "../users.php";
                });
            </script>
        </body>
        </html>';
        exit();
    }

    // Delete user
    $delete_query = "DELETE FROM users WHERE id = :id";
    $stmt = $db->prepare($delete_query);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        // Display SweetAlert success after successful deletion
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
                    text: "User removed successfully!",
                    icon: "success"
                }).then(function() {
                     window.location.href = "../users.php";
                });
            </script>
        </body>
        </html>';
        exit();
    } else {
        // Display SweetAlert error if the deletion fails
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
                    text: "Error removing user.",
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
