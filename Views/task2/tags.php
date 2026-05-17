
<?php

session_start();

require_once('../Models/database2.php');

if(

!isset($_SESSION['role'])

||

$_SESSION['role'] != 'admin'
){

    exit("Access Denied");
}

$tags =
getAllTags();

?>

<!DOCTYPE html>
<html>

<head>

<title>

Tags

</title>

</head>

<body>

<h1>

Tag Management

</h1>

<form

action="../Controllers/Add-Tag.php"

method="POST"

>

<input
type="text"
name="name"
placeholder="Tag Name"
required>

<button type="submit">

Add Tag

</button>

</form>

<hr>

<?php

while(
$row =
mysqli_fetch_assoc(
$tags
)){
?>

<div>

<?php
echo $row['name'];
?>

<a href="
../Controllers/Delete-Tag.php?id=<?php
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