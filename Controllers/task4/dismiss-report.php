
<?php

session_start();

header(
    "Content-Type: application/json"
);

require_once('../../Models/database.php');
require_once('../../Models/database2.php');
require_once('../../Models/database3.php');
require_once('../../Models/database4.php');

if(

!isset($_SESSION['role'])

||

$_SESSION['role'] != 'admin'
){

    echo json_encode([

        "success" => false
    ]);

    exit();
}

if(!isset($_POST['report_id'])){

    echo json_encode([

        "success" => false
    ]);

    exit();
}

$result = dismissReport(
    $_POST['report_id']
);

echo json_encode([

    "success" => $result
]);

?>