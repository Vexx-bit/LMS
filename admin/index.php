<?php
session_start();
include 'includes/config.php';

//  Redirect to login if not logged in
if (!isset($_SESSION['employee_no'])) {
    echo "<script>alert('Please log in first.'); window.location.href = 'admin_login.php';</script>";
    exit();
}

$adminNo = $_SESSION['employee_no'];

// Retrieve admin data from the database
$sql = "SELECT * FROM admins WHERE employee_no = '$adminNo'";
$result = mysqli_query($conn, $sql);

$adminName = "";
if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $adminName = $row['admin_fullname'];
}

// Fetch total counts from the database
$student_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM students"))['total'];
$unit_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM units"))['total'];
$course_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM courses"))['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zetech University - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css">
    <style>
        /* Root Variables */
        :root {
            --color-primary: #213373;
            --color-secondary: #1B85FB;
            --color-white: #fff;
            --color-light: #D3D3D3;
            --color-tab: #ED1E24;
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
        <h2 class="mb-4">Welcome, <?php echo strtok($adminName, ' '); ?></h2>

        <!-- Cards for quick access -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card p-3">
                    <h5 class="card-title">Total Students</h5>
                    <p class="card-text">Total: <?php echo $student_count; ?></p>
                    <a href="manage_students.php" class="btn btn-primary">View Details</a>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card p-3">
                    <h5 class="card-title">Units Offered</h5>
                    <p class="card-text">Total: <?php echo $unit_count; ?></p>
                    <a href="manage_units.php" class="btn btn-primary">Manage Units</a>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card p-3">
                    <h5 class="card-title">Available Courses</h5>
                    <p class="card-text">Total: <?php echo $course_count; ?></p>
                    <a href="view_courses.php" class="btn btn-primary">View Courses</a>
                </div>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card p-3">
                    <h5 class="card-title">Recent Student Registrations</h5>
                    <p class="card-text">List of the latest registered students...</p>
                    <a href="reports.php" class="btn btn-secondary">View All</a>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card p-3">
                    <h5 class="card-title">Course Statistics</h5>
                    <p class="card-text">Overview of course enrollments...</p>
                    <a href="reports.php" class="btn btn-secondary">View Stats</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php mysqli_close($conn); ?>