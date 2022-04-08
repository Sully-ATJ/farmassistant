<?php
/**
 * 
 * Move Cow Form handler
 */

 if (isset($_POST["move-cow"])) {
    $govId = $_POST['gov-id'];
    $newFarmId = $_POST["farm-id"];

    include_once '../../../config/db.php';
    include_once '../../Models/Cow.class.php';

    $cow  = new Cow();
    $cow->moveCow($govId, $newFarmId);
    $cow = null;
    unset($cow);
    header("location: ../../../public/userPanel.php?dest=cowRegC&msg=movesuccess");
    exit();
 }
 else {
    header("location: ../../../public/userPanel.php?error=invalidaccess");
    exit();
    }
?>