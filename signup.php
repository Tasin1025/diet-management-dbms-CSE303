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
        <form action="#" method="post" class="auth-form">
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
            <p>Already have an account? <a href="login.html">Login</a></p>
        </form>
    </section>

</body>

</html>