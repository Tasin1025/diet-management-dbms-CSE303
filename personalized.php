<?php
// Include database configuration
include 'db_config.php';

// Start session
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

// Fetch meals for the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT meal_type, meal_item FROM meals WHERE user_id = ? ORDER BY meal_type";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Organize meals by type
$meals = [
    'Breakfast' => [],
    'Lunch' => [],
    'Dinner' => []
];

while ($row = $result->fetch_assoc()) {
    $meals[$row['meal_type']][] = $row['meal_item'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personalized Diet Plans</title>
    <link rel="stylesheet" href="styles.css">
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

    <!-- Page Content -->
    <section class="personalized">
        <h1>Personalized Diet Plans</h1>
        <p>We create meal plans tailored to your unique dietary needs and health goals.</p>

        <div class="meal-box-container">
            <!-- Breakfast Box -->
            <div class="meal-box">
                <h2>Breakfast</h2>
                <?php if (!empty($meals['Breakfast'])): ?>
                <ul>
                    <?php foreach ($meals['Breakfast'] as $item): ?>
                    <li><?php echo htmlspecialchars($item); ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p>No meals available for Breakfast.</p>
                <?php endif; ?>
            </div>

            <!-- Lunch Box -->
            <div class="meal-box">
                <h2>Lunch</h2>
                <?php if (!empty($meals['Lunch'])): ?>
                <ul>
                    <?php foreach ($meals['Lunch'] as $item): ?>
                    <li><?php echo htmlspecialchars($item); ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p>No meals available for Lunch.</p>
                <?php endif; ?>
            </div>

            <!-- Dinner Box -->
            <div class="meal-box">
                <h2>Dinner</h2>
                <?php if (!empty($meals['Dinner'])): ?>
                <ul>
                    <?php foreach ($meals['Dinner'] as $item): ?>
                    <li><?php echo htmlspecialchars($item); ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p>No meals available for Dinner.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>

</html>