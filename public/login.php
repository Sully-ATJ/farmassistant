<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/auth.css">
    <title>Login Page</title>
</head>
<body>
    <div class="navBar">
        <a href="index.php">Farm Assistant</a>
    </div>
    <div class="login">
        <form action="../src/FormHandlers/login.inc.php" method="post">
            <h2>Login</h2>
            <input type="text" name="user" placeholder="Email" required>
            <input type="password" name="pwd" placeholder="Password" required>
            <button type="submit" name="login" class="Btn submitBtn">Login</button>
        </form>
        <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo"<p style='color:#f00'>Fill in all fields!</p>";
                }
                elseif ($_GET["error"] == "wronglogin") {
                    echo"<p style='color:#f00'=>Incorrect login credentials!</p>";
                }
                elseif ($_GET["error"] == "wrongpwd") {
                    echo"<p style='color:#f00'>Incorrect password!</p>";
                }
                elseif ($_GET["error"] == "unapproved") {
                    echo"<p style='color:#f00'>User has not been approved<br>Contact admin to resolve user status </p>";
                }
            }   
        ?>
    </div>
</body>
</html>