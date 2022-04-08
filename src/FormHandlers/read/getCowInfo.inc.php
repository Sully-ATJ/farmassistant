<?php
/**
 * 
 * Php code to fetch Modal information for Cows
 */

include_once '../../../config/db.php';
include_once '../../Models/Cow.class.php';
include_once '../../Models/Notes.class.php';

    if(isset($_POST['cowGovId'])){
        $cowId = $_POST['cowGovId'];
        $cow = new Cow();
        $note = new Notes();

        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from cows WHERE gov_cow_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$cowId]);
        $row = $stmt->fetch();
        
        $cowId = $row['cow_id'];
        $localID = $row['local_cow_id'];
        $govID = $row['gov_cow_id'];
        $dob = $row['date_of_birth'];
    
        $weight = $cow->getLastWeightMeasurement($govID);
        $note = $note->getLastNote($govID);
        $vaccine = $cow->getCowVaccination($govID);

        $status = $row['status'];
       
        $response = "<div class='modal-block'>";
        $response .= "<div class='modal-row'>";
        $response .= "<form  action='../src/FormHandlers/update/updateCowLocalId.inc.php' method='post'>";
        $response .= "<input type='hidden' name='cow-id' value='".$cowId."'>";
        $response .= "Local Cow ID : <input name='new-local-id' value='".$localID."'/><button type='submit' name='update-local-id' class='Btn updateModalBtn'>Update</button>";
        $response .= "</form>";
        $response .= "</div>";
        $response .= "<div class='modal-row'>";
        $response .= "<form action='../src/FormHandlers/update/updateCowGovId.inc.php' method='post'>";
        $response .= "<input type='hidden' name='cow-id' value='".$cowId."'>";
        $response .= "Government Cow ID : <input name='new-gov-id' value='".$govID."'/><button type='submit' name='update-gov-id' class='Btn updateModalBtn'>Update</button>";
        $response .= "</form>";
        $response .= "</div>";
        $response .= "<div class='modal-row'>";
        $response .= "<form action='../src/FormHandlers/update/updateCowStatus.inc.php' method='post'>";
        $response .= "<input type='hidden' name='cow-id' value='".$cowId."'>";
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
        $response .= "Last Vaccination  : ".$vaccine."";
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