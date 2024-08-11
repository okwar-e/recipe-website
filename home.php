<?php
// Database connection
$db = mysqli_connect('localhost', 'root', '', 'project');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch recipes from database
$query = "SELECT * FROM recipes";
$result = mysqli_query($db, $query);

// Initialize an array to store recipes
$recipes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $recipes[] = $row;
}

mysqli_close($db); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Pacifico&display=swap" rel="stylesheet">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>PUPPA GUMP RECIPES</title>
    <link rel="stylesheet" href="homestyle.css">
</head>
<body>

<div class="banner">
    <!-- Navbar -->
    <nav>
        <div class="navbar">
            <img src="f.jpg" class="logo">
            <ul> 
                <li><a href="#featured-recipes">Recipies</a></li>
                <li><a href="#contacts">Contact</a></li>
                <li>
                    <form action="http://localhost/draft/adm.php">
                        <button type="link" style="background-color: transparent; width: 150px; height: 50px; color: rgb(247, 247, 247); border-radius: 5px;"><span>LOGIN</span></button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="content">
        <div>
            <h1>PUPPA GUMP RECIPES</h1>
        </div>
        <div style="display: flex; flex-direction: column; gap: 90px;">
            <p style="font-weight: 100; font-size: 24px;">Make a wonderful meal with US!</p>
            <form action="http://localhost/draft/submitrecipe.php">
                <button type="link" style="background-color: transparent; height: 50px; border-radius: 5px; color: white; font-size: small; font-weight: 900; margin-top: 2cm; padding: 10px;"> CLICK HERE TO ADD YOUR RECIPE
                </button>
            </form>  
        </div>    
    </div> 
</div>

<main>
    <section>
        <h3>Featured Recipes</h3>
        <div class="featured-recipes" id="featured-recipes">
            <?php foreach ($recipes as $recipe): ?>
                <div class="recipe-card">
                    <div class="img">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($recipe['image']); ?>" width="300" height="300" alt="Recipe Image">
                    </div>
                    <div class="hmm">
                        <h4><?php echo htmlspecialchars($recipe['name']); ?></h4>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div>
            <button class="button">See All Recipes</button>
        </div>
    </section>

    <!-- Testimonial section -->
    <section id="testimonials">
        <h2>What our readers say:</h2>
        <div class="testimonial-container">
            <div class="testimonial">
                <i style='font-size:24px' class='far'>&#xf118;</i>
                <img src="user1.jpg" alt="User 1">
                <p>"This website is amazing! I've never seen such a great collection of recipes."</p>
                <h5>John Doe</h5>
            </div>
            <div class="testimonial">
                <img src="user1.jpg" alt="User 2">
                <p>"I've tried several recipes from this website and they all turned out delicious!"</p>
                <h5>Jane Smith</h5>
            </div>
            <div class="testimonial">
                <img src="user1.jpg" alt="User 3">
                <p>"I love how easy it is to navigate and find the recipes I'm looking for."</p>
                <h5>Bob Johnson</h5>
            </div>
        </div>
    </section>
</main>

<!-- Footer -->
<footer id="contacts">
    <img src="f.jpg" class="logo">
    <div class="social-media">
        <h2>Follow Us</h2>
        <ul>
            <li>Facebook @TASTYTREATS</li>
            <li>Twitter @TASTY_TREATS</li>
            <li>Instagram @TASTY_TREATS</li>
        </ul>
    </div>
    <div class="contacts">
        <h2>Contact us</h2>
        <p>Call: 254717278278</p>
        <p>Email: tastytreats@gmail.com</p>
        <p>P.O BOX: 21223, 43443</p>
    </div>
</footer>

</body>
</html>
