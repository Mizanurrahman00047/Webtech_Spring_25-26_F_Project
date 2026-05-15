
<?php

?>
<html>
<head>
    <title>Login</title>
</head>
<body>

    <form method="POST" action="../Controllers/login-controller.php">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email">
    <br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <br><br>

    <label>
        <input type="checkbox" name="remember">
        Remember Me
    </label>
    <br><br>
    <a href="../Views/Registration.php">Don't have an account? Register here.</a>
    <br><br>
    <a href="../Views/admin-login.php">Admin Login</a>
    <br><br>
    
    <button type="submit" name="login" value="login">Login</button>

</form>

</body>
</html>