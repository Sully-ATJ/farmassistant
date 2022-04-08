<?php
/**
 * 
 * Adding Sales Sheep form Handler
 */

 if (isset($_POST["add-sale"])) {
    $id = $_POST["id"];
    $animalId = $_POST["animal-id"];
    $weight = $_POST["weight"];
    $price = $_POST["price"];
    $sheepBreed = $_POST["sheep-breed"];
    $buyerFname = $_POST["buyer-fname"];
    $buyerLname = $_POST["buyer-lname"];
    $DOS = $_POST["dos"];

    include_once '../../../config/db.php';
    include_once '../../Models/Sales.class.php';

    $sheep = new Sales();
    $sheep->addSaleSheep($id, $animalId, $weight, $price, $sheepBreed, $buyerFname, $buyerLname, $DOS);

    $sheep = null;
    unset($sheep);

    header("location: ../../../public/userPanel.php?dest=salesC&msg=addsalesuccess");
    exit();
 }
 else {
    header("location: ../../public/userPanel.php?error=invalidaccess");
    exit();
}
?>