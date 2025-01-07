<?php
// Include database configuration
include 'db_config.php';

// Start session
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the user's name from the session
$user_name = $_SESSION['user_name'] ?? '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'] ?? '';

    // Insert the name and message into the database
    $sql = "INSERT INTO contact_messages (name, message) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_name, $message);
    if ($stmt->execute()) {
        echo "<script>alert('Your message has been sent successfully!');</script>";
    } else {
        echo "<script>alert('An error occurred. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">
            <img src="logo.png" alt="Diet Planner Logo"> <!-- Replace "logo.png" with your logo file path -->
        </div>
        <ul class="nav-links">
            <li><a href="user_dashboard.php">Home</a></li>
            <li> <a href="personalized.php">Personalized Diet Plans</a></li>
            <li> <a href="analysis.php">Detailed Nutritional Analysis</a></li>
            <li> <a href="grocery.php">Easy Grocery Lists</a></li>
            <li> <a href="contact.php">Contact Us</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Page Content -->
    <section class="contact">
        <h1>Contact Us</h1>
        <form action="" method="post">
            <input type="text" value="<?php echo htmlspecialchars($user_name); ?>" readonly>
            <textarea name="message" placeholder="Your Message" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </section>

</body>

</html>