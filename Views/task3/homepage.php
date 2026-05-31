
<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="../../Views/design/homepage.css">
</head>

<body>

<div class="container">

    <!-- SEARCH -->
    <input type="text" id="searchInput" placeholder="Search Articles">
    <div id="searchResults" style="display: none; border: 1px solid #ccc; padding: 10px; margin-top: 5px;"></div>

    <header>
        <h1>Blog & News</h1>
    </header>

    <!-- CATEGORY FILTER -->
    <div id="categories">
       
    <button onclick="loadArticles('all')">All</button>
        
        <?php 
        require_once(__DIR__ . '/../../Models/database2.php');
        $category_id = getAllCategories();
        while($category = mysqli_fetch_assoc($category_id)) { ?>
            <button onclick="loadArticles('<?php echo $category['id']; ?>')">
                <?php echo $category['name']; ?>
            </button>
        <?php } ?>
    </div>

    <hr>

    <!-- ARTICLES -->
    <div id="articleGrid">
        <!-- Articles will be loaded here via JavaScript -->
    </div>

</div>

<script src="../../ajax/script3.js"></script>

<script>
// Load all articles when page first loads
document.addEventListener('DOMContentLoaded', function() {
    loadArticles('all');
});
</script>

</body>
</html>