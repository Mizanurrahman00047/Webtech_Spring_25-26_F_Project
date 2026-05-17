
<?php

session_start();

require_once(__DIR__ . '/../../Models/database.php');
require_once(__DIR__ . '/../../Models/database2.php');
require_once(__DIR__ . '/../../Models/database3.php');
require_once(__DIR__ . '/../../Models/database4.php');

publish_scheduled();

$categories = getAllCategories();

$articles = getPublishedArticles();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Homepage</title>
</head>

<body>

<h1>Blog & News</h1>

<!-- CATEGORY TABS -->

<div id="categories">

<button onclick="loadArticles('all')">
    All
</button>

<?php
while($category = mysqli_fetch_assoc($categories)){
?>

<button
onclick="loadArticles(
'<?php echo $category['id']; ?>'
)">
    <?php echo $category['name']; ?>
</button>

<?php
}
?>

</div>

<hr>

<!-- ARTICLE GRID -->

<div id="articleGrid">

<?php

while($row = mysqli_fetch_assoc($articles)){
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

<input
type="text"
id="searchInput"
placeholder="Search Articles">

<div
id="searchResults"
style="
border:1px solid black;
width:300px;
display:none;
background:white;
position:absolute;
">
</div>


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

</div>

<script src="../ajax/script3.js"></script>


</body>
</html>