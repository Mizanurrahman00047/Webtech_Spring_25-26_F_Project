
<?php

session_start();

header(
    "Content-Type: application/json"
);

require_once('../Models/database.php');
require_once('../Models/database2.php');
require_once('../Models/database3.php');
require_once('../Models/database4.php');

if(!isset($_SESSION['user_id'])){

    echo json_encode([

        "success" => false,

        "message" =>
        "Login Required"
    ]);

    exit();
}

if(!isset($_POST['comment_id'])){

    echo json_encode([

        "success" => false
    ]);

    exit();
}

$comment_id =
$_POST['comment_id'];

$comment =
getCommentById($comment_id);

if(!$comment){

    echo json_encode([

        "success" => false
    ]);

    exit();
}

$current_user =
$_SESSION['user_id'];

$isAdmin =

isset($_SESSION['role'])

&&

$_SESSION['role']
== 'admin';

$isOwner =

$current_user
==
$comment['user_id'];

$isAuthor =

$current_user
==
$comment['author_id'];

if(

    !$isAdmin

    &&

    !$isOwner

    &&

    !$isAuthor
){

    echo json_encode([

        "success" => false,

        "message" =>
        "Unauthorized"
    ]);

    exit();
}

$result =
deleteComment($comment_id);

if($result){

    echo json_encode([

        "success" => true
    ]);
}

else{

    echo json_encode([

        "success" => false
    ]);
}
?>