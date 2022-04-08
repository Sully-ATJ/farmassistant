<?php

/**
 * 
 * Delete Sales Record for Sheep Form Handler
 */

    if (isset($_POST["delete-sale"])) {
        $animalId = $_POST["animal-id"];
        
        include_once '../../../config/db.php';
        include_once '../../Models/Sales.class.php';
        
        
        $sale = new Sales();
        $sale->deleteSheepSale($animalId);

        $sale = null;
        unset($sale);

        header("location: ../../../public/userPanel.php?dest=salesC&msg=deletesalesuccess");
        exit();
    }
    else {
        header("location: ../../../public/userPanel.php?error=invalidaccess");
        exit();
    }
?>