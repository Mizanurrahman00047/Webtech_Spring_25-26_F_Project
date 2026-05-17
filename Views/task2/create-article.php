
<?php

session_start();

require_once(__DIR__ . '/../../Models/database.php');
require_once(__DIR__ . '/../../Models/database2.php');
require_once(__DIR__ . '/../../Models/database3.php');
require_once(__DIR__ . '/../../Models/database4.php');

if(
!isset($_SESSION['user_id'])
||
$_SESSION['role'] != 'author'
){
    exit("Access Denied");
}

$categories =
getAllCategories();

?>

<!DOCTYPE html>
<html>

<head>

<title>

Create Article

</title>

</head>

<body>


<h1>

Create Article

</h1>

<form

action="../../Controllers/task2/create-article-controller.php"

method="POST"

enctype="multipart/form-data"

>

Title

<br>



<input
type="text"
name="title"
required>

<br><br>

Body

<br>

<textarea
name="body"
rows="10"
cols="50"
required>
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
?>">

<?php
echo $category['name'];
?>

</option>

<?php
}
?>

</select>

<br><br>

Tags
(comma separated)

<br>

<input
type="text"
name="tags">

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

<option value="draft">

Draft

</option>

<option value="published">

Published

</option>

</select>

<br><br>

Schedule Publish

<br>

<input
type="datetime-local"
name="publish_at">

<br><br>

<button type="submit">

Create Article

</button>

</form>

</body>
</html>