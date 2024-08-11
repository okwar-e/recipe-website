<?php
require("server.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Database connection (assuming server.php handles this)
$db = mysqli_connect('localhost', 'root', '', 'project');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all recipes along with the owner's name from the database
$sql_recipes = "
    SELECT recipes.id, recipes.name, recipes.owner_id, recipes.ingredients, recipes.image, users.username AS owner_name
    FROM recipes
    JOIN users ON recipes.owner_id = users.id
";
$result_recipes = mysqli_query($db, $sql_recipes);

$recipes = array();
if (mysqli_num_rows($result_recipes) > 0) {
    while ($row = mysqli_fetch_assoc($result_recipes)) {
        $recipes[] = $row;
    }
}

mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Recipes</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <center>
    <h2>All Recipes</h2>

    <table>
        <thead>
            <tr>
                <th>Recipe Name</th>
                <th>Owner Name</th>
                <th>Ingredients</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipes as $recipe): ?>
                <tr>
                    <td><?php echo htmlspecialchars($recipe['name']); ?></td>
                    <td><?php echo htmlspecialchars($recipe['owner_name']); ?></td>
                    <td><?php echo htmlspecialchars($recipe['ingredients']); ?></td>
                    <td>
                        <?php if (!empty($recipe['image'])): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($recipe['image']); ?>" alt="Recipe Image" style="max-width: 150px; max-height: 150px;">
                        <?php else: ?>
                            No Image Available
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </center>
    <center><a href="http://localhost/draft/home.php">  click to go home </a></center>
</body>
</html>
