
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
    $password,
    $role,
    $pending_author
){

    $connection = connectDatabase();

    $socialLinksJson = json_encode(['pending_author' => $pending_author]);

    $sql = "INSERT INTO user_info
            (name, email, password_hash, role, pending_author, social_links)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $connection->prepare($sql);

    $stmt->bind_param(
        "ssssi",
        $name,
        $email,
        $password,
        $role,
        $pending_author,
        $socialLinksJson
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


?>