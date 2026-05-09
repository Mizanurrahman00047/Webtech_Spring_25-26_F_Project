
<?php

function connectDatabase(){

    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'blog_news_database';

    $connection = new mysqli(
        $db_host,
        $db_user,
        $db_password,
        $db_name
    );

    if($connection->connect_error){

        die(
            "Could not Connect Database "
            . $connection->connect_error
        );
    }

    return $connection;
}


function registration(
    $name,
    $email,
    $hashedpassword,
    $role,
    $pending_author
){

    $connection = connectDatabase();

    //$socialLinksJson = json_encode(['pending_author' => $pending_author]);

    $sql = "INSERT INTO user_info
            (name, email, password_hash, role, pending_author)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(
        "ssssi",
        $name,
        $email,
        $hashedpassword,
        $role,
        $pending_author,
        
        // $socialLinksJson
    );

    if($stmt->execute()){

        echo "Registration successful";
        header("Location: ../Views/login.php");
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





function updateProfile(
    $id,
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
        $id
    );

    if($stmt->execute()){

        echo "Profile Updated";
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


function getAuthorArticles($id){

    $connection = connectDatabase();

    $sql = "SELECT *
            FROM articles
            WHERE author_id = ?
            AND status = 'published'
            ORDER BY created_at DESC";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(
        "i",
        $id
    );

    $stmt->execute();

    return $stmt->get_result();
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

function getRememberUsers(){

    $connection = connectDatabase();

    $sql = "SELECT *
            FROM user_info
            WHERE remember_token IS NOT NULL";

    return $connection->query($sql);
}

?>