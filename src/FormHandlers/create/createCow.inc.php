<?php

/**
 * 
 * Create Cow Form Handler
 */

    if (isset($_POST["create-cow"])) {
        $localId = $_POST["local-id"];
        $govId = $_POST["gov-id"];
        $farmId = $_POST["farm-id"];
        $DOB = $_POST["dob"];
        $gender = $_POST["gender"];
        $status = $_POST["status"];

        include_once '../../../config/db.php';
        include_once '../../Models/Cow.class.php';
        
        
        $cow = new Cow();
        $cow->addNewCow($localId, $govId, $farmId, $DOB, $gender, $status);

        $cow = null;
        unset($cow);

        header("location: ../../../public/userPanel.php?dest=cowRegC&msg=addanimalsuccess");
        exit();
    }
    else {
        header("location: ../../public/userPanel.php#farmC?error=invalidaccess");
        exit();
    }
?>
