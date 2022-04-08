<?php
/**
 * 
 * Sales Class
 */

 class Sales{

    public function addSaleCow($ownerId, $animalId, $weight, $price, $cowBreed, $buyerFname, $buyerLname, $DOS){
        $database = new Db();
        $db = $database->connect();
        $sql = "INSERT INTO sales_cow(owner_id, animal_id, `weight`, price, cow_breed, buyer_first_name, buyer_last_name, date_of_sale) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId, $animalId, $weight, $price, $cowBreed, $buyerFname, $buyerLname, $DOS]);

        $sql = "UPDATE cows SET cow_condition=? WHERE gov_cow_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(["sold",$animalId]);

        $database->closeConnection();
    }

    public function addSaleSheep($ownerId, $animalId, $weight, $price, $sheepBreed, $buyerFname, $buyerLname, $DOS){
        $database = new Db();
        $db = $database->connect();
        $sql = "INSERT INTO sales_sheep(owner_id, animal_id, `weight`, price, sheep_breed, buyer_first_name, buyer_last_name, date_of_sale) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId, $animalId, $weight, $price, $sheepBreed, $buyerFname, $buyerLname, $DOS]);

        $sql = "UPDATE sheeps SET sheep_condition=? WHERE gov_sheep_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(["sold",$animalId]);

        $database->closeConnection();
    }

    public function getNumOfSales($ownerId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT COUNT(*) from sales_cow WHERE owner_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId]);
        $count = $stmt->fetchColumn();
        $sql = "SELECT COUNT(*) from sales_sheep WHERE owner_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId]);
        $count += $stmt->fetchColumn();
        echo "<h2>" . $count . "</h2>";
    }

    public function getCowSale($animalId, $ownerId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from sales_cow WHERE ((animal_id=?) AND(owner_id=?))"; 
        $stmt = $db->prepare($sql);
        $stmt->execute([$animalId, $ownerId]);
        if ($row = $stmt->fetch()) {
            echo "<div class='search-result'>
                    Result
                    <table>
                        <tr><td> Animal Gov ID: ".$row['animal_id']."</td></tr>
                        <tr><td> Buyer: ".$row['buyer_first_name']." ".$row['buyer_last_name']."</td></tr>
                        <tr><td> Breed: ".$row['cow_breed']."</td></tr>
                        <tr><td> Price: ".$row['price']."</td></tr>
                        <tr><td> Weight: ".$row['weight']."</td></tr>
                        <tr><td> Date of Sale: ".$row['date_of_sale']."</td>
                    </table>
                 </div>";
        }
        else {
            echo "<div class='search-result'>
                    No cow with this Government Id was sold, Please check the Government Id again
                 </div>";
        }
    }

    public function getSheepSale($animalId, $ownerId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from sales_sheep WHERE ((animal_id=?) AND(owner_id=?))"; 
        $stmt = $db->prepare($sql);
        $stmt->execute([$animalId, $ownerId]);
        if ($row = $stmt->fetch()) {
            echo "<div class='search-result'>
                    Result
                    <table>
                        <tr><td> Animal Gov ID: ".$row['animal_id']."</td></tr>
                        <tr><td> Buyer: ".$row['buyer_first_name']." ".$row['buyer_last_name']."</td></tr>
                        <tr><td> Breed: ".$row['sheep_breed']."</td></tr>
                        <tr><td> Price: ".$row['price']."</td></tr>
                        <tr><td> Weight: ".$row['weight']."</td></tr>
                        <tr><td> Date of Sale: ".$row['date_of_sale']."</td>
                    </table>
                 </div>";
        }
        else {
            echo "<div class='search-result'>
                    No sheep with this Government Id was sold, Please check the Government Id again
                 </div>";
        }
    }

    public function getRecentSalesActivity($ownerId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from sales_cow WHERE owner_id=?
                ORDER BY sale_id DESC LIMIT 5";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId]);
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch()) {
                echo"<div class='timeline-item'>
                        <div class='timeline-badge'> $ </div>
                        <div class='timeline-content'>
                            Sale on ".$row['date_of_sale']." to ".$row['buyer_first_name']." ".$row['buyer_last_name']." for ".$row['price'].
                        "</div>
                    </div>";
            }
        }
        else {
            echo"<br>NO Cow sales made yet<br>";
        }
        $sql = "SELECT * from sales_sheep WHERE owner_id=?
                ORDER BY sale_id DESC LIMIT 5";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId]);
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch()) {
                echo"<div class='timeline-item'>
                        <div class='timeline-badge'> $ </div>
                        <div class='timeline-content'>
                            Sale on ".$row['date_of_sale']." to ".$row['buyer_first_name']." ".$row['buyer_last_name']." for ".$row['price'].
                        "</div>
                    </div>";
            }
        }
        else {
            echo"<br>NO Sheep sales made yet<br>";
        }
        
    }

    public function getSalesSummary($ownerId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from sales_cow WHERE owner_id=?
                ORDER BY sale_id DESC LIMIT 15";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId]);
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch()) {
                echo"<div class='timeline-item'>
                        <div class='timeline-badge'> $ </div>
                        <div class='timeline-content'>
                            Sale on ".$row['date_of_sale']." to ".$row['buyer_first_name']." ".$row['buyer_last_name']." for ".$row['price'].
                        "</div>
                    </div>";
            }
        }
        else {
            echo "<br>No Cow Sales Made</br>";
        }
        $sql = "SELECT * from sales_sheep WHERE owner_id=?
                ORDER BY sale_id DESC LIMIT 5";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId]);
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch()) {
                echo"<div class='timeline-item'>
                        <div class='timeline-badge'> $ </div>
                        <div class='timeline-content'>
                            Sale on ".$row['date_of_sale']." to ".$row['buyer_first_name']." ".$row['buyer_last_name']." for ".$row['price'].
                        "</div>
                    </div>";
            }
        }
        else {
            echo "<br>No Sheep Sales Made</br>";
        }
        
    }

    public function getSalesForPreviousMonth($ownerId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from sales_cow 
        WHERE owner_id=?
        AND MONTH(date_of_sale)=MONTH(now())-1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId]);
        $count = 0;
        while ($row = $stmt->fetch()) {
            $count += $row['price'];
        }

        $sql = "SELECT * from sales_sheep 
        WHERE owner_id=?
        AND MONTH(date_of_sale)=MONTH(now())-1";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId]);
        while ($row = $stmt->fetch()) {
            $count += $row['price'];
        }

        echo "<h2>".$count."TL</h2>";
    }

    public function getSalesForCurrentMonth($ownerId){
        $database = new Db();
        $db = $database->connect();
        $sql = "SELECT * from sales_cow 
        WHERE owner_id=?
        AND MONTH(date_of_sale)=MONTH(now())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId]);
        $count = 0;
        while ($row = $stmt->fetch()) {
            $count += $row['price'];
        }

        $sql = "SELECT * from sales_sheep 
        WHERE owner_id=?
        AND MONTH(date_of_sale)=MONTH(now())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$ownerId]);
        while ($row = $stmt->fetch()) {
            $count += $row['price'];
        }

        echo "<h2>".$count."TL</h2>";
    }

    public function deleteCowSale($animalId){
        $database = new Db();
        $db = $database->connect();
        $sql = "DELETE FROM sales_cow WHERE animal_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$animalId]);

        $sql = "UPDATE cows SET cow_condition=? WHERE gov_cow_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(["available",$animalId]);

        $database->closeConnection();
    }


    public function deleteSheepSale($animalId){
        $database = new Db();
        $db = $database->connect();
        $sql = "DELETE FROM sales_sheep WHERE animal_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$animalId]);

        $sql = "UPDATE sheeps SET sheep_condition=? WHERE gov_sheep_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(["available",$animalId]);

        $database->closeConnection();
    }
 }

?>