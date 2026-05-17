
<?php

require_once(__DIR__ . '/../../Models/database.php');
require_once(__DIR__ . '/../../Models/database2.php');
require_once(__DIR__ . '/../../Models/database3.php');
require_once(__DIR__ . '/../../Models/database4.php');

//add category
$name =
trim($_POST['name']);

if($name != ""){

    addCategory($name);
}

header("Location: ../../Views/task2/categories.php");


//delete category

$id = $_GET['id'];

if(
categoryHasArticle($id)
){

    exit(
    "Cannot Delete.
    Category Has Articles"
    );
}

deleteCategory($id);

header(
"Location: ../../Views/task2/categories.php"
);


?>