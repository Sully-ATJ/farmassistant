<?php

/**
 * 
 * Update Cow Info Form Handler
 */

    if (isset($_POST["update-info"])) {
        $cowId = $_POST["cow-id"];
        $localId = $_POST["new-local-id"];
        $govId = $_POST["new-gov-id"];
        $status = $_POST["new-status"];
        
        

        include_once '../../../config/db.php';
        include_once '../../Models/Cow.class.php';
        
        
        $cow = new Cow();
        $cow->updateCowInfo($cowId, $localId, $govId, $status);

        $cow = null;
        unset($cow);

        header("location: ../../../public/userPanel.php?dest=cowRegC");
        exit();
    }
    else {
        header("location: ../../../public/userPanel.php?error=invalidaccess");
        exit();
    }
?>