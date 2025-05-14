<?php
session_start();
include 'includes/config.php';

// Check if the student is logged in
if (!isset($_SESSION['student_no'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zetech University - Unit Registration</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/logout.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="sticky-navbar">
        <div class="container-fluid">
            <img src="assets/images/logo.png" width="60px" height="60px">
            <button class="btn btn-link text-white" id="sidebarToggle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" width="30px" height="30px" stroke="currentColor" class="sidebar-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>

            </button>
            <span class="navbar-brand">Zetech University</span>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar collapsed" id="sidebar">
        <ul class="sidebar-links">
            <a class="text-decoration-none text-light" href="index.php">
                <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" width="30px" height="30px" stroke="currentColor" class="sidebar-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span class="sidebar-text">Dashboard</span>
                </li>
            </a>
            <a class="text-decoration-none text-light" href="units.php">
                <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" width="30px" height="30px" stroke="currentColor" class="sidebar-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <span class="sidebar-text">Units</span>
                </li>
            </a>
            <a class="text-decoration-none text-light" href="timetable.php">
                <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" width="30px" height="30px" stroke="currentColor" class="sidebar-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                    <span class="sidebar-text">Timetable</span>
                </li>
            </a>
            <a class="text-decoration-none text-light" href="profile.php">
                <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" width="30px" height="30px" stroke="currentColor" class="sidebar-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg> <span class="sidebar-text">Profile</span></li>
            </a>
            <a class="text-decoration-none text-light active-link" href="logout.php">
                <li><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" width="30px" height="30px" stroke="currentColor" class="sidebar-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" />
                    </svg>
                    <span class="sidebar-text">Logout</span>
                </li>
            </a>
        </ul>
    </div>


    <!-- Main Content -->
    <section class="main-content">
        <div class="container logout-section">
            <h2>Logout</h2>
            <p>Are you sure you want to log out?</p>
            <div class="logout-actions">
                <a href="logout_now.php" class="btn confirm-logout">Yes, Logout</a>
                <a href="" class="btn cancel-logout">Cancel</a>
            </div>
        </div>

    </section>

    <!-- JavaScript for Sidebar Functionality -->
    <script text="javascript" src="js/script.js"></script>
</body>

</html>