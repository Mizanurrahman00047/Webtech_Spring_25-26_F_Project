<?php

session_start();

require_once('../Models/database.php');

if(
    !isset($_SESSION['role'])
    ||
    $_SESSION['role'] !== 'admin'
){
    exit("Access Denied");
}

$result = getAllUsers();

$users = [];

while($row = $result->fetch_assoc()){
    $users[] = $row;
}

$json = json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

if($json === false){
    exit("Failed to encode JSON: " . json_last_error_msg());
}

$filePath = __DIR__ . '/../Public/user_info.json';

if(file_put_contents($filePath, $json) === false){
    exit("Failed to write JSON file.");
}

header('Content-Type: application/json');
echo $json;
