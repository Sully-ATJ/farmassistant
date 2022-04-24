<?php
    include_once '../config/db.php';
    include '../src/autoloader.inc.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <link rel="stylesheet" href="css/userPanel.css">
    <script src="js/userPanel.js" type="text/javascript"></script>
    <title>User Panel</title>
</head>
<body>
    <div class="wrapper">

        <!-- The Cow info Modal -->
        <div id="myCowModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close closeBtn1">&times;</span>
                    <h2>Cow Details</h2>
                </div>
                <div class="modal-body">
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="closeBtn1">Close</button>
                </div>
            </div>
        </div>

         <!-- The Sheep info Modal -->
        <div id="mySheepModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close closeBtn2">&times;</span>
                    <h2>Sheep Modal</h2>
                </div>
                <div class="modal-body">
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="closeBtn2">Close</button>
                </div>
            </div>
        </div>

        <!-- Side tab menu-->
        <div id="menu" class="menu">
            <h3 class="logo">Farm Assistant</h3>
            <ul>
                <li><a id="farm" class="tab" >Farms</a></li>
                <label class="labels">Animals</label>
                <li><a id="cowReg" class="tab" >Cow Registry</a></li>
                <li><a id="sheepReg" class="tab" >Sheep Registry</a></li>
                <li><a id="milkProduction" class="tab" >Milk Production</a></li>
                <hr>
                <li><a id="sales" class="tab" >Sales</a></li>
                <li><a id="notes" class="tab" >Notes</a></li>
                <hr>
                <li><a id="setting" class="tab" >Settings</a></li>
                <li><a id="help" class="tab" >Help</a></li>
            </ul>
        </div>

        <!-- Main page-->
        <div class="page">
            <!-- Nav Bar-->
            <div class="nav">
                <?php
                    echo $_SESSION["fname"] . " " . $_SESSION["lname"] . " " . $_SESSION["userId"];
                ?>
                <ul>
                    <a href='../src/FormHandlers/logout.inc.php'> Log out</a>
                </ul>
            </div>
            <div class="page-wrapper">

                <!-- ---------------Farm div---------------- -->
                <div id="farmC" class="page-content">
                    <ul id="f-tabs">
                        <li><a id="f-tab1" class="sub-tab">Dashboard</a></li>
                        <li><a id="f-tab2" class="sub-tab">Forms</a></li>
                    </ul>
                    <div id="f-tab1C" class="f-container">
                        <div class="farm-stats">
                            <div class="farm-stat-item">
                                <?php
                                $sales = new Sales();
                                $sales->getNumOfSales($_SESSION["userId"])
                                ?>    Sales
                            </div>
                            <div class="farm-stat-item">
                                <?php 
                                $cows = new Cow();
                                $cows->getNumOfCows($_SESSION["userId"]);
                                ?>  Cows
                            </div>
                            <div class="farm-stat-item">
                                <?php 
                                $sheep = new Sheep();
                                $sheep->getNumOfSheep($_SESSION["userId"]);
                                ?>  Sheep
                            </div>
                        </div>
                        <div class="farm-info">
                            <div class="gen-farm-info">
                                <h3>My Farms</h3>
                                <?php
                                    $farm = new Farm();
                                    $farm->displayAllFarms($_SESSION["userId"]);
                                ?>
                            </div>
                            <div class="farm-numbers">
                                <div class="farm-mp">
                                    <p> Milk Production</p>
                                    <?php
                                        $cow = new Cow();
                                        $sheep = new Sheep();
                                        echo" Cow Milk ".$cow->getMilkProductionThisMonth($_SESSION["userId"])."L This month<br><hr>";
                                        echo" Sheep Milk ".$sheep->getMilkProductionThisMonth($_SESSION["userId"])."L This month";
                                    ?>
                                </div>
                                <div class="farm-births">
                                    <?php
                                        $cow = new Cow();
                                        $sheep = new Sheep();
                                        $cow->getCowBirth($_SESSION["userId"]);
                                        $sheep->getSheepBirth($_SESSION["userId"]);
                                        echo"<hr>";
                                        $cow->getCowDeaths($_SESSION["userId"]);
                                        $sheep->getSheepDeaths($_SESSION["userId"]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="f-tab2C" class="f-container">
                        <form action="../src/FormHandlers/create/createFarm.inc.php" method="post">
                            <h3>Add New Farm</h3>
                            <?php
                                echo '<input type="hidden" name="userId" value="'.$_SESSION['userId'].'">';
                            ?>
                            <div class="form-group">
                                <label for="farm-name">Farm Name: </label>
                                <input type="text" name="farm-name" required>
                            </div>
                            <div class="form-group">
                                <label for="farm-location">Farm Location: </label>
                                <input type="text" name="farm-location" required>
                            </div>
                            <button type="submit" name="create-farm" class="Btn submitBtn">Submit</button>
                        </form>
                        <form action="../src/FormHandlers/update/updateFarm.inc.php" method="post">
                            <h3>Update Farm Info</h3>
                            <p style='color:#f00'>If you are only changing 1 field, fill the other field with its current value.</p>
                            <div class="form-group">
                                <label for="farm-id">Select Farm : </label>
                                <select name="farm-id" id="" required>
                                    <option value="">>---Select---<</option>
                                    <?php
                                        $farm = new Farm();
                                        $farm->getAllFarms($_SESSION["userId"]);
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="farm-name">New Farm Name: </label>
                                <input type="text" name="farm-name" required>
                            </div>
                            <div class="form-group">
                                <label for="farm-location"> New Farm Location: </label>
                                <input type="text" name="farm-location">
                            </div>
                            <button type="submit" name="update-farm" class="Btn updateBtn">Update</button>
                        </form>
                        <form action="../src/FormHandlers/delete/deleteFarm.inc.php" method="post">
                            <h3>Delete Farm</h3>
                            <p style='color:#f00'>Make sure all animals are sold or added to other farms before you delete farm!</p> 
                            <div class="form-group">
                                <label for="farm-name">Farm Name: </label>
                                <input type="text" name="farm-name">
                            </div>
                            <div class="form-group">
                                <label for="farm-location">Farm Location: </label>
                                <input type="text" name="farm-location">
                            </div>
                            <button type="submit" name="delete-farm" class="Btn deleteBtn">Delete</button>
                        </form>  
                    </div>
                </div>

                <!-- ---------------Cow Registry div---------------- -->
                <div id="cowRegC" class="page-content">
                    <ul id="c-tabs">
                        <li><a id="c-tab1" class="sub-tab">Cow info</a></li>
                        <li><a id="c-tab2" class="sub-tab">Sold Cows</a></li>
                        <li><a id="c-tab3" class="sub-tab">Dead Cows</a></li>
                        <li><a id="c-tab4" class="sub-tab">Forms</a></li>
                    </ul>
                    <div id="c-tab1C" class="container">
                        <div class="cows-stats">
                            <div class="cow-stat-item">
                                <?php
                                    $cow = new Cow();
                                    $cow->getLastMonthCowDeaths($_SESSION["userId"]);
                                ?>Deaths Last Month
                            </div>
                            <div class="cow-stat-item">
                                <?php
                                    $cow = new Cow();
                                    $cow->getThisMonthCowDeaths($_SESSION["userId"]);
                                ?>Deaths This Month
                            </div>
                            <div class="cow-stat-item">
                                <?php
                                    $cow = new Cow();
                                    $cow->getLastMonthCowBirths($_SESSION["userId"]);
                                ?>Births Last Month
                            </div>
                            <div class="cow-stat-item">
                                <?php
                                    $cow = new Cow();
                                    $cow->getThisMonthCowBirths($_SESSION["userId"]);
                                ?>Births This Month
                            </div>
                        </div>
                        <form class="req-form" action="" method="POST">
                            <input type="hidden" name="dest" value="cowRegC" />
                            <input type="text" name="animal-id" placeholder="Enter Cow Gov ID" required/>
                            <input type="radio" id="vax" name="option" value="1" required>
                            <label for="vax">Vaccinations</label>
                            <input type="radio" id="weight" name="option" value="2">
                            <label for="weight">Weight Measurements</label>
                            <input type="submit" name="get-val"/>
                        </form>
                        <?php
                            if (isset($_POST['get-val'])) {
                                if ($_POST['option'] == 1) {
                                    $cow = new Cow();
                                    $cow->getCowVaccinationHistory($_POST['animal-id'], $_SESSION["userId"]);
                                }
                                else if($_POST['option'] == 2) {
                                    $cow = new Cow();
                                    $cow->getCowWeightMeasurementHistory($_POST['animal-id'], $_SESSION["userId"]);
                                } 
                            }
                        ?> 
                        <?php
                            $cow = new Cow();
                            $cow->getCowsInfo($_SESSION["userId"]);
                        ?>
                    </div>
                    <div id="c-tab2C" class="container">
                        <?php
                            $cow = new Cow();
                            $cow->getSoldCowsInfo($_SESSION["userId"]);
                        ?>
                    </div> 
                    <div id="c-tab3C" class="container"> 
                        <?php
                            $cow = new Cow();
                            $cow->getDeadCowsInfo($_SESSION["userId"]);
                        ?>
                    </div> 
                    <div id="c-tab4C" class="container">
                        <form action="../src/FormHandlers/create/createCow.inc.php" method="post">
                            <h3>Add Cow Farm</h3>
                            <div class="form-group">
                                <label for="local-id">Local Cow ID : </label>
                                <input type="text" name="local-id" required>
                            </div>
                            <div class="form-group">
                                <label for="gov-id">Government Cow ID : </label>
                                <input type="text" name="gov-id" required>
                            </div>
                            <div class="form-group">
                                <label for="farm-id">Farm ID : </label>
                                <select name="farm-id" id="" required>
                                    <option value="">>---Select---<</option>
                                    <?php
                                        $farm = new Farm();
                                        $farm->getAllFarms($_SESSION["userId"]);
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date Of Birth : </label>
                                <input type="date" name="dob" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender : </label>
                                <select name="gender" id="" required>
                                    <option value="">>---Select---<</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status : </label>
                                <input type="text" name="status" required>
                            </div>
                            <button type="submit" name="create-cow" class="Btn submitBtn">Submit</button>
                        </form>
                        <form action="../src/FormHandlers/create/addBirthRecordCow.inc.php" method="post">
                            <h3>Add Birth Record</h3>
                            <div class="form-group">
                                <label for="mother-id">Mother Cow Government ID : </label>
                                <input type="text" name="mother-id" required>
                            </div>
                            <div class="form-group">
                                <label for="numOfBirth">Number of Births : </label>
                                <input type="number" name="numOfBirth" required>
                            </div>
                            <div class="form-group">
                                <label for="numOfDeath">Number of Deaths : </label>
                                <input type="number" name="numOfDeath" required>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date Of Birth : </label>
                                <input type="date" name="dob" required>
                            </div>
                            <button type="submit" name="add-birth" class="Btn submitBtn">Submit</button>
                        </form>
                        <form action="../src/FormHandlers/create/addWeightCow.inc.php" method="post">
                            <h3>Add Cow Weight</h3>
                            <div class="form-group">
                                <label for="animal-id">Government Cow ID : </label>
                                <input type="text" name="animal-id" required>
                            </div>
                            <div class="form-group">
                                <label for="weight">Weight: </label>
                                <input type="number" name="weight" required>
                            </div>
                            <div class="form-group">
                                <label for="dom">Date Of Measurement : </label>
                                <input type="date" name="dom" required>
                            </div>
                            <button type="submit" name="add-weight" class="Btn submitBtn">Submit</button>
                        </form>
                        <form action="../src/FormHandlers/create/addVaccination.inc.php" method="post">
                            <h3>Add Vaccination Record</h3>
                            <div class="form-group">
                                <label for="cow-id">Government Cow ID : </label>
                                <input type="text" name="cow-id" required>
                            </div>
                            <div class="form-group">
                                <label for="vaccine">Vaccine Name : </label>
                                <input type="text" name="vaccine" required>
                            </div>
                            <div class="form-group">
                                <label for="dov">Date Of Vaccination : </label>
                                <input type="date" name="dov" required>
                            </div>
                            <button type="submit" name="add-vax" class="Btn submitBtn">Submit</button>
                        </form>
                        <form action="../src/FormHandlers/update/moveCow.inc.php" method="post">
                            <h3>Move Cow to Another Farm</h3>
                            <div class="form-group">
                                <label for="gov-id">Government Cow ID : </label>
                                <input type="text" name="gov-id" required>
                            </div>
                            <div class="form-group">
                                <label for="farm-id"> New Farm : </label>
                                <select name="farm-id" id="" required>
                                    <option value="">>---Select---<</option>
                                    <?php
                                        $farm = new Farm();
                                        $farm->getAllFarms($_SESSION["userId"]);
                                    ?>
                                </select>
                            </div>
                            <button type="submit" name="move-cow" class="Btn submitBtn">Move Cow</button>
                        </form>
                    </div>
                </div>

                <!-- ---------------Sheep Registry div---------------- -->
                <div id="sheepRegC" class="page-content">
                    <ul id="s-tabs">
                        <li><a id="s-tab1" class="sub-tab">Sheep info</a></li>
                        <li><a id="s-tab2" class="sub-tab">Sold Sheep</a></li>
                        <li><a id="s-tab3" class="sub-tab">Dead Sheep</a></li>
                        <li><a id="s-tab4" class="sub-tab">Forms</a></li>
                    </ul>
                    <div id="s-tab1C" class="s-container">
                        <div class="sheep-stats">
                            <div class="sheep-stat-item">
                                <?php
                                    $sheep = new Sheep();
                                    $sheep->getLastMonthSheepDeaths($_SESSION["userId"]);
                                ?>Deaths Last Month
                            </div>
                            <div class="sheep-stat-item">
                                <?php
                                    $sheep = new Sheep();
                                    $sheep->getThisMonthSheepDeaths($_SESSION["userId"]);
                                ?>Deaths This Month
                            </div>
                            <div class="sheep-stat-item">
                                <?php
                                    $sheep = new Sheep();
                                    $sheep->getLastMonthSheepBirths($_SESSION["userId"]);
                                ?>Births Last Month
                            </div>
                            <div class="sheep-stat-item">
                                <?php
                                    $sheep = new Sheep();
                                    $sheep->getThisMonthSheepBirths($_SESSION["userId"]);
                                ?>Births This Month
                            </div>
                        </div>
                        <form action="" class="req-form" method="POST">
                            <input type="text" name="animal-id" placeholder="Enter Gov/Local ID" required/>
                            <input type="hidden" name="dest" value="sheepRegC">
                            <input type="submit" name="get-weight"/>
                        </form> 
                        <?php
                            if (isset($_POST['get-weight'])) {
                                $sheep = new Sheep();
                                $sheep->getSheepWeightMeasurementHistory($_POST['animal-id'], $_SESSION["userId"]);
                            }
                        ?> 
                        <?php
                            $sheep = new Sheep();
                            $sheep->getSheepInfo($_SESSION["userId"]);
                        ?>
                        
                    </div>
                    <div id="s-tab2C" class="s-container">
                        <?php
                            $sheep = new Sheep();
                            $sheep->getSoldSheepInfo($_SESSION["userId"]);
                        ?>
                    </div>
                    <div id="s-tab3C" class="s-container">
                        <?php
                            $sheep = new Sheep();
                            $sheep->getDeadSheepInfo($_SESSION["userId"]);
                        ?>
                    </div>
                    <div id="s-tab4C" class="s-container">
                        <form action="../src/FormHandlers/create/createSheep.inc.php" method="post">
                            <h3>Add Sheep to Farm</h3>
                            <div class="form-group">
                                <label for="local-id">Local Sheep ID : </label>
                                <input type="text" name="local-id" required>
                            </div>
                            <div class="form-group">
                                <label for="gov-id">Government Sheep ID : </label>
                                <input type="text" name="gov-id" required>
                            </div>
                            <div class="form-group">
                                <label for="farm-id">Farm ID : </label>
                                <select name="farm-id" id="" required>
                                    <option value="">>---Select---<</option>
                                    <?php
                                        $farm = new Farm();
                                        $farm->getAllFarms($_SESSION["userId"]);
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date Of Birth : </label>
                                <input type="date" name="dob" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender : </label>
                                <select name="gender" id="" required>
                                    <option value="">>---Select---<</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status : </label>
                                <input type="text" name="status" required>
                            </div>
                            <button type="submit" name="create-sheep" class="Btn submitBtn">Submit</button>
                        </form>
                        <form action="../src/FormHandlers/create/addBirthRecordSheep.inc.php" method="post">
                            <h3>Add Birth Record</h3>
                            <div class="form-group">
                                <label for="mother-id">Mother Sheep Government ID : </label>
                                <input type="text" name="mother-id" required>
                            </div>
                            <div class="form-group">
                                <label for="numOfBirth">Number of Births : </label>
                                <input type="number" name="numOfBirth" required>
                            </div>
                            <div class="form-group">
                                <label for="numOfDeath">Number of Deaths : </label>
                                <input type="number" name="numOfDeath" required>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date Of Birth : </label>
                                <input type="date" name="dob" required>
                            </div>
                            <button type="submit" name="add-birth" class="Btn submitBtn">Submit</button>
                        </form>
                        <form action="../src/FormHandlers/create/addWeightSheep.inc.php" method="post">
                            <h3>Add Sheep Weight</h3>
                            <div class="form-group">
                                <label for="animal-id">Government Sheep ID : </label>
                                <input type="text" name="animal-id" required>
                            </div>
                            <div class="form-group">
                                <label for="weight">Weight: </label>
                                <input type="number" name="weight" required>
                            </div>
                            <div class="form-group">
                                <label for="dom">Date Of Measurement : </label>
                                <input type="date" name="dom" required>
                            </div>
                            <button type="submit" name="add-weight" class="Btn submitBtn">Submit</button>
                        </form>
                        <form action="../src/FormHandlers/update/moveSheep.inc.php" method="post">
                            <h3>Move Sheep to Another Farm</h3>
                            <div class="form-group">
                                <label for="gov-id">Government Sheep ID : </label>
                                <input type="text" name="gov-id" required>
                            </div>
                            <div class="form-group">
                                <label for="farm-id"> New Farm : </label>
                                <select name="farm-id" id="" required>
                                    <option value="">>---Select---<</option>
                                    <?php
                                        $farm = new Farm();
                                        $farm->getAllFarms($_SESSION["userId"]);
                                    ?>
                                </select>
                            </div>
                            <button type="submit" name="move-sheep" class="Btn submitBtn">Move Sheep</button>
                        </form>
                    </div>
                </div>

                <!-- ---------------Milk Production div---------------- -->
                <div id="milkProductionC" class="page-content">
                    <ul id="mp-tabs">
                        <li><a id="mp-stats" class="sub-tab">Dashboard</a></li>
                        <li><a id="mp-forms" class="sub-tab">Forms</a></li>
                    </ul>
                    <div id="mp-statsC" class="mp-container">
                        <div class="mp-figs">
                            <div class="mp-fig-item">
                                <?php
                                $cow = new Cow();
                                $sheep = new Sheep();
                                $totalMP = $cow->getMilkProductionLastMonth($_SESSION["userId"]);
                                $totalMP += $sheep->getMilkProductionLastMonth($_SESSION["userId"]);
                                echo"<h2>".$totalMP."L</h2>";
                                ?> Last Month
                            </div>
                            <div class="mp-fig-item">
                            <?php
                                $cow = new Cow();
                                $sheep = new Sheep();
                                $totalMP = $cow->getMilkProductionThisMonth($_SESSION["userId"]);
                                $totalMP += $sheep->getMilkProductionThisMonth($_SESSION["userId"]);
                                echo"<h2>".$totalMP."L</h2>";
                                ?> This Month
                            </div>
                        </div>
                        <form class="req-form" action="" method="POST">
                            <input type="hidden" name="dest" value="milkProductionC" />
                            <input type="text" name="animal-id" placeholder="Enter Animal (Cow/Sheep)Gov ID" required/>
                            <input type="radio" id="cow" name="option" value="1" required>
                            <label for="cow">Cow</label>
                            <input type="radio" id="sheep" name="option" value="2">
                            <label for="sheep">Sheep</label>
                            <input type="submit" name="get-mp"/>
                        </form>
                        <?php
                            if (isset($_POST['get-mp'])) {
                                if ($_POST['option'] == 1) {
                                    $cow = new Cow();
                                    $cow->getCowMPHistory($_POST['animal-id'], $_SESSION["userId"]);
                                }
                                else {
                                    $sheep = new Sheep();
                                    $sheep->getSheepMPHistory($_POST['animal-id'],$_SESSION["userId"]);
                                } 
                            }
                        ?>
                        <div class="mpStats">
                            <div class="timeline">
                                <h3>Milk Production Stats</h3>
                                <?php
                                    $cow = new Cow();
                                    $cow->getMilkProduction($_SESSION["userId"]);
                                    $sheep = new Sheep();
                                    $sheep->getMilkProduction($_SESSION["userId"]);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div id="mp-formsC" class="mp-container">
                        <form action="../src/FormHandlers/create/addCowMP.inc.php" method="post">
                            <h3>Add entry for Cow Milk Production</h3>
                            <div class="form-group">
                                <label for="gov-id">Government Cow ID : </label>
                                <input type="text" name="gov-id" required>
                            </div>
                            <div class="form-group">
                                <label for="milk-produced">Amount of Milk Produced : </label>
                                <input type="number" name="milk-produced" required>
                            </div>
                            <div class="form-group">
                                <label for="doe">Date Of Entry : </label>
                                <input type="date" name="doe" required>
                            </div>
                            <button type="submit" name="add-entry" class="Btn submitBtn">Submit</button>
                        </form>
                        <form action="../src/FormHandlers/create/addSheepMP.inc.php" method="post">
                            <h3>Add entry for Sheep Milk Production</h3>
                            <div class="form-group">
                                <label for="gov-id">Government Sheep ID : </label>
                                <input type="text" name="gov-id" required>
                            </div>
                            <div class="form-group">
                                <label for="milk-produced">Amount of Milk Produced : </label>
                                <input type="number" name="milk-produced" required>
                            </div>
                            <div class="form-group">
                                <label for="doe">Date Of Entry : </label>
                                <input type="date" name="doe" required>
                            </div>
                            <button type="submit" name="add-entry" class="Btn submitBtn">Submit</button>
                        </form>
                    </div>
                </div>

                <!-- --------------- Sales div---------------- -->
                <div id="salesC" class="page-content">
                    <ul id="sales-tabs">
                        <li><a id="sales-stats" class="sub-tab">Sales info</a></li>
                        <li><a id="sales-forms" class="sub-tab">Forms</a></li>
                    </ul>
                    <div id="sales-statsC" class="sales-container">
                        <div class="sales-figs">
                            <div class="sales-fig-item">
                                <?php
                                $sales = new Sales();
                                $sales->getSalesForPreviousMonth($_SESSION["userId"])
                                ?> Made last Month
                            </div>
                            <div class="sales-fig-item">
                            <?php
                                $sales = new Sales();
                                $sales->getSalesForCurrentMonth($_SESSION["userId"])
                                ?> Made This Month
                            </div>
                        </div>
                        <form class="req-form" action="" method="POST">
                            <input type="hidden" name="dest"  value="salesC" />
                            <input type="text" name="animal-id" placeholder="Enter Animal (Cow/Sheep)Gov ID" required/>
                            <input type="radio" id="cow" name="option" value="1" required>
                            <label for="cow">Cow</label>
                            <input type="radio" id="sheep" name="option" value="2">
                            <label for="sheep">Sheep</label>
                            <input type="submit" name="get-sale"/>
                        </form>
                        <?php
                            if (isset($_POST['get-sale'])) {
                                $sale = new Sales();
                                if ($_POST['option'] == 1) {
                                    $sale->getCowSale($_POST['animal-id'],$_SESSION["userId"]);
                                }
                                else {
                                    $sale->getSheepSale($_POST['animal-id'],$_SESSION["userId"]);
                                } 
                            }
                        ?>
                        <div class="salesStats">
                            <h4>Recent Sales</h4>
                            <div class="timeline">
                            <?php
                                $sales = new Sales();
                                $sales->getSalesSummary($_SESSION["userId"]);
                            ?>
                            </div>
                        </div>
                    </div>
                    <div id="sales-formsC" class="sales-container">
                        <form action="../src/FormHandlers/create/addSalesCow.inc.php" method="post">
                            <h3>Add New Cow Sales</h3>
                            <?php
                                echo '<input type="hidden" name="id" value="'.$_SESSION['userId'].'">';
                            ?>
                            <div class="form-group">
                                <label for="animal-id">Government Cow ID : </label>
                                <input type="text" name="animal-id" required>
                            </div>
                            <div class="form-group">
                                <label for="weight">Weight: </label>
                                <input type="number" name="weight" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price of Sale: </label>
                                <input type="number" name="price" required>
                            </div>
                            <div class="form-group">
                                <label for="cow-breed"> Cow Breed: </label>
                                <input type="text" name="cow-breed" required>
                            </div>
                            <div class="form-group">
                                <label for="buyer-fname"> Buyers First Name: </label>
                                <input type="text" name="buyer-fname" required>
                            </div>
                            <div class="form-group">
                                <label for="buyer-lname"> Buyers Last Name: </label>
                                <input type="text" name="buyer-lname" required>
                            </div>
                            <div class="form-group">
                                <label for="dos"> Date of Sale: </label>
                                <input type="date" name="dos" required>
                            </div>
                            <button type="submit" name="add-sale" class="Btn submitBtn">Submit</button>
                        </form>
                        <form action="../src/FormHandlers/create/addSalesSheep.inc.php" method="post">
                            <h3>Add New Sheep Sales</h3>
                            <?php
                                echo '<input type="hidden" name="id" value="'.$_SESSION['userId'].'">';
                            ?>
                            <div class="form-group">
                                <label for="animal-id">Government Sheep ID : </label>
                                <input type="text" name="animal-id" required>
                            </div>
                            <div class="form-group">
                                <label for="weight">Weight: </label>
                                <input type="number" name="weight" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price of Sale: </label>
                                <input type="number" name="price" required>
                            </div>
                            <div class="form-group">
                                <label for="sheep-breed"> Sheep Breed: </label>
                                <input type="text" name="sheep-breed" required>
                            </div>
                            <div class="form-group">
                                <label for="buyer-fname"> Buyers First Name: </label>
                                <input type="text" name="buyer-fname" required>
                            </div>
                            <div class="form-group">
                                <label for="buyer-lname"> Buyers Last Name: </label>
                                <input type="text" name="buyer-lname" required>
                            </div>
                            <div class="form-group">
                                <label for="dos"> Date of Sale: </label>
                                <input type="date" name="dos" required>
                            </div>
                            <button type="submit" name="add-sale" class="Btn submitBtn">Submit</button>
                        </form>
                        <form action="../src/FormHandlers/delete/deleteSalesCow.inc.php" method="post">
                            <h3>Delete Cow Sales</h3>
                            <?php
                                echo '<input type="hidden" name="id" value="'.$_SESSION['userId'].'">';
                            ?>
                            <div class="form-group">
                                <label for="animal-id">Government Cow ID : </label>
                                <input type="text" name="animal-id" required>
                            </div>
                            <button type="submit" name="delete-sale" class="Btn deleteBtn">Delete</button>
                        </form>
                        <form action="../src/FormHandlers/delete/deleteSalesSheep.inc.php" method="post">
                            <h3>Delete Sheep Sales</h3>
                            <?php
                                echo '<input type="hidden" name="id" value="'.$_SESSION['userId'].'">';
                            ?>
                            <div class="form-group">
                                <label for="animal-id">Government Sheep ID : </label>
                                <input type="text" name="animal-id" required>
                            </div>
                            <button type="submit" name="delete-sale" class="Btn deleteBtn">Delete</button>
                        </form>
                    </div>
                </div>

                <!-- ---------------Notes div---------------- -->
                <div id="notesC" class="page-content">
                    <form action="" method="POST">
                        <input type="text" name="animal-id" placeholder="Enter Gov/Local ID" required/>
                        <input type="hidden" name="dest" value="notesC">
                        <input type="submit" name="get-note"/>
                    </form>
                    <?php
                        if (isset($_POST['get-note'])) {
                            $note = new Notes();
                            $note->getNotes($_POST['animal-id'], $_SESSION["userId"]);
                        }
                    ?>
                    <form action="../src/FormHandlers/create/addNote.inc.php" method="post">
                        <h3>Add New Note</h3>
                        <div class="form-group">
                            <label for="animal-id"> Animal's Government ID: </label>
                            <input type="text" name="animal-id" required>
                        </div>
                        <div class="form-group">
                            <label for="note"> Note: </label>
                            <textarea name="note" id="" cols="80" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="date"> Date: </label>
                            <input type="date" name="date" required>
                        </div>
                        <button type="submit" name="add-note" class="Btn submitBtn">Submit</button>
                    </form>
                </div>

                <!-- ---------------Settings div---------------- -->
                <div id="settingC" class="page-content">
                    <form action="../src/FormHandlers/update/changePassword.inc.php" method="post">
                        <h4>Change Password</h4>
                        <?php
                            echo '<input type="hidden" name="id" value="'.$_SESSION['userId'].'">';
                        ?>
                        <div class="form-group">
                            <label for="new-pwd">Enter New Password: </label>
                            <input type="password" class="form-input" name="new-pwd" required>
                        </div>
                        <div class="form-group">
                            <label for="rep-pwd">Repeat New Password: </label>
                            <input type="password" class="form-input" name="rep-pwd" required>
                        </div>
                        <button type="submit" name="change-pwd" class="Btn updateBtn">Change</button>
                    </form>
                </div>

                <!-- ---------------Help div---------------- -->
                <div id="helpC" class="page-content">
                    <div class="help-section">
                        
                    </div>
                </div>
            </div>
        </div>


        <!-- Error and Success messages-->

        <!-- farm -->
        <div id="fname-error" class="op-msg"> This name and Location is already taken, please try another.</div>
        <div id="farm-updated" class="op-msg"> Farm updated successfully </div>
        <div id="farm-deleted" class="op-msg"> Farm deleted successfully</div>
        <div id="farmadded" class="op-msg"> Farm updated successfully </div>

        <!-- Animals -->
        <div id="cownotexist" class="op-msg"> A cow with this ID does not exist, please check entry information and try again</div>
        <div id="sheepnotexist" class="op-msg"> A sheep with this ID does not exist, please check entry information and try again</div>
        <div id="addanimalsuccess" class="op-msg"> Animal added successfully</div>
        <div id="addbirthrecsuccess" class="op-msg"> Birth Record added successfully </div>

        <div id="govidupdated" class="op-msg"> The Government Id has been updated </div>
        <div id="localidupdated" class="op-msg"> The Local Id has been updated </div>
        <div id="statusupdated" class="op-msg"> The Animal's status has been updated </div>

        <div id="addweightsuccess" class="op-msg"> Weight added successfully </div>
        <div id="addvaxsuccess" class="op-msg"> Cow vaccination added successfully</div>
        <div id="movesuccess" class="op-msg"> Animal successfully moved to new farm</div>
        <div id="addmpsuccess" class="op-msg"> Milk Production record added successfully</div>
        <div id="wronggender" class="op-msg">This entry is strictly for female animals only!</div>

        <!-- Sales -->
        <div id="addsalesuccess" class="op-msg"> Sale Record Added successfully</div>
        <div id="deletesalesuccess" class="op-msg">Sale Record deleted successfully</div>


        <!-- Notes -->
        <div id="addnotesuccess" class="op-msg"> Note Succcessfully added</div>
        <div id="deleted-note" class="op-msg">Note was successfully deleted.</div>
        
        <!-- Others-->
        <div id="pwdchngsuccess" class="op-msg">Password changed successfully</div>
        
        

    </div>
</body>
</html>