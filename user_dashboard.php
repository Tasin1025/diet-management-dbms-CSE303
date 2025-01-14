<?php
// Include database configuration
include 'db_config.php';

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details for profile form
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Fetch details for the details form
$details_sql = "SELECT * FROM user_details WHERE user_id = ?";
$details_stmt = $conn->prepare($details_sql);
$details_stmt->bind_param("i", $user_id);
$details_stmt->execute();
$user_details = $details_stmt->get_result()->fetch_assoc();

// Handle profile form update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $update_sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssi", $name, $email, $password, $user_id);

    if ($update_stmt->execute()) {
        $success_message = "Profile updated successfully!";
    } else {
        $error_message = "Failed to update profile. Please try again.";
    }
}

// Handle details form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_details'])) {
    $age = $_POST['age'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $goal = $_POST['goal'];

    if ($user_details) {
        // Update existing record
        $update_details_sql = "UPDATE user_details SET age = ?, weight = ?, height = ?, goal = ? WHERE user_id = ?";
        $update_details_stmt = $conn->prepare($update_details_sql);
        $update_details_stmt->bind_param("iidsi", $age, $weight, $height, $goal, $user_id);
        $update_details_stmt->execute();
    } else {
        // Insert new record
        $insert_details_sql = "INSERT INTO user_details (user_id, age, weight, height, goal) VALUES (?, ?, ?, ?, ?)";
        $insert_details_stmt = $conn->prepare($insert_details_sql);
        $insert_details_stmt->bind_param("iidis", $user_id, $age, $weight, $height, $goal);
        $insert_details_stmt->execute();
    }
    $details_success_message = "Details saved successfully!";
    header("Refresh:0");
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

    <section class="features" id="forms-flex">
        <div class="forms" style="display: flex; gap: 20px;">
            <!-- Profile Form -->
            <div class="one_form" style="flex: 1;">
                <h2>Your Profile</h2>
                <form id="profile-form" method="post" class="auth-form">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>"
                        readonly>

                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                        readonly>

                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password"
                        value="<?php echo htmlspecialchars($user['password']); ?>" readonly>

                    <button type="button" id="edit-button" class="auth-button" onclick="enableEdit()">Edit</button>
                    <button type="submit" id="save-button" name="save" class="auth-button"
                        style="display: none;">Save</button>
                </form>
            </div>
            <!--  Details Form -->
            <div class="one_form" style="flex: 1;">
                <h2>Set Your Details</h2>
                <form id="details-form" method="post" class="auth-form">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" value="<?php echo $user_details['age'] ?? ''; ?>" required>

                    <label for="weight">Weight (kg):</label>
                    <input type="number" id="weight" name="weight" value="<?php echo $user_details['weight'] ?? ''; ?>"
                        required>

                    <label for="height">Height (cm):</label>
                    <input type="number" id="height" name="height" value="<?php echo $user_details['height'] ?? ''; ?>"
                        required>

                    <label for="goal">Goal:</label>
                    <select id="goal" name="goal">
                        <option value="weight-loss"
                            <?php echo (isset($user_details['goal']) && $user_details['goal'] === 'weight-loss') ? 'selected' : ''; ?>>
                            Weight Loss</option>
                        <option value="muscle-gain"
                            <?php echo (isset($user_details['goal']) && $user_details['goal'] === 'muscle-gain') ? 'selected' : ''; ?>>
                            Muscle Gain</option>
                        <option value="healthy-living"
                            <?php echo (isset($user_details['goal']) && $user_details['goal'] === 'healthy-living') ? 'selected' : ''; ?>>
                            Healthy Living</option>
                    </select>


                    <button type="submit" name="save_details" class="auth-button">Save</button>
                </form>
            </div>

        </div>
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