
<?php

session_start();

require_once('../Models/database.php');
require_once('../Models/database2.php');
require_once('../Models/database3.php');
require_once('../Models/database4.php');

$id =
$_POST['id'];

$title =
$_POST['title'];

$body =
$_POST['body'];

$category_id =
$_POST['category_id'];

$status =
$_POST['status'];

$publish_at =
$_POST['publish_at'];

$imageName = "";

if(
isset($_FILES['image'])
&&
$_FILES['image']['size'] > 0
){

$imageName =

time()

.

"_"

.

basename(
$_FILES['image']['name']
);

move_uploaded_file(

$_FILES['image']['tmp_name'],

"../public/uploads/articles/"
.
$imageName
);
}

else{

$old =
getArticleById($id);

$imageName =
$old['featured_image_path'];
}

updateArticle(

$id,

$title,

$body,

$imageName,

$category_id,

$status,

$publish_at
);

header(
"Location: ../Views/dashboard.php"
);

?>