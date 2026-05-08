
<?php

?>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <h2>Registration</h2>
    <form method="POST" action="/register">
        <label for ="name">Name:</label>
        <input type="text" name="name" placeholder="Name"><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Email"><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password"><br><br>

    <label>
        <input type="radio" name="role" value="reader" checked>
            Reader
    </label>

    <label>
        <input type="radio" name="role" value="author">
            Author
    </label> <br><br>

    <button type="submit">Register</button>

</form>
</body>
</html>
