<?php
/**
 * 
 * Declare Sheep Dead Form handler
 */

include_once '../../../config/db.php';
include_once '../../Models/Sheep.class.php';


$sheep = new Sheep();
$sheep->declareSheepDead($_GET["id"]);

$sheep = null;
unset($sheep);

header("location: ../../../public/userPanel.php?dest=sheepRegC");
exit();

?>