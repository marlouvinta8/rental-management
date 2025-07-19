<?php
session_start();
include_once 'functions/connection.php';
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>RENTWISE - House Rental Management System</title>
    <meta name="description" content="House Rental Management System">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/Change-Password-floating-Label.css">
    <link rel="stylesheet" href="assets/css/Navbar-Right-Links-icons.css">
    <link rel="stylesheet" href="assets/css/Profile-with-data-and-skills.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --dark-color: #212529;
            --light-color: #f8f9fa;
        }

        body {
            font-family: 'Nunito', sans-serif;
            overflow-x: hidden;
        }

        .navbar {
            position: relative;
            z-index: 1050;
            /* Makes navbar stack above hero section */
        }

        .collapse.navbar-collapse {
            overflow: visible !important;
            /* Allows dropdown to overflow properly */
        }

        .dropdown-menu {
            z-index: 2000;
            /* Forces dropdown to appear above hero section */
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 600;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: var(--primary-color) !important;
            font-weight: 700;
        }

        section {
            padding: 100px 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .section-title p {
            font-size: 1.1rem;
            color: var(--secondary-color);
        }

        /* Home Section */
        #home {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('assets/img/bg.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            animation: fadeInUp 1s ease 0.2s;
        }

        .btn-hero {
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            animation: fadeInUp 1s ease 0.4s;
        }

        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* About Section */
        #about {
            background-color: var(--light-color);
        }

        .about-content {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .about-image {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .about-image:hover {
            transform: scale(1.02);
        }

        /* Rooms Section */
        #rooms {
            background-color: white;
        }

        .room-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .room-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .room-image {
            height: 250px;
            object-fit: cover;
        }

        .room-details {
            padding: 20px;
        }

        .room-details h5 {
            font-weight: 700;
            margin-bottom: 15px;
        }

        .room-features {
            margin-bottom: 20px;
        }

        .room-features i {
            color: var(--primary-color);
            margin-right: 5px;
        }

        /* Contact Section */
        #contacts {
            background-color: var(--light-color);
        }

        .contact-info,
        #contactForm {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .contact-info:hover,
        #contactForm:hover {
            transform: translateY(-5px);
        }

        .contact-info i {
            font-size: 24px;
            margin-right: 10px;
            color: var(--primary-color);
        }

        #contactForm .form-control {
            background: white;
            border: 1px solid #dee2e6;
            color: var(--dark-color);
            padding: 12px 15px;
        }

        #contactForm .form-control:focus {
            background: white;
            border-color: var(--primary-color);
            color: var(--dark-color);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        #contactForm .form-control::placeholder {
            color: var(--secondary-color);
        }

        #contactForm label {
            color: var(--dark-color);
            font-weight: 500;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            section {
                padding: 60px 0;
            }

            .section-title h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <div class="d-flex flex-column" id="content-wrapper">
            <nav class="navbar navbar-expand-lg shadow py-3 border navbar-light">
                <div class="container-fluid">
                    <span class="bs-icon-md bs-icon-rounded bs-icon-semi-white border rounded-circle border-primary-subtle shadow-lg d-flex justify-content-center align-items-center me-2 bs-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-house-heart-fill">
                            <path d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.707L8 2.207 1.354 8.853a.5.5 0 1 1-.708-.707L7.293 1.5Z"></path>
                            <path d="m14 9.293-6-6-6 6V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9.293Zm-6-.811c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.691 0-5.018Z"></path>
                        </svg>
                    </span>
                    <a class="navbar-brand d-flex align-items-center" href="#home"><span>&nbsp;RENTWISE</span></a>
                    <button data-bs-toggle="collapse" data-bs-target="#navcol-1" class="navbar-toggler">
                        <span class="visually-hidden">Toggle navigation</span>
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navcol-1">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                            <li class="nav-item"><a class="nav-link" href="#rooms">Available Rooms</a></li>
                            <li class="nav-item"><a class="nav-link" href="#contacts">Contact Us</a></li>
                            <?php
                            if (isset($_SESSION['username'])):

                                // Get the session username
                                $username = $_SESSION['username'];

                                // Query to fetch the status from the 'boarders' table where email matches the session username
                                $query = "SELECT status FROM boarders WHERE email = :username LIMIT 1";
                                $stmt = $db->prepare($query);
                                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                // Check if the result is found and the status is available
                                if ($result) {
                                    $status = $result['status'];
                                } else {
                                    $status = null; // Handle the case if no user found
                                }
                            ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Hi, <?= htmlspecialchars($username) ?>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                        <?php if ($status === 0 || $status === 2): ?>
                                            <!-- Display this if status is 0 -->
                                            <li><a class="dropdown-item" href="rental-request.php">View Rental Request</a></li>
                                        <?php elseif ($status === 1): ?>
                                            <!-- Display this if status is 1 -->
                                            <li><a class="dropdown-item" href="payment-transaction.php">View Payment Transaction</a></li>
                                            <li><a class="dropdown-item" href="maintenance-request.php">View Maintenance Requests</a></li>
                                            <li><a class="dropdown-item" href="tenant-reports.php">Reports</a></li>
                                        <?php endif; ?>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="manage-account.php">Manage Account</a></li>
                                        <li><a class="dropdown-item text-danger" href="functions/logout.php">Logout</a></li>
                                    </ul>
                                </li>
                            <?php
                            else:
                            ?>
                                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                            <?php endif; ?>


                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Home Section -->
            <section id="home">
                <div class="container">
                    <div class="hero-content">
                        <h1>Welcome to RENTWISE</h1>
                        <p class="lead">Find your perfect house room with our easy-to-use rental management system.</p>
                        <a href="#rooms" class="btn btn-primary btn-hero">View Available Rooms</a>
                    </div>
                </div>
            </section>

            <!-- About Us Section -->
            <section id="about">
                <div class="container">
                    <div class="section-title">
                        <h2>About Us</h2>
                        <p>Learn more about our house rental management system</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="about-content">
                                <h3 class="mb-4">Why Choose RENTWISE?</h3>
                                <p class="lead">RENTWISE is a modern house rental management system designed to make finding and managing rental spaces easier for both tenants and landlords.</p>
                                <p>Our platform provides:</p>
                                <ul class="list-unstyled">
                                    <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> Easy room browsing and booking</li>
                                    <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> Secure payment processing</li>
                                    <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> Real-time availability updates</li>
                                    <li class="mb-3"><i class="fas fa-check-circle text-primary me-2"></i> 24/7 customer support</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <img src="assets/img/bg2.jpg" alt="About RENTWISE" class="img-fluid about-image">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Available Rooms Section -->
            <section id="rooms">
                <div class="container">
                    <div class="section-title">
                        <h2>Available Rooms</h2>
                        <p>Find your perfect room today</p>
                    </div>
                    <div class="row">
                        <?php
                        $query = "SELECT r.*, 
                        COUNT(b.id) AS occupied, 
                        GROUP_CONCAT(ri.image_path) AS images 
                    FROM rooms r 
                    LEFT JOIN boarders b ON r.id = b.room 
                    LEFT JOIN room_images ri ON r.id = ri.room_id 
                    WHERE r.is_available = 0 
                    GROUP BY r.id 
                    ORDER BY r.rent ASC";

                        $stmt = $db->prepare($query);
                        $stmt->execute();
                        $results = $stmt->fetchAll();

                        if (empty($results)) {
                            echo '<div class="col-12 text-center"><p class="text-muted fs-5">No available rooms as of today.</p></div>';
                        } else {
                            foreach ($results as $room) {
                                $available = $room['pax'] - $room['occupied'];
                                $images = !empty($room['images']) ? explode(',', $room['images']) : [];
                        ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card room-card">
                                        <div id="carousel<?php echo $room['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <?php
                                                if (!empty($images)) {
                                                    foreach ($images as $index => $image) {
                                                        $active = $index === 0 ? 'active' : '';
                                                        $image_path = trim($image);
                                                ?>
                                                        <div class="carousel-item <?php echo $active; ?>">
                                                            <img src="<?php echo 'functions/' . $image_path; ?>" class="d-block w-100 room-image" alt="Room Image">
                                                        </div>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="carousel-item active">
                                                        <img src="assets/img/rooms/default.jpg" class="d-block w-100 room-image" alt="Default Room Image">
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <?php if (!empty($images) && count($images) > 1) { ?>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $room['id']; ?>" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $room['id']; ?>" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            <?php } ?>
                                        </div>
                                        <div class="room-details">
                                            <h5>Room <?php echo $room['id']; ?></h5>
                                            <div class="room-features">
                                                <p><i class="fas fa-users"></i> Capacity: <?php echo $room['pax']; ?> persons</p>
                                                <p><i class="fas fa-peso-sign"></i> Monthly Rent: ₱<?php echo number_format($room['rent'], 2); ?></p>
                                            </div>
                                            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="<?php echo isset($_SESSION['username']) ? '#rentModal' . $room['id'] : '#loginModal'; ?>">
                                                Rent This Room
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Rent Modal -->
                                <div class="modal fade" id="rentModal<?php echo $room['id']; ?>" tabindex="-1" aria-labelledby="rentModalLabel<?php echo $room['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Rent Room <?php echo $room['id']; ?></h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="functions/rent-room.php" method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3">
                                                                    <input class="form-control" type="text" placeholder="Fullname" name="fullname" required>
                                                                    <label class="form-label">Fullname</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3">
                                                                    <input class="form-control" type="text" placeholder="Email Address" name="email"
                                                                        value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" readonly required>
                                                                    <label class="form-label">Username</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3">
                                                                    <input class="form-control" type="text" placeholder="Phone" name="phone" minlength="11" maxlength="11" required>
                                                                    <label class="form-label">Phone</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating">
                                                                    <select class="form-select" name="sex" required>
                                                                        <option value="Male">Male</option>
                                                                        <option value="Female">Female</option>
                                                                    </select>
                                                                    <label class="form-label">Sex</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <input class="form-control" type="text" placeholder="Address" name="address" required>
                                                            <label class="form-label">Address</label>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3">
                                                                    <input class="form-control" type="date" name="start_date" required>
                                                                    <label class="form-label">Start Date</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3">
                                                                    <input class="form-control" type="date" name="end_date" required>
                                                                    <label class="form-label">End Date</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="mb-3 mt-3">
                                                                    <label class="form-label">Profile Picture</label>
                                                                    <input class="form-control" type="file" accept="image/*" name="profile" required>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="mb-3 mt-3">
                                                                    <label class="form-label">Proof of Identity</label>
                                                                    <input class="form-control" type="file" accept="image/*" name="proof" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit Rental Request</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </section>


            <!-- Contact Us Section -->
            <section id="contacts">
                <div class="container">
                    <div class="section-title">
                        <h2>Contact Us</h2>
                        <p>Have questions? We're here to help!</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-info">
                                <div>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>123 Purok 1 Bugbugan Street</span>
                                </div>
                                <div>
                                    <i class="fas fa-phone"></i>
                                    <span>+1 234 567 890</span>
                                </div>
                                <div>
                                    <i class="fas fa-envelope"></i>
                                    <span>info@rentwise.com</span>
                                </div>
                                <div>
                                    <i class="fas fa-clock"></i>
                                    <span>Monday - Friday: 9:00 AM - 6:00 PM</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form id="contactForm">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your message" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Message</button>
                                <div id="formFeedback" class="mt-3"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Login Modal -->
            <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Please login first to rent a room.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="login.php" class="btn btn-primary">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Update active nav link on scroll
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('.nav-link');

            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop - 100) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });

        // Contact form submission
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const feedbackDiv = document.getElementById('formFeedback');

            fetch('functions/contact.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        feedbackDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                        document.getElementById('contactForm').reset();
                    } else {
                        feedbackDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                    }

                    // Remove feedback after 5 seconds
                    setTimeout(() => {
                        feedbackDiv.innerHTML = '';
                    }, 5000);
                })
                .catch(error => {
                    feedbackDiv.innerHTML = '<div class="alert alert-danger">Something went wrong. Please try again later.</div>';
                    setTimeout(() => {
                        feedbackDiv.innerHTML = '';
                    }, 5000);
                });
        });
    </script>
</body>

</html>