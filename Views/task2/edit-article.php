
<?php

session_start();

require_once('../Models/database.php');
require_once('../Models/database2.php');
require_once('../Models/database3.php');
require_once('../Models/database4.php');

$id = $_GET['id'];

$article = getArticleById($id);

$categories =
getAllCategories();

?>

<!DOCTYPE html>
<html>

<head>

<title>

Edit Article

</title>

</head>

<body>

<h1>

Edit Article

</h1>

<form

action="../Controllers/edit-article-controller.php"

method="POST"

enctype="multipart/form-data"

>

<input
type="hidden"
name="id"

value="<?php
echo $article['id'];
?>">

Title

<br>

<input
type="text"
name="title"

value="<?php
echo $article['title'];
?>">

<br><br>

Body

<br>

<textarea
name="body"
rows="10"
cols="50">

<?php
echo $article['body'];
?>

</textarea>

<br><br>

Category

<br>

<select name="category_id">

<?php

while(
$category =
mysqli_fetch_assoc(
$categories
)){
?>

<option

value="<?php
echo $category['id'];
?>"

<?php

if(
$article['category_id']
==
$category['id']
){
echo "selected";
}
?>

>

<?php
echo $category['name'];
?>

</option>

<?php
}
?>

</select>

<br><br>

Featured Image

<br>

<input
type="file"
name="image">

<br><br>

Status

<br>

<select name="status">

<option
value="draft"

<?php

if(
$article['status']
==
'draft'
){
echo "selected";
}
?>

>

Draft

</option>

<option
value="published"

<?php

if(
$article['status']
==
'published'
){
echo "selected";
}
?>

>

Published

</option>

</select>

<br><br>

Schedule Publish

<br>

<input
type="datetime-local"
name="publish_at"

value="<?php
echo $article['publish_at'];
?>">

<br><br>

<button type="submit">

Update Article

</button>

</form>

</body>
</html>