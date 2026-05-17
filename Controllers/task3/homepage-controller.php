
<?php

require_once('../Models/database.php');
require_once('../Models/database2.php');
require_once('../Models/database3.php');
require_once('../Models/database4.php');

if(
    isset($_GET['category_id'])
){

    $articles =
    getArticlesByCategory(
        $_GET['category_id']
    );
}

else{

    $articles =
    getPublishedArticles();
}

while(
    $row =
    mysqli_fetch_assoc(
        $articles
    )
){
?>

<div
style="
border:1px solid black;
padding:10px;
margin:10px;
width:300px;
">

<img
src="../public/uploads/articles/<?php
echo $row['featured_image_path'];
?>"
width="250">

<h3>

<a href="
article.php?id=<?php
echo $row['id'];
?>
">

<?php
echo $row['title'];
?>

</a>

</h3>

<img
src="../public/uploads/avatars/<?php
echo $row['profile_pic_path'];
?>"
width="40">

<?php
echo $row['author_name'];
?>

<br>

<?php
echo $row['created_at'];
?>

<br>

Category:
<?php
echo $row['category_name'];
?>

<br>

Likes:
<?php
echo $row['like_count'];
?>

</div>

<?php
}
?>