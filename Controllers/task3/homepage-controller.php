
<?php

require_once('../../Models/database.php');
require_once('../../Models/database2.php');
require_once('../../Models/database3.php');
require_once('../../Models/database4.php');

// Fetch all categories for the filter dropdown
$category_id = getAllCategories();

if(
    isset($_GET['category_id'])
){

    $articles =
    getArticlesByCategory(
        $_GET['category_id']
    );
}

else{

    $articles =
    getPublishedArticles();
}

// Always output articles as HTML (for both initial page load and AJAX calls)
while($row = mysqli_fetch_assoc($articles)){
    ?>

    <div class="article-card">

        <div class="article-image">
            <img src="../../public/uploads/articles/<?php echo $row['featured_image_path']; ?>">
        </div>

        <h3>
            <a href="article.php?id=<?php echo $row['id']; ?>">
                <?php echo $row['title']; ?>
            </a>
        </h3>

        <div class="article-meta">
            <img src="../../public/uploads/avatars/<?php echo $row['profile_pic_path']; ?>">
            <span><?php echo $row['author_name']; ?></span>
        </div>

        <p><?php echo $row['created_at']; ?></p>

        <span class="category">
            <?php echo $row['category_name']; ?>
        </span>

        <p>❤️ Likes: <?php echo $row['like_count']; ?></p>

    </div>

    <?php
    }
?>
