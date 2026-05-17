
<?php

session_start();

require_once('../../Models/database.php');
require_once('../../Models/database2.php');
require_once('../../Models/database3.php');
require_once('../../Models/database4.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
}
elseif(isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id'];
}
else{
    exit("Author ID Missing");
}

$user = getAuthor($id);

$social = json_decode(
    $user['social_links'],
    true
);

$twitter = isset($social['twitter'])
    ? $social['twitter']
    : '';

$github = isset($social['github'])
    ? $social['github']
    : '';
?>

<!DOCTYPE html>
<html>

<head>

    <title>Author Profile</title>
    <link rel="stylesheet" href="../design/design.css">

</head>

<body>

<?php

if(!empty($user['profile_pic_path'])){
?>

<img
src="../public/uploads/avatars/<?php
echo $user['profile_pic_path'];
?>"
width="150">

<?php
}
?>

<h2>

<?php echo $user['name']; ?>

</h2>

<p>

<?php echo $user['bio']; ?>

</p>

<a href="<?php echo $twitter; ?>">

Twitter

</a>

<br>

<a href="<?php echo $github; ?>">

GitHub

</a>
<br><br>
<a href="../Views/task1/profile-edit.php">
    Edit Profile
</a>

</body>

</html>