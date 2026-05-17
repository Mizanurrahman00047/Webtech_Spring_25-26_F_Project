
<?php

require_once('../Models/database.php');
require_once('../Models/database2.php');
require_once('../Models/database3.php');
require_once('../Models/database4.php');

//add tag

$name =
trim($_POST['name']);

if($name != ""){

    addTag($name);
}

header(
"Location: ../Views/tags.php"
);


//delete tag

$id = $_GET['id'];

if(
tagHasArticle($id)
){

    exit(
    "Cannot Delete.
    Tag Linked To Articles"
    );
}

deleteTag($id);

header(
"Location: ../Views/tags.php"
);

?>