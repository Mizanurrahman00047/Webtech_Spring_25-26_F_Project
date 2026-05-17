
<?php
session_start();

require_once(__DIR__ . '/../../Models/database.php');
require_once(__DIR__ . '/../../Models/database2.php');
require_once(__DIR__ . '/../../Models/database3.php');
require_once(__DIR__ . '/../../Models/database4.php');

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $hasError = false;


    if(empty($email)){

        echo "Email required";
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
                if ($user['role'] == 'admin'){
                    
                   header("Location: ../../Views/task1/admin-users.php");
                    exit();
                }
               
                elseif ($user['role'] == 'author'){
                    
                    header("Location: ../../Views/task2/dashboard.php");
                    exit();
                }
                else{
                    
                    header("Location: ../../Views/task3/homepage.php");
                    exit();
                }
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
