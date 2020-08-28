<!-- This page shows current home insurances -->
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
    

    <?php

$result1 = showAutoInsDetails($_SESSION['email']);
if($result1!=false){
    while ($row1 = mysqli_fetch_array($result1)) {

        $res1 = createVehicleModal($row1['ainsid']);
        addAutoAssetModal($row1['ainsid']);
    }
}

?>


<div class="auto_ins_content">
    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table mr-1"></i> Current Auto Insurances</div>
        <div class="card-body">
            <div class="table-responsive-lg">
                <table class="table table-bordered table-hover text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>Policy No.</th>
                            <th>Vehicle Details</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Add Assets</th>
                        </tr>
                    </thead>
                    <tbody>
                        

                    <?php

                    $result = showAutoInsDetails($_SESSION['email']);
                    if ($result == false) {
                        echo " <tr>
                                <td colspan='8'>No insurances found. &nbsp;&nbsp;Add some from new insurance portal.</td>
                              </tr>";
                    } else {
                        while ($row = mysqli_fetch_array($result)) {

                            if($row['status']=='C'){
                                $row['status'] = 'Current';
                            }
                            else{
                                $row['status'] = 'Expired';
                            }
                            $row['start_date'] = getFormattedDate(strtotime($row['start_date']));
                            $row['end_date'] = getFormattedDate(strtotime($row['end_date']));

                            $paymentCountForAinsid = getPaymentCountForAins($row['ainsid']);

                            echo "
                                    <tr>
                                        <td>".$row['ainsid']."</td>
                                        <td><a href='#' data-toggle='modal' data-target='#vehicleDetailsModall".$row['ainsid']."'>Click Here</a></td>
                                        <td>" . $row['start_date'] . "</td>
                                        <td>" . $row['end_date'] . "</td>
                                        <td>" . $row['total_amount'] . "</td>
                                        <td>" . $row['status'] . "</td>";

                                    if($paymentCountForAinsid > 0){
                                        echo "  <td><a href='#' data-toggle='modal' data-target='#addAutoAssetModal".$row['ainsid']."'><i class='fas fa-plus-circle'></i></a></td>";
                                    }
                                    else{
                                        echo "  <td>Payments Completed</td>";
                                    }
                                        
                            echo " </tr>
                                ";
                        }
                    }

                    ?>

                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
       
                 
    </div>
	</main>

                <!-- After main footer should come. -->
                <?php 
                	require_once 'footer.php';
                 ?>
            </div>
         </div>      <!-- This is the ending of the header -->
 </body>
 </html>

 <?php
    require_once 'footer.php';
    ?>
    </div>
    </div> <!-- This is the ending of the header -->
</body>

</html>


<?php

  if(isset($_POST['addAssetExisting'])){
        $vin = 0;
        $vins = "";
        $ainsid = $_POST['ainsid'];
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
              $result = insureVehicle($vin, $ainsid);
                if($result){
                    //Successfully created insurance and set vins
                    $success = true;
                }
                else{
                    // Trouble in insuring the vehicles.
                    $success = false;
                    $_SESSION['display'] = "inline";
                    $_SESSION['errorMsg'] = "Error in insuring vehicle!";
                    $_SESSION['alert_class'] = "alert alert-danger";
                    echo "<script>window.location.replace('new_auto_ins.php');</script>";
                }
            }
            if($success == true){
                // Successfully registered with vehicles.
                $today = date("Y-m-d",strtotime("today"));
                addAssetToAutoIns($ainsid, $totalAmountDetails['totalAmount'], $today);
                $_SESSION['display'] = "inline";
                $_SESSION['errorMsg'] = "Successfully updated the insurance for your vehicles. <br> You can see them below.";
                $_SESSION['alert_class'] = "alert alert-success";
                echo "<script>window.location.replace('current_auto_ins.php');</script>";
              }
              else{
                  // error in registering.
                  $_SESSION['display'] = "inline";
                  $_SESSION['errorMsg'] = "Error in adding in your insurance! <br> Please try again after some time.";
                  $_SESSION['alert_class'] = "alert alert-danger";
                  echo "<script>window.location.replace('current_auto_ins.php');</script>";
              }
            
          }
          else{
            echo "<script>alert('Please select the Vehicle');</script>";
          }
  }


?>