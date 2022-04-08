<?php
/**
 * 
 * Sheep Weight Measurement form Handler
 */

 if (isset($_POST["add-weight"])) {
    $animalId = $_POST["animal-id"];
    $weight = $_POST["weight"];
    $DOM = $_POST["dom"];

    include_once '../../../config/db.php';
    include_once '../../Models/Sheep.class.php';

    $sheep = new Sheep();
    $sheep->addWeightMeasurement($animalId, $weight, $DOM);

    $sheep = null;
    unset($sheep);

    header("location: ../../../public/userPanel.php?dest=sheepRegC&msg=addweightsuccess");
    exit();
 }
 else {
    header("location: ../../../public/userPanel.php?error=invalidaccess");
    exit();
}
?>