<?php
include_once 'functions/connection.php';
include_once 'functions/authentication.php';
include_once 'functions/views/get-data.php';
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - RENTWISE</title>
    <meta name="description" content="House Rental Management System">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/Change-Password-floating-Label.css">
    <link rel="stylesheet" href="assets/css/Navbar-Right-Links-icons.css">
    <link rel="stylesheet" href="assets/css/Profile-with-data-and-skills.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <div class="d-flex flex-column" id="content-wrapper" style="background: rgb(255,255,255);">
            <nav class="navbar navbar-expand-lg shadow py-3 border mb-4 navbar-light">
                <div class="container-fluid">
                    <span class="bs-icon-md bs-icon-rounded bs-icon-semi-white border rounded-circle border-primary-subtle shadow-lg d-flex justify-content-center align-items-center me-2 bs-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-house-heart-fill">
                            <path d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.707L8 2.207 1.354 8.853a.5.5 0 1 1-.708-.707L7.293 1.5Z"></path>
                            <path d="m14 9.293-6-6-6 6V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9.293Zm-6-.811c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.691 0-5.018Z"></path>
                        </svg>
                    </span>
                    <a class="navbar-brand d-flex align-items-center" href="/"><span>&nbsp;RENTWISE</span></a>
                    <button data-bs-toggle="collapse" data-bs-target="#navcol-1" class="navbar-toggler">
                        <span class="visually-hidden">Toggle navigation</span>
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navcol-1">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-th-list"></i>&nbsp;Dashboard</a></li>
                            <li class="nav-item"><a class="nav-link" href="boarders.php"><i class="fas fa-users"></i>&nbsp;Boarders</a></li>
                            <li class="nav-item"><a class="nav-link" href="rooms.php"><i class="fas fa-home"></i>&nbsp;Rooms</a></li>
                            <li class="nav-item"><a class="nav-link" href="rentals.php"><i class="fas fa-credit-card"></i>&nbsp;Payment Transaction</a></li>
                            <li class="nav-item"><a class="nav-link" href="reports.php"><i class="fas fa-chart-pie"></i>&nbsp;Reports</a></li>
                            <li class="nav-item"><a class="nav-link" href="request.php"><i class="fas fa-user-shield"></i>&nbsp;Maintenance Request</a></li>
                            <li class="nav-item"><a class="nav-link" href="users.php"><i class="fas fa-users"></i>&nbsp;Users</a></li>
                            <li class="nav-item"><a class="nav-link" href="account.php"><i class="fas fa-user-shield"></i>&nbsp;My Account</a></li>
                        </ul>
                        <a class="btn btn-light shadow" href="functions/logout.php">LOGOUT</a>
                    </div>
                </div>
            </nav>

            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Maintenance Request</h3>
                        <button class="btn btn-primary btn-icon-split" type="button" data-bs-target="#add" data-bs-toggle="modal"></button>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Maintenance Requests Lists</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable-1" role="grid">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Boarders</th>
                                            <th>Room</th>
                                            <th>Request</th>
                                            <th>Status</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include_once 'functions/connection.php';

                                        $sql = '
                                            SELECT mr.*, b.fullname 
                                            FROM maintenance_request mr
                                            JOIN boarders b ON mr.boarder_id = b.id
                                        ';

                                        $stmt = $db->prepare($sql);
                                        $stmt->execute();
                                        $results = $stmt->fetchAll();

                                        foreach ($results as $row) {
                                            // Convert status number to readable label
                                            switch ($row['status']) {
                                                case 0:
                                                    $statusLabel = 'Pending';
                                                    $statusClass = 'bg-secondary';
                                                    break;
                                                case 1:
                                                    $statusLabel = 'Confirmed';
                                                    $statusClass = 'bg-primary';
                                                    break;
                                                case 2:
                                                    $statusLabel = 'Completed';
                                                    $statusClass = 'bg-success';
                                                    break;
                                                default:
                                                    $statusLabel = 'Unknown';
                                            }
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['fullname']) ?></td>
                                                <td><?= htmlspecialchars('Room #' . $row['room']) ?></td>
                                                <td><?= htmlspecialchars($row['requests']) ?></td>
                                                <td>
                                                    <!-- Display the status badge with the corresponding color -->
                                                    <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($statusLabel) ?></span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#statusModal" data-id="<?= $row['id'] ?>" data-status="<?= $row['status'] ?>">Change Status</button>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Changing Status -->
            <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="statusModalLabel">Change Maintenance Request Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="statusForm">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Select Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="0">Pending</option>
                                        <option value="1">Confirmed</option>
                                        <option value="2">Completed</option>
                                    </select>
                                </div>
                                <input type="hidden" id="requestId" name="request_id">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" form="statusForm" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/jszip.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/buttons.print.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/sweetalert.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
        $(document).ready(function() {

            $('#dataTable').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true
            });
        });
        // Show modal with current request ID and status
        $('#statusModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var requestId = button.data('id');
            var status = button.data('status');

            var modal = $(this);
            modal.find('#requestId').val(requestId);
            modal.find('#status').val(status);
        });

        // Handle form submission for status update
        $('#statusForm').on('submit', function(event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: 'functions/update-status.php', // Make sure to create this PHP file to handle the update
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response == 'success') {
                        $('#statusModal').modal('hide');
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Error updating status');
                    }
                }
            });
        });
    </script>

</body>

</html>