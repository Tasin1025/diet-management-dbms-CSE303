<?php
// Include database configuration
include 'db_config.php';

// Start session
session_start();

// Redirect if the user is not a nutritionist
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'nutritionist') {
    header("Location: login.php");
    exit();
}

// Update meals in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $user_id = $_POST['save'];

    $breakfast = $_POST['breakfast'][$user_id] ?? '';
    $lunch = $_POST['lunch'][$user_id] ?? '';
    $dinner = $_POST['dinner'][$user_id] ?? '';

    // Delete existing meals for the user
    $delete_sql = "DELETE FROM meals WHERE user_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $user_id);
    $delete_stmt->execute();

    // Insert updated meals
    $insert_sql = "INSERT INTO meals (user_id, meal_type, meal_item) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);

    foreach (['Breakfast' => $breakfast, 'Lunch' => $lunch, 'Dinner' => $dinner] as $type => $items) {
        $items_array = array_filter(explode(',', $items));
        foreach ($items_array as $item) {
            $insert_stmt->bind_param("iss", $user_id, $type, trim($item));
            $insert_stmt->execute();
        }
    }

    header("Location: nutritionist_dashboard.php");
    exit();
}
?>