<?php

/**
 * 
 * Cow Class
 *
 */

 class Cow{

    //-----------------------------create-----------------------------
    //Add cow to cow table
    public function addNewCow($localId, $govId, $farmId, $DOB, $gender, $status){
        $database = new Db();
        $db = $database->connect();
        $sql = "INSERT INTO cows(local_cow_id, gov_cow_id, farm_id, date_of_birth, gender, `status`, cow_condition) VALUES (?,?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$localId, $govId, $farmId, $DOB, $gender, $status, "available"]);
        $database->closeConnection();
    }

    //Add new calves births to "cow_birth" table
    public function addNewBirth($motherId, $numOfBirths, $numOfDeaths, $DOB){
        $database = new Db();
        $db = $database->connect();

        $sql = "SELECT gender FROM cows WHERE gov_cow_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$motherId]);
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            if ($row["gender"] == "Male") {
                header("location: ../../../public/userPanel.php?dest=cowRegC&msg=wronggender");
                exit();
            }
            else {
                $sql = "INSERT INTO cow_birth(mother_cow_id, num_of_births, num_dead, date_of_birth) VALUES (?,?,?,?)";
                $stmt = $db->prepare($sql);
                $stmt->execute([$motherId, $numOfBirths, $numOfDeaths, $DOB]);
                $database->closeConnection();
            }
        }
        else{
            header("location: ../../../public/userPanel.php?dest=cowRegC&msg=cownotexist");
            exit();
        }
    }

    public function addMilkEntry($govId, $milkProduced, $DOE){
        $database = new Db();
        $db = $database->connect();

        $sql = "SELECT gender FROM cows WHERE gov_cow_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$govId]);
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            if ($row["gender"] == "Male") {
                header("location: ../../../public/userPanel.php?dest=cowRegC&msg=wronggender");
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
            header("location: ../../../public/userPanel.php?dest=cowRegC&msg=cownotexist");
            exit();
        }
    }

    public function addWeightMeasurement($animalId, $weight, $DOM){
        $database = new Db();
        $db = $database->connect();
        $sql = "INSERT INTO weight_measurement(animal_id, `weight`, measured_at ) VALUES (?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$animalId, $weight, $DOM]);
        $database->closeConnection();
    }

    public function addVaccination($animalId, $vaccine, $DOV){
        $database = new Db();
        $db = $database->connect();
        $sql = "INSERT INTO cow_vaccinations(cow_id, vaccine_name, date_of_vaccination ) VALUES (?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$animalId, $vaccine, $DOV]);
        $database->closeConnection();
    }
    //-----------------------------read-----------------------------

    public function getCowVaccinationHistory($govId, $ownerId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * FROM cows 
        INNER JOIN cow_vaccinations
        INNER JOIN farm_authority ON (
            (cows.gov_cow_id = cow_vaccinations.cow_id) AND 
            (cows.farm_id = farm_authority.farm_id) AND 
            (farm_authority.owner_id = ?) AND (cow_vaccinations.cow_id = ?)
        )
        ORDER BY vaccination_id DESC
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId, $govId]);
        if ($stmt->rowCount() > 0) {
            echo "<div class='search-result'>
                    Vaccination history of ".$govId.
                    "<table>";
            while ($row = $stmt->fetch()) {
                echo "<tr><td>".$row['cow_id']." was given the ".$row['vaccine_name']." vaccine on ".$row['date_of_vaccination']."</td></tr>";      
            }
            echo"</table></div>";
        }
        else {
            echo "<div class='search-result'>
                    No vaccinations administered yet
                </div>";
        } 
    }

    public function getCowsInfo($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from cows INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?) AND (cows.cow_condition=?))";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id,"available"]);
        if ($stmt->rowCount() > 0) {
            echo"<table>
            <tr>
                <th>Local Cow ID</th>
                <th>Government Cow ID</th>
                <th>Gender</th>
                <th>Date Of Birth</th>
                <th>More Info</th>
                <th>Action</th>
            </tr>";
            while ($row = $stmt->fetch()) {
                echo "<tr><td>".$row['local_cow_id']. "</td>
                   <td>" . $row['gov_cow_id']. "</td>
                   <td>" . $row['gender']. "</td>
                   <td>" . $row['date_of_birth']. "</td>
                   <td><button type='button' class=' viewBtn viewBtnC' id='myBtn' data-id='". $row["gov_cow_id"]."' >VIEW</button></td>
                   <td><a href='../src/FormHandlers/update/declareCowDead.inc.php?id=".$row['cow_id']."' class='Btn submitBtn'>Declare Dead?</a></td>
                    </tr>";
            }
            echo"</table>";
        }
        else {
            echo "<div class='search-result'>
                    No Cows on record. Add Cows in the form sub-tab.
                  </div>";
        }
    }

    public function getSoldCowsInfo($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from cows INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?) AND (cows.cow_condition=?))";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id,"sold"]);
        if ($stmt->rowCount() > 0) {
            echo"<table>
            <tr>
                <th>Local Cow ID</th>
                <th>Government Cow ID</th>
                <th>Gender</th>
                <th>Date Of Birth</th>
                <th>More Info</th>
            </tr>";
            while ($row = $stmt->fetch()) {
                echo "<tr><td>".$row['local_cow_id']. "</td>
                   <td>" . $row['gov_cow_id']. "</td>
                   <td>" . $row['gender']. "</td>
                   <td>" . $row['date_of_birth']. "</td>
                   <td><button type='button' class=' viewBtn viewBtnC2' id='myBtn' data-id='". $row["gov_cow_id"]."' >VIEW</button></td>
                    </tr>";
            }
            echo"</table>";
        }
        else {
            echo "<div class='search-result'>
                    No Sold Cows on record. Make a Cow sale record under the Sales tab.
                  </div>";
        }
        
    }

    public function getDeadCowsInfo($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from cows INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?) AND (cows.cow_condition=?))";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id,"dead"]);
        if ($stmt->rowCount() > 0) {
            echo"<table>
            <tr>
                <th>Local Cow ID</th>
                <th>Government Cow ID</th>
                <th>Gender</th>
                <th>Date Of Birth</th>
                <th>More Info</th>
                <th>Action</th>
            </tr>";
            while ($row = $stmt->fetch()) {
                echo "<tr><td>".$row['local_cow_id']. "</td>
                   <td>" . $row['gov_cow_id']. "</td>
                   <td>" . $row['gender']. "</td>
                   <td>" . $row['date_of_birth']. "</td>
                   <td><button type='button' class=' viewBtn viewBtnC3' id='myBtn' data-id='". $row["gov_cow_id"]."' >VIEW</button></td>
                   <td><a href='../src/FormHandlers/update/reviveCow.inc.php?id=".$row['cow_id']."' class='Btn submitBtn'>Revive?</a></td>
                    </tr>";
            }
            echo"</table>";
        }
        else {
            echo "<div class='search-result'>
                    No Dead Cows on record. Declare Cows dead in the Cows sub-tab.
                  </div>";
        }
    }
    
    public function getNumOfCows($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT COUNT(*) from cows INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?) AND (cows.cow_condition = 'available'))";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $count = $stmt->fetchColumn();
        echo "<h2>" . $count . "</h2>";
    }

    public function getLastWeightMeasurement($cowId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT `weight` from cows INNER JOIN
         weight_measurement ON((cows.gov_cow_id = weight_measurement.animal_id) AND (weight_measurement.animal_id= ?))
         ORDER BY measurement_id DESC
         LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$cowId]);
        if ($row = $stmt->fetch()) {
            return $row['weight'];
        }
        else{
            return "No recorded measurements";
        }
    }

    public function getCowWeightMeasurementHistory($govId, $ownerId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from cows
        INNER JOIN farm_authority
        INNER JOIN weight_measurement ON (
             (cows.gov_cow_id = weight_measurement.animal_id) AND
             (cows.farm_id = farm_authority.farm_id) AND 
             (farm_authority.owner_id = ?) AND (weight_measurement.animal_id= ?)
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

    public function getCowBirth($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT num_of_births from cows 
        INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN cow_birth ON((cows.gov_cow_id = cow_birth.mother_cow_id)OR(cows.local_cow_id = cow_birth.mother_cow_id))
        AND MONTH(cow_birth.date_of_birth)=MONTH(now())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $count = 0;
        while($row = $stmt->fetch()) {
            $count += $row['num_of_births'];
            
        }
        echo "<p> Cow Births : " . $count . " this month</p>";   
    }

    public function getCowDeaths($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT num_dead from cows 
        INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN cow_birth ON((cows.gov_cow_id = cow_birth.mother_cow_id)OR(cows.local_cow_id = cow_birth.mother_cow_id))
        AND MONTH(cow_birth.date_of_birth)=MONTH(now())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $count = 0;
        while($row = $stmt->fetch()) {
            $count += $row['num_dead'];
            
        }
        echo "<p> Cow Deaths : " . $count . " this month</p>";   
    }

    public function getThisMonthCowBirths($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT num_of_births from cows 
        INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN cow_birth ON((cows.gov_cow_id = cow_birth.mother_cow_id)OR(cows.local_cow_id = cow_birth.mother_cow_id))
        AND MONTH(cow_birth.date_of_birth)=MONTH(now())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $count = 0;
        while($row = $stmt->fetch()) {
            $count += $row['num_of_births'];
            
        }
        echo "<h2>". $count ."</h2>";   
    }

    public function getLastMonthCowBirths($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT num_of_births from cows 
        INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN cow_birth ON((cows.gov_cow_id = cow_birth.mother_cow_id)OR(cows.local_cow_id = cow_birth.mother_cow_id))
        AND MONTH(cow_birth.date_of_birth)=MONTH(now())-1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $count = 0;
        while($row = $stmt->fetch()) {
            $count += $row['num_of_births'];
            
        }
        echo "<h2>". $count . "</h2>";   
    }

    public function getThisMonthCowDeaths($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT num_dead from cows 
        INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN cow_birth ON((cows.gov_cow_id = cow_birth.mother_cow_id)OR(cows.local_cow_id = cow_birth.mother_cow_id))
        AND MONTH(cow_birth.date_of_birth)=MONTH(now())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $count = 0;
        while($row = $stmt->fetch()) {
            $count += $row['num_dead'];
            
        }
        echo "<h2>" . $count . "</h2>";   
    }

    public function getLastMonthCowDeaths($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT num_dead from cows 
        INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN cow_birth ON((cows.gov_cow_id = cow_birth.mother_cow_id)OR(cows.local_cow_id = cow_birth.mother_cow_id))
        AND MONTH(cow_birth.date_of_birth)=MONTH(now())-1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $count = 0;
        while($row = $stmt->fetch()) {
            $count += $row['num_dead'];
            
        }
        echo "<h2>" . $count . "</h2>";   
    }

    //Gets all the milk production for your cows
    public function getRecentMilkProductionActivity($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from cows 
        INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN milk_production ON((cows.gov_cow_id = milk_production.animal_id) OR (cows.local_cow_id = milk_production.animal_id))
        ORDER BY production_id DESC LIMIT 2";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch()) {
                echo "<div class='timeline-item'>
                        <div class='timeline-badge'> $ </div>
                            <div class='timeline-content'> Cow "
                            .$row['local_cow_id']." produced ".$row['amount_of_milk']." liters of milk on ".$row['production_date'].
                        "</div>
                    </div>";
            }
        }
        else {
            echo "<br>No cow milk produced yet<br>";
        } 
    }

    //Gets all the milk production for your cows
    public function getMilkProduction($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from cows 
        INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN milk_production ON((cows.gov_cow_id = milk_production.animal_id) OR (cows.local_cow_id = milk_production.animal_id))
        ORDER BY production_id DESC LIMIT 5";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch()) {
                echo "<div class='timeline-item'>
                        <div class='timeline-badge'> $ </div>
                            <div class='timeline-content'> Cow "
                            .$row['local_cow_id']." produced ".$row['amount_of_milk']." liters of milk on ".$row['production_date'].
                        "</div>
                    </div>";
            }
        }
        else {
            echo "<br>No Cow milk has been produced yet<br>";
        }
        
    }

    //Get milk production stats for this month
    public function getMilkProductionThisMonth($id){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT amount_of_milk from cows 
        INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN milk_production ON((cows.gov_cow_id = milk_production.animal_id) OR (cows.local_cow_id = milk_production.animal_id))
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
        $sql = "SELECT amount_of_milk from cows 
        INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) AND (farm_authority.owner_id = ?))
        INNER JOIN milk_production ON((cows.gov_cow_id = milk_production.animal_id) OR (cows.local_cow_id = milk_production.animal_id))
        AND MONTH(production_date)=MONTH(now())-1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $total = 0;
        while ($row = $stmt->fetch()) {
            $total += $row['amount_of_milk'];
        }
        return $total;
    } 

    public function getCowMPHistory($cowId, $ownerId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from cows 
        INNER JOIN farm_authority ON((cows.farm_id = farm_authority.farm_id) 
                                  AND (farm_authority.owner_id = ?) 
                                  AND ((cows.gov_cow_id = ?) OR (cows.local_cow_id = ?)))
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId,$cowId,$cowId]);

        //save local and gov ids
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch();
            if ($result['gender'] == "Male") {
                echo "<div class='search-result'>
                        This is a Male Cow
                      </div>";
            }
            else {
                $localId = $result['local_cow_id'];
                $govId = $result['gov_cow_id'];
        
        
                $sql = "SELECT * from milk_production WHERE ((animal_id = ?)OR (animal_id=?))";
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
            You do not own a cow with this ID, please check entry information and try again
                  </div>";
        }
    }


    public function getCowVaccination($cowId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * FROM cow_vaccinations WHERE cow_id = ?
        ORDER BY vaccination_id DESC
        LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$cowId]);
        if ($row = $stmt->fetch()) {
            return $row['vaccine_name'];
        }
        else {
            return "No vaccinations administered yet";
        } 
    }
    //-----------------------------update-----------------------------

    public function updateCowInfo($cowId, $localId, $govId, $status){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE cows 
            SET local_cow_id = ?,gov_cow_id = ?,`status`=?
            WHERE cow_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$localId, $govId, $status, $cowId ]);
        $database->closeConnection();
    }

    public function declareCowDead($cowId){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE cows 
            SET cow_condition = 'dead'
            WHERE cow_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$cowId]);
        $database->closeConnection();
    }

    public function reviveCow($cowId){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE cows 
            SET cow_condition = 'available'
            WHERE cow_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$cowId]);
        $database->closeConnection();
    }

    public function moveCow($govId, $newFarmId){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE cows 
            SET farm_id = ?
            WHERE gov_cow_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$newFarmId, $govId]);
        $database->closeConnection();
    }

    public function updateCowLocalId($cowId, $localId){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE cows 
            SET local_cow_id = ?
            WHERE cow_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$localId, $cowId ]);
        $database->closeConnection();
    }

    public function updateCowGovId($cowId, $govId){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE cows 
            SET gov_cow_id = ?
            WHERE cow_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$govId, $cowId ]);
        $database->closeConnection();
    }

    public function updateCowStatus($cowId, $status){
        $database = new Db();
        $db = $database->connect();
        $sql = "UPDATE cows 
            SET `status`=?
            WHERE cow_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$status, $cowId ]);
        $database->closeConnection();
    }
    //-----------------------------delete-----------------------------
    
    

    

    


 }