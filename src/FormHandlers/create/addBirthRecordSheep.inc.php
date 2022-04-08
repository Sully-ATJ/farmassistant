<?php

/**
 * 
 * Adding Sheep Birth Record  Form Handler
 */

    if (isset($_POST["add-birth"])) {
        $motherId = $_POST["mother-id"];
        $numOfBirths = $_POST["numOfBirth"];
        $numOfDeaths = $_POST["numOfDeath"];
        $DOB = $_POST["dob"];
        

        include_once '../../../config/db.php';
        include_once '../../Models/Sheep.class.php';
        
        
        $sheep = new Sheep();
        $sheep->addNewBirth($motherId, $numOfBirths, $numOfDeaths, $DOB);

        $sheep = null;
        unset($sheep);

        header("location: ../../../public/userPanel.php?dest=sheepRegC&msg=addbirthrecsuccess");
        exit();
    }
    else {
        header("location: ../../public/userPanel.php#farmC?error=invalidaccess");
        exit();
    }
?>