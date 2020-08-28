<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();
require_once 'functions.php';

?>
<!DOCTYPE html>
<html>

<head>
  <title>My Details</title>
  <style type="text/css">
    #tableHouse tr td,
    th {
      text-align: center;
      padding: 10px;
    }
  </style>

</head>

<body class="sb-nav-fixed">
  <?php
  require_once 'header.php';
  ?>
  <div id="layoutSidenav_content">
    <?php
    require_once 'my_details.php';
    ?>
    <div class="home_ins_content">
      <div class="container-fluid">
        <h1 class="mt-4">My Personal details</h1>

        <div class="card mb-4">
          <div class="card-header"><i class="fas fa-table mr-1"></i> MY DETAILS</div>
          <div class="card-body">
            <div class="row">
              <div class="col-xl-12">
                <div class="card-body row">

                  <div class="col-md-3"></div>
                  <div class="card mb-4 col-md-5 text-center">
                    <div class="card-body">
                      <div class="user-profile-block">
                        <img alt="img" src="assets/img/avatar.png" width="100" height="100" />


                        <!-- Dynamic data displayed below -->
                        <?php

                        $email = $_SESSION['email'];

                        $result = showCustDetails($email);

                        // show gender in correct output
                        if ($result['gender'] == 'M') {
                          $result['gender'] = 'Male';
                        } else {
                          $result['gender'] = 'Female';
                        }

                        // Show marital status in correct output
                        if ($result['marital_status'] == 'S') {
                          $result['marital_status'] = 'Single';
                        } else if ($result['marital_status'] == 'M') {
                          $result['marital_status'] = 'Married';
                        } else if ($result['marital_status'] == 'W') {
                          if ($result['gender'] == "Male") {
                            $result['marital_status'] = 'Widower';
                          } else {
                            $result['marital_status'] = 'Widow';
                          }
                        }


                        echo "<h4 class='user-name'> " . $result['first_name'] . " " . $result['middle_name'] . " " . $result['last_name'] . "</h4>
                                                          
                                                          <h6 class='user-designation'><b>Gender: </b>" . $result['gender'] . " </h6> 

                                                          <h6 class='user-designation'><b>Marital Status: </b>" . $result['marital_status'] . " </h6>        

                                                          <h6 class='user-designation'><b>Address: </b> " . $result['address'] . " </h6>";




                        ?>

                        <!-- End of Profile Links -->

                      </div>
                    </div>
                  </div>
                </div>
                <div class="row text-center">
                  <div class="col-md-4"></div>
                  <div class="row col-md-5 text-right" style="padding-left: 40px;">
                    <a href="update_my_details.php">
                      <button class="btn btn-primary col-xl-12" type="button" name="updateDetails">Update Details</button>
                    </a>
                    &nbsp;
                    <a href="index.php">
                      <button class="btn btn-primary col-x1-12" type="button" name="Dashboard">Home</button>
                    </a>
                  </div>
                </div>


              </div>

              <!--Add new houses-->


            </div>
          </div>
        </div>
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