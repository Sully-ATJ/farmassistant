<?php

/**
 * 
 * Users Model class 
 */

 class Users{


    //login Function
    public function loginUser($username, $pwd){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = $db->prepare($sql);
        $stmt->execute([$username]);

        $result = $stmt->fetch();

        //check if username exits in database
        if ($result === false) {
            header("location: ../../public/login.php?error=wronglogin");
            exit();
        }

        $status = $result['user_status'];
        if ($status == 'approved') {
            //check if entered password matches the one in the database
            $pwdDb = $result["password"];
            if($pwd !== $pwdDb){
                header("location: ../../public/login.php?error=wrongpwd");
                exit();
            }
            session_start();
            $_SESSION["userId"] = $result["user_id"];
            $_SESSION["fname"] = $result["first_name"];
            $_SESSION["lname"] = $result["last_name"];

            header("location: ../../public/userPanel.php");
            exit();
        }
        elseif ($status == 'unapproved') {
            header("location: ../../public/login.php?error=unapproved");
            exit();
        } 
    }


    //Register new Users
    public function registerUser($first_name, $last_name, $email, $pwd){
        $database = new Db();
        $db = $database->connect();
        $sql = "INSERT INTO users(first_name, last_name, email, `password`, user_status) VALUES (?,?,?,?,?);";
        $stmt = $db->prepare($sql);
        $stmt->execute([$first_name, $last_name, $email, $pwd, "unapproved"]);
        $database->closeConnection();

        header("location: ../../public/index.php");
        exit();
    }

    //check if any of the inputs are empty (Login)
    public function emptyInputLogin($username, $pwd){
        $result;
        if(empty($username) || empty($pwd)){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }

    //check for empty fields in registration form
    public function emptyInputRegister($first_name, $last_name, $email, $pwd){
        $result;
        if(empty($first_name) || empty($last_name) || empty($email) || empty($pwd)){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }

    public function changePassword($id, $pwd){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE users SET `password`=? WHERE `user_id` = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$pwd,$id]);
    }
 }