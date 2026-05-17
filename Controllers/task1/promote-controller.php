
<?php

session_start();

header("Content-Type: application/json");

require_once(__DIR__ . '/../../Models/database.php');
require_once(__DIR__ . '/../../Models/database2.php');
require_once(__DIR__ . '/../../Models/database3.php');
require_once(__DIR__ . '/../../Models/database4.php');

if(
    !isset($_SESSION['role'])
    ||
    $_SESSION['role'] != 'admin'
){

    echo json_encode([
        "success" => false,
        "message" => "Access denied. Admin session not found."
    ]);

    exit();
}

if(!isset($_POST['user_id'])){

    echo json_encode([
        "success" => false,
        "message" => "Missing user ID."
    ]);

    exit();
}

$user_id = $_POST['user_id'];

$result = promoteAuthor($user_id);

echo json_encode([
    "success" => $result,
    "message" => $result
        ? "User promoted successfully."
        : "Could not promote user."
]);
?>