<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/auth.css">
    <title>Registration Page</title>
</head>
<body>
    <div class="navBar">
        <a href="index.php">Farm Assistant</a>
    </div>
    <div class="register">
        <form action="../src/FormHandlers/register.inc.php" method="post">
            <h2>Register</h2>
            <input type="text" name="fname" placeholder="First Name" required>
            <input type="text" name="lname" placeholder="Last Name" required>
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="pwd" placeholder="Password" required>
            <input type="password" name="repeat-pwd" placeholder="Repeat Password" required>
            <button type="submit" name="register" class="Btn submitBtn">Register</button>
        </form>
        <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo"<p style='color:#f00'>Fill in all fields!</p>";
                }
                elseif ($_GET["error"] == "pwdneq") {
                    echo"<p style='color:#f00'>Passwords not the same!</p>";
                }
            }   
        ?>
    </div>
</body>
</html>