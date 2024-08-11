<!DOCTYPE html>
<html lang="en">
    <style>

        table, th, td {
            border: 1px solid black;
        }
        table {
            border-left: 30%;
        }
    </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Display Users Info</title>
</head>
<body>
    <center>
<table style="color:white; border:solid white;" cellpadding="30" cellspacing="30" align="center" border="4">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
    </tr>
  
<?php 
require ("server.php");
$sql = "SELECT id, username, email FROM users";
$result = mysqli_query($db, $sql);

if ($result->num_rows > 0) {
    
  
    while($row = $result->fetch_assoc()) {
        echo 
        "<tr>
            <td>".$row["id"]."</td>
            <td>".$row["username"]."</td>
            <td>".$row["email"]."</td>
        </tr>";
    }
} else {
    echo "0 results";
}
$db->close();
?>
</table>

    </center>
    
  <form action="delete_process.php" method="GET">
    <button type="submit" class="btn">Delete Record</button>
  </form>
  <form action="update_process.php" method="GET">
    <button type="submit" class="btn">Update Record</button>
  </form>
  <center><a href="http://localhost/draft/home.php">click to go back home </a></center>
  
</body>
</html>
