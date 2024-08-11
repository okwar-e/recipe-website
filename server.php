<?php
session_start();

$username = "";
$email = "";
$errors = array();

// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'project');

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}


$db = mysqli_connect('localhost', 'root', '', 'project');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Registration handler
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($db, $_POST['confirm_password']);
    $user_type = mysqli_real_escape_string($db, $_POST['user_type']);

    if ($password == $confirm_password) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the correct table
        $table = '';
        if ($user_type == "Admin") {
            $table = "admin";
        } elseif ($user_type == "User") {
            $table = "users";
        } elseif ($user_type == "Client") {
            $table = "clients";
        }

        $query = "INSERT INTO $table (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

        if (mysqli_query($db, $query)) {
            echo "Registration successful.";
        } else {
            echo "Error: " . mysqli_error($db);
        }
    } else {
        echo "Passwords do not match.";
    }
}

// Login handler
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $user_type = mysqli_real_escape_string($db, $_POST['user_type']);

    // Choose the table based on user type
    $table = '';
    if ($user_type == "Admin") {
        $table = "admin";
    } elseif ($user_type == "User") {
        $table = "users";
    } elseif ($user_type == "Client") {
        $table = "clients";
    }

    // Check if the user exists in the chosen table
    $query = "SELECT * FROM $table WHERE username='$username'";
    $results = mysqli_query($db, $query);

    if (mysqli_num_rows($results) == 1) {
        $user = mysqli_fetch_assoc($results);

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $user_type;

            echo "Login successful. Welcome, " . htmlspecialchars($username) . "!";

            if ($user_type == "Admin") {
                // Redirect to display_users.php for admins
                header("Location: display_users.php");
            } elseif ($user_type == "User") {
                // Redirect to profile.php for users
                header("Location: profile.php");
            } elseif ($user_type == "Client") {
                // Redirect to display_recipes.php for clients
                header("Location: display_recipes.php");
            }
            exit();
        } else {
            echo "Wrong username/password combination";
        }
    } else {
        echo "Wrong username/password combination";
    }
}
?>

