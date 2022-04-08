<?php

/**
 * 
 * Farm Class
 */

 class Farm{


    //create Farm 
    public function createFarm($farmName, $farmLocation, $id){
        $database = new Db();
        $db = $database->connect();

        $sql = "SELECT * farm WHERE farm_name = ? AND farm_location = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$farmName, $farmLocation]);
        if ($stmt->rowCount() > 0) {
            header("location: ../../../public/userPanel.php?dest=farmC&msg=nametaken");
            exit();
        }
        else {
            //Insert farm record into farm table
            $sql = "INSERT INTO farm(farm_name, farm_location) VALUES(?,?);";
            $stmt = $db->prepare($sql);
            $stmt->execute([$farmName, $farmLocation]);

            $sql = "SELECT * FROM farm WHERE farm_location=?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$farmLocation]);

            $result = $stmt->fetch();
            $farmId = $result["farm_id"];

            $sql = "INSERT INTO farm_authority(farm_id, owner_id) VALUES(?,?);";
            $stmt = $db->prepare($sql);
            $stmt->execute([$farmId, $id]);

            $database->closeConnection();
        }

        
    }

    //Get all the users farms 
    public function getAllFarms($userId){
        $database = new Db();
        $db = $database->connect();

        $sql = "SELECT farm.farm_name, farm.farm_id 
        from farm 
        INNER JOIN farm_authority  ON ((farm.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))";
        $stmt = $db->prepare($sql);
        $stmt->execute([$userId]);
        while ($row = $stmt->fetch()) {
            echo "<option value=". $row['farm_id'].">
                    " .$row['farm_name']. "        
                </option>";
        }
    }

    //Display farm basic farm information
    public function displayAllFarms($userId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT *
        from farm 
        INNER JOIN farm_authority  ON ((farm.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))";
        $stmt = $db->prepare($sql);
        $stmt->execute([$userId]);
        echo"<table>
                <tr>
                    <th>Farm Name</th>
                    <th>Farm Location</th>
                    <th>Cows</th>
                    <th>Sheep</th>
                </tr>";

        while ($row = $stmt->fetch()) {
            $sql = "SELECT COUNT(*) from cows WHERE farm_id=? AND  cow_condition='available'";
            $subStmt = $db->prepare($sql);
            $subStmt->execute([$row['farm_id']]);
            $countCow = $subStmt->fetchColumn();
            $sql = "SELECT COUNT(*) from sheeps WHERE farm_id=? AND sheep_condition='available'";
            $subStmt = $db->prepare($sql);
            $subStmt->execute([$row['farm_id']]);
            $countSheep = $subStmt->fetchColumn();
            echo "<tr>
                    <td>".$row['farm_name']."</td>
                    <td>".$row['farm_location']."</td>
                    <td>".$countCow."</td>
                    <td>".$countSheep."</td>
                  </tr>";
        }
        echo"</table>";
    }

    //Delete a farm
    public function deleteFarm($farmName, $farmLocation){
        $database = new Db();
        $db = $database->connect();
        
        //Get the farm id
        $sql = "SELECT farm_id FROM farm WHERE ((farm_name=?) AND (farm_location=?))";
        $stmt = $db->prepare($sql);
        $stmt->execute([$farmName, $farmLocation]);

        $result = $stmt->fetch();
        $farmId = $result["farm_id"];

        //Delete from farm table
        $sql = "DELETE FROM farm WHERE farm_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$farmId]);

        //Delete from farm authority table
        $sql = "DELETE FROM farm_authority WHERE farm_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$farmId]);

        $database->closeConnection();
    }

    public function updateFarmInfo($farmId, $newFarmName, $newFarmLocation){
        $database = new Db();
        $db = $database->connect();

        $sql = "UPDATE farm 
            SET farm_name = ?,farm_location = ?
            WHERE farm_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$newFarmName, $newFarmLocation, $farmId]);
        $database->closeConnection();
    }

    //test function to test connection to frontend
    public function test(){
        echo "class files are loading!";
    }
 }
