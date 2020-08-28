<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();
require_once 'functions.php';
?>
<!DOCTYPE html>
<html>

<head>
  <title>Home Insurance</title>
</head>

<body class="sb-nav-fixed">
  <?php
  require_once 'header.php';
  ?>
  <div id="layoutSidenav_content">
    <?php
    require_once 'home_ins_header.php';
    ?>



    <div class="home_ins_content">
      <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table mr-1"></i> MY HOUSES</div>
        <div class="card-body">
          <div class="row">
            <div><b>Note: </b>You cannot remove insured houses from here. </div>
            <div class="table-responsive">
              <br>
              <table id="tableHouse" style="text-align: center;" class="col-md-12 table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>House No.</th>
                    <th>Location</th>
                    <th>Purchase Date</th>
                    <th>Purchase Value</th>
                    <th>Area</th>
                    <th>Insured?</th>
                    <th>Ins Details</th>
                    <th>More</th>
                    <th>Remove</th>
                  </tr>
                </thead>
                <tbody id="show_home_details_table">

                  <?php

                  $email = $_SESSION['email'];
                  $res = showHomeDetails($email);


                  if ($res == false) {
                    echo " 
                      <tr>
                        <td colspan='10'>No Data Found</td>
                      </tr>
                    ";
                  } else {
                    $count = 1;
                    while ($result = mysqli_fetch_array($res)) {

                      $result = convertHomeProperFormat($result);

                      createHomeDetailsModal($result);
                      createInsDetailsModal($result['hinsid']);
                      createDeleteModal($result);

                      $showRemove = true;

                      echo " 
                        <tr>
                          <td>" . $result['home_id'] . "</td>
                          <td>" . $result['location'] . "</td>
                          <td>" . $result['purchase_date'] . "</td>
                          <td>" . $result['purchase_value'] . "</td>
                          <td>" . $result['area_sq_feet'] . "</td>";
                      if ($result['hinsid'] != 'No' || $result['hinsid'] != 0) {
                        echo "
                            <td>" . $result['hinsid'] . "</td>
                            <td><a href='#' data-toggle='modal' data-target='#insModal" . $result['hinsid'] . "'>Click Here</a></td>";
                      } else {
                        echo "
                            <td>" . $result['hinsid'] . "</td>
                            <td>" . $result['hinsid'] . "</td>";
                        $showRemove = false;
                      }
                      echo "<td> <a href='#' data-toggle='modal' data-target='#homeModal" . $result['home_id'] . "'>Details</a></td>";

                      if ($showRemove == false) {
                        echo "<td> <button type='button' class='btn btn-warning' data-toggle='modal' data-target='#showDeleteModal" . $result['home_id'] . "'><b>x</b></button></td>";
                      } else {
                        echo "<td>NotA</td>";
                      }
                      echo "</tr>
                      ";
                      $count++;
                    }
                  }


                  ?>


                </tbody>
              </table>
            </div>

            <!--Add new houses-->
            <div class="col-xl-12">
              <div class="card mb-4">
                <div class="card-header"><i class="fas fa-plus mr-1"></i>Add a new house</div>
                <div class="card-body">
                  <form method="POST" action="" accept-charset="UTF-8">
                    <div class="row">
                      <div class="col-md-3 text-right" style="margin-top:5px;">
                        <label for="email">
                          Location:
                        </label>
                        <br>
                      </div>
                      <div class="col-md-5 text-left"><?php require_once 'us_states_dropDown.php'; ?></div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-3 text-right" style="margin-top:5px;">
                        <label for="pdate">
                          Purchase Date:
                        </label>
                        <br>
                      </div>
                      <input id="pdate" class="form-control col-md-5 text-left" type="date" placeholder="Purchase Date:" name="purchase_date" required value="2000-01-01" min="1965-01-01" max="2020-05-08">
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-3 text-right" style="margin-top:5px;">
                        <label for="pvalue">
                          Purchase Value:
                        </label>
                        <br>
                      </div>
                      <input id="pvalue" class="form-control col-md-5 text-left" type="number" placeholder="Purchase Value: (in $)" name="purchase_value" required min="10000" max="500000">
                    </div>
                    <br>
                    <div class="row text-center">
                      <div class="col-md-3 text-right" style="margin-top:5px;">
                        <label for="Area">
                          Area:
                        </label>
                        <br>
                      </div>
                      <input id="Area" class="form-control col-md-5 text-left" type="number" placeholder="Area in square feet" name="area_sq_feet" required min="800" max="3000">
                    </div>
                    <br>

                    <div class="row">
                      <legend class="col-form-label col-md-3 text-right" style="margin-top:20px;">Home Type:</legend>
                      <div class="col-sm-10 col-md-5">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="home_type" id="single_family" value="S" checked>
                          <label class="form-check-label" for="single_family">
                            Single Family
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="home_type" id="multi_family" value="M">
                          <label class="form-check-label" for="multi_family">
                            Multi Family
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="home_type" id="condo" value="C">
                          <label class="form-check-label" for="condo">
                            Condominium
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="home_type" id="town_house" value="T">
                          <label class="form-check-label" for="town_house">
                            Town House
                          </label>
                        </div>
                      </div>
                    </div>
                    <br>
                    <!-- Auto Fire Notification -->
                    <div class="row">
                      <legend class="col-form-label col-md-3 text-right">Auto Fire Notification:</legend>
                      <div class="col-sm-10  col-md-5">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="auto_fire_noti" id="fire_noti_yes" value="1" checked>
                          <label class="form-check-label" for="fire_noti_yes">
                            Yes
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="auto_fire_noti" id="fire_noti_no" value="0">
                          <label class="form-check-label" for="fire_noti_no">
                            No
                          </label>
                        </div>
                      </div>
                    </div>
                    <br>
                    <!-- Home Security System -->
                    <div class="row">
                      <legend class="col-form-label col-md-3 text-right">Home Security System:</legend>
                      <div class="col-sm-10 col-md-5">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="home_security" id="home_sec_yes" value=1 checked>
                          <label class="form-check-label" for="home_sec_yes">
                            Yes
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="home_security" id="home_sec_no" value=0>
                          <label class="form-check-label" for="home_sec_no">
                            No
                          </label>
                        </div>
                      </div>
                    </div>
                    <br>
                    <!-- Swimming -->
                    <div class="row">
                      <legend class="col-form-label col-md-3 text-right" style="margin-top:20px;">Swimming Pool:</legend>
                      <div class="col-sm-10 col-md-5">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="swimming_pool" id="swim_under" value="U" checked>
                          <label class="form-check-label" for="swim_under">
                            Underground
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="swimming_pool" id="swim_over" value="O">
                          <label class="form-check-label" for="swim_over">
                            Overground
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="swimming_pool" id="swim_indoor" value="I">
                          <label class="form-check-label" for="swim_indoor">
                            Indoor
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="swimming_pool" id="swim_multi" value="M">
                          <label class="form-check-label" for="swim_multi">
                            Multiple
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="swimming_pool" id="swim_none" value=null>
                          <label class="form-check-label" for="swim_none">
                            Null
                          </label>
                        </div>
                      </div>
                    </div>
                    <br>
                    <!-- Basement -->
                    <div class="row">
                      <legend class="col-form-label col-md-3 text-right">Basement:</legend>
                      <div class="col-sm-10  col-md-5">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="basement" id="basement_yes" value=1 checked>
                          <label class="form-check-label" for="basement_yes">
                            Yes
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="basement" id="basement_no" value=0>
                          <label class="form-check-label" for="basement_no">
                            No
                          </label>
                        </div>
                      </div>
                    </div>
                    <!-- Submit button -->
                    <br>
                    <div class="row text-center">
                      <div class="col-md-3"></div>
                      <input class="btn btn-primary col-md-2" id="newHouse" class="form-control" type="submit" name="newHouse">
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- End of add houses -->

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
  </div> <!-- This is the ending of the header -->
</body>

</html>

<?php

if (isset($_POST['newHouse'])) {

  //create a new house

  $cust_details = showCustDetails($_SESSION['email']);
  $cust_id = $cust_details['cust_id'];
  $location = $_POST['location'];
  $purchase_date = $_POST['purchase_date'];
  $purchase_value = $_POST['purchase_value'];
  $area_sq_feet = $_POST['area_sq_feet'];
  $home_type = $_POST['home_type'];
  $auto_fire_noti = $_POST['auto_fire_noti'];
  $home_security = $_POST['home_security'];
  $swimming_pool = $_POST['swimming_pool'];
  $basement = $_POST['basement'];

  if ($location == "0") {
    echo "<script>alert('Please select the location');</script>";
  } else {
    $result = insertHome($cust_id, $location, $purchase_date, $purchase_value, $area_sq_feet, $home_type, $auto_fire_noti, $home_security, $swimming_pool, $basement, 0);

    if ($result == 0) {
      $_SESSION['display'] = "inline";
      $_SESSION['errorMsg'] = "Error in inserting house! <br> Please try again after some time.";
      $_SESSION['alert_class'] = "alert alert-danger";
      echo "<script>window.location.replace('home_ins_houses.php');</script>";
    } else {
      $_SESSION['display'] = "inline";
      $_SESSION['errorMsg'] = "Successfully inserted the house";
      $_SESSION['alert_class'] = "alert alert-success";
      echo "<script>window.location.replace('home_ins_houses.php');</script>";
    }
  }
}



if (isset($_POST['deleteHome'])) {
  $home_id = $_POST['home_id'];


  $result = removeHouse($home_id);
  if ($result == 1) {
    $_SESSION['display'] = "inline";
    $_SESSION['errorMsg'] = "Successfully removed the house";
    $_SESSION['alert_class'] = "alert alert-success";
    echo "<script>window.location.replace('home_ins_houses.php');</script>";
  } else {
    $_SESSION['display'] = "inline";
    $_SESSION['errorMsg'] = "Error in removing house! <br> Please try again after some time.";
    $_SESSION['alert_class'] = "alert alert-danger";
    echo "<script>window.location.replace('home_ins_houses.php');</script>";
  }
}


?>