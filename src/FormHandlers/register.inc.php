<?php
/**
 * 
 * Registration Form Handler
 */
    if(isset($_POST["register"])){
        $first_name = $_POST["fname"];
        $last_name = $_POST["lname"];
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];
        $repeat_pwd = $_POST["repeat-pwd"];

        if ($pwd !== $repeat_pwd) {
            header("location: ../../public/register.php?error=pwdneq");
            exit();
        }
        else{
            include_once '../../config/db.php';
            include_once '../Models/Users.class.php';

            $userObj = new Users();
            if ($userObj->emptyInputRegister($first_name, $last_name, $email, $pwd) !== false) {
            header("location: ../../public/register.php?error=emptyinput");
            exit();
            }

            $userObj->registerUser($first_name, $last_name, $email, $pwd);
        }
    }
    else{
        header("location: ../../public/register.php?error=invalidaccess");
        exit();
    }

?>