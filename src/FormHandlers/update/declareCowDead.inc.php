<?php
/**
 * 
 * Declare Cow dead Form handler
 */

include_once '../../../config/db.php';
include_once '../../Models/Cow.class.php';


$cow = new Cow();
$cow->declareCowDead($_GET["id"]);

$cow = null;
unset($cow);

header("location: ../../../public/userPanel.php?dest=cowRegC");
exit();

?>