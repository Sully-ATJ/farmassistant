<?php

/**
 * 
 * Create Sheep Form Handler
 */

    if (isset($_POST["create-sheep"])) {
        $localId = $_POST["local-id"];
        $govId = $_POST["gov-id"];
        $farmId = $_POST["farm-id"];
        $DOB = $_POST["dob"];
        $gender = $_POST["gender"];
        $status = $_POST["status"];

        include_once '../../../config/db.php';
        include_once '../../Models/Sheep.class.php';
        
        
        $sheep = new Sheep();
        $sheep->addNewSheep($localId, $govId, $farmId, $DOB, $gender, $status);

        $sheep = null;
        unset($sheep);

        header("location: ../../../public/userPanel.php?dest=sheepRegC&msg=addanimalsuccess");
        exit();
    }
    else {
        header("location: ../../public/userPanel.php?error=invalidaccess");
        exit();
    }
?>