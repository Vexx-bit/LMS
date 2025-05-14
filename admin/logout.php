<?php
session_start();
include '../includes/config.php';

// Handle logout confirmation and session destruction
if (isset($_POST['confirm_logout'])) {
    // Destroy the session and redirect to the login page or homepage
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: admin_login.php"); // Redirect to the login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Logout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css">
    <style>
        /* Root Variables */
        :root {
            --color-primary: #213373;
            --color-secondary: #1B85FB;
            --color-white: #fff;
            --color-light: #D3D3D3;
            --color-black: #000000;
            --box-shadow-btn: 0 1rem 2rem rgba(0, 0, 0, 0.175);
            --transition: all 400ms ease;
        }

        /* Global Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--color-white);
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Navbar Styling */
        .navbar {
            background-color: var(--color-primary);
            color: var(--color-white);
            height: 4rem;
            display: flex;
            align-items: center;
            padding: 0 1rem;
            margin-left: 250px;
        }

        .navbar .navbar-brand {
            font-size: 1.5rem;
            color: var(--color-white);
        }

        /* Sidebar Styling */
        .sidebar {
            background-color: var(--color-primary);
            color: var(--color-white);
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            transition: width 0.3s;
        }

        .sidebar a {
            color: var(--color-white);
            text-decoration: none;
            padding: 15px 20px;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: var(--color-secondary);
        }

        .sidebar i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .container {
            margin-left: 260px;
            background-color: var(--color-white);
            padding: 2rem;
            border-radius: 10px;
            margin-top: 5rem;
            box-shadow: var(--box-shadow-btn);
            /* max-width: 800px; */
            width: calc(100% - 280px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        /* Headings */
        h3 {
            color: var(--color-primary);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Button styles */
        button,
        a.btn {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--box-shadow-btn);
        }

        /* Confirm logout button */
        button.btn-danger {
            background-color: var(--color-tab);
            color: var(--color-black);
        }

        button.btn-danger:hover {
            background-color: #b31216;
            /* Darker red */
        }

        /* Cancel button */
        a.btn-secondary {
            background-color: var(--color-light);
            color: var(--color-primary);
            margin-left: 1rem;
            text-decoration: none;
        }

        a.btn-secondary:hover {
            background-color: var(--color-secondary);
            color: var(--color-white);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container-fluid">
            <span class="navbar-brand">Log Out</span>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <img src="assets/images/logo_name.png" height="70px" style="padding: 1rem;">
        <a href="index.php"><i class='bx bxs-dashboard'></i> Dashboard</a>
        <a href="manage_students.php"><i class="bx bx-user"></i> Manage Students</a>
        <a href="view_courses.php"><i class="bx bx-calendar"></i> View Courses</a>
        <a href="manage_units.php"><i class="bx bx-book"></i> Manage Units</a>
        <a href="reports.php"><i class="bx bx-bar-chart-alt"></i> Reports</a>
        <a href="add_admin.php"><i class='bx bxs-user-plus'></i> Add Admin</a>
        <a href="logout.php"><i class="bx bx-log-out"></i> Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="container mt-5">
        <h3>Are you sure you want to log out?</h3>
        <form method="POST" action="">
            <button type="submit" name="confirm_logout" class="btn btn-danger">Yes, Log Out</button>

        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php mysqli_close($conn); ?>