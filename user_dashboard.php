<?php
// Include database configuration
include 'db_config.php';

// Start session
session_start();

// Redirect to login if user is not logged in
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
//     header("Location: login.php");
//     exit();
// }

// Fetch user details from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $update_sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssi", $name, $email, $password, $user_id);

    if ($update_stmt->execute()) {
        $success_message = "Profile updated successfully!";
        // Refresh user details
        $stmt = $conn->prepare($sql); // Prepare the SELECT statement again
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    } else {
        $error_message = "Failed to update profile. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script>
    function enableEdit() {
        document.getElementById("profile-form").querySelectorAll("input").forEach(input => input.removeAttribute(
            "readonly"));
        document.getElementById("edit-button").style.display = "none";
        document.getElementById("save-button").style.display = "inline-block";
    }
    </script>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">
            <img src="logo.png" alt="Diet Planner Logo">
        </div>
        <ul class="nav-links">
            <li><a href="user_dashboard.php">Home</a></li>
            <li><a href="personalized.php">Personalized Diet Plans</a></li>
            <li><a href="analysis.php">Detailed Nutritional Analysis</a></li>
            <li><a href="grocery.php">Easy Grocery Lists</a></li>
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Hero Section with Welcome Text -->
    <section class="hero2">
        <div class="hero-content">
            <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
            <p>We are glad to have you on your journey to a healthier lifestyle.</p>
        </div>
    </section>

    <!-- User Details Section -->
    <section class="features">
        <h2>Your Profile</h2>
        <!-- Success/Error Messages -->
        <?php if (!empty($success_message)) : ?>
        <p class="success-message"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($error_message)) : ?>
        <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form id="profile-form" method="post" class="auth-form">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" readonly>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                readonly>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password"
                value="<?php echo htmlspecialchars($user['password']); ?>" readonly>

            <button type="button" id="edit-button" class="auth-button" onclick="enableEdit()">Edit</button>
            <button type="submit" id="save-button" name="save" class="auth-button" style="display: none;">Save</button>
        </form>
    </section>

    <!-- Feature Highlights -->
    <section class="features" id="about">
        <h2>Why Choose Our Diet Planner?</h2>
        <div class="feature-cards">
            <div class="feature-card">
                <h3>Personalized Diet Plans</h3>
                <p>Customized meals tailored to your unique health goals.</p>
            </div>
            <div class="feature-card">
                <h3>Detailed Nutritional Analysis</h3>
                <p>Track your nutrient intake easily.</p>
            </div>
            <div class="feature-card">
                <h3>Easy Grocery Lists</h3>
                <p>Automatically generated shopping lists for meal planning.</p>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="howitworks" id="details">
        <h2>How It Works</h2>
        <div class="steps">
            <div class="step">
                <h3>Create Your Profile</h3>
            </div>
            <div class="step">
                <h3>Set Your Goals</h3>
            </div>
            <div class="step">
                <h3>Get Your Meal Plan</h3>
            </div>
            <div class="step">
                <h3>Track Progress</h3>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2024 Diet Planner. All rights reserved.</p>
    </footer>

</body>

</html>