<?php
// Include database configuration
include 'db_config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role']; // 'user' or 'nutritionist'

    // Validate input fields
    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
        $error_message = "Please fill in all fields.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Determine the table based on role
        $table = $role === 'user' ? 'users' : 'nutritionists';

        // Insert data into the database
        $sql = "INSERT INTO $table (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $full_name, $email, $password);

        if ($stmt->execute()) {
            $success_message = "Registration successful for $role! You can now <a href='login.php'>Login</a>.";
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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

    <!-- Registration Form -->
    <section class="auth-section">
        <h1>Sign Up</h1>

        <!-- Display Messages -->
        <?php if (!empty($error_message)) : ?>
        <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($success_message)) : ?>
        <p class="success-message"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <form action="signup.php" method="post" class="auth-form">
            <input type="text" placeholder="Full Name" name="full_name" required>
            <input type="email" placeholder="Email Address" name="email" required>
            <input type="password" placeholder="Password" name="password" required>
            <input type="password" placeholder="Confirm Password" name="confirm_password" required>

            <!-- Role Selection Dropdown -->
            <select name="role" required>
                <option value="" disabled selected>Select Role</option>
                <option value="user">User</option>
                <option value="nutritionist">Nutritionist</option>
            </select>

            <button type="submit" class="auth-button">Sign Up</button>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </section>

</body>

</html>