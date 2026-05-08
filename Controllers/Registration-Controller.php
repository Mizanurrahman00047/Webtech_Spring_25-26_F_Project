
<?php

require_once('../Models/database.php');

if (isset($_POST["register"])) {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $selectedRole = $_POST["role"];

    $hasError = false;

    if (empty($name)) {
        echo "Name required";
        $hasError = true;
    }

    elseif (strlen($name) < 3) {
        echo "Name must be at least 3 characters";
        $hasError = true;
    }


    elseif (empty($email)) {
        echo "Email required";
        $hasError = true;
    }

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        $hasError = true;
    }

  
    elseif (empty($password)) {
        echo "Password required";
        $hasError = true;
    }

    elseif (
        strlen($password) < 8 ||
        !preg_match('/[A-Za-z]/', $password) ||
        !preg_match('/\d/', $password) ||
        !preg_match('/[!@#$%^&*()-+]/', $password)
    ) {

        echo "Password must be at least 8 characters and contain letters, numbers and special characters";

        $hasError = true;
    }

    
    if ($hasError == false) {


        $role = "reader";
        $pending_author = 0;

        if ($selectedRole == "author") {
            $pending_author = 1;
        }

    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        registration(
            $name,
            $email,
            $hashedPassword,
            $role,
            $pending_author
        );
    }
}
?>