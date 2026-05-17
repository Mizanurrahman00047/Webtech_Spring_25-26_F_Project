<?php

session_start();

require_once(__DIR__ . '/../../Models/database.php');
require_once(__DIR__ . '/../../Models/database2.php');
require_once(__DIR__ . '/../../Models/database3.php');
require_once(__DIR__ . '/../../Models/database4.php');

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'author'){
    exit("Access Denied");
}

$title       = trim($_POST['title']);
$body        = trim($_POST['body']);
$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;
$status      = $_POST['status'];
$publish_at  = !empty($_POST['publish_at']) ? $_POST['publish_at'] : null;
$tags        = explode(',', $_POST['tags']);

if(!$category_id){
    exit("Please select a category.");
}

$imageName = "";

if(isset($_FILES['image']) && $_FILES['image']['size'] > 0){

    $uploadDir = __DIR__ . '/../../public/uploads/articles/';

    if(!is_dir($uploadDir)){
        mkdir($uploadDir, 0755, true);
    }

    $imageName = time() . "_" . basename($_FILES['image']['name']);

    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
}

$article_id = addArticle(
    $_SESSION['user_id'],
    $category_id,
    $title,
    $body,
    $imageName,
    $status,
    $publish_at
);

foreach($tags as $tag){
    $tag = trim($tag);
    if($tag != ""){
        createTagIfNotExists($tag);
        $tag_id = getTagId($tag);
        insertArticleTag($article_id, $tag_id);
    }
}

header("Location: ../../Views/task2/dashboard.php");
exit();
?>