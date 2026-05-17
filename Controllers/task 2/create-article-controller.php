
<?php

session_start();

require_once('../Models/database.php');
require_once('../Models/database2.php');
require_once('../Models/database3.php');
require_once('../Models/database4.php');

$title =
trim($_POST['title']);

$body =
trim($_POST['body']);

$category_id =
$_POST['category_id'];

$status =
$_POST['status'];

$publish_at =
$_POST['publish_at'];

$tags =
explode(
',',
$_POST['tags']
);

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

$article_id = addArticle(

$_SESSION['user_id'],

$category_id,

$title,

$body,

$imageName,

$status,

$publish_at
);

foreach($tags as $tag){

$tag = trim($tag);

if($tag != ""){

createTagIfNotExists(
$tag
);

$tag_id =
getTagId($tag);

insertArticleTag(
$article_id,
$tag_id
);
}
}

header(
"Location: ../Views/dashboard.php"
);

?>