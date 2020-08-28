<!-- This page shows driver details -->
<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();
require_once 'functions.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Auto Insurance</title>

    <script>
        function toggleAddNewDrivers() {
            var addNewDrivers = document.getElementById('addNewDrivers');
            var viewAllDrivers = document.getElementById('viewAllDrivers');
            if (addNewDrivers.style.display == 'none') {
                addNewDrivers.style.display = 'inline';
                viewAllDrivers.style.display = 'none';
            }
        }

        function toggleViewAllDrivers() {
            var addNewDrivers = document.getElementById('addNewDrivers');
            var viewAllDrivers = document.getElementById('viewAllDrivers');
            if (viewAllDrivers.style.display == 'none') {
                addNewDrivers.style.display = 'none';
                viewAllDrivers.style.display = 'inline';
            }
        }
    </script>

</head>

<body class="sb-nav-fixed" onload="toggleViewAllDrivers()">
    <?php
    require_once 'header.php';
    ?>
    <div id="layoutSidenav_content">
        <?php
        require_once 'auto_ins_header.php';
        ?>

        <center>
            <h4 style="text-decoration: underline;"><b>Drivers</b></h4>
        </center>


        <div class="main_content">

            <center>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-outline-danger" onclick="toggleAddNewDrivers()"><b>Add New Driver</b></button>
                    <button type="button" class="btn btn-outline-success" onclick="toggleViewAllDrivers()"><b>View All Drivers</b></button>
                    <a href="vehicles.php" class="btn btn-dark"> <b style="color:white;">Vehicles</b></a>
                </div>
            </center>



            <!-- ADD NEW DRIVERS -->
            <br>
            <div class="addNewDrivers" id="addNewDrivers" style="display:none;">
                <div class="card-mb-12">
                    <div class="card-header text-center">
                        <i class="fas fa-plus mr-1"></i><b>Add new Driver</b>
                    </div>
                    <div class="card-body">
                        <form method="POST" name="addDriver" id="addDriver" align="left">
                            <div class="row">
                                <div class="col-md-4 text-right">
                                    <b>Select Vehicle VIN:</b>
                                </div>
                                <select name="vin" id="vin" class="col-md-5" required>
                                    <option value="0">Select</option>
                                    <?php

                                    $result = showUnInsuredVehicles($_SESSION['email']);
                                    if ($result != false) {
                                        while ($row = mysqli_fetch_array($result)) {
                                            $row['status'] = getFormattedStatus($row['status']);

                                            echo "
                        <option value='" . $row['vin'] . "'>VIN: " . $row['vin'] . " -- " . $row['vehicle_type'] . " -- " . $row['make'] . " " . $row['model'] . " -- " . $row['year'] . " -- " . $row['status'] . "</option>
                                                ";
                                        }
                                    }

                                    ?>




                                </select>
                            </div>
                            <br>
                            <!--Driver Name-->
                            <div class="row">
                                <div class="col-md-4 text-right" style="margin-top:4px;">
                                    <label for="dname">
                                        <b>Driver Name:</b>
                                    </label>
                                    <br>
                                </div>
                                <input id="dname" class="form-control col-md-5 text-left" type="text" placeholder="Enter the Full Name" name="dname" required>
                            </div>
                            <br>
                            <!--Driver date of birth-->
                            <div class="row">
                                <div class="col-md-4 text-right" style="margin-top:4px;">
                                    <label for="dob">
                                        <b>Driver DOB:</b>
                                    </label>
                                    <br>
                                </div>
                                <input id="dob" class="form-control col-md-5 text-left" type="date" placeholder="Enter the date of birth" min="1960-01-01" max="2015-12-31" name="dob" required>
                            </div>
                            <br>
                            <!--Driver License-->
                            <div class="row">
                                <div class="col-md-4 text-right" style="margin-top:4px;">
                                    <label for="dl">
                                        <b>Driver License No:</b>
                                    </label>
                                    <br>
                                </div>
                                <input id="dl" class="form-control col-md-5 text-left" type="number" placeholder="Enter the license number" name="dl" required>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <button class="btn btn-primary col-md-5" id="addDriver" class="form-control" type="submit" name="addDriver"><b>Add Driver</b></button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>


            <!-- END OF ADD NEW DRIVERS -->
            <!-- VIEW ALL DRIVERS -->

            <div class="viewAllDrivers" id="viewAllDrivers" style="display:none;">
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="thead-active">
                            <tr>
                                <th>License No.</th>
                                <th>Name</th>
                                <th>Birth Date</th>
                                <th>VIN</th>
                                <th>Make-Model-Year</th>
                                <th>Vehicle Status</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $res = showDriverDetails($_SESSION['email']);


                            if ($res != false) {
                                while ($row = mysqli_fetch_array($res)) {

                                    $row['status'] = getFormattedStatus($row['status']);

                                    createDriverDeleteModal($row);

                                    echo "
                                        <tr>
                                            <td>" . $row['license_no'] . "</td>
                                            <td>" . $row['name'] . "</td>
                                            <td>" . $row['birth_date'] . "</td>
                                            <td>" . $row['vin'] . "</td>
                                            <td>" . $row['make'] . " " . $row['model'] . " " . $row['year'] . "</td>
                                            <td>" . $row['status'] . "</td> 
                                            ";

                                    echo "
                                                <td><a href='#' data-toggle='modal' data-target='#removeDriver" . $row['license_no'] . "'><i style='color:red;' class='fas fa-trash mr-1'></i></a></td>
                                                
                                            ";
                                    echo
                                        "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No Drivers found.<br> Try Adding some from 'Add New Driver' Portal.</td></tr>";
                            }

                            ?>

                        </tbody>
                    </table>
                </div>
            </div>


            <!-- END OF VIEW ALL DRIVERS -->



        </div>



        </main>

        <!-- After main footer should come. -->
        <?php
        require_once 'footer.php';
        ?>
    </div>
    </div> <!-- This is the ending of the header -->
</body>

</html>


<?php


if (isset($_POST['deleteDriver'])) {
    $license_no = $_POST['license_no'];


    $result = removeDriver($license_no);
    if ($result == 1) {
        $_SESSION['display'] = "inline";
        $_SESSION['errorMsg'] = "Successfully deleted the Driver!";
        $_SESSION['alert_class'] = "alert alert-success";
        echo "<script>window.location.replace('drivers.php');</script>";
    } else {
        $_SESSION['display'] = "inline";
        $_SESSION['errorMsg'] = "Error in removing Driver! <br> Please try again after some time.";
        $_SESSION['alert_class'] = "alert alert-danger";
        echo "<script>window.location.replace('drivers.php');</script>";
    }
}


if (isset($_POST['addDriver'])) {
    $vin = $_POST['vin'];
    if ($vin == '0') {
        echo "<script>alert('Please select a vehicle number');</script>";
        exit;
    } else {
        $dname = $_POST['dname'];
        $dob = $_POST['dob'];
        $dl = $_POST['dl'];
        $email = $_SESSION['email'];

        $res = addNewDriver($dl, $vin, $dname, $dob, $email);

        if ($res == -1) {
            $_SESSION['display'] = "inline";
            $_SESSION['errorMsg'] = "Error: Driver with same License already exists! <br> Please Enter a different driver";
            $_SESSION['alert_class'] = "alert alert-danger";
            echo "<script>window.location.replace('drivers.php');</script>";
        } else if ($res == 0) {
            $_SESSION['display'] = "inline";
            $_SESSION['errorMsg'] = "Error: Fields cannot be empty!";
            $_SESSION['alert_class'] = "alert alert-danger";
            echo "<script>window.location.replace('drivers.php');</script>";
        } else if ($res == 1) {
            $_SESSION['display'] = "inline";
            $_SESSION['errorMsg'] = "Successfully added the Driver";
            $_SESSION['alert_class'] = "alert alert-success";
            echo "<script>window.location.replace('drivers.php');</script>";
        } else {
            $_SESSION['display'] = "inline";
            $_SESSION['errorMsg'] = "Error in adding the driver <br> Please try again after some time";
            $_SESSION['alert_class'] = "alert alert-danger";
            echo "<script>window.location.replace('drivers.php');</script>";
        }
    }
}

?>