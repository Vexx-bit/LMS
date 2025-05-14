<?php
session_start();
include 'includes/config.php';

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['employee_no'], $_POST['password'])) {
    $employee_no = mysqli_real_escape_string($conn, $_POST['employee_no']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check credentials
    $query = "SELECT * FROM `admins` WHERE employee_no = '$employee_no' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        // Login successful, set session
        $_SESSION['employee_no'] = $employee_no;
        echo "<script>alert('Login successful!'); window.location.href = 'index.php';</script>";
    } else {
        // Login failed
        $error_message = "Invalid Employee Number or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Zetech University</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        /* Body Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--color-primary-rgba);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        /* Card Styling */
        .login-card {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            background-color: var(--color-white);
            border-radius: 10px;
            box-shadow: var(--box-shadow-btn);
            text-align: center;
        }

        .login-card h2 {
            color: var(--color-primary);
            margin-bottom: 1.5rem;
        }

        .form-control {
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: var(--color-secondary);
            border: none;
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            border-radius: 5px;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background-color: var(--color-tab);
            color: var(--color-white);
        }

        .form-text {
            font-size: 0.85rem;
            color: var(--color-tab);
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-card">
        <h2>Admin Login</h2>

        <?php if (isset($error_message)) { ?>
            <p class="form-text"><?php echo $error_message; ?></p>
        <?php } ?>

        <form method="POST" action="admin_login.php">
            <div class="mb-3">
                <label for="employeeNo" class="form-label">Employee Number</label>
                <input type="text" id="employeeNo" name="employee_no" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>

</html>

<?php mysqli_close($conn); ?>