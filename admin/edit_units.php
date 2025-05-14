<?php
session_start();
include 'includes/config.php';

// Only allow access if the admin is logged in
if (!isset($_SESSION['employee_no'])) {
    echo "<script>alert('Please log in as an admin to access this page.'); window.location.href = 'admin_login.php';</script>";
    exit();
}

// Check if `unit_id` is set in the query string
if (isset($_GET['edit_id'])) {
    $unit_id = $_GET['edit_id'];

    // Fetch the unit details
    $unit_query = "SELECT * FROM `units` WHERE unit_id = '$unit_id'";
    $unit_result = mysqli_query($conn, $unit_query);

    // Check if the unit exists
    if ($unit_result && mysqli_num_rows($unit_result) > 0) {
        $unit = mysqli_fetch_assoc($unit_result);
    } else {
        echo "<script>alert('Unit not found.'); window.location.href = 'manage_units.php';</script>";
        exit();
    }

    // Fetch the courses for the dropdown
    $courses_query = "SELECT course_id, course_name FROM `courses`";
    $courses_result = mysqli_query($conn, $courses_query);
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'manage_units.php';</script>";
    exit();
}

// Handle form submission for updating the unit
if (isset($_POST['update_unit'])) {
    $unit_code = $_POST['unit_code'];
    $unit_name = $_POST['unit_name'];
    $unit_lec = $_POST['unit_lec'];
    $course_id = $_POST['course_id'];

    // Update query
    $update_query = "UPDATE `units` SET 
        unit_code = '$unit_code',
        unit_name = '$unit_name',
        unit_lec = '$unit_lec',
        course_id = '$course_id'
        WHERE unit_id = '$unit_id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Unit updated successfully!'); window.location.href = 'manage_units.php';</script>";
    } else {
        echo "<script>alert('Error updating unit: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Unit - Zetech University</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
        <h3 class="text-center">Edit Unit</h3>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="unitCode" class="form-label">Unit Code</label>
                <input type="text" id="unitCode" name="unit_code" class="form-control" required
                    value="<?php echo $unit['unit_code']; ?>">
            </div>
            <div class="mb-3">
                <label for="unitName" class="form-label">Unit Name</label>
                <input type="text" id="unitName" name="unit_name" class="form-control" required
                    value="<?php echo $unit['unit_name']; ?>">
            </div>
            <div class="mb-3">
                <label for="unitLec" class="form-label">Lecturer</label>
                <input type="text" id="unitLec" name="unit_lec" class="form-control" required
                    value="<?php echo $unit['unit_lec']; ?>">
            </div>
            <div class="mb-3">
                <label for="courseId" class="form-label">Course</label>
                <select id="courseId" name="course_id" class="form-select" required>
                    <?php
                    while ($course = mysqli_fetch_assoc($courses_result)) {
                        $selected = $unit['course_id'] == $course['course_id'] ? 'selected' : '';
                        echo "<option value='{$course['course_id']}' $selected>{$course['course_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <a href="manage_units.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" name="update_unit" class="btn btn-primary">Update Unit</button>
            </div>
        </form>
    </div>
</body>

</html>

<?php mysqli_close($conn); ?>