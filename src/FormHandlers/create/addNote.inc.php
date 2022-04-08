<?php
/**
 * 
 * Adding Notes form Handler
 */

 if (isset($_POST["add-note"])) {
    $animalId = $_POST["animal-id"];
    $note = $_POST["note"];
    $date = $_POST["date"];

    include_once '../../../config/db.php';
    include_once '../../Models/Notes.class.php';

    $notes = new Notes();
    $notes->addNewNote($animalId, $note, $date);

    $notes = null;
    unset($notes);

    header("location: ../../../public/userPanel.php?dest=notesC&msg=addnotesuccess");
    exit();
 }
 else {
    header("location: ../../../public/userPanel.php?error=invalidaccess");
    exit();
}
?>