
<?php

require_once(__DIR__ . '/../database/db.php');


function registration(
    $name,
    $email,
    $hashedPassword,
    $role,
    $pending_author
){

    $connection = connectDatabase();


    $sql = "INSERT INTO user_info
            (name, email, password_hash, role, pending_author)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(
        "ssssi",
        $name,
        $email,
        $hashedPassword,
        $role,
        $pending_author
    );

    if($stmt->execute()){

        echo "Registration successful";
        header("Location: ../Views/task1/login.php");
    }

    else{

        echo "Error: " . $stmt->error;
    }
}

function login($email){

    $connection = connectDatabase();

    $sql = "SELECT * FROM user_info
            WHERE email = ?";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(
        "s",
        $email
    );

    $stmt->execute();

    return $stmt->get_result();
}


function updateRememberToken(
    $token,
    $user_id
){

    $connection = connectDatabase();

    $sql = "UPDATE user_info
            SET remember_token = ?
            WHERE id = ?";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(
        "si",
        $token,
        $user_id
    );

    $stmt->execute();
}


function getRememberUsers(){

    $connection = connectDatabase();

    $sql = "SELECT *
            FROM user_info
            WHERE remember_token IS NOT NULL";

    return $connection->query($sql);
}

function getAllUsers(){

    $connection = connectDatabase();

    $sql = "SELECT *
            FROM user_info";

    return $connection->query($sql);
}


function promoteAuthor($id){

    $connection = connectDatabase();

    $sql = "UPDATE user_info
            SET role = 'author',
                pending_author = 0
            WHERE id = ?";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(
        "i",
        $id
    );

    return $stmt->execute();
}

function updateProfile(
    $user_id,
    $bio,
    $profile_pic_path,
    $social_links
){

    $connection = connectDatabase();

    $sql = "UPDATE user_info
            SET bio = ?,
                profile_pic_path = ?,
                social_links = ?
            WHERE id = ?";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(

        "sssi",

        $bio,
        $profile_pic_path,
        $social_links,
        $user_id
    );

    if($stmt->execute()){

        echo "Profile Updated";
        header("Location: ../Views/task1/author-profile.php");
        exit();
    }

    else{

        echo "Update Failed";
    }
}

function getAuthor($id){

    $connection = connectDatabase();

    $sql = "SELECT *
            FROM user_info
            WHERE id = ?";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(
        "i",
        $id
    );

    $stmt->execute();

    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

?>