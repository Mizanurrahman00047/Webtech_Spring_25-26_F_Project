
<?php

require_once(__DIR__ . '/../database/db.php');

require_once(__DIR__ . '/../Models/database.php');
require_once(__DIR__ . '/../Models/database3.php');
require_once(__DIR__ . '/../Models/database4.php');

function getAuthorArticles($author_id){

    $connection = connectDatabase();

    $sql = "SELECT

            articles.*,

            COUNT(comments.id)
            AS comment_count

            FROM articles

            LEFT JOIN comments

            ON articles.id =
            comments.article_id

            WHERE author_id=?

            GROUP BY articles.id

            ORDER BY articles.id DESC";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $author_id);
    $stmt->execute();
    return $stmt->get_result();
}

function getArticleById($id)
{
    $connection = connectDatabase();

    $sql = "SELECT * FROM articles WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}


function publish_scheduled(){

    $connection = connectDatabase();

    $sql = "UPDATE articles

            SET status='published'

            WHERE status='draft'

            AND publish_at IS NOT NULL

            AND publish_at <= NOW()";

    mysqli_query(
        $connection,
        $sql
    );
}

function toggleStatus($id){

    $connection = connectDatabase();

    $sql = "SELECT * FROM articles
            WHERE id=?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc(
        $result
    );

    if($row['status'] == 'draft'){

        $status = 'published';
    }

    else{

        $status = 'draft';
    }

    $sql2 = "UPDATE articles

             SET status=?

             WHERE id=?";

    $stmt2 = $connection->prepare($sql2);
    $stmt2->bind_param("si", $status, $id);
    $stmt2->execute();

    return $status;
}

function getAllCategories(){

    $connection = connectDatabase();

    $sql = "SELECT * FROM categories";

    return mysqli_query(
        $connection,
        $sql
    );
}

function addCategory($name){

    $connection = connectDatabase();

    $sql = "INSERT INTO categories(name)

            VALUES(?)";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $name);
    return $stmt->execute();
}

function categoryHasArticle($id){

    $connection = connectDatabase();

    $sql = "SELECT *

            FROM articles

            WHERE category_id=?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    return mysqli_num_rows(
        $result
    ) > 0;
}

function deleteCategory($id){

    $connection = connectDatabase();

    $sql = "DELETE FROM categories

            WHERE id=?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function getAllTags(){

    $connection = connectDatabase();

    $sql = "SELECT * FROM tags";

    return mysqli_query(
        $connection,
        $sql
    );
}

function addTag($name){

    $connection = connectDatabase();

    $sql = "INSERT INTO tags(name)

            VALUES(?)";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $name);
    return $stmt->execute();
}

function tagHasArticle($id){

    $connection = connectDatabase();

    $sql = "SELECT *

            FROM article_tags

            WHERE tag_id=?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    return mysqli_num_rows(
        $result
    ) > 0;
}

function deleteTag($id){

    $connection = connectDatabase();

    $sql = "DELETE FROM tags

            WHERE id=?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function addArticle($author_id, $category_id, $title, $body, $imageName, $status, $publish_at){
    $connection = connectDatabase();
    $sql = "INSERT INTO articles 
            (author_id, category_id, title, body, featured_image_path, status, publish_at)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iisssss", $author_id, $category_id, $title, $body, $imageName, $status, $publish_at);
    $stmt->execute();
    return $connection->insert_id; // returns new article's ID for tags
}

function createTagIfNotExists($name){
    $connection = connectDatabase();
    $sql = "INSERT IGNORE INTO tags (name) VALUES (?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
}

function getTagId($name){
    $connection = connectDatabase();
    $sql = "SELECT id FROM tags WHERE name = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['id'];
}

function insertArticleTag($article_id, $tag_id){
    $connection = connectDatabase();
    $sql = "INSERT IGNORE INTO article_tags (article_id, tag_id) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ii", $article_id, $tag_id);
    $stmt->execute();
}

function updateArticle($id, $title, $body, $imageName, $category_id, $status, $publish_at){
    $connection = connectDatabase();
    $sql = "UPDATE articles 
            SET title=?, body=?, featured_image_path=?, category_id=?, status=?, publish_at=?
            WHERE id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssssi", $title, $body, $imageName, $category_id, $status, $publish_at, $id);
    $stmt->execute();
}


?>
