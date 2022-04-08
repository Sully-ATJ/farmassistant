<?php

/**
 * 
 * Update Cow Local Id Form Handler
 */

    if (isset($_POST["update-local-id"])) {
        $cowId = $_POST["cow-id"];
        $localId = $_POST["new-local-id"];

        include_once '../../../config/db.php';
        include_once '../../Models/Cow.class.php';
        
        $cow = new Cow();
        $cow->updateCowLocalId($cowId, $localId);

        $cow = null;
        unset($cow);

        header("location: ../../../public/userPanel.php?dest=cowRegC&msg=localidupdated");
        exit();
    }
    else {
        header("location: ../../../public/userPanel.php?error=invalidaccess");
        exit();
    }
?>