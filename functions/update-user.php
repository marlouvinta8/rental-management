<?php
include_once 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $level = $_POST['level'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Query to fetch the old username
    $get_old_username_query = "SELECT username FROM users WHERE id = :id";
    $stmt_get_old_username = $db->prepare($get_old_username_query);
    $stmt_get_old_username->bindParam(':id', $id);
    $stmt_get_old_username->execute();
    $old_username = $stmt_get_old_username->fetchColumn(); // get the old username

    // Check if username already exists for other users
    $check_query = "SELECT * FROM users WHERE username = :username AND id != :id";
    $stmt = $db->prepare($check_query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Display SweetAlert error for existing username
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

    // Update user
    $update_query = "UPDATE users SET fullname = :name, username = :username, level = :level, phone = :phone, email = :email, address = :address";
    
    // Only update password if provided
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $update_query .= ", password = :password";
    }
    
    $update_query .= " WHERE id = :id";
    
    $stmt = $db->prepare($update_query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':level', $level);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':address', $address);
    
    if (!empty($_POST['password'])) {
        $stmt->bindParam(':password', $password);
    }

    if ($stmt->execute()) {
        // Update the email in the boarders table based on the old username
        $update_boarders_query = "UPDATE boarders SET email = :username WHERE email = :old_username";
        $stmt_boarders = $db->prepare($update_boarders_query);
        $stmt_boarders->bindParam(':username', $username);
        $stmt_boarders->bindParam(':old_username', $old_username); // Use the old username here
        $stmt_boarders->execute();

        // Get the current user's level
        $current_user_level = $_SESSION['level']; // Assuming the user level is stored in the session
        session_regenerate_id(true);
        // Redirect based on user level
        if ($current_user_level == 2) {
            // Redirect to index.php if the logged-in user level is 2
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
                        text: "User updated successfully!",
                        icon: "success"
                    }).then(function() {
                         window.location.href = "../index.php";
                    });
                </script>
            </body>
            </html>';
        } else {
            // Redirect to users.php if the logged-in user level is 0 or 1
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
                        text: "User updated successfully!",
                        icon: "success"
                    }).then(function() {
                         window.location.href = "../users.php";
                    });
                </script>
            </body>
            </html>';
        }
        exit();
    } else {
        // Display SweetAlert error if the update fails
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
                    text: "Error updating user.",
                    icon: "error"
                }).then(function() {
                     window.location.href = "../users.php";
                });
            </script>
        </body>
        </html>';
        exit();
    }
}

?>
