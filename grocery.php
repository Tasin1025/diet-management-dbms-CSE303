<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Grocery Lists</title>
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

    <!-- Grocery List Section -->
    <section class="grocery-list">
        <h1>Grocery List for Diet Plans</h1>

        <!-- Weight Loss Plan Grocery List -->
        <div class="plan">
            <h2>Weight Loss Plan</h2>
            <ul>
                <li><strong>Vegetables & Greens:</strong> Cucumber, Tomato, Okra, Carrots, Spinach</li>
                <li><strong>Fruits:</strong> Mango, Papaya, Guava, Banana</li>
                <li><strong>Grains & Pulses:</strong> Moong dal, Brown rice, Roasted chana</li>
                <li><strong>Proteins:</strong> Pomfret or substitute lean fish</li>
                <li><strong>Dairy:</strong> Plain yogurt</li>
                <li><strong>Spices & Condiments:</strong> Basic spices (turmeric, salt, pepper, cumin)</li>
            </ul>
        </div>

        <!-- Muscle Gain Plan Grocery List -->
        <div class="plan">
            <h2>Muscle Gain Plan</h2>
            <ul>
                <li><strong>Vegetables & Greens:</strong> Spinach, Garlic, Cucumber, Green chili, Bottle gourd</li>
                <li><strong>Fruits:</strong> Apple or Banana</li>
                <li><strong>Grains & Pulses:</strong> Whole wheat flour, Basmati rice, Muri, Moong dal</li>
                <li><strong>Proteins:</strong> Eggs, Peanuts, Chicken breast, Shrimp</li>
                <li><strong>Dairy:</strong> Plain yogurt, Lassi</li>
                <li><strong>Condiments & Spices:</strong> Peanut butter, Chia seeds, Basic spices</li>
            </ul>
        </div>

        <!-- Diabetes Management Plan Grocery List -->
        <div class="plan">
            <h2>Diabetes Management Plan</h2>
            <ul>
                <li><strong>Vegetables & Greens:</strong> Spinach, Fenugreek, Cauliflower, Green beans, Carrots, Bottle
                    gourd</li>
                <li><strong>Fruits:</strong> Apple, Cucumber</li>
                <li><strong>Grains & Pulses:</strong> Oats or Whole wheat flour, Red or Black rice, Sprouted moong, Red
                    lentils</li>
                <li><strong>Proteins:</strong> Rohu fish, Prawns, Almonds</li>
                <li><strong>Dairy:</strong> Plain yogurt or curd</li>
                <li><strong>Spices & Condiments:</strong> Basic spices, Mint leaves</li>
            </ul>
        </div>
    </section>
</body>

</html>