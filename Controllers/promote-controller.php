
<?php

session_start();

header("Content-Type: application/json");

require_once('../Models/database.php');

if($_SESSION['role'] != 'admin'){

    echo json_encode([
        "success" => false
    ]);

    exit();
}

$user_id = $_POST['user_id'];

$result = promoteAuthor($user_id);

echo json_encode([
    "success" => $result
]);
?>