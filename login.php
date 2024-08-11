<?php

require("server.php");

$db = mysqli_connect('localhost', 'root', '', 'project');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Debugging output
    echo "Username: $username <br>";
    echo "Password: $password <br>";

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);

    // Debugging output
    if (!$results) {
        die("Query failed: " . mysqli_error($db));
    }

    $num_rows = mysqli_num_rows($results);
    echo "Number of rows returned: $num_rows <br>";

    if ($num_rows == 1) {
        $_SESSION['username'] = $username;
        header('Location: profile.php');
        exit();
    } else {
        echo "Wrong username/password combination";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <center>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <div>
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <button type="submit" name="login">Login</button>
        </div>
    </form>
    </center>
</body>
</html>
