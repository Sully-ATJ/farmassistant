<?php
/**
 * 
 * Cow Weight Measurement form Handler
 */

 if (isset($_POST["add-weight"])) {
    $animalId = $_POST["animal-id"];
    $weight = $_POST["weight"];
    $DOM = $_POST["dom"];

    include_once '../../../config/db.php';
    include_once '../../Models/Cow.class.php';

    $cow = new Cow();
    $cow->addWeightMeasurement($animalId, $weight, $DOM);

    $cow = null;
    unset($cow);

    header("location: ../../../public/userPanel.php?dest=cowRegC&msg=addweightsuccess");
    exit();
 }
 else {
    header("location: ../../../public/userPanel.php?error=invalidaccess");
    exit();
}
?>