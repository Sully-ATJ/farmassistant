<?php
/**
 * 
 * Change Password Form handler
 */

 if (isset($_POST["change-pwd"])) {
    $id = $_POST['id'];
    $pwd = $_POST["new-pwd"];
    $repPwd = $_POST["rep-pwd"];

    if ($pwd !== $repPwd) {
        header("location: ../../../public/userPanel.php?dest=settingC&error=pwdnotsame"); //add error message
        exit();
    }

    include_once '../../../config/db.php';
    include_once '../../Models/Users.class.php';

    session_start();
    $usr  = new Users();
    $usr->changePassword($id, $pwd);
    $usr = null;
    unset($usr);
    header("location: ../../../public/userPanel.php?dest=settingC&msg=pwdchngsuccess");
    exit();
 }
 else {
    header("location: ../../../public/userPanel.php?error=invalidaccess");
    exit();
    }
?>