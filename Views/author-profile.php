
<?php

require_once('../Webtech_Spring_25-26_F_Project/Webtech_Spring_25-26_F_Project/Models/database.php');

$id = $_GET['id'];

$user = getAuthor($id);

$articles = getAuthorArticles($id);

$social = json_decode(
    $user['social_links'],
    true
);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Author Profile</title>
</head>

<body>

<img src="../public/uploads/avatars/<?php
echo $user['profile_pic_path'];
?>"
width="150">

<h2>
<?php echo $user['name']; ?>
</h2>

<p>
<?php echo $user['bio']; ?>
</p>

<a href="<?php echo $social['twitter']; ?>">
Twitter
</a>

<br>

<a href="<?php echo $social['github']; ?>">
GitHub
</a>

<hr>

<h3>Published Articles</h3>

<?php

while($article = $articles->fetch_assoc()){

    echo "<h4>"
        . $article['title']
        . "</h4>";
}
?>

</body>

</html>