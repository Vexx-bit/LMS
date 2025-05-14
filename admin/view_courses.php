<?php
session_start();
include 'includes/config.php';

// Only allow access if the admin is logged in
if (!isset($_SESSION['employee_no'])) {
    echo "<script>alert('Please log in as an admin to access this page.'); window.location.href = 'admin_login.php';</script>";
    exit();
}

// Fetch categories and levels
$categories = [
    'School Of ICT, Media & Engineering',
    'School of Business & Economics',
    'School of Education, Arts & Social Sciences',
    'Technical and Vocational Education and Training',
    'Centre For Professional Short Courses'
];
$levels = ['Postgraduate', 'Undergraduate', 'Diploma', 'Certificate', 'Degree', 'Others'];

// Course filtering
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$level_filter = isset($_GET['level']) ? $_GET['level'] : '';

// Fetch filtered courses
$query = "SELECT * FROM `courses` WHERE 1";
if ($category_filter) $query .= " AND course_category = '$category_filter'";
if ($level_filter) $query .= " AND course_level = '$level_filter'";
$courses_result = mysqli_query($conn, $query);

if (isset($_POST['add_course'])) {
    // Get the form data
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];
    $course_category = $_POST['course_category'];
    $course_level = $_POST['course_level'];
    $course_duration = $_POST['course_duration'];

    // Insert the new course into the courses table
    $insquery = "INSERT INTO `courses` (course_abbrv, course_name, course_category, course_level, course_duration) 
             VALUES ('$course_code', '$course_name', '$course_category', '$course_level', '$course_duration')";

    if (mysqli_query($conn, $insquery)) {
        echo "<script>alert('Course added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding course: " . mysqli_error($conn) . "');</script>";
    }



    // Redirect back to the courses page
    echo "<script>window.location.href = 'view_courses.php';</script>";
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete query
    $delete_query = "DELETE FROM `courses` WHERE course_id = '$delete_id'";

    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Course deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting course: " . mysqli_error($conn) . "');</script>";
    }

    // Redirect back to the courses page after deletion
    echo "<script>window.location.href = 'view_courses.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - View Courses</title>
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
        <h2>View Courses</h2>
        <p>Here is a list of courses offered at Zetech University.</p>

        <!-- Course Category and Level Filters -->
        <form method="GET" class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="categoryFilter" class="form-label">Filter by Category:</label>
                <select id="categoryFilter" name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?php echo $category; ?>" <?php echo ($category_filter === $category) ? 'selected' : ''; ?>>
                            <?php echo $category; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="levelFilter" class="form-label">Filter by Level:</label>
                <select id="levelFilter" name="level" class="form-select" onchange="this.form.submit()">
                    <option value="">All Levels</option>
                    <?php foreach ($levels as $level) { ?>
                        <option value="<?php echo $level; ?>" <?php echo ($level_filter === $level) ? 'selected' : ''; ?>>
                            <?php echo $level; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </form>

        <!-- Add Course Modal -->
        <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#addCourseModal">Add New Course</button>

        <!-- Courses Table -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Course Abbrv.</th>
                    <th>Course Name</th>
                    <th>Category</th>
                    <th>Level</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($courses_result) > 0) {
                    $counter = 1; // Start counting from 1
                    while ($course = mysqli_fetch_assoc($courses_result)) { ?>
                        <tr>
                            <?php echo '<td>' . $counter++ . '</td>'; ?>
                            <td><?php echo $course['course_abbrv']; ?></td>
                            <td><?php echo $course['course_name']; ?></td>
                            <td><?php echo $course['course_category']; ?></td>
                            <td><?php echo $course['course_level']; ?></td>
                            <td><?php echo $course['course_duration']; ?> Semesters</td>
                            <td class="d-flex justify-content-between">
                                <a href="edit_course.php?edit_id=<?php echo $course['course_id']; ?>" class="btn btn-primary btn-sm">Edit</button>
                                    <a href="view_courses.php?delete_id=<?php echo $course['course_id']; ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="7" class="text-center">No courses found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Modal Structure -->
        <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="view_courses.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="courseCode" class="form-label">Course Abbrv.</label>
                                <input type="text" id="courseCode" name="course_code" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="courseName" class="form-label">Course Name</label>
                                <input type="text" id="courseName" name="course_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="courseCategory" class="form-label">Category</label>
                                <select id="courseCategory" name="course_category" class="form-select" required>
                                    <?php foreach ($categories as $category) { ?>
                                        <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="courseLevel" class="form-label">Level</label>
                                <select id="courseLevel" name="course_level" class="form-select" required>
                                    <?php foreach ($levels as $level) { ?>
                                        <option value="<?php echo $level; ?>"><?php echo $level; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="courseDuration" class="form-label">Duration</label>
                                <input type="text" id="courseDuration" name="course_duration" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="add_course" class="btn btn-primary">Add Course</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });

        window.addEventListener('beforeunload', function() {
            localStorage.setItem('scrollPosition', window.scrollY);
        });

        // Restore scroll position
        window.addEventListener('load', function() {
            if (localStorage.getItem('scrollPosition') !== null) {
                window.scrollTo(0, localStorage.getItem('scrollPosition'));
            }
        });
    </script>
</body>

</html>

<?php mysqli_close($conn); ?>