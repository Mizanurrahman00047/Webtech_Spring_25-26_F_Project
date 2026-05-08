
<?php
require_once('../Controllers/Registration-Controller.php');
?>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <h2>Registration</h2>
    <form method="POST" action="../Controllers/Registration-Controller.php">
        <label for ="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Name"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Email"><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Password"><br><br>

    <label>
        <input type="radio" name="role" value="reader" checked>
            Reader
    </label>

    <label>
        <input type="radio" name="role" value="author">
            Author
    </label> <br><br>

    <button type="submit" name = "register" value="sign up">Register</button>

</form>
</body>
</html>
