
<?php

session_start();

header(
    "Content-Type: application/json"
);

require_once('../../Models/database.php');
require_once('../../Models/database2.php');
require_once('../../Models/database3.php');
require_once('../../Models/database4.php');

if(!isset($_SESSION['user_id'])){

    echo json_encode([

        "success" => false,

        "message" =>
        "Login Required"
    ]);

    exit();
}

if(

    !isset($_POST['comment_id'])

    ||

    !isset($_POST['reason'])
){

    echo json_encode([

        "success" => false
    ]);

    exit();
}

$comment_id =
$_POST['comment_id'];

$reason =
trim($_POST['reason']);

if(strlen($reason) < 3){

    echo json_encode([

        "success" => false,

        "message" =>
        "Reason too short"
    ]);

    exit();
}

$result = reportComment(

    $comment_id,

    $_SESSION['user_id'],

    $reason
);

if($result == "already"){

    echo json_encode([

        "success" => false,

        "message" =>
        "Already Reported"
    ]);
}

elseif($result == "success"){

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