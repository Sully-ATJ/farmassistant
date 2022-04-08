<?php
/**
 * 
 * Cow Milk Production form Handler
 */

 if (isset($_POST["add-entry"])) {
    $govId = $_POST["gov-id"];
    $milkProduced = $_POST["milk-produced"];
    $DOE = $_POST["doe"];

    include_once '../../../config/db.php';
    include_once '../../Models/Cow.class.php';

    $cow = new Cow();
    $cow->addMilkEntry($govId, $milkProduced, $DOE);

    $cow = null;
    unset($cow);

    header("location: ../../../public/userPanel.php?dest=milkProductionC&msg=addmpsuccess");
    exit();
 }
 else {
    header("location: ../../public/userPanel.php?error=invalidaccess");
    exit();
}
?>