
<?php

session_start();

require_once('../Models/database.php');
require_once('../Models/database2.php');
require_once('../Models/database3.php');
require_once('../Models/database4.php');

if(
    !isset($_SESSION['user_id'])
    &&
    isset($_COOKIE['remember_token'])
){

    $token = $_COOKIE['remember_token'];

    $user = getRememberUsers();

    while($row = $user->fetch_assoc()){

        if(
            password_verify(
                $token,
                $row['remember_token']
            )
        ){

            $_SESSION['user_id'] = $row['id'];

            $_SESSION['name'] = $row['name'];

            $_SESSION['role'] = $row['role'];

            break;
        }
    }
}
?>