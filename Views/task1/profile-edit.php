
<?php

session_start();

if(!isset($_SESSION['user_id'])){

    exit("Login Required");
}
    
?>

<!DOCTYPE html>
<html>

<head>

    <title>Profile Edit</title>

</head>

<body>

<form
action="../Controllers/task1/Profile-Controller.php"
method="POST"
enctype="multipart/form-data">

    <textarea
    name="bio"
    placeholder="Enter Bio"></textarea>

    <br><br>

    <input
    type="text"
    name="twitter"
    placeholder="Twitter URL">

    <br><br>

    <input
    type="text"
    name="github"
    placeholder="GitHub URL">

    <br><br>

    <input
    type="file"
    name="profile_pic">

    <br><br>

    <input
    type="submit"
    name="update_profile"
    value="Update Profile">

</form>

</body>

</html>