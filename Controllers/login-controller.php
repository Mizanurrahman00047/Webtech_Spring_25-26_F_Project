
<?php

session_start();

require_once('../Models/database.php');

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $hasError = false;


    if(empty($email)){

        echo "Email required";
        $hasError = true;
    }

    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){

        echo "Invalid email format";
        $hasError = true;
    }

    
    elseif(empty($password)){

        echo "Password required";
        $hasError = true;
    }

    if($hasError == false){

        $result = login($email);

        if($result->num_rows > 0){

            $user = $result->fetch_assoc();

            // PASSWORD VERIFY REQUIRED

            if(password_verify(
                $password,
                $user['password_hash']
            )){

                // EXACT REQUIREMENT

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                // REMEMBER ME

                if(isset($_POST['remember_me'])){

                    $token = bin2hex(random_bytes(32));

                    $hashedToken = password_hash(
                        $token,
                        PASSWORD_DEFAULT
                    );

                    updateRememberToken(
                        $hashedToken,
                        $user['id']
                    );

                    setcookie(
                        "remember_token",
                        $token,
                        time() + (86400 * 30),
                        "/"
                    );
                }

                echo "Login Successful";
            }

            else{

                echo "Incorrect Password";
            }
        }

        else{

            echo "User Not Found";
        }
    }
}
?>