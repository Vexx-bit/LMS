<?php
session_start();
include 'includes/config.php';

// Only allow access if the admin is logged in
if (!isset($_SESSION['employee_no'])) {
    echo "<script>alert('Please log in as an admin to access this page.'); window.location.href = 'admin_login.php';</script>";
    exit();
}

// Check if `course_id` is set in the query string
if (isset($_GET['edit_id'])) {
    $course_id = $_GET['edit_id'];

    // Fetch the course details
    $query = "SELECT * FROM `courses` WHERE course_id = '$course_id'";
    $result = mysqli_query($conn, $query);

    // Check if the course exists
    if ($result && mysqli_num_rows($result) > 0) {
        $course = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Course not found.'); window.location.href = 'view_courses.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'view_courses.php';</script>";
    exit();
}

// Handle form submission for updating the course
if (isset($_POST['update_course'])) {
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];
    $course_category = $_POST['course_category'];
    $course_level = $_POST['course_level'];
    $course_duration = $_POST['course_duration'];

    // Update query
    $update_query = "UPDATE `courses` SET 
        course_abbrv = '$course_code',
        course_name = '$course_name',
        course_category = '$course_category',
        course_level = '$course_level',
        course_duration = '$course_duration'
        WHERE course_id = '$course_id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Course updated successfully!'); window.location.href = 'view_courses.php';</script>";
    } else {
        echo "<script>alert('Error updating course: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course - Zetech University</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add custom styling here */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            max-width: 500px;
            width: 100%;
            padding: 2rem;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h3 class="text-center">Edit Course</h3>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="courseCode" class="form-label">Course Abbrv.</label>
                <input type="text" id="courseCode" name="course_code" class="form-control" required
                    value="<?php echo $course['course_abbrv']; ?>">
            </div>
            <div class="mb-3">
                <label for="courseName" class="form-label">Course Name</label>
                <input type="text" id="courseName" name="course_name" class="form-control" required
                    value="<?php echo $course['course_name']; ?>">
            </div>
            <div class="mb-3">
                <label for="courseCategory" class="form-label">Category</label>
                <select id="courseCategory" name="course_category" class="form-select" required>
                    <?php
                    $categories = [
                        'School Of ICT, Media & Engineering',
                        'School of Business & Economics',
                        'School of Education, Arts & Social Sciences',
                        'Technical and Vocational Education and Training',
                        'Centre For Professional Short Courses'
                    ];

                    foreach ($categories as $category) {
                        $selected = $course['course_category'] === $category ? 'selected' : '';
                        echo "<option value='$category' $selected>$category</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="courseLevel" class="form-label">Level</label>
                <select id="courseLevel" name="course_level" class="form-select" required>
                    <?php
                    $levels = ['Postgraduate', 'Undergraduate', 'Diploma', 'Certificate', 'Degree', 'Others'];

                    foreach ($levels as $level) {
                        $selected = $course['course_level'] === $level ? 'selected' : '';
                        echo "<option value='$level' $selected>$level</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="courseDuration" class="form-label">Duration</label>
                <input type="text" id="courseDuration" name="course_duration" class="form-control" required
                    value="<?php echo $course['course_duration']; ?>">
            </div>
            <div class="d-flex justify-content-between">
                <a href="view_courses.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" name="update_course" class="btn btn-primary">Update Course</button>
            </div>
        </form>
    </div>
</body>

</html>

<?php mysqli_close($conn); ?>