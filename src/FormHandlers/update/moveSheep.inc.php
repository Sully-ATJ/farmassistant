<?php
/**
 * 
 * Move Sheep Form handler
 */

 if (isset($_POST["move-sheep"])) {
    $govId = $_POST['gov-id'];
    $newFarmId = $_POST["farm-id"];

    include_once '../../../config/db.php';
    include_once '../../Models/Sheep.class.php';

    $sheep  = new Sheep();
    $sheep->moveSheep($govId, $newFarmId);
    $sheep = null;
    unset($sheep);
    header("location: ../../../public/userPanel.php?dest=sheepRegC&msg=movesuccess");
    exit();
 }
 else {
    header("location: ../../../public/userPanel.php?error=invalidaccess");
    exit();
    }
?>