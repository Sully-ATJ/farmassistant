<?php

/**
 * 
 * Update Cow Info Form Handler
 */

    if (isset($_POST["update-gov-id"])) {
        $cowId = $_POST["cow-id"];
        $govId = $_POST["new-gov-id"];

        include_once '../../../config/db.php';
        include_once '../../Models/Cow.class.php';
        
        
        $cow = new Cow();
        $cow->updateCowGovId($cowId, $govId);

        $cow = null;
        unset($cow);

        header("location: ../../../public/userPanel.php?dest=cowRegC&msg=govidupdated");
        exit();
    }
    else {
        header("location: ../../../public/userPanel.php?error=invalidaccess");
        exit();
    }
?>