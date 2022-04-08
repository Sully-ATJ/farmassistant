<?php
/**
 * 
 * Adding Sales Cow form Handler
 */

 if (isset($_POST["add-sale"])) {
    $id = $_POST["id"];
    $animalId = $_POST["animal-id"];
    $weight = $_POST["weight"];
    $price = $_POST["price"];
    $cowBreed = $_POST["cow-breed"];
    $buyerFname = $_POST["buyer-fname"];
    $buyerLname = $_POST["buyer-lname"];
    $DOS = $_POST["dos"];

    include_once '../../../config/db.php';
    include_once '../../Models/Sales.class.php';

    $cow = new Sales();
    $cow->addSaleCow($id, $animalId, $weight, $price, $cowBreed, $buyerFname, $buyerLname, $DOS);

    $cow = null;
    unset($cow);

    header("location: ../../../public/userPanel.php?dest=salesC&msg=addsalesuccess");
    exit();
 }
 else {
    header("location: ../../public/userPanel.php?error=invalidaccess");
    exit();
}
?>