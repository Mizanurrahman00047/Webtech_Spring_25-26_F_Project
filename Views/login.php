<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="design/design.css">
</head>
<body>
<div class="container">
    <header class="page-header">
        <h1>Member Login</h1>
        <p>Sign in to access your account and manage your profile.</p>
    </header>

    <form class="form-card" method="POST" action="../Controllers/login-controller.php">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        

        
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

    
            <label class="checkbox-label">
                <input type="checkbox" name="remember">
                Remember Me
            </label>
        </div>

        <button class="button-primary" type="submit" name="login" value="login">Login</button>

        <p class="small-text">
            <a href="../Views/Registration.php">Don't have an account? Register here.</a>
        </p>
    </form>
</div>
</body>
</html>