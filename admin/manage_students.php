<?php
session_start();
// Database connection
include '../includes/config.php';

// Only allow access if the admin is logged in
if (!isset($_SESSION['employee_no'])) {
    echo "<script>alert('Please log in as an admin to access this page.'); window.location.href = 'admin_login.php';</script>";
    exit();
}

// Query to fetch students with course name
$query = "SELECT students.*, courses.course_name 
          FROM students
          LEFT JOIN courses ON students.course_id = courses.course_id";
$result = mysqli_query($conn, $query);

if (isset($_GET['delete_id'])) {
    $student_id = $_GET['delete_id'];

    // SQL query to delete the student record
    $delete_query = "DELETE FROM students WHERE student_id = $student_id";

    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Student deleted successfully');</script>";
        echo "<script>window.location.href='manage_students.php';</script>";
    } else {
        echo "<script>alert('Error deleting student');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Students</title>
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

        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: var(--box-shadow-btn);
            transition: var(--transition);
            background-color: var(--color-white);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1.5rem 2rem rgba(33, 51, 115, 0.3);
        }

        .card-title {
            color: var(--color-primary);
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
        <h2>Manage Students</h2>
        <p>Below is a list of all students.</p>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Names</th>
                    <th>Student No</th>
                    <th>Course</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                    <td>{$row['student_names']}</td>
                    <td>{$row['student_no']}</td>
                    <td>{$row['course_name']}</td> <!-- Displaying the course name here -->
                    <td>{$row['created_at']}</td>
                    <td>
                        <a href='manage_students.php?delete_id={$row['student_id']}' class='btn btn-danger btn-sm'>Delete</a>
                    </td>
                </tr>";
                    }
                } else {
                    echo "<tr>
                    <td colspan='5' class='text-center'>No students found.</td>
                </tr>";
                }

                // Close database connection
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>