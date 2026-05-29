
<?php

require_once(__DIR__ . '/../../Controllers/task2/dashboard-controller.php');

?>

<!DOCTYPE html>
<html>

<head>

<title>

Author Dashboard

</title>
<link rel="stylesheet" href="../../Views/design/dashboard.css">

</head>

<body>
<div class="container">
<nav class="navbar">
    <ul>
        <li><a href="../../Views/task2/create-article.php">
            Create New Article
        </a></li>
        <li><a href="../../Controllers/task2/edit-article-controller.php"> edit article </a></li>

        <li><a href="../../Views/task1/author-profile.php">
            author profile
        </a></li>
    </ul>
</nav>

<header class="page-header">
<h1>

My Articles

</h1>
</header>

<?php

while(
$row =
mysqli_fetch_assoc(
    $articles
))
{
?>

<div class="article-card">

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
</div>

<?php
}
?>

<script src="../../ajax/ajax2.js"></script>

</body>
</html>