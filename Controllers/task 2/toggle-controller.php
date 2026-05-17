
<?php

session_start();

header(
"Content-Type: application/json"
);

require_once('../Models/database.php');
require_once('../Models/database2.php');
require_once('../Models/database3.php');
require_once('../Models/database4.php');

if(!isset($_POST['id'])){

    echo json_encode([]);

    exit();
}

$status = toggleStatus(
    $_POST['id']
);

echo json_encode([

    "status" => $status
]);

?>