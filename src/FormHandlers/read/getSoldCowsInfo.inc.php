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
       
        $response = "<table border='0' class='modal-table' width='100%'>";
        $response .= "<tr>";
        $response .= "<td>Local Cow ID : </td><td>".$localID."</td>";
        $response .= "</tr>";
        $response .= "<tr>";
        $response .= "<td>Government Cow ID : </td><td>".$govID."</td>";
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
        $response .= "<td>Last Vaccination  : </td><td>".$vaccine."</td>";
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