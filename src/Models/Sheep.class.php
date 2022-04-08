<?php

/**
 * 
 * Sheep Class
 *
 */

 class Sheep{

    //-----------------------------create-----------------------------

    //Add sheep to sheep table
    public function addNewSheep($localId, $govId, $farmId, $DOB, $gender, $status){
        $database = new Db();
        $db = $database->connect();
        $sql = "INSERT INTO sheeps(local_sheep_id, gov_sheep_id, farm_id, date_of_birth, gender, `status`, sheep_condition) VALUES (?,?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$localId, $govId, $farmId, $DOB, $gender, $status, "available"]);
        $database->closeConnection();
    }

    //Add new calves births to "sheep_birth" table
    public function addNewBirth($motherId, $numOfBirths, $numOfDeaths, $DOB){
        $database = new Db();
        $db = $database->connect();

        $sql = "SELECT gender FROM sheeps WHERE gov_sheep_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$motherId]);
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            if ($row["gender"] == "Male") {
                header("location: ../../../public/userPanel.php?dest=sheepRegC&msg=wronggender");
                exit();
            }
            else {
                $sql = "INSERT INTO sheep_birth(mother_sheep_id, num_of_births, num_dead, date_of_birth) VALUES (?,?,?,?)";
                $stmt = $db->prepare($sql);
                $stmt->execute([$motherId, $numOfBirths, $numOfDeaths, $DOB]);
                $database->closeConnection();
            }
        }
        else{
            header("location: ../../../public/userPanel.php?dest=sheepRegC&msg=sheepnotexist");
            exit();
        }

        
    }

    public function addMilkEntry($govId, $milkProduced, $DOE){
        $database = new Db();
        $db = $database->connect();

        $sql = "SELECT gender FROM sheeps WHERE gov_sheep_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$govId]);
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            if ($row["gender"] == "Male") {
                header("location: ../../../public/userPanel.php?dest=sheepRegC&msg=wronggender");
                exit();
            }
            else {
                $sql = "INSERT INTO milk_production(animal_id, amount_of_milk, production_date) VALUES (?,?,?)";
                $stmt = $db->prepare($sql);
                $stmt->execute([$govId, $milkProduced, $DOE]);
                $database->closeConnection();
            }
        }
        else{
            header("location: ../../../public/userPanel.php?dest=sheepRegC&msg=sheepnotexist");
            exit();
        }
    }

    //add a weight measurement to the weight_measurement table
    public function addWeightMeasurement($animalId, $weight, $DOM){
        $database = new Db();
        $db = $database->connect();
        $sql = "INSERT INTO weight_measurement(animal_id, `weight`, measured_at ) VALUES (?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$animalId, $weight, $DOM]);

        $database->closeConnection();
    }

    //-----------------------------read-----------------------------

    public function getRecentMilkProductionActivity($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from sheeps 
        INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN milk_production ON((sheeps.gov_sheep_id = milk_production.animal_id) OR (sheeps.local_sheep_id = milk_production.animal_id))
        ORDER BY production_id DESC LIMIT 2";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch()) {
                echo "<div class='timeline-item'>
                        <div class='timeline-badge'> $ </div>
                            <div class='timeline-content'> Sheep "
                            .$row['local_sheep_id']." produced ".$row['amount_of_milk']." liters of milk on ".$row['production_date'].
                        "</div>
                    </div>";
            }
        }
        else {
            echo "<br>No sheep milk produced yet<br>";
        } 
    }

    public function getMilkProduction($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from sheeps 
        INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN milk_production ON((sheeps.gov_sheep_id = milk_production.animal_id) OR (sheeps.local_sheep_id = milk_production.animal_id))
        ORDER BY production_id DESC LIMIT 5";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch()) {
                echo "<div class='timeline-item'>
                        <div class='timeline-badge'> $ </div>
                            <div class='timeline-content'> Sheep "
                            .$row['local_sheep_id']." produced ".$row['amount_of_milk']." liters of milk on ".$row['production_date'].
                        "</div>
                    </div>";
            }
        }
        else {
            echo "<br>No Sheep milk has been produced yet<br>";
        }
        
    }

    public function getSheepMPHistory($sheepId, $ownerId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from sheeps 
        INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) 
                                  AND (farm_authority.owner_id = ?) 
                                  AND ((sheeps.gov_sheep_id = ?) OR (sheeps.local_sheep_id = ?)))
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId,$sheepId,$sheepId]);

        //save local and gov ids
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch();
            if ($result['gender'] == "Male") {
                echo "<div class='search-result'>
                        This is a Male sheep
                    </div>";
            }
            else {
                $localId = $result['local_sheep_id'];
                $govId = $result['gov_sheep_id'];


                $sql = "SELECT * from milk_production WHERE ((animal_id = ?)OR (animal_id=?)) ORDER BY production_id DESC LIMIT 10";
                $stmt = $db->prepare($sql);
                $stmt->execute([$localId, $govId]);
                echo "<div class='search-result'>
                        Recent Milk Production History of ".$localId."
                        <table>";
                while ($row = $stmt->fetch()) {
                    echo "
                        <tr><td> On ".$row['production_date'].", ".$row['amount_of_milk']." liters of milk was produced.</td></tr>";
                }
                echo "</table></div>";
            }
        }
        else {
            echo "<div class='search-result'>
            You do not own a sheep with this ID, please check entry information and try again
                  </div>";
        } 
    }

    //get the last weight measurement for specific sheep from the weight_measurement table
    public function getLastWeightMeasurement($sheepId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT `weight` from sheeps INNER JOIN
         weight_measurement ON((sheeps.gov_sheep_id = weight_measurement.animal_id) AND (weight_measurement.animal_id= ?))
         ORDER BY measurement_id DESC
         LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$sheepId]);
        if ($row = $stmt->fetch()) {
            return $row['weight'];
        }
        else{
            return "No recorded measurements";
        }
    }

    public function getSheepWeightMeasurementHistory($govId, $ownerId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from sheeps
        INNER JOIN farm_authority 
        INNER JOIN weight_measurement ON(
            (sheeps.gov_sheep_id = weight_measurement.animal_id) AND 
            (sheeps.farm_id = farm_authority.farm_id) AND 
            (farm_authority.owner_id = ?) AND (weight_measurement.animal_id = ?) 
        )
        ORDER BY measurement_id DESC
         ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId, $govId]);
        if ($stmt->rowCount() > 0) { 
            echo "<div class='search-result'>
                Weight Measurement history of ".$govId.
                "<table>";
            while ($row = $stmt->fetch()) {
                echo"<tr><td> On ".$row['measured_at'].", ".$row['animal_id']." weighed ".$row['weight']."kg.</td></tr>";      
            }
            echo"</table></div>";
            
        }
        else{
            echo "<div class='search-result'>
                    No recorded measurements.
                  </div>";
        }
    }

    public function getSheepInfo($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from sheeps INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?) AND (sheeps.sheep_condition=?))";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id,"available"]);
        if ($stmt->rowCount() > 0) {
            echo "<table>
            <tr>
                <th>Local Sheep ID</th>
                <th>Government Sheep ID</th>
                <th>Gender</th>
                <th>Date Of Birth</th>
                <th>More Info</th>
                <th>Action</th>
            </tr>";
            while ($row = $stmt->fetch()) {
                echo "<tr><td>".$row['local_sheep_id']. "</td>
                <td>" . $row['gov_sheep_id']. "</td>
                <td>" . $row['gender']. "</td>
                <td>" . $row['date_of_birth']. "</td>
                <td><button type='button'  class=' viewBtn viewBtnS' data-id='". $row["gov_sheep_id"]."'>VIEW</button></td>
                <td><a href='../src/FormHandlers/update/declareSheepDead.inc.php?id=".$row['sheep_id']."' class='Btn submitBtn'>Declare Dead?</a></td>
                 </tr>";
            }
            echo"</table>";
        }
        else {
            echo "<div class='search-result'>
                    No Sheep on record. Add Sheep in the form sub-tab.
                  </div>";
        }
        
    }

    public function getSoldSheepInfo($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from sheeps INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?) AND (sheeps.sheep_condition=?))";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id,"sold"]);
        if ($stmt->rowCount() > 0) {
            echo"<table>
            <tr>
                <th>Local Sheep ID</th>
                <th>Government Sheep ID</th>
                <th>Gender</th>
                <th>Date Of Birth</th>
                <th>More Info</th>
            </tr>";
            while ($row = $stmt->fetch()) {
                echo "<tr><td>".$row['local_sheep_id']. "</td>
                <td>" . $row['gov_sheep_id']. "</td>
                <td>" . $row['gender']. "</td>
                <td>" . $row['date_of_birth']. "</td>
                <td><button type='button'  class=' viewBtn viewBtnS2' data-id='". $row["gov_sheep_id"]."'>VIEW</button></td>
                 </tr>";
            }
            echo"</table>";
        }
        else {
            echo "<div class='search-result'>
                    No Sold Sheep on record. Add a Sheep Sale in the Sales tab.
                  </div>";
        }
        
    }

    public function getDeadSheepInfo($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from sheeps INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?) AND (sheeps.sheep_condition=?))";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id,"dead"]);
        if ($stmt->rowCount() > 0) {
            echo"<table>
            <tr>
                <th>Local Sheep ID</th>
                <th>Government Sheep ID</th>
                <th>Gender</th>
                <th>Date Of Birth</th>
                <th>More Info</th>
                <th>Action</th>
            </tr>";
            while ($row = $stmt->fetch()) {
                echo "<tr><td>".$row['local_sheep_id']. "</td>
                <td>" . $row['gov_sheep_id']. "</td>
                <td>" . $row['gender']. "</td>
                <td>" . $row['date_of_birth']. "</td>
                <td><button type='button'  class=' viewBtn viewBtnS3' data-id='". $row["gov_sheep_id"]."'>VIEW</button></td>
                <td><a href='../src/FormHandlers/update/reviveSheep.inc.php?id=".$row['sheep_id']."' class='Btn submitBtn'>Revive?</a></td>
                 </tr>";
            }
            echo"</table>";
        }
        else {
            echo "<div class='search-result'>
                    No Dead Sheep on record. Declare a sheep dead in the sheep sub-tab
                  </div>";
        }
    }

    public function getNumOfSheep($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT COUNT(*) from sheeps INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?) AND (sheeps.sheep_condition=?))";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id,"available"]);
        $count = $stmt->fetchColumn();
        echo "<h2>" . $count . "</h2>";
    }

    public function getSheepBirth($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT num_of_births from sheeps 
        INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN sheep_birth ON((sheeps.gov_sheep_id = sheep_birth.mother_sheep_id)OR(sheeps.local_sheep_id = sheep_birth.mother_sheep_id))
        AND MONTH(sheep_birth.date_of_birth)=MONTH(now())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $count = 0;
        while($row = $stmt->fetch()) {
            $count += $row['num_of_births'];
        }
        echo "<p>Sheep births : " . $count . " this month</p>";
    }

    public function getLastMonthSheepBirths($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT num_of_births from sheeps 
        INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN sheep_birth ON((sheeps.gov_sheep_id = sheep_birth.mother_sheep_id)OR(sheeps.local_sheep_id = sheep_birth.mother_sheep_id))
        AND MONTH(sheep_birth.date_of_birth)=MONTH(now())-1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $count = 0;
        while($row = $stmt->fetch()) {
            $count += $row['num_of_births'];
        }
        echo "<h2>" . $count . " </h2>";
    }

    public function getThisMonthSheepBirths($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT num_of_births from sheeps 
        INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN sheep_birth ON((sheeps.gov_sheep_id = sheep_birth.mother_sheep_id)OR(sheeps.local_sheep_id = sheep_birth.mother_sheep_id))
        AND MONTH(sheep_birth.date_of_birth)=MONTH(now())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $count = 0;
        while($row = $stmt->fetch()) {
            $count += $row['num_of_births'];
        }
        echo "<h2>" . $count . "</h2>";
    }

    public function getSheepDeaths($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT num_dead from sheeps 
        INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN sheep_birth ON((sheeps.gov_sheep_id = sheep_birth.mother_sheep_id)OR(sheeps.local_sheep_id = sheep_birth.mother_sheep_id))
        AND MONTH(sheep_birth.date_of_birth)=MONTH(now())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $count = 0;
        while($row = $stmt->fetch()) {
            $count += $row['num_dead'];
        }
        echo "<p>Sheep deaths : " . $count . " this month</p>";
    }

    public function getLastMonthSheepDeaths($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT num_dead from sheeps 
        INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN sheep_birth ON((sheeps.gov_sheep_id = sheep_birth.mother_sheep_id)OR(sheeps.local_sheep_id = sheep_birth.mother_sheep_id))
        AND MONTH(sheep_birth.date_of_birth)=MONTH(now())-1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $count = 0;
        while($row = $stmt->fetch()) {
            $count += $row['num_dead'];
        }
        echo "<h2>" . $count . "</h2>";
    }

    public function getThisMonthSheepDeaths($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT num_dead from sheeps 
        INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN sheep_birth ON((sheeps.gov_sheep_id = sheep_birth.mother_sheep_id)OR(sheeps.local_sheep_id = sheep_birth.mother_sheep_id))
        AND MONTH(sheep_birth.date_of_birth)=MONTH(now())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $count = 0;
        while($row = $stmt->fetch()) {
            $count += $row['num_dead'];
        }
        echo "<h2>" . $count . "</h2>";
    }

    //Get milk production stats for this month
    public function getMilkProductionThisMonth($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT amount_of_milk from sheeps 
        INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN milk_production ON((sheeps.gov_sheep_id = milk_production.animal_id) OR (sheeps.local_sheep_id = milk_production.animal_id))
        AND MONTH(production_date)=MONTH(now())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $total = 0;
        while ($row = $stmt->fetch()) {
            $total += $row['amount_of_milk'];
        }
        return $total;
    }

    //get milk production for last month
    public function getMilkProductionLastMonth($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT amount_of_milk from sheeps 
        INNER JOIN farm_authority ON((sheeps.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN milk_production ON((sheeps.gov_sheep_id = milk_production.animal_id) OR (sheeps.local_sheep_id = milk_production.animal_id))
        AND MONTH(production_date)=MONTH(now())-1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $total = 0;
        while ($row = $stmt->fetch()) {
            $total += $row['amount_of_milk'];
        }
        return $total;
    }
    //-----------------------------update-----------------------------

    public function updateSheepInfo($sheepId, $localId, $govId, $status){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE sheeps 
            SET local_sheep_id = ?,gov_sheep_id = ?,`status`=?
            WHERE sheep_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$localId, $govId, $status, $sheepId ]);
        $database->closeConnection();
    }

    public function declareSheepDead($sheepId){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE sheeps 
            SET sheep_condition = 'dead'
            WHERE sheep_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$sheepId]);
        $database->closeConnection();
    }

    public function reviveSheep($sheepId){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE sheeps 
            SET sheep_condition = 'available'
            WHERE sheep_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$sheepId]);
        $database->closeConnection();
    }

    public function moveSheep($govId, $newFarmId){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE sheeps 
            SET farm_id = ?
            WHERE gov_sheep_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$newFarmId, $govId]);
        $database->closeConnection();
    }

    public function updateSheepLocalId($sheepId, $localId){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE sheeps 
            SET local_sheep_id = ?
            WHERE sheep_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$localId, $sheepId ]);
        $database->closeConnection();
    }

    public function updateSheepGovId($sheepId, $govId){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE sheeps 
            SET gov_sheep_id = ?
            WHERE sheep_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$govId, $sheepId ]);
        $database->closeConnection();
    }

    public function updateSheepStatus($sheepId, $status){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE sheeps 
            SET `status`=?
            WHERE sheep_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$status, $sheepId ]);
        $database->closeConnection();
    }

     //-----------------------------delete-----------------------------
 }