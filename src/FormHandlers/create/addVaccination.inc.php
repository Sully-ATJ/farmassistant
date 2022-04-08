<?php
/**
 * 
 * Adding Cow Vaccination Record form Handler
 */

 if (isset($_POST["add-vax"])) {
    $animalId = $_POST["cow-id"];
    $vaccine = $_POST["vaccine"];
    $DOV = $_POST["dov"];

    include_once '../../../config/db.php';
    include_once '../../Models/Cow.class.php';

    $cow = new Cow();
    $cow->addVaccination($animalId, $vaccine, $DOV);

    $cow = null;
    unset($cow);

    header("location: ../../../public/userPanel.php?dest=cowRegC&msg=addvaxsuccess");
    exit();
 }
 else {
    header("location: ../../../public/userPanel.php?error=invalidaccess");
    exit();
}
?>