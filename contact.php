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
        <form action="#" method="post">
            <input type="text" placeholder="Your Name" required>
            <input type="email" placeholder="Your Email" required>
            <textarea placeholder="Your Message" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </section>

</body>

</html>