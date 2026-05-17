
<?php

session_start();

require_once(__DIR__ . '/../../Models/database.php');
require_once(__DIR__ . '/../../Models/database2.php');
require_once(__DIR__ . '/../../Models/database3.php');
require_once(__DIR__ . '/../../Models/database4.php');

if(isset($_POST['update_profile'])){

    if(!isset($_SESSION['user_id'])){

        exit("Login Required");
    }

    $bio = trim($_POST['bio']);

    $twitter = trim($_POST['twitter']);

    $github = trim($_POST['github']);

    $profile_pic_path = "";

    // IMAGE CHECK

    if(isset($_FILES['profile_pic'])){

        $profile_pic = $_FILES['profile_pic'];

        // MAX 1 MB

        if($profile_pic['size'] <= 1048576){

            $allowedTypes = [
                'image/jpeg',
                'image/png'
            ];

            // JPG / PNG ONLY

            if(
                in_array(
                    $profile_pic['type'],
                    $allowedTypes
                )
            ){

                $profile_pic_path =
                    time()
                    . "_"
                    . basename(
                        $profile_pic['name']
                    );

                $destination =
                    "../public/uploads/avatars/"
                    . $profile_pic_path;

                move_uploaded_file(
                    $profile_pic['tmp_name'],
                    $destination
                );
            }

            else{

                exit(
                    "Only JPG and PNG allowed"
                );
            }
        }

        else{

            exit(
                "Image size must be under 1MB"
            );
        }
    }

    // JSON SOCIAL LINKS

    $social_links = json_encode([

        "twitter" => $twitter,

        "github" => $github
    ]);

    updateProfile(

        $_SESSION['user_id'],

        $bio,

        $profile_pic_path,

        $social_links
    );
}
?>