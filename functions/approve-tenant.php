<?php
include_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kumuha ng 'user_id' at 'room' mula sa POST request
    $user_id = $_POST['id'];
    $room = $_POST['room'];
    $status = 1; // Set default status to 1 (approve)

    // Query para i-check kung available pa ang room
    $stmt = $db->prepare("SELECT is_available FROM rooms WHERE id = :room");
    $stmt->bindParam(':room', $room);
    $stmt->execute();
    $roomData = $stmt->fetch(PDO::FETCH_ASSOC);

    // I-check kung available ang room
    if ($roomData && $roomData['is_available'] == 0) {
        // Room is available, update the status
        $updateStmt = $db->prepare("UPDATE boarders SET status = :status WHERE id = :id");
        $updateStmt->bindParam(':status', $status);
        $updateStmt->bindParam(':id', $user_id);

        if ($updateStmt->execute()) {
            // I-update ang rooms table para gawing unavailable
            $updateRoomStmt = $db->prepare("UPDATE rooms SET is_available = 1 WHERE id = :room");
            $updateRoomStmt->bindParam(':room', $room);
            $updateRoomStmt->execute();

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
                        text: "The boarder has been approved.",
                        icon: "success"
                    }).then(function() {
                        window.location.href = "../boarders.php";
                    });
                </script>
            </body>
            </html>';
            exit;
        } else {
            // Error habang nag-uupdate ng status
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
    } else {
        // Kung hindi available ang room
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <script src="../assets/js/sweetalert.min.js"></script>
        </head>
        <body>
            <script>
                swal({
                    title: "Room Not Available!",
                    text: "This room is no longer available.",
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
