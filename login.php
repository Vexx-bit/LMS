<?php
session_start(); // Start the session

// Include database configuration
include 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $accountType = $_POST['accountType'];

    // Check if the account type is student or employee
    if ($accountType == 'student') {
        $query = "SELECT * FROM students WHERE student_no = '$username'";
    } elseif ($accountType == 'employee') {
        $query = "SELECT * FROM employees WHERE employee_no = '$username'";
    }

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the user exists
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Verify the password
        // if ($password == $row['password']) {     we wont use this 
        // Use password_verify() for secure password comparison because we have hashed passwords
        if (password_verify($password, $row['password'])) {
            // Redirect based on account type
            if ($row['account_type'] == 'student') {
                $_SESSION['student_no'] = $row['student_no']; // Store student_no in session
                echo "<script>alert('Logged in successfully')</script>";
                header("Location: index.php");
            } elseif ($row['account_type'] == 'employee') {
                $_SESSION['employee_no'] = $row['employee_no']; // Store employee_no in session
                echo "<script>alert('Logged in successfully')</script>";
                header("Location: admin/index.php");
            }
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid password. Please try again.')</script>";
        }
    } else {
        // Invalid username
        echo "<script>alert('Sorry, the username you entered is not valid. Kindly contact admin.')</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zetech University - Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --color-primary: #213373;
            /* Dark Blue */
            --color-secondary: #1B85FB;
            /* Bright Blue */
            --color-white: #fff;
            --color-light: #D3D3D3;
            --color-black: #000000;
            --box-shadow-btn: 0 1rem 2rem rgba(0, 0, 0, 0.175);
            --transition: all 400ms ease;
            --color-primary-rgba: rgba(33, 51, 115, 0.25);
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

        /* Card Styling */
        .card {
            border: none;
            border-radius: 0.5rem;
            background-color: var(--color-white);
            box-shadow: 0 0.5rem 1rem var(--color-primary-rgba);
            /* Primary color shadow */
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            /* Lift card on hover */
            box-shadow: 0 1.5rem 2rem rgba(33, 51, 115, 0.5);
            /* Darker shadow on hover */
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

        /* Button Styling */
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
            <!-- Add logo before the heading -->
            <div class="text-center mb-4">
                <img src="assets/images/logo.png" alt="Zetech University Logo" width="100">
            </div>
            <h3 class="text-center mb-4">Sign In</h3>
            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Student No/ Employee No" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                </div>

                <!-- Radio buttons for Student/Employee -->
                <div class="mb-3">
                    <label class="form-label">Account Type</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="accountType" id="student" value="student" checked>
                        <label class="form-check-label" for="student">Student</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="accountType" id="employee" value="employee">
                        <label class="form-check-label" for="employee">Employee</label>
                    </div>
                </div>

                <button type="submit" name="signin" class="btn btn-primary w-100">Sign In</button>
                <p class="text-center mt-3">Don't have an account? <a href="register.php">Register</a></p>
            </form>
        </div>
    </div>
</body>

</html>