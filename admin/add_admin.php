<?php
session_start();
include 'includes/config.php';

// Only allow access if the admin is logged in
if (!isset($_SESSION['employee_no'])) {
    echo "<script>alert('Please log in as an admin to access this page.'); window.location.href = 'admin_login.php';</script>";
    exit();
}

// Handle form submission for adding a new admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_fullname'], $_POST['employee_no'], $_POST['password'], $_POST['confirm_password'])) {
    $admin_fullname = mysqli_real_escape_string($conn, $_POST['admin_fullname']);
    $employee_no = mysqli_real_escape_string($conn, $_POST['employee_no']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match. Please try again.";
    } else {
        // Check if employee number already exists
        $check_query = "SELECT * FROM `admins` WHERE employee_no = '$employee_no'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $error_message = "Employee Number already exists. Please use a different one.";
        } else {
            // Insert new admin into the database
            $insert_query = "INSERT INTO `admins` (admin_fullname, employee_no, password) 
                             VALUES ('$admin_fullname', '$employee_no', '$password')";

            if (mysqli_query($conn, $insert_query)) {
                echo "<script>alert('New admin added successfully!'); window.location.href = 'index.php';</script>";
            } else {
                $error_message = "Error adding admin: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Add Admin</title>
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
            --color-tab: #ED1E24;
            --box-shadow-btn: 0 1rem 2rem rgba(0, 0, 0, 0.175);
            --transition: all 400ms ease;
            --color-primary-rgba: rgba(33, 51, 115, 0.25);
            --small-font: 0.5rem;
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

        /* Content Area */
        .content {
            margin-left: 250px;
            padding: 2rem;
            background-color: var(--color-light);
            min-height: 100vh;
        }

        .form-container {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            background-color: var(--color-white);
            border-radius: 8px;
            box-shadow: var(--box-shadow-btn);
            text-align: center;
        }

        .form-container h2 {
            color: var(--color-primary);
            margin-bottom: 1rem;
        }

        .btn-primary {
            background-color: var(--color-secondary);
            border: none;
            width: 100%;
            padding: 0.75rem;
            border-radius: 5px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--color-tab);
            color: var(--color-white);
        }

        .form-text {
            font-size: 0.85rem;
            color: var(--color-tab);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container-fluid">
            <span class="navbar-brand">Admin Dashboard</span>
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
    <div class="content">
        <h2>Add New Admin</h2>

        <?php if (isset($error_message)) { ?>
            <p class="form-text"><?php echo $error_message; ?></p>
        <?php } ?>

        <form method="POST" action="add_admin.php">
            <div class="mb-3">
                <label for="adminFullname" class="form-label">Full Name</label>
                <input type="text" id="adminFullname" name="admin_fullname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="employeeNo" class="form-label">Employee Number</label>
                <input type="text" id="employeeNo" name="employee_no" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Admin</button>
        </form>
    </div>
</body>

</html>