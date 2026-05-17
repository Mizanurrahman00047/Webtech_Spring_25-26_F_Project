
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
){

    echo json_encode([

        "success" => false
    ]);

    exit();
}

$article_id = $_POST['article_id'];

$user_id = $_SESSION['user_id'];

$result = toggleLike(
    $article_id,
    $user_id
);

echo json_encode([

    "success" => true,

    "liked" => $result['liked'],

    "count" => $result['count']
]);

?>