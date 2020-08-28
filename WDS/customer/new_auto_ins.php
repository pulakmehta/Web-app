<!-- This page is used to add new auto insurances -->
<!DOCTYPE html>
<html>

<head>
  <title>Auto Insurance</title>

</head>

<body class="sb-nav-fixed">
  <?php
  require_once 'header.php';
  ?>
  <div id="layoutSidenav_content">
    <?php
    require_once 'auto_ins_header.php';
    ?>
    
    <div class="home_ins_content">
      <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table mr-1"></i> New Auto Insurance</div>

        <div class="card-body">
          <div id="directions">
            <center>Select the Vehicles from below which you want to insure,
              <br>
              Then Select the duration of insurance you want to avail.
              <br>
              Then click to proceed to receive a quote.
            </center>
          </div>

          <?php
          $res = showVehicleDetails($_SESSION['email']);

          if ($res != false) {
            while ($row = mysqli_fetch_array($res)) {
              if ($row['ainsid'] != '0' || $row['ainsid'] != 0) {
                showDriverForVehicleModal($row['vin'], 0);  // 1 indicates its okay to delete vehicles.
              } else {
                showDriverForVehicleModal($row['vin'], 1);
              }
            }
          }


          ?>

          <!-- Show Table Data here -->
          <form method="POST" action="" accept-charset="UTF-8">

            <div class="table-responsive">
              <h6>
                <center><b>Note: </b>Vehicles without drivers cannot be added.</center>
              </h6>
              <table class="table table-bordered table-hover text-center">
                <thead class="thead-active">
                  <tr>
                    <th>Vehicle IN</th>
                    <th>Vehicle Type</th>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Status</th>
                    <th>Driver Details</th>
                    <th>Insure this</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $res = showUnInsuredVehicles($_SESSION['email']);

                  if ($res != false) {
                    while ($row = mysqli_fetch_array($res)) {

                      $driverCount = getDriverCountForVehicle($row['vin']);

                      $row['status'] = getFormattedStatus($row['status']);

                      if ($driverCount > 0) {
                        echo "
                                        <tr>
                                            <td>" . $row['vin'] . "</td>
                                            <td>" . $row['vehicle_type'] . "</td>
                                            <td>" . $row['make'] . "</td>
                                            <td>" . $row['model'] . "</td>
                                            <td>" . $row['year'] . "</td>
                                            <td>" . $row['status'] . "</td> 
                                            ";

                        echo "<td><a href='#' data-toggle='modal' data-target='#showDrivers" . $row['vin'] . "'>Drivers</a></td>";





                        echo
                          "<td><input type='checkbox' name='addVehicleToIns[]' value='" . $row['vin'] . "' style='zoom: 1.5;'></td>
                                        </tr>";
                      }
                    }
                  } else {
                    echo "<tr><td colspan='9'>No Vehicles found.<br> Try Adding some from 'Add New Vehicles' Portal.</td></tr>";
                  }

                  ?>

                </tbody>
              </table>
            </div>
            <div class="row text-center">
              <div class="col-md-5 text-right"><b>Insurance Duration:</b></div>
              <select class="col-md-2" name="insDuration" id="insDuration" required>
                <option value="1">1 Year</option>
                <option value="2">2 Years</option>
                <option value="5">5 Years</option>
              </select>
            </div>
            <br>
            <div class="row">
              <div class="col-md-5"></div>
              <button type="submit" class="btn btn-primary col-md-2" name="getQuote"><b>Proceed</b></button>
            </div>
          </form>
          <br>
        </div>
      </div>
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


if (isset($_POST['deleteVehicle'])) {
  $vin = $_POST['vin'];


  $result = removeVehicle($vin);
  if ($result == 1) {
    $_SESSION['display'] = "inline";
    $_SESSION['errorMsg'] = "Successfully deleted the vehicle!";
    $_SESSION['alert_class'] = "alert alert-success";
    echo "<script>window.location.replace('vehicles.php');</script>";
  } else {
    $_SESSION['display'] = "inline";
    $_SESSION['errorMsg'] = "Error in removing vehicle! <br> Please try again after some time.";
    $_SESSION['alert_class'] = "alert alert-danger";
    echo "<script>window.location.replace('vehicles.php');</script>";
  }
}



if (isset($_POST['getQuote'])) {
  // Calculates quotes from fields, and then displays the billed modal.
  $vin = 0;     // Gives me the home id which I wanna insure.
  $amount = 0;

  $duration = $_POST['insDuration'];

  $vins = "";

  $totalAmountDetails = array("vehicle_type"=>0,"status"=>0,"driverCount"=>0,"year"=>0,"make"=>0, "totalAmount"=>0);

  if (!empty($_POST['addVehicleToIns'])) {
    $vins =  $_POST['addVehicleToIns'];
    // Loop to store and display values of individual checked checkbox.
    foreach ($_POST['addVehicleToIns'] as $selected) {
      $vin = $selected;
      $getAmountDetails = calculateAutoInsAmount($vin);

      foreach ($getAmountDetails as $k => $v) {
        $totalAmountDetails[$k] += $v;
      }
    }
    createAutoQuoteModal($totalAmountDetails, $duration, $vins);
    echo "<script>$('#autoQuoteModal').modal('show')</script>";
  }
  else{
    echo "<script>alert('Please select the vehicle and duration!');</script>";
  }
  
}


if (isset($_POST['getInsurance'])) {
  // Form from Quote Modal
  // Used to create a new insurance 

  $cust_details = showCustDetails($_SESSION['email']);

  //Fields to create a new insurance
  $cust_id = $cust_details['cust_id'];
  $start_date = strtotime("today");
  $end_date = strtotime("+".$_POST['insDuration']."Year");
  $duration = $_POST['insDuration'];
  $total_amount = $_POST['total_amount'];
  $status = 'C';


  $ainsid = newAutoIns($cust_id, $start_date, $end_date, $total_amount, $status);

  $res = createAutoPayments($ainsid, $total_amount, $duration, $start_date);

  $success = false;
  
  if($ainsid!=0 || $ainsid!='0'){
    if(isset($_POST['vins'])){
      foreach ($_POST['vins'] as $i) {
        echo $i;
        $result = insureVehicle($i, $ainsid);
        if($result){
            //Successfully created insurance and set home ids
            $success = true;
        }
        else{
            // Trouble in insuring the house.
            $success = false;
            $_SESSION['display'] = "inline";
            $_SESSION['errorMsg'] = "Error in insuring vehicle! <br> Please try again!";
            $_SESSION['alert_class'] = "alert alert-danger";
            echo "<script>window.location.replace('new_auto_ins.php');</script>";
        }
      }
    }
  }
  else if($ainsid =='-1' || $ainsid==-1){
    $success = false;
  }
  else{
    $_SESSION['display'] = "inline";
    $_SESSION['errorMsg'] = "Fields cannot be empty! <br> Please try again with all fields filled.";
    $_SESSION['alert_class'] = "alert alert-danger";
    echo "<script>window.location.replace('new_auto_ins.php');</script>";
  }

  if($success == true && $res == true){
    // Successfully registered with houses.
    $_SESSION['display'] = "inline";
    $_SESSION['errorMsg'] = "Successfully added the insurance for your vehicle. <br> You can see them below.";
    $_SESSION['alert_class'] = "alert alert-success";
    echo "<script>window.location.replace('current_auto_ins.php');</script>";
  }
  else{
      // error in registering.
      $_SESSION['display'] = "inline";
      $_SESSION['errorMsg'] = "Error in creating your insurance! <br> Please try again after some time.";
      $_SESSION['alert_class'] = "alert alert-danger";
      echo "<script>window.location.replace('new_auto_ins.php');</script>";
  }
}



?>