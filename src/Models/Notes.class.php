<?php

/**
 * 
 * Notes class
 */

 class Notes{

    public function addNewNote($animalId, $note, $date){
        $database = new Db();
        $db = $database->connect();
        $sql = "INSERT INTO notes(animal_id, note, created_at) VALUES (?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$animalId, $note, $date]);
        $database->closeConnection();
    }


    public function getLastNote($animalId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT note FROM notes
                WHERE animal_id=?
                ORDER BY note_id DESC
                LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$animalId]);
        if ($row = $stmt->fetch()) {
            return $row['note'];
        }
        else{
            return "No recorded notes";
        }
    }

    public function getNotes($animalId, $ownerId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * FROM notes
                INNER JOIN cows ON((cows.gov_cow_id = notes.animal_id) AND (notes.animal_id = ?))
                INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
                ORDER BY note_id DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute([$animalId, $ownerId]);
        if ($stmt->rowCount() > 0) {
            echo "<div class='search-result'>
                All Notes on ".$animalId."
                    <table>";
            while ($row = $stmt->fetch()) {
                echo "
                    <tr><td>".$row['created_at']."<br><br>  - ".$row['note']."</td><td><a href='../src/FormHandlers/delete/deleteNote.inc.php?id=".$row['note_id']."' class='Btn deleteBtn'>Delete Note?</a></td</tr>";
            }
            echo "</table></div>";
        }
        else {
            $sql = "SELECT * FROM notes
                INNER JOIN sheeps ON((sheeps.gov_sheep_id = notes.animal_id) AND (notes.animal_id = ?))
                INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
                ORDER BY note_id DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute([$animalId, $ownerId]);
            if ($stmt->rowCount() > 0) {
                echo "<div class='search-result'>
                    All Notes on ".$animalId."
                        <table>";
                while ($row = $stmt->fetch()) {
                    echo "
                        <tr><td>".$row['created_at']."<br><br>  -".$row['note']."</td><td><a href='../src/FormHandlers/delete/deleteNote.inc.php?id=".$row['note_id']."' class='Btn deleteBtn'>Delete Note?</a></td</tr>";
                }
                echo "</table></div>";
            }
            else{
                echo"<div class='search-result'>
                        No notes have been added for this animal.
                    </div>";
            }
        }
    }

    public function deleteNote($noteId){
        $database = new Db();
        $db = $database->connect();

        $sql = "DELETE FROM notes WHERE note_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$noteId]);
    }
 }

?>