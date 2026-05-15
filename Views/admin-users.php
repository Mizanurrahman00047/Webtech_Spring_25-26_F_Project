
<?php

session_start();

require_once('../Models/database.php');

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

</head>

<body>

<h2>All Users</h2>

<p>
    <a href="../Controllers/export-users.php" target="_blank">
        Export all users to JSON
    </a>
</p>

<?php

while($user = $users->fetch_assoc()){
?>

<div>

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

<script src="../ajax/ajax.js"></script>

</body>

</html>