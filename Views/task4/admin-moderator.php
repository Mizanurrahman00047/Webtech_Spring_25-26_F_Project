
<?php

session_start();

require_once(__DIR__ . '/../../Models/database.php');
require_once(__DIR__ . '/../../Models/database2.php');
require_once(__DIR__ . '/../../Models/database3.php');
require_once(__DIR__ . '/../../Models/database4.php');

if(

!isset($_SESSION['role'])

||

$_SESSION['role'] != 'admin'
){

    exit("Access Denied");
}

$reports =
getReportedComments();

?>

<!DOCTYPE html>
<html>

<head>

    <title>
        Moderation Dashboard
    </title>

</head>

<body>

<h1>

Reported Comments

</h1>

<?php

while(
    $row =
    mysqli_fetch_assoc(
        $reports
    )
){
?>

<div

id="report<?php
echo $row['report_id'];
?>"

style="
border:1px solid black;
padding:10px;
margin:10px;
">

<h3>

Article:
<?php
echo $row['title'];
?>

</h3>

<p>

<b>Comment:</b>

<?php
echo $row['body'];
?>

</p>

<p>

<b>Reason:</b>

<?php
echo $row['reason'];
?>

</p>

<p>

<b>Reported By:</b>

<?php
echo $row['reporter_name'];
?>

</p>

<button

onclick="
deleteReportedComment(
<?php
echo $row['comment_id'];
?>,

<?php
echo $row['report_id'];
?>)
">

Delete Comment

</button>

<button

onclick="
dismissReport(
<?php
echo $row['report_id'];
?>)
">

Dismiss

</button>

</div>

<?php
}
?>

<script src="../ajax/script4.js"></script>

</body>
</html>