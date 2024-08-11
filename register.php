<?php
require("server.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration and Login Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style> input{
        background-color: transparent;
    }
    #login_user_type,#register_user_type{
        background-color: black;
    }
    </style>
</head>
<body>


    <center><h2 style="color:white">Register</h2></center>
    <form action="" method="post" >
        <label for="register_username">Username:</label>
        <input type="text" id="register_username" name="username" required><br><br>
        
        <label for="register_email">Email:</label>
        <input type="email" id="register_email" name="email" required><br><br>
        
        <label for="register_password">Password:</label>
        <input type="password" id="register_password" name="password" required><br><br>
        
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        
        <label for="register_user_type">User Type:</label>
        <select id="register_user_type" name="user_type" required>
            <option value="User">recipe owner</option>
            <option value="Client">Client</option>
            <option value="Admin">Admin</option>
        </select><br><br>
        
        <input type="submit" name="register" value="Register" style="height: 50px;width: 100px;background-color:darkgreen"><br>
        <a href="http://localhost/draft/adm.php">login</a>
    </form>
    
</body>
</html>
