<?php
include_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kumuha ng 'user_id' mula sa POST request
    $user_id = $_POST['id'];
    $status = 2; // Set default status to 1 (approve)

    // SQL query para i-update ang status ng boarder
    $stmt = $db->prepare("UPDATE boarders SET status = :status WHERE id = :id");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $user_id);

    // I-execute ang query
    if ($stmt->execute()) {
        // Pag-success, magpapakita ng SweetAlert
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
                    text: "The boarder has been disapproved.",
                    icon: "success"
                }).then(function() {
                     window.location.href = "../boarders.php";
                });
            </script>
        </body>
        </html>';
        exit;
    } else {
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
                    text: "There was an error updating the status.",
                    icon: "error"
                }).then(function() {
                     window.location.href = "../boarders.php";
                });
            </script>
        </body>
        </html>';
        exit;
    }
}
?>
