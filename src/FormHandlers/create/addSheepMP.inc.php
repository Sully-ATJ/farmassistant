<?php
/**
 * 
 * Sheep Milk Production form Handler
 */

 if (isset($_POST["add-entry"])) {
    $govId = $_POST["gov-id"];
    $milkProduced = $_POST["milk-produced"];
    $DOE = $_POST["doe"];

    include_once '../../../config/db.php';
    include_once '../../Models/Sheep.class.php';

    $sheep = new Sheep();
    $sheep->addMilkEntry($govId, $milkProduced, $DOE);

    $sheep = null;
    unset($sheep);

    header("location: ../../../public/userPanel.php?dest=milkProductionC&msg=addmpsuccess");
    exit();
 }
 else {
    header("location: ../../../public/userPanel.php#farmC?error=invalidaccess");
    exit();
}
?>