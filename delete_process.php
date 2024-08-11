

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Record</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <h2 style="color:azure">Delete Record</h2>
    <form action="delete_process.php" method="POST" style="color:white">
        <label for="id">Enter ID to Delete:</label>
        <input type="text" id="id" name="id" required>
        <button type="submit">Delete</button>
    </form>
    <a href="http://localhost/draft/display_users.php">back to users <br></a>
</body>
</html>
<?php
require("server.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
}
?>
