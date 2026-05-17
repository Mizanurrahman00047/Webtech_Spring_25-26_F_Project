

<html>
<head>
    <title>Registration</title>
     <link rel="stylesheet" href="../design/design.css">
</head>
<body>
    <div class="container">
        <header class="page-header">
            <h1>Member Registration</h1>
            <p>Create an account to access exclusive content and manage your profile.</p>
        </header>

    <form class="form-card" method="POST" action="../Controllers/task1/Registration-Controller.php">
    <div class="form-group">    
    <label for ="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="name"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="email"><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="password"><br><br>
    <label for="role">Select Role:</label><br>
    <label>
        <input type="radio" name="role" value="reader" checked>
            Reader
    </label>

    <label>
        <input type="radio" name="role" value="author">
            Author
    </label> <br><br>
    </div>

    <button class="button-primary" type="submit" name = "register" value="sign up">Register</button>
    <br><br>
    <p class="small-text">
    <a href="../../Views/task1/login.php">Already have an account? Login here.</a>
    </p>
</form>
</body>
</html>
