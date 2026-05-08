<?php
$email = "";
$password="";
//$datafile ="../data.json";

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $email = $_POST["email"];
        $password= $_POST["password"];


        if(empty($email)){
         echo "Email required";
        }
        elseif(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "Invalid email format";
        }
        if(empty($password)){
        echo "Password required";
        }
        elseif(){
        echo "Password is incorrect";
        }
        else{
        echo "Registration successful";
        //$hash = password_hash($password, PASSWORD_DEFAULT);
         }

    }
?>