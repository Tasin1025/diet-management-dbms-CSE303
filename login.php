<?php
// Include database configuration
include 'db_config.php';

// Start session
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // 'user' or 'nutritionist'

    // Validate input fields
    if (empty($email) || empty($password) || empty($role)) {
        $error_message = "Please fill in all fields.";
    } else {
        // Determine the table and redirect page based on role
        if ($role === 'user') {
            $table = 'users';
            $redirect_page = 'user_dashboard.php';
        } elseif ($role === 'nutritionist') {
            $table = 'nutritionists';
            $redirect_page = 'nutritionist_dashboard.php';
        } else {
            $error_message = "Invalid role selected.";
        }

        if (!isset($error_message)) {
            // Check the database for matching credentials
            $sql = "SELECT * FROM $table WHERE email = ? AND password = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                // Login successful, set session variables
                $user = $result->fetch_assoc();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['role'] = $role;

                // Redirect to the respective dashboard
                header("Location: $redirect_page");
                exit();
            } else {
                $error_message = "Invalid email or password.";
            }

            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">
            <img src="logo.png" alt="Diet Planner Logo">
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="signup.php">Sign Up</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <!-- Login Form -->
    <section class="auth-section">
        <h1>Login</h1>

        <!-- Display Messages -->
        <?php if (!empty($error_message)) : ?>
        <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form action="login.php" method="post" class="auth-form">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="" disabled selected>Select Role</option>
                <option value="user">User</option>
                <option value="nutritionist">Nutritionist</option>
            </select>

            <button type="submit" class="auth-button">Login</button>
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </form>
    </section>

</body>

</html>