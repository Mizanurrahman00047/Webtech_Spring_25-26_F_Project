<?php

session_start();

header("Content-Type: application/json");

// Test 1: Check if session exists
$response = [
    "session_started" => true,
    "user_id_set" => isset($_SESSION['user_id']),
    "user_id_value" => $_SESSION['user_id'] ?? null,
    "post_data_received" => $_POST,
    "get_data_received" => $_GET,
    "request_method" => $_SERVER['REQUEST_METHOD']
];

// Test 2: Try to connect to database
try {
    require_once('../../database/db.php');
    $connection = connectDatabase();
    $response["database_connected"] = true;
} catch (Exception $e) {
    $response["database_connected"] = false;
    $response["database_error"] = $e->getMessage();
}

// Test 3: Check if POST values exist
if (isset($_POST['article_id']) && isset($_POST['body'])) {
    $response["post_values_present"] = true;
    $response["article_id"] = $_POST['article_id'];
    $response["body_length"] = strlen($_POST['body']);
} else {
    $response["post_values_present"] = false;
}

echo json_encode($response);
?>
