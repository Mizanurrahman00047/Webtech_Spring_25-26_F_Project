
<?php

session_start();

require_once('../Models/database.php');
require_once('../Models/database2.php');
require_once('../Models/database3.php');
require_once('../Models/database4.php');

if(

!isset($_SESSION['user_id'])

||

$_SESSION['role'] != 'author'
){

    exit("Access Denied");
}

publish_scheduled();

$author_id =
$_SESSION['user_id'];

$articles =
getAuthorArticles(
    $author_id
);

?>