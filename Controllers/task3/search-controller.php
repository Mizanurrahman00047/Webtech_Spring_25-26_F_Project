
<?php

header(
    "Content-Type: application/json"
);

require_once('../../Models/database.php');
require_once('../../Models/database2.php');
require_once('../../Models/database3.php');
require_once('../../Models/database4.php');

if(!isset($_GET['q'])){

    echo json_encode([]);

    exit();
}

$q = $_GET['q'];

$result = searchArticles($q);

 $data = [];

while($row = mysqli_fetch_assoc($result)){

    $data[] = [
        "id" => $row['id'],
        "title" => $row['title'],
        "author" => isset($row['author_name']) ? $row['author_name'] : null,
        "category" => isset($row['category_name']) ? $row['category_name'] : null
    ];
}

echo json_encode($data);

?>