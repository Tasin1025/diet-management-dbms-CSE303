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

// Delete the message if delete is pressed
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $message_id = $_POST['delete'];

    // Delete the message from the database
    $delete_sql = "DELETE FROM contact_messages WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $message_id);

    if ($delete_stmt->execute()) {
        // Redirect back to the dashboard after deletion
        header("Location: nutritionist_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Error deleting message.');</script>";
    }
}
?>