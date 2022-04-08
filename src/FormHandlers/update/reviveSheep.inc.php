<?php
/**
 * 
 * Revive Sheep Form handler
 */

include_once '../../../config/db.php';
include_once '../../Models/Sheep.class.php';


$sheep = new Sheep();
$sheep->reviveSheep($_GET["id"]);

$sheep = null;
unset($sheep);

header("location: ../../../public/userPanel.php?dest=sheepRegC");
exit();

?>