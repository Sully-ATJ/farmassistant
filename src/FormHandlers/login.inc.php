<?php
/**
 * 
 * Login Form Handler
 */
    if(isset($_POST["login"])){
        $username = $_POST["user"];
        $pwd = $_POST["pwd"];

        include_once '../../config/db.php';
        include '../Models/Users.class.php';

        $userObj = new Users();
        if ($userObj->emptyInputLogin($username, $pwd) !== false) {
            header("location: ../../public/login.php?error=emptyinput");
            exit();
        }

        $userObj->loginUser($username, $pwd);
    }
    else{
        header("location: ../../public/login.php?error=invalidaccess");
        exit();
    }

?>