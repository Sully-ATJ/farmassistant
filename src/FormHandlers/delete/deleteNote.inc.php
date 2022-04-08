<?php
/**
 * 
 * Delete Note Handler
 * 
 */

include_once '../../../config/db.php';
include_once '../../Models/Notes.class.php';


$note = new Notes();
$note->deleteNote($_GET["id"]);

$note = null;
unset($note);

header("location: ../../../public/userPanel.php?dest=notesC&msg=deleted-note");
exit();
?>