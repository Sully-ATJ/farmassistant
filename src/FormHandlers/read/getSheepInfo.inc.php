<?php
/**
 * 
 * Php code to fetch Modal information for Sheep
 */

include_once '../../../config/db.php';
include_once '../../Models/Sheep.class.php';
include_once '../../Models/Notes.class.php';

    if(isset($_POST['sheepGovId'])){
        $sheepId = $_POST['sheepGovId'];
        $sheep = new Sheep();
        $note = new Notes();

        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from sheeps WHERE gov_sheep_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$sheepId]);
        $row = $stmt->fetch();

        $sheepId = $row['sheep_id'];
        $localID = $row['local_sheep_id'];
        $govID = $row['gov_sheep_id'];
        $dob = $row['date_of_birth'];
    
        $weight = $sheep->getLastWeightMeasurement($govID);
        $note = $note->getLastNote($govID);

        $status = $row['status'];
       
        $response = "<div class='modal-block'>";
        $response .= "<div class='modal-row'>";
        $response .= "<form class='modalForm' action='../src/FormHandlers/update/updateSheepLocalId.inc.php' method='post'>";
        $response .= "<input type='hidden' name='sheep-id' value='".$sheepId."'>";
        $response .= "Local Sheep ID : <input name='new-local-id' value='".$localID."'/><button type='submit' name='update-local-id' class='Btn updateModalBtn'>Update</button>";
        $response .= "</form>";
        $response .= "</div>";
        $response .= "<div class='modal-row'>";
        $response .= "<form class='modalForm' action='../src/FormHandlers/update/updateSheepGovId.inc.php' method='post'>";
        $response .= "<input type='hidden' name='sheep-id' value='".$sheepId."'>";
        $response .= "Government Sheep ID : <input name='new-gov-id' value='".$govID."'/><button type='submit' name='update-gov-id' class='Btn updateModalBtn'>Update</button>";
        $response .= "</form>";
        $response .= "</div>";
        $response .= "<div class='modal-row'>";
        $response .= "<form class='modalForm' action='../src/FormHandlers/update/updateSheepStatus.inc.php' method='post'>";
        $response .= "<input type='hidden' name='sheep-id' value='".$sheepId."'>";
        $response .= "Status : <input name='new-status' value='".$status."'/><button type='submit' name='update-status' class='Btn updateModalBtn'>Update</button>";
        $response .= "</form>";
        $response .= "</div>";
        $response .= "<div class='modal-row'>";
        $response .= "Date of Birth : ".$dob."";
        $response .= "</div>";
        $response .= "<div class='modal-row'>";
        $response .= "Weight : ".$weight."";
        $response .= "</div>";
        $response .= "<div class='modal-row'>";
        $response .= "Note : ".$note."";
        $response .= "</div>";
        $response .= "</div>";
        echo $response;
        exit();
    }
    else {
        $response = "failed to fetch";
        echo $response;
        exit();
    }

?>