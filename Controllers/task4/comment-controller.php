
<?php

session_start();

header("Content-Type: application/json");

error_log("Comment controller called - POST data: " . json_encode($_POST));
error_log("Session user_id: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NOT SET'));

require_once('../../Models/database.php');
require_once('../../Models/database2.php');
require_once('../../Models/database3.php');
require_once('../../Models/database4.php');

if(!isset($_SESSION['user_id'])){
    error_log("User not logged in");
    echo json_encode([
        "success" => false,
        "message" => "Login Required"
    ]);
    exit();
}

if(!isset($_POST['article_id']) || !isset($_POST['body'])){
    error_log("Missing POST parameters");
    echo json_encode([
        "success" => false,
        "message" => "Missing article_id or body"
    ]);
    exit();
}

$article_id = $_POST['article_id'];
$body = trim($_POST['body']);

error_log("Article ID: $article_id, Body: $body");

if(strlen($body) < 5){
    echo json_encode([
        "success" => false,
        "message" => "Minimum 5 characters"
    ]);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $connection = connectDatabase();
    
    if (!$connection) {
        error_log("Database connection failed");
        echo json_encode([
            "success" => false,
            "message" => "Database connection failed"
        ]);
        exit();
    }

    $sql = "INSERT INTO comments
            (
                article_id,
                user_id,
                body
            )
            VALUES
            (?, ?, ?)";

    $stmt = $connection->prepare($sql);
    
    if (!$stmt) {
        error_log("Prepare failed: " . $connection->error);
        echo json_encode([
            "success" => false,
            "message" => "Query prepare failed: " . $connection->error
        ]);
        exit();
    }
    
    $stmt->bind_param("iis", $article_id, $user_id, $body);

    if($stmt->execute()){
        error_log("Comment inserted successfully");
        $comment_id = $connection->insert_id;

        $selectSql = "SELECT
                comments.*,
                user_info.name,
                user_info.profile_pic_path
                FROM comments
                LEFT JOIN user_info
                ON comments.user_id = user_info.id
                WHERE comments.id = ?";

        $selectStmt = $connection->prepare($selectSql);
        $selectStmt->bind_param("i", $comment_id);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $comment = $result->fetch_assoc();

        error_log("Comment fetched: " . json_encode($comment));

        echo json_encode([
            "success" => true,
            "comment" => $comment
        ]);
    } else {
        error_log("Execute failed: " . $stmt->error);
        echo json_encode([
            "success" => false,
            "message" => "Failed to add comment: " . $stmt->error
        ]);
    }
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}
?>