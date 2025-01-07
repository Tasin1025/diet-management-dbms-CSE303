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
        <form action="#" method="post" class="auth-form">
            <input type="email" placeholder="Email Address" required>
            <input type="password" placeholder="Password" required>
            <button type="submit" class="auth-button">Login</button>
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </form>
    </section>

</body>

</html>