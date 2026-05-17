
<?php

require_once(__DIR__ . '/../database/db.php');
//postcomment

function addComment(
    $article_id,
    $user_id,
    $body
){

    $connection = connectDatabase();

    $sql = "INSERT INTO comments
            (
                article_id,
                user_id,
                body
            )

            VALUES
            (?, ?, ?)";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(

        "iis",

        $article_id,
        $user_id,
        $body
    );

    return $stmt->execute();
}

// get comments

function getComments($article_id){

    $connection = connectDatabase();

    $sql = "SELECT

            comments.*,

            user_info.name,

            user_info.profile_pic_path,

            articles.author_id

            FROM comments

            LEFT JOIN user_info
            ON comments.user_id =
            user_info.id

            LEFT JOIN articles
            ON comments.article_id =
            articles.id

            WHERE comments.article_id=?

            ORDER BY comments.id DESC";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(
        "i",
        $article_id
    );

    $stmt->execute();

    return $stmt->get_result();
}

// report comment

function reportComment(
    $comment_id,
    $reported_by,
    $reason
){

    $connection = connectDatabase();

    // check if already reported

      $check = "SELECT *

              FROM reported_comments

              WHERE comment_id=?

              AND reported_by=?";

    $stmt = $connection->prepare($check);

    $stmt->bind_param(

        "ii",

        $comment_id,
        $reported_by
    );

    $stmt->execute();

    $result =
    $stmt->get_result();

    if($result->num_rows > 0){

        return "already";
    }

    // insert report

    $sql = "INSERT INTO reported_comments
            (
                comment_id,
                reported_by,
                reason
            )

            VALUES
            (?, ?, ?)";

    $stmt2 = $connection->prepare($sql);

    $stmt2->bind_param(

        "iis",

        $comment_id,
        $reported_by,
        $reason
    );

    if($stmt2->execute()){

        return "success";
    }

    return "failed";
}

// delete comment

function deleteComment($id){

    $connection = connectDatabase();

    $sql = "DELETE FROM comments
            WHERE id=?";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(
        "i",
        $id
    );

    return $stmt->execute();
}

// get single comment

function getCommentById($id){

    $connection = connectDatabase();

    $sql = "SELECT * FROM comments
            WHERE id=?";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(
        "i",
        $id
    );

    $stmt->execute();

    return $stmt->get_result()
                ->fetch_assoc();
}

function getReportedComments(){

    $connection = connectDatabase();

    $sql = "SELECT

            reported_comments.id
            AS report_id,

            reported_comments.reason,

            comments.id
            AS comment_id,

            comments.body,

            articles.title,

            reporter.name
            AS reporter_name

            FROM reported_comments

            LEFT JOIN comments
            ON reported_comments.comment_id =
            comments.id

            LEFT JOIN articles
            ON comments.article_id =
            articles.id

            LEFT JOIN user_info
            AS reporter

            ON reported_comments.reported_by =
            reporter.id

            ORDER BY
            reported_comments.id DESC";

    return mysqli_query(
        $connection,
        $sql
    );
}

function dismissReport($report_id){

    $connection = connectDatabase();

    $sql = "DELETE FROM reported_comments
            WHERE id=?";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(
        "i",
        $report_id
    );

    return $stmt->execute();
}

?>