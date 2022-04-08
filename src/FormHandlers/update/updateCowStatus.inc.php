<?php

/**
 * 
 * Update Cow Info Form Handler
 */

    if (isset($_POST["update-status"])) {
        $cowId = $_POST["cow-id"];
        $status = $_POST["new-status"];

        include_once '../../../config/db.php';
        include_once '../../Models/Cow.class.php';
        
        
        $cow = new Cow();
        $cow->updateCowStatus($cowId, $status);

        $cow = null;
        unset($cow);

        header("location: ../../../public/userPanel.php?dest=cowRegC&msg=statusupdated");
        exit();
    }
    else {
        header("location: ../../../public/userPanel.php?error=invalidaccess");
        exit();
    }
?>