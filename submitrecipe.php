<?php
// Database connection
$db = mysqli_connect('localhost', 'root', '', 'project');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user IDs
$userIds = [];
$query = "SELECT id FROM users";
$result = mysqli_query($db, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $userIds[] = $row['id'];
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $ingredients = mysqli_real_escape_string($db, $_POST['ingredients']);
    $owner_id = intval($_POST['owner_id']); // Ensure owner_id is an integer
    $category = mysqli_real_escape_string($db, $_POST['category']);
    
    // Get image data
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['tmp_name'];
        $imageData = addslashes(file_get_contents($image));
    } else {
        echo "Error: Please upload an image.";
        exit;
    }

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO recipes (name, image, ingredients, owner_id, category) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssis", $name, $imageData, $ingredients, $owner_id, $category);

    if ($stmt->execute()) {
        echo "Recipe submitted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit a Recipe</title>
    <link rel="stylesheet" type="text/css" href="form.css">
    <style>body {
    display: flex;
    flex-direction: column;}
    input,textarea,select{
    background-color: white;
    color: black;
}   
a{
    color: red;
}

    </style>
</head>
<body>
    <h2 style="color: white;">Submit a Recipe</h2>
    <form action="submit_recipe.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="name">Recipe Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="image">Recipe Image:</label>
            <input type="file" id="image" name="image" required>
        </div>
        <div>
            <label for="ingredients">Ingredients:</label>
            <textarea id="ingredients" name="ingredients" rows="5" required></textarea>
        </div>
        <div>
            <label for="owner_id">Recipe Owner ID:</label>
            <select id="owner_id" name="owner_id" required>
                <?php
                // Populate dropdown with user IDs fetched from database
                foreach ($userIds as $id) {
                    echo "<option value='$id'>$id</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="category">Category:</label>
            <input type="text" id="category" name="category" required>
        </div>
        <div>
            <button type="submit" name="submit">Submit Recipe</button>
        </div>
        <a href="http://localhost/draft/home.php" >click to go back home </a>
    </form>
    
</body>
</html>
