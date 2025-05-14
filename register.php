<?php
// Include database configuration
include 'includes/config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {



    // Get form data
    $username = $_POST['username'];
    $names = $_POST['names'];
    $password = $_POST['password'];
    $confirm_password = $_POST['cpassword'];
    $account_type = $_POST['accountType']; // student or employee

    // Validate form data
    if (empty($username) || empty($names) || empty($password) || empty($confirm_password)) {
        echo "<script>alert('Please fill in all fields.')</script>";
    } elseif ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.')</script>";
    } else {
        // Check if username already exists in the respective table
        if ($account_type == 'student') {
            $check_query = "SELECT * FROM students WHERE student_no = '$username'";
        }

        // Execute the query to check if username exists
        $result = mysqli_query($conn, $check_query);

        // If the username exists, show an error
        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('This username is already registered. Please log in or use a different username.')</script>";
        } else {
            // If no duplicate, proceed with registration
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into the correct table based on account type
            if ($account_type == 'student') {
                $query = "INSERT INTO students (student_no, student_names, password, account_type) VALUES ('$username', '$names', '$hashed_password', '$account_type')";
            }

            // Execute the insert query
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Successfully Registered.'); 
                window.location.href = 'login.php';</script>";
            } else {
                echo "Error: " . mysqli_error($conn);
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
    <title>Zetech University - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --color-primary: #213373;
            --color-secondary: #1B85FB;
            --color-white: #fff;
            --color-light: #D3D3D3;
            --color-black: #000000;
            --box-shadow-btn: 0 1rem 2rem rgba(0, 0, 0, 0.175);
            --transition: all 400ms ease;
            --color-primary-rgba: rgba(33, 51, 115, 0.25);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--color-white);
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
            background-color: var(--color-white);
            box-shadow: 0 0.5rem 1rem var(--color-primary-rgba);
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1.5rem 2rem rgba(33, 51, 115, 0.5);
        }

        h3 {
            color: var(--color-primary);
        }

        p {
            color: var(--color-primary);
        }

        a {
            color: var(--color-secondary);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn-primary {
            background-color: var(--color-primary);
            border: none;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background-color: var(--color-secondary);
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
            <div class="text-center mb-4">
                <img src="assets/images/logo.png" alt="Zetech University Logo" width="100">
            </div>
            <h3 class="text-center mb-2">Create an Account</h3>
            <p class="text-center mb-4">To sign up, kindly fill the form below</p>
            <form method="POST">
                <div class="mb-3">
                    <label for="names" class="form-label">Full names</label>
                    <input type="text" class="form-control" id="names" name="names" placeholder="Full names">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Student No</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Student No">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                </div>
                <div class="mb-3">
                    <label for="cpassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm your password">
                </div>

                <!-- Radio buttons for Student/Employee -->
                <div class="mb-3">
                    <label class="form-label">Account Type</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="accountType" id="student" value="student" checked>
                        <label class="form-check-label" for="student">Student</label>
                    </div>
                    <!-- <div class="form-check">
                        <input class="form-check-input" type="radio" name="accountType" id="employee" value="employee">
                        <label class="form-check-label" for="employee">Employee</label>
                    </div> -->
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
                <p class="text-center mt-3">Already have an account? <a href="login.php">Log In</a></p>
            </form>
        </div>
    </div>
</body>

</html>