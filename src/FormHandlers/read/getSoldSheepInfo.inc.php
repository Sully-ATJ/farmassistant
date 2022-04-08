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
       
        $response = "<table border='0'class='modal-table' width='100%'>";
        $response .= "<tr>";
        $response .= "<td>Local Sheep ID : </td><td>".$localID."</td>";
        $response .= "</tr>";
        $response .= "<tr>";
        $response .= "<td>Government Sheep ID : </td><td>".$govID."</td>";
        $response .= "</tr>";
        $response .= "<tr>";
        $response .= "<td>Status : </td><td>".$status."</td>";
        $response .= "</tr>";
        $response .= "<tr>";
        $response .= "<td>Date of Birth : </td><td>".$dob."</td>";
        $response .= "</tr>";
        $response .= "<tr>";
        $response .= "<td>Weight : </td><td>".$weight."</td>";
        $response .= "</tr>";
        $response .= "<tr>";
        $response .= "<td>Note : </td><td>".$note."</td>";
        $response .= "</tr>";
        $response .= "</table>";
        echo $response;
        exit();
    }
    else {
        $response = "failed to fetch";
        echo $response;
        exit();
    }

?>