
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

        "message" => "Login Required"
    ]);

    exit();
}

if(

    !isset($_POST['article_id'])

    ||

    !isset($_POST['body'])
){

    echo json_encode([

        "success" => false
    ]);

    exit();
}

$article_id =
$_POST['article_id'];

$body =
trim($_POST['body']);

if(strlen($body) < 5){

    echo json_encode([

        "success" => false,

        "message" =>
        "Minimum 5 characters"
    ]);

    exit();
}

$user_id =
$_SESSION['user_id'];

$result = addComment(

    $article_id,

    $user_id,

    $body
);

if($result){

    $connection =
    connectDatabase();

    $sql = "SELECT

            comments.*,

            user_info.name,

            user_info.profile_pic_path

            FROM comments

            LEFT JOIN user_info

            ON comments.user_id =
            user_info.id

            WHERE comments.id =
            LAST_INSERT_ID()";

    $comment =
    mysqli_fetch_assoc(

        mysqli_query(
            $connection,
            $sql
        )
    );

    echo json_encode([

        "success" => true,

        "comment" => $comment
    ]);
}

else{

    echo json_encode([

        "success" => false
    ]);
}
?>