<?php

/**
 * 
 * Add Birth Record Form Handler
 */

    if (isset($_POST["add-birth"])) {
        $motherId = $_POST["mother-id"];
        $numOfBirths = $_POST["numOfBirth"];
        $numOfDeaths = $_POST["numOfDeath"];
        $DOB = $_POST["dob"];
        

        include_once '../../../config/db.php';
        include_once '../../Models/Cow.class.php';
        
        
        $cow = new Cow();
        $cow->addNewBirth($motherId, $numOfBirths, $numOfDeaths, $DOB);

        $cow = null;
        unset($cow);

        header("location: ../../../public/userPanel.php?dest=cowRegC&msg=addbirthrecsuccess");
        exit();
    }
    else {
        header("location: ../../public/userPanel.php?error=invalidaccess");
        exit();
    }
?>