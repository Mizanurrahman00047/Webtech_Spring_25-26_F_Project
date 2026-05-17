<?php

session_start();

require_once(__DIR__ . '/../../Models/database.php');
require_once(__DIR__ . '/../../Models/database2.php');
require_once(__DIR__ . '/../../Models/database3.php');
require_once(__DIR__ . '/../../Models/database4.php');

if(!isset($_GET['id'])){
    exit("Article ID Missing");
}

$id = $_GET['id'];

incrementViewCount($id);

$article = getArticleDetails($id);

if(!$article){
    exit("Article Not Found");
}

$tags = getArticleTags($id);

// Get like count safely using prepared statement
$connection = connectDatabase();
$likeStmt = $connection->prepare("SELECT COUNT(*) AS total FROM likes WHERE article_id = ?");
$likeStmt->bind_param("i", $id);
$likeStmt->execute();
$likeRow = $likeStmt->get_result()->fetch_assoc();
$likeCount = $likeRow['total'];

$comments = getComments($article['id']);

?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo htmlspecialchars($article['title']); ?></title>
</head>

<body>

<!-- FEATURED IMAGE -->
<?php if(!empty($article['featured_image_path'])){ ?>
<img src="../../public/uploads/articles/<?php echo $article['featured_image_path']; ?>" width="500">
<br><br>
<?php } ?>

<!-- TITLE -->
<h1><?php echo htmlspecialchars($article['title']); ?></h1>

<!-- AUTHOR -->
<a href="author-profile.php?id=<?php echo $article['author_id']; ?>">

    <?php if(!empty($article['profile_pic_path'])){ ?>
    <img src="../../public/uploads/avatars/<?php echo $article['profile_pic_path']; ?>" width="50">
    <?php } ?>

    <?php echo htmlspecialchars($article['author_name']); ?>
</a>

<br><br>

<!-- DATE -->
Published: <?php echo $article['created_at']; ?>

<br><br>

<!-- CATEGORY -->
<span style="border:1px solid black; padding:5px;">
    <?php echo htmlspecialchars($article['category_name']); ?>
</span>

<br><br>

<!-- TAGS -->
<?php while($tag = mysqli_fetch_assoc($tags)){ ?>
<span style="border:1px solid gray; padding:5px; margin:5px;">
    <?php echo htmlspecialchars($tag['name']); ?>
</span>
<?php } ?>

<hr>

<!-- ARTICLE BODY -->
<p><?php echo nl2br(htmlspecialchars($article['body'])); ?></p>

<hr>

<!-- VIEW COUNT -->
Views: <?php echo $article['view_count']; ?>

<br><br>

<!-- LIKE BUTTON -->
<button id="likeBtn" data-id="<?php echo $article['id']; ?>">
    Like
</button>

<span id="likeCount"><?php echo $likeCount; ?></span> Likes

<hr>

<h2>Comments</h2>

<?php if(isset($_SESSION['user_id'])){ ?>

    <textarea id="commentBody" placeholder="Write a comment..."></textarea>
    <br>
    <!-- data-article attribute passes article ID to script3.js without PHP in JS -->
    <button id="commentBtn" data-article="<?php echo $article['id']; ?>">
        Post Comment
    </button>

<?php } else { ?>

    <a href="login.php">Login to comment</a>

<?php } ?>

<hr>

<!-- COMMENTS LIST -->
<div id="commentList">

<?php while($comment = mysqli_fetch_assoc($comments)){ ?>

    <div id="comment<?php echo $comment['id']; ?>">

        <?php if(!empty($comment['profile_pic_path'])){ ?>
        <img src="../../public/uploads/avatars/<?php echo $comment['profile_pic_path']; ?>" width="40">
        <?php } ?>

        <b><?php echo htmlspecialchars($comment['name']); ?></b>

        <p><?php echo htmlspecialchars($comment['body']); ?></p>

        <!-- REPORT BUTTON -->
        <?php if(isset($_SESSION['user_id'])){ ?>

            <a href="#" onclick="showReportForm(<?php echo $comment['id']; ?>)">
                🚩 Report
            </a>

            <div id="reportForm<?php echo $comment['id']; ?>" style="display:none;">
                <input type="text" id="reason<?php echo $comment['id']; ?>" placeholder="Reason">
                <button onclick="submitReport(<?php echo $comment['id']; ?>)">Submit</button>
            </div>

        <?php } ?>

        <!-- DELETE BUTTON -->
        <?php if(
            isset($_SESSION['user_id'])
            && (
                $_SESSION['user_id'] == $comment['user_id']
                || $_SESSION['role'] == 'admin'
                || $_SESSION['user_id'] == $comment['author_id']
            )
        ){ ?>

            <a href="#" onclick="deleteComment(<?php echo $comment['id']; ?>)">
                🗑 Delete
            </a>

        <?php } ?>

        <hr>

    </div>

<?php } ?>

</div>

<script src="../../ajax/script3.js"></script>

</body>
</html>