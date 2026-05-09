
<?php

session_start();

require_once('../Models/database.php');

if($_SESSION['role'] != 'admin'){

    die("Access Denied");
}

$users = getAllUsers();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Users</title>
</head>

<body>

<?php

while($user = $users->fetch_assoc()){
?>

<div id="row-<?php echo $user['id']; ?>">

    <h3>
        <?php echo $user['name']; ?>
    </h3>

    <span id="role-<?php echo $user['id']; ?>">
        <?php echo $user['role']; ?>
    </span>

    <br><br>

<?php

if($user['pending_author'] == 1){
?>

<button onclick="promoteUser(<?php
echo $user['id'];
?>)">
Promote to Author
</button>

<?php
}
?>

<hr>

</div>

<?php
}
?>

<script>

function promoteUser(userId){

    fetch(
        '../Controllers/Promote-Controller.php',
        {
            method: 'POST',

            headers: {
                'Content-Type':
                'application/x-www-form-urlencoded'
            },

            body: 'user_id=' + userId
        }
    )


    .then(response => response.json())

.then(data => {

    if(data.success){

        document.getElementById(
            'role-' + userId
        ).innerText = 'author';
    }
});
}

</script>

</body>

</html>