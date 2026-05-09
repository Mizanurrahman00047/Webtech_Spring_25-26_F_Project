
<?php

session_start();

require_once('../Models/database.php');

if(isset($_POST['update_profile'])){

    $bio = trim($_POST['bio']);

    $twitter = trim($_POST['twitter']);

    $github = trim($_POST['github']);

    $profile_pic = $_FILES['profile_pic'];

    $imageName = "";

    // IMAGE VALIDATION

    if($profile_pic['size'] <= 1048576){

        $allowedTypes = [
            'image/jpeg',
            'image/png'
        ];

        if(in_array(
            $profile_pic['type'],
            $allowedTypes
        )){

            $imageName =
                time() .
                "_" .
                basename($profile_pic['name']);

            $destination =
                "../public/uploads/avatars/"
                . $imageName;

            move_uploaded_file(
                $profile_pic['tmp_name'],
                $destination
            );
        }

        else{

            echo "Only JPG and PNG allowed";
            exit();
        }
    }

    else{

        echo "Image size must be under 1MB";
        exit();
    }

    // JSON SOCIAL LINKS

    $social_links = json_encode([
        "twitter" => $twitter,
        "github" => $github
    ]);

    updateProfile(
        $_SESSION['user_id'],
        $bio,
        $imageName,
        $social_links
    );
}
?>