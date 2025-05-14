<?php
session_start();
// Include database configuration
include '../includes/config.php';

// Only allow access if the admin is logged in
if (!isset($_SESSION['employee_no'])) {
    echo "<script>alert('Please log in as an admin to access this page.'); window.location.href = 'admin_login.php';</script>";
    exit();
}

// Fetch courses with their IDs and names for the dropdown
$courses_query = "SELECT course_id, course_name FROM courses";
$courses_result = mysqli_query($conn, $courses_query);

// Fetch units with an optional course filter
$course_filter = isset($_GET['course']) ? $_GET['course'] : '';
$units_query = "SELECT units.*, courses.course_name 
                FROM units 
                LEFT JOIN courses ON units.course_id = courses.course_id"
    . ($course_filter ? " WHERE units.course_id = '$course_filter'" : "");
$units_result = mysqli_query($conn, $units_query);

// Handle unit addition form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['unit_code'], $_POST['unit_name'], $_POST['unit_lec'], $_POST['course_id'])) {
    // Retrieve form data
    $unit_code = $_POST['unit_code'];
    $unit_name = $_POST['unit_name'];
    $unit_lec = $_POST['unit_lec'];
    $course_id = $_POST['course_id'];

    // Insert the new unit into the units table
    $insert_query = "INSERT INTO units (unit_code, unit_name, unit_lec, course_id) VALUES ('$unit_code', '$unit_name', '$unit_lec', '$course_id')";

    if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Unit added successfully!');</script>";
        echo "<script>window.location.href = 'manage_units.php';</script>";
    } else {
        echo "<script>alert('Error adding unit: " . mysqli_error($conn) . "');</script>";
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete query
    $delete_query = "DELETE FROM `units` WHERE unit_id = '$delete_id'";

    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Unit deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting unit: " . mysqli_error($conn) . "');</script>";
    }

    // Redirect back to the courses page after deletion
    echo "<script>window.location.href = 'manage_units.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Units</title>
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
        <h2>Manage Units</h2>
        <p>Below is a list of units available for students to register.</p>

        <!-- Course Filter Dropdown -->
        <form method="GET" class="mb-3">
            <label for="courseFilter" class="form-label">Filter by Course:</label>
            <select id="courseFilter" name="course" class="form-select" onchange="this.form.submit()">
                <option value="">All Courses</option>
                <?php while ($course = mysqli_fetch_assoc($courses_result)) { ?>
                    <option value="<?php echo $course['course_id']; ?>" <?php echo ($course_filter == $course['course_id']) ? 'selected' : ''; ?>>
                        <?php echo $course['course_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </form>

        <!-- Add Unit Modal -->
        <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#addUnitModal">Add New Unit</button>


        <!-- Units Table -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Unit Code</th>
                    <th>Unit Name</th>
                    <th>Lecturer</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($units_result) > 0) {
                    $counter = 1; // Start counting from 1
                    while ($unit = mysqli_fetch_assoc($units_result)) { ?>
                        <tr>
                            <?php echo '<td>' . $counter++ . '</td>'; ?>
                            <td><?php echo $unit['unit_code']; ?></td>
                            <td><?php echo $unit['unit_name']; ?></td>
                            <td><?php echo $unit['unit_lec']; ?></td>
                            <td><?php echo $unit['course_name']; ?></td>
                            <td class="d-flex justify-content-between">
                                <a href="edit_units.php?edit_id=<?php echo $unit['unit_id']; ?>" class="btn btn-primary btn-sm">Edit</button>
                                    <a href="manage_units.php?delete_id=<?php echo $unit['unit_id']; ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this unit?');">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="6" class="text-center">No units found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>


        <!-- Modal Structure -->
        <div class="modal fade" id="addUnitModal" tabindex="-1" aria-labelledby="addUnitModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUnitModalLabel">Add New Unit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="unitCode" class="form-label">Unit Code</label>
                                <input type="text" class="form-control" id="unitCode" name="unit_code" required>
                            </div>
                            <div class="mb-3">
                                <label for="unitName" class="form-label">Unit Name</label>
                                <input type="text" class="form-control" id="unitName" name="unit_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="unitLec" class="form-label">Lecturer</label>
                                <input type="text" class="form-control" id="unitLec" name="unit_lec" required>
                            </div>
                            <div class="mb-3">
                                <label for="unitCourse" class="form-label">Course</label>
                                <select id="unitCourse" name="course_id" class="form-select" required>
                                    <option value="">Select Course</option>
                                    <?php
                                    mysqli_data_seek($courses_result, 0);
                                    while ($course = mysqli_fetch_assoc($courses_result)) { ?>
                                        <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Unit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php mysqli_close($conn); ?>