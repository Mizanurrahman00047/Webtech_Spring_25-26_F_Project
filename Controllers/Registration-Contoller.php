
<?php

$name = "";
$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];



if(empty($name)){
    echo "Name required";
}
elseif(!empty($name) && strlen($name) < 3){
    echo "Name must be at least 3 characters";   
}

if(empty($email)){
    echo "Email required";
}
elseif(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo "Invalid email format";
}
if(empty($password)){
    echo "Password required";
}
elseif(strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password) || !preg_match('/[!@#$%^&*()-+]/', $password)){
    echo "Password must be at least 8 characters and contain at least one capital letter and one number and one special character";
}
else{
    echo "Registration successful";
    //$hash = password_hash($password, PASSWORD_DEFAULT);
}

}
/*
if(empty($errors)){

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $role = 'reader';
    $pending_author = 0;

    if($selectedRole == 'author'){
        $pending_author = 1;
    }

    $stmt = $pdo->prepare("
        INSERT INTO users
        (name,email,password_hash,role,pending_author,created_at)
        VALUES (?,?,?,?,?,NOW())
    ");

    $stmt->execute([
        $name,
        $email,
        $hash,
        $role,
        $pending_author
    ]);
}
*/

?>