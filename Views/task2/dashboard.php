
<?php

require_once(__DIR__ . '/../../Controllers/task2/dashboard-controller.php');

?>

<!DOCTYPE html>
<html>

<head>

<title>

Author Dashboard

</title>

</head>

<body>

<a href="../../Views/task2/create-article.php">
    Create New Article
</a>
<br><br>

<a href="../../Controllers/task2/edit-article-controller.php"> edit article </a>

<br><br>
<a href="../../Views/task1/author-profile.php">
author profile
</a>

<h1>

My Articles

</h1>

<?php

while(
$row =
mysqli_fetch_assoc(
    $articles
))
{
?>

<div

style="
border:1px solid black;
padding:10px;
margin:10px;
">

<h3>

<?php
echo $row['title'];
?>

</h3>

<p>

Status:
<span
id="status<?php
echo $row['id'];
?>">

<?php
echo $row['status'];
?>

</span>

</p>

<p>

Views:
<?php
echo $row['view_count'];
?>

</p>

<p>

Comments:
<?php
echo $row['comment_count'];
?>

</p>

<a href="
edit-article.php?id=<?php
echo $row['id'];
?>
">

Edit

</a>

<button

onclick="
toggleStatus(
<?php
echo $row['id'];
?>)
">
Toggle Status

</button>

</div>

<?php
}
?>

<script src="../../ajax/ajax2.js"></script>

</body>
</html>