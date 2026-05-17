
<?php

require_once(__DIR__ . '/../database/db.php');

function getPublishedArticles(){

    $connection = connectDatabase();

    $sql = "SELECT
            articles.*,
            user_info.name AS author_name,
            user_info.profile_pic_path,
            categories.name AS category_name,
            COUNT(likes.id) AS like_count

            FROM articles

            LEFT JOIN user_info
            ON articles.author_id = user_info.id

            LEFT JOIN categories
            ON articles.category_id = categories.id

            LEFT JOIN likes
            ON articles.id = likes.article_id

            WHERE articles.status='published'

            GROUP BY articles.id

            ORDER BY articles.created_at DESC";

    return mysqli_query($connection, $sql);
}

//catergoty filter ajax

function getArticlesByCategory($category_id){

    $connection = connectDatabase();

    $sql = "SELECT
            articles.*,
            user_info.name AS author_name,
            user_info.profile_pic_path,
            categories.name AS category_name,
            COUNT(likes.id) AS like_count

            FROM articles

            LEFT JOIN user_info
            ON articles.author_id = user_info.id

            LEFT JOIN categories
            ON articles.category_id = categories.id

            LEFT JOIN likes
            ON articles.id = likes.article_id

            WHERE articles.status='published'
            AND category_id=?

            GROUP BY articles.id

            ORDER BY articles.created_at DESC";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    return $stmt->get_result();
}

//live search
function searchArticles($q){

    $connection = connectDatabase();

    $q = '%' . $q . '%';
    $sql = "SELECT DISTINCT
            articles.id,
            articles.title

            FROM articles

            LEFT JOIN article_tags
            ON articles.id = article_tags.article_id

            LEFT JOIN tags
            ON article_tags.tag_id = tags.id

            WHERE articles.status='published'

            AND
            (
                articles.title LIKE ?
                OR
                tags.name LIKE ?
            )

            LIMIT 8";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $q, $q);
    $stmt->execute();
    return $stmt->get_result();
}

//single article 

function getArticleDetails($id){

    $connection = connectDatabase();

    $sql = "SELECT
            articles.*,
            user_info.name AS author_name,
            user_info.profile_pic_path,
            categories.name AS category_name

            FROM articles

            LEFT JOIN user_info
            ON articles.author_id = user_info.id

            LEFT JOIN categories
            ON articles.category_id = categories.id

            WHERE articles.id=?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    return mysqli_fetch_assoc($result);
}

//increment article view count

function incrementViewCount($id){

    $connection = connectDatabase();

    $sql = "UPDATE articles

            SET view_count =
            view_count + 1

            WHERE id=?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

//get article tags

function getArticleTags($article_id){

    $connection = connectDatabase();

    $sql = "SELECT tags.*

            FROM tags

            LEFT JOIN article_tags
            ON tags.id = article_tags.tag_id

            WHERE article_tags.article_id=?";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    return $stmt->get_result();
}

// like toggle

function toggleLike($article_id, $user_id){

    $connection = connectDatabase();

    $check = "SELECT *
              FROM likes
              WHERE article_id=?
              AND user_id=?";

    $stmt = $connection->prepare($check);
    $stmt->bind_param("ii", $article_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if(mysqli_num_rows($result) > 0){

        $sql = "DELETE FROM likes
                WHERE article_id=?
                AND user_id=?";

        $stmt2 = $connection->prepare($sql);
        $stmt2->bind_param("ii", $article_id, $user_id);
        $stmt2->execute();

        $liked = false;
    }

    else{

        $sql = "INSERT INTO likes
                (article_id, user_id)
                VALUES
                (?,?)";

        $stmt2 = $connection->prepare($sql);
        $stmt2->bind_param("ii", $article_id, $user_id);
        $stmt2->execute();

        $liked = true;
    }

    $countQuery = "SELECT COUNT(*) AS total
                   FROM likes
                   WHERE article_id=?";

    $stmt3 = $connection->prepare($countQuery);
    $stmt3->bind_param("i", $article_id);
    $stmt3->execute();
    $countResult = $stmt3->get_result();

    $countRow = mysqli_fetch_assoc(
        $countResult
    );

    return [

        "liked" => $liked,

        "count" => $countRow['total']
    ];
}



?>