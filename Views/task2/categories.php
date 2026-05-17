
<?php

session_start();

require_once(__DIR__ . '/../../Models/database.php');
require_once(__DIR__ . '/../../Models/database2.php');
require_once(__DIR__ . '/../../Models/database3.php');
require_once(__DIR__ . '/../../Models/database4.php');

if(

!isset($_SESSION['role'])

||

$_SESSION['role'] != 'admin'
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

Categories

</title>

</head>

<body>

<h1>

Category Management

</h1>

<form

action="../../Controllers/task2/category-controller.php"

method="POST"

>

<input
type="text"
name="name"
placeholder="Category Name"
required>

<button type="submit">

Add Category

</button>

</form>

<hr>

<?php

while(
$row =
mysqli_fetch_assoc(
$categories
)){
?>

<div>

<?php
echo $row['name'];
?>

<a href="
../Controllers/Delete-Category.php?id=<?php
echo $row['id'];
?>
">

Delete

</a>

</div>

<?php
}
?>

</body>
</html>