<?php
include_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and get data
    $room_id = $_POST['room_id'];
    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $sex = $_POST['sex'];
    $address = trim($_POST['address']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $email = $_POST['email'];
    $type = 'regular';

    // Check if email already exists
    $checkSql = "SELECT * FROM boarders WHERE email = :email AND status = 1";
    $checkStmt = $db->prepare($checkSql);
    $checkStmt->bindParam(':email', $email);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        // Redirect with error if email exists
        header('Location: ../index.php?type=error&message=The username "' . urlencode($email) . '" has already been used for a different rental. Please create a new account with a different username.');
        exit;
    }
    // File handling
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle Profile Picture
    $profileName = basename($_FILES['profile']['name']);
    $profileTmp = $_FILES['profile']['tmp_name'];
    $profilePath = $uploadDir . uniqid('profile_') . '_' . $profileName;
    move_uploaded_file($profileTmp, $profilePath);

    // Handle Proof of Identity
    $proofName = basename($_FILES['proof']['name']);
    $proofTmp = $_FILES['proof']['tmp_name'];
    $proofPath = $uploadDir . uniqid('proof_') . '_' . $proofName;
    move_uploaded_file($proofTmp, $proofPath);

    try {
        $stmt = $db->prepare("INSERT INTO boarders 
            (fullname, phone, sex, address, room, type, start_date, end_date, profile_picture, proof_of_identity, email) 
            VALUES (:fullname, :phone, :sex, :address, :room, :type, :start_date, :end_date, :profile_picture, :proof_of_identity, :email)");

        $stmt->execute([
            ':fullname' => $fullname,
            ':phone' => $phone,
            ':sex' => $sex,
            ':address' => $address,
            ':room' => $room_id,
            ':type' => $type,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':profile_picture' => $profilePath,
            ':proof_of_identity' => $proofPath,
            ':email' => $email
        ]);

        // Show SweetAlert then redirect
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
                    text: "The rent request has been submitted.",
                    icon: "success"
                }).then(function() {
                    window.location.href = "../index.php";
                });
            </script>
        </body>
        </html>';
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
