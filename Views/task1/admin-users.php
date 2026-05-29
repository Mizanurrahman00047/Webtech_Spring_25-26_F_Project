
<?php

session_start();

require_once(__DIR__ . '/../../Models/database.php');

if(
    !isset($_SESSION['role'])
    ||
    $_SESSION['role'] != 'admin'
){

    exit("Access Denied");
}

$users = getAllUsers();


?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Users</title>
    <link rel="stylesheet" href="../../Views/design/admin-user.css">

</head>

<body>
<nav class="menu">
    <ul>
        <li><a href="../../Views/task2/categories.php">Category Management</a></li>
        <li><a href="../../Views/task2/tags.php">Tag Management</a></li>
        <li><a href="../../Views/task4/admin-moderator.php">Moderation Dashboard</a></li>
    </ul>
<br><br>
</nav>

<header class="container">
<h1>All Users</h1>

<p>
    <a href="../../Controllers/task1/export-users.php" target="_blank">
        Export all users to JSON
    </a>
</p>
</header>
<?php

while($user = $users->fetch_assoc()){
?>

<div class="container">
    <h3>
        ID: <?php echo $user['id']; ?>

    <h3>
        <?php echo $user['name']; ?>
    </h3>

    <p>
        <?php echo $user['email']; ?>
    </p>

    <p id="role-<?php echo $user['id']; ?>">

        Role:
        <?php echo $user['role']; ?>

    </p>

<?php

if($user['pending_author'] == 1){
?>

<button
onclick="promoteUser(<?php
echo $user['id'];
?>)">

Promote To Author

</button>

<?php
}
?>

<hr>

</div>

<?php
}
?>

<script src="../../ajax/ajax.js"></script>

</body>

</html>