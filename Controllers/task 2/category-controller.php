
<?php

require_once('../Models/database.php');
require_once('../Models/database2.php');
require_once('../Models/database3.php');
require_once('../Models/database4.php');

//add category
$name =
trim($_POST['name']);

if($name != ""){

    addCategory($name);
}

header(
"Location: ../Views/categories.php"
);


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
"Location: ../Views/categories.php"
);


?>