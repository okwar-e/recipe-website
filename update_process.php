<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Update Record</title>
    <style>input{
        background-color: transparent;
    }</style>
</head>
<body>
    <h2 style="color:azure">Update Record</h2>
    <form action="update_process.php" method="POST"  style="color:white">
        <label for="id">Enter ID to Update:</label>
        <input type="text" id="id" name="id" required><br><br>
        <label for="username">New Username:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="email">New Email:</label>
        <input type="text" id="email" name="email"><br><br>
        <button type="submit"class="btn">Update</button>
    </form>
    <center>
        <a href="http://localhost/draft/display_users.php" style="color:red">back to users <br></a>

    </center>
</body>
</html>

<?php
require("server.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Check if the ID exists in the database
    $check_sql = "SELECT COUNT(*) FROM users WHERE id=?";
    $check_stmt = $db->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($count > 0) {
        // Only prepare the update statement if either username or email is provided
        if (!empty($username) || !empty($email)) {
            $set_clauses = [];
            $params = [];
            $param_types = '';

            if (!empty($username)) {
                $set_clauses[] = "username=?";
                $params[] = $username;
                $param_types .= 's';
            }

            if (!empty($email)) {
                $set_clauses[] = "email=?";
                $params[] = $email;
                $param_types .= 's';
            }

            $params[] = $id;
            $param_types .= 'i';

            $sql = "UPDATE users SET " . implode(", ", $set_clauses) . " WHERE id=?";
            $stmt = $db->prepare($sql);

            // Bind parameters dynamically
            $stmt->bind_param($param_types, ...$params);

            if ($stmt->execute()) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "No fields to update";
        }
    } else {
        echo "Error: ID not found in the database.";
    }

    $db->close();
}
?>
