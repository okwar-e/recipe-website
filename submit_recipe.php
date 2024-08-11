    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" type="text/css" href="style.css">

    </head>
    <body>
       <center> <a href="http://localhost/draft/home.php">click to go back home </a><br><br><br>
       <a href="http://localhost/draft/submitrecipe.php">click to add another recipe </a>
       </center>
    
    <?php
    // Database connection
    $db = mysqli_connect('localhost', 'root', '', 'project');

    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $ingredients = mysqli_real_escape_string($db, $_POST['ingredients']);
        $owner_id = intval($_POST['owner_id']); // Ensure owner_id is an integer
        $category = mysqli_real_escape_string($db, $_POST['category']);
        
        // Get image data
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = $_FILES['image']['tmp_name'];
            $imageData = file_get_contents($image);
        } else {
            echo "Error: Please upload an image.";
            exit;
        }

        // Prepare the SQL statement with placeholders
        $sql = "INSERT INTO recipes (name, image, ingredients, owner_id, category) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        
        // Bind parameters (the "b" type specifier is for blobs)
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
</body>
</html>