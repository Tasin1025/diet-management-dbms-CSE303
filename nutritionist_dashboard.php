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

// Fetch all users and their meal plans
$sql = "
    SELECT 
        users.id AS user_id, 
        users.name AS user_name, 
        GROUP_CONCAT(CASE WHEN meals.meal_type = 'Breakfast' THEN meals.meal_item END) AS breakfast,
        GROUP_CONCAT(CASE WHEN meals.meal_type = 'Lunch' THEN meals.meal_item END) AS lunch,
        GROUP_CONCAT(CASE WHEN meals.meal_type = 'Dinner' THEN meals.meal_item END) AS dinner
    FROM users
    LEFT JOIN meals ON users.id = meals.user_id
    GROUP BY users.id;
";

$result = $conn->query($sql);

// Fetch all contact messages
$msg_sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$msg_result = $conn->query($msg_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutritionist Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="dashboard">
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">
            <img src="logo.png" alt="Diet Planner Logo">
            <h1 class="dashboard-header">Nutritionist Dashboard</h1>
        </div>

        <ul class="nav-links">
            <li><a href="nutritionist_dashboard.php">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Messages Table -->
    <section class="messages-table-section">
        <h2>Messages from Users</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($msg_row = $msg_result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($msg_row['id']); ?></td>
                        <td><?php echo htmlspecialchars($msg_row['name']); ?></td>
                        <td><?php echo htmlspecialchars($msg_row['message']); ?></td>
                        <td>
                            <form method="POST" action="delete_message.php">
                                <button type="submit" name="delete"
                                    value="<?php echo $msg_row['id']; ?>">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>



    <!-- Patient Table -->
    <section class="patient-table-section">
        <h2>Manage Patients</h2>
        <!-- Search Bar -->
        <header class="search-header">
            <input type="text" id="search-bar" placeholder="Search patients..." onkeyup="filterTable()">
        </header>
        <div class="table-container">
            <form method="POST" action="update_meals.php">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Breakfast</th>
                            <th>Lunch</th>
                            <th>Dinner</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="patient-table">
                        <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                            <td>
                                <textarea
                                    name="breakfast[<?php echo $row['user_id']; ?>]"><?php echo htmlspecialchars($row['breakfast']); ?></textarea>
                            </td>
                            <td>
                                <textarea
                                    name="lunch[<?php echo $row['user_id']; ?>]"><?php echo htmlspecialchars($row['lunch']); ?></textarea>
                            </td>
                            <td>
                                <textarea
                                    name="dinner[<?php echo $row['user_id']; ?>]"><?php echo htmlspecialchars($row['dinner']); ?></textarea>
                            </td>
                            <td>
                                <button type="submit" name="save" value="<?php echo $row['user_id']; ?>">Save</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </form>
        </div>
    </section>



    <!-- Footer -->
    <footer class="footer">
        <p>© 2024 Diet Planner. All rights reserved.</p>
    </footer>

    <script>
    function filterTable() {
        const searchInput = document.getElementById('search-bar').value.toLowerCase();
        const tableRows = document.querySelectorAll('#patient-table tr');

        tableRows.forEach(row => {
            const rowData = row.innerText.toLowerCase();
            row.style.display = rowData.includes(searchInput) ? '' : 'none';
        });
    }
    </script>

</body>

</html>