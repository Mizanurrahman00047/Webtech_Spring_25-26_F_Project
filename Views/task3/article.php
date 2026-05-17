
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

$tags = getArticleTags($id);

?>

<!DOCTYPE html>
<html>

<head>

    <title>
        <?php
        echo $article['title'];
        ?>
    </title>

</head>

<body>

<!-- FEATURED IMAGE -->

<img
src="../public/uploads/articles/<?php
echo $article['featured_image_path'];
?>"
width="500">

<br><br>

<!-- TITLE -->

<h1>

<?php
echo $article['title'];
?>

</h1>

<!-- AUTHOR -->

<a href="
author-profile.php?id=<?php
echo $article['author_id'];
?>
">

<img
src="../public/uploads/avatars/<?php
echo $article['profile_pic_path'];
?>"
width="50">

<?php
echo $article['author_name'];
?>

</a>

<br><br>

<!-- DATE -->

Published:
<?php
echo $article['created_at'];
?>

<br><br>

<!-- CATEGORY -->

<span
style="
border:1px solid black;
padding:5px;
">

<?php
echo $article['category_name'];
?>

</span>

<br><br>

<!-- TAGS -->

<?php

while(
    $tag =
    mysqli_fetch_assoc($tags)
){
?>

<span
style="
border:1px solid gray;
padding:5px;
margin:5px;
">

<?php
echo $tag['name'];
?>

</span>

<?php
}
?>

<hr>

<!-- ARTICLE BODY -->

<p>

<?php
echo nl2br(
    $article['body']
);
?>

</p>

<hr>

<!-- VIEW COUNT -->

Views:
<?php
echo $article['view_count'];
?>

<br><br>

<button
id="likeBtn"

data-id="<?php
echo $article['id'];
?>">

Like

</button>

<span
id="likeCount">

<?php

$connection = connectDatabase();

$likeQuery = "SELECT COUNT(*) AS total
              FROM likes
              WHERE article_id='
              $id'";

$likeResult = mysqli_query(
    $connection,
    $likeQuery
);

$likeRow = mysqli_fetch_assoc(
    $likeResult
);

echo $likeRow['total'];

?>

</span>
Likes

<hr>

<h2>Comments</h2>

<?php

if(isset($_SESSION['user_id'])){
?>

<textarea
id="commentBody"
placeholder="Write comment">
</textarea>

<br>

<button id="commentBtn">

Post Comment

</button>

<?php
}

else{
?>

<a href="login.php">

Login to comment

</a>

<?php
}
?>

<hr>

<div id="commentList">

<?php
$comments = getComments($article['id']);

while(
    $comment =
    mysqli_fetch_assoc(
        $comments
    )
){
?>

<div
id="comment<?php
echo $comment['id'];
?>">

<img
src="../public/uploads/avatars/<?php
echo $comment['profile_pic_path'];
?>"
width="40">

<b>

<?php
echo $comment['name'];
?>

</b>

<p>

<?php
echo $comment['body'];
?>

</p>

<!-- REPORT -->

<?php

if(isset($_SESSION['user_id'])){
?>

<a href="#"
onclick="
showReportForm(
<?php
echo $comment['id'];
?>)
">

🚩 Report

</a>

<div
id="reportForm<?php
echo $comment['id'];
?>"

style="display:none;">

<input
type="text"

id="reason<?php
echo $comment['id'];
?>"

placeholder="Reason">

<button
onclick="
submitReport(
<?php
echo $comment['id'];
?>)
">

Submit

</button>

</div>

<?php
}
?>

<!-- DELETE -->

<?php

if(
isset($_SESSION['user_id'])

&&

(
$_SESSION['user_id']
==
$comment['user_id']

||

$_SESSION['role']
==
'admin'

||

$_SESSION['user_id']
==
$comment['author_id']
)
){
?>

<a href="#"
onclick="
deleteComment(
<?php
echo $comment['id'];
?>)
">

Delete

</a>

<?php
}
?>

<hr>

</div>

<?php
}
?>

</div>

<script src="../ajax/script3.js"></script>
</body>

</html>