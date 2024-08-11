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

// Check if delete button is clicked
if (isset($_POST['delete'])) {
    $recipe_id = intval($_POST['recipe_id']);

    // Delete recipe from database
    $sql_delete = "DELETE FROM recipes WHERE id=?";
    $stmt_delete = $db->prepare($sql_delete);
    $stmt_delete->bind_param("i", $recipe_id);

    if ($stmt_delete->execute()) {
        echo "Recipe deleted successfully.";
    } else {
        echo "Error deleting recipe: " . $stmt_delete->error;
    }

    $stmt_delete->close();

    // Redirect to avoid resubmission
    header("Location: profile.php");
    exit();
}

// Check if update button is clicked
if (isset($_POST['update'])) {
    $recipe_id = intval($_POST['recipe_id']);
    $recipe_name = mysqli_real_escape_string($db, $_POST['name']);
    $recipe_ingredients = mysqli_real_escape_string($db, $_POST['ingredients']);
    $recipe_image = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $recipe_image = file_get_contents($_FILES['image']['tmp_name']);
    }

    // Update recipe in database
    if ($recipe_image !== null) {
        $sql_update = "UPDATE recipes SET name=?, ingredients=?, image=? WHERE id=?";
        $stmt_update = $db->prepare($sql_update);
        $stmt_update->bind_param("sssi", $recipe_name, $recipe_ingredients, $recipe_image, $recipe_id);
    } else {
        $sql_update = "UPDATE recipes SET name=?, ingredients=? WHERE id=?";
        $stmt_update = $db->prepare($sql_update);
        $stmt_update->bind_param("ssi", $recipe_name, $recipe_ingredients, $recipe_id);
    }

    if ($stmt_update->execute()) {
        echo "Recipe updated successfully.";
    } else {
        echo "Error updating recipe: " . $stmt_update->error;
    }

    $stmt_update->close();

    // Redirect to avoid resubmission
    header("Location: profile.php");
    exit();
}

// Fetch user information from the database
$sql = "SELECT id, username, email FROM users WHERE username=?";
$stmt = $db->prepare($sql);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Error: User not found.";
    exit();
}

$stmt->close();

// Fetch recipes owned by the user, including images
$sql_recipes = "SELECT id, name, owner_id, ingredients, image FROM recipes WHERE owner_id=?";
$stmt_recipes = $db->prepare($sql_recipes);
$stmt_recipes->bind_param("i", $user['id']);
$stmt_recipes->execute();
$result_recipes = $stmt_recipes->get_result();

$recipes = array();
if ($result_recipes->num_rows > 0) {
    while ($row = $result_recipes->fetch_assoc()) {
        $recipes[] = $row;
    }
}

$stmt_recipes->close();
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        button {
            background-color: transparent;
        }
        input {
            background-color: transparent;
        }
    </style>
</head>
<body>
    <center>
    <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>

    <table>
        <tr>
            <th>Username</th>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
        </tr>
    </table>

    <h3>Your Recipes:</h3>
    <table>
        <thead>
            <tr>
                <th>Recipe Name</th>
                <th>Owner ID</th>
                <th>Ingredients</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipes as $recipe): ?>
                <tr>
                    <td><?php echo htmlspecialchars($recipe['name']); ?></td>
                    <td><?php echo htmlspecialchars($recipe['owner_id']); ?></td>
                    <td><?php echo htmlspecialchars($recipe['ingredients']); ?></td>
                    <td>
                        <?php if (!empty($recipe['image'])): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($recipe['image']); ?>" alt="Recipe Image" style="max-width: 150px; max-height: 150px;">
                        <?php else: ?>
                            No Image Available
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                            <button type="submit" name="delete">Delete</button>
                            <button type="button" onclick="showUpdateForm('<?php echo $recipe['id']; ?>', '<?php echo htmlspecialchars($recipe['name']); ?>', '<?php echo htmlspecialchars($recipe['ingredients']); ?>')">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div id="updateForm" style="display: none;">
        <h3>Update Recipe</h3>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="recipe_id" id="updateRecipeId">
            <label for="name">Name:</label>
            <input type="text" name="name" id="updateRecipeName" required><br>
            <label for="ingredients">Ingredients:</label>
            <input type="text" name="ingredients" id="updateRecipeIngredients" required><br>
            <label for="image">Image:</label>
            <input type="file" name="image" id="updateRecipeImage" accept="image/*"><br>
            <button type="submit" name="update">Update</button>
        </form>
    </div>

    <script>
        function showUpdateForm(id, name, ingredients) {
            document.getElementById('updateRecipeId').value = id;
            document.getElementById('updateRecipeName').value = name;
            document.getElementById('updateRecipeIngredients').value = ingredients;
            document.getElementById('updateForm').style.display = 'block';
        }
    </script>

    <a href="http://localhost/draft/submitrecipe.php">click here to add a recipe</a>
    </center>
</body>
</html>
