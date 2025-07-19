<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: ./dashboard.php');
}
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register - RENTWISE</title>
    <meta name="description" content="House Rental Management System">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/Change-Password-floating-Label.css">
    <link rel="stylesheet" href="assets/css/Navbar-Right-Links-icons.css">
    <link rel="stylesheet" href="assets/css/Profile-with-data-and-skills.css">
</head>

<body>
    <div id="wrapper">
        <div class="d-flex flex-column" id="content-wrapper" style="background: rgb(255,255,255);">
            <nav class="navbar navbar-expand-lg shadow py-3 border mb-4 navbar-light">
                <div class="container-fluid"><span class="bs-icon-md bs-icon-rounded bs-icon-semi-white border rounded-circle border-primary-subtle shadow-lg d-flex justify-content-center align-items-center me-2 bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-house-heart-fill">
                            <path d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.707L8 2.207 1.354 8.853a.5.5 0 1 1-.708-.707L7.293 1.5Z"></path>
                            <path d="m14 9.293-6-6-6 6V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9.293Zm-6-.811c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.691 0-5.018Z"></path>
                        </svg></span><a class="navbar-brand d-flex align-items-center" href="/"><span>&nbsp;RENTWISE</span></a><button data-bs-toggle="collapse" data-bs-target="#navcol-1" class="navbar-toggler"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navcol-1"></div>
                </div>
            </nav>
            <section class="position-relative py-4 py-xl-5">
                <div class="container">
                    <div class="row mb-5">
                        <div class="col-md-8 col-xl-6 text-center mx-auto">
                            <h2>Register</h2>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6 col-xl-4">
                            <div class="card mb-5">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <form action="functions/register.php" method="post">
                                        <div class="mb-3 w-100">
                                            <label class="form-label">Full Name</label>
                                            <input class="form-control" type="text" name="fullname" required>
                                        </div>
                                        <div class="mb-3 w-100">
                                            <label class="form-label">Username</label>
                                            <input class="form-control" type="text" name="username" required>
                                        </div>
                                        <div class="mb-3 w-100">
                                            <label class="form-label">Password</label>
                                            <input class="form-control" type="password" name="password" required>
                                        </div>
                                        <div class="mb-3 w-100">
                                            <label class="form-label">Address</label>
                                            <input class="form-control" type="text" name="address" required>
                                        </div>
                                        <div class="mb-3 w-100">
                                            <label class="form-label">Email</label>
                                            <input class="form-control" type="email" name="email" required>
                                        </div>
                                        <div class="mb-3 w-100">
                                            <label class="form-label">Phone Number</label>
                                            <input class="form-control" type="text" name="phone" required>
                                        </div>
                                        <div class="mb-3 w-100 text-center">
                                            <button class="btn btn-primary w-100" type="submit">Register</button>
                                        </div>
                                        <div class="mb-3 w-100 text-center">
                                            <a href="login.php" class="btn btn-secondary w-100">Back to Login</a>
                                        </div>
                                        <p class="text-muted text-center">House Reservation Management System</p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>