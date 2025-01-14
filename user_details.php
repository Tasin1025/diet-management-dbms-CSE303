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

// Fetch all users and their details from user_details table
$sql = "
    SELECT 
        users.id AS user_id, 
        users.name AS user_name, 
        users.email AS user_email,
        user_details.age,
        user_details.weight,
        user_details.height,
        user_details.goal
    FROM users
    INNER JOIN user_details ON users.id = user_details.user_id
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="dashboard">
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">
            <img src="logo.png" alt="Diet Planner Logo">
            <h1 class="dashboard-header">User Details Dashboard</h1>
        </div>

        <ul class="nav-links">
            <li><a href="nutritionist_dashboard.php">Home</a></li>
            <li><a href="user_details.php">Patient Details</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- User Details Table -->
    <section class="messages-table-section">
        <h2>User Details</h2>
        <!-- Search Bar -->
        <header class="search-header">
            <input type="text" id="search-bar" placeholder="Search users..." onkeyup="filterTable()">
        </header>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Weight (kg)</th>
                        <th>Height (cm)</th>
                        <th>Goal</th>
                    </tr>
                </thead>
                <tbody id="details-table">
                    <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_email']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['weight']); ?></td>
                        <td><?php echo htmlspecialchars($row['height']); ?></td>
                        <td><?php echo htmlspecialchars($row['goal']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>© 2024 Diet Planner. All rights reserved.</p>
    </footer>

    <script>
    function filterTable() {
        const searchInput = document.getElementById('search-bar').value.toLowerCase();
        const tableRows = document.querySelectorAll('#details-table tr');

        tableRows.forEach(row => {
            const rowData = row.innerText.toLowerCase();
            row.style.display = rowData.includes(searchInput) ? '' : 'none';
        });
    }
    </script>
</body>

</html>