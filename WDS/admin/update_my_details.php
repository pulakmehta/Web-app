<?php
session_start();
require_once 'functions.php';
?>
<!DOCTYPE html>
<html>

<head>
  <title>Update Details</title>
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

    <div class="home_ins_content">
      <div class="container-fluid  col-xl-12">
        <h1 class="mt-12">Update Personal details</h1>
        <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item active">Update your details here</li>
        </ol>


        <!-- Error message display -->
        <div id="error" style="display:<?php echo isset($_SESSION['display']) ? $_SESSION['display'] : 'none;';
                                        unset($_SESSION['display']); ?> ">

          <div class="<?php echo isset($_SESSION['alert_class']) ? $_SESSION['alert_class'] : 'none;';
                      unset($_SESSION['alert_class']); ?>">
            <?php echo isset($_SESSION['errorMsg']) ? $_SESSION['errorMsg'] : 'none;';
            unset($_SESSION['errorMsg']);  ?></div>
        </div>


        <div class="card mb-4">
          <div class="card-header"><i class="fas fa-table mr-1"></i>UPDATE MY DETAILS</div>
          <div class="card-body">
            <div class="row">
              <div class="col-xl-12">
                <form method="POST" action="" accept-charset="UTF-8" style="color:black;margin-top: -50px;">
                  <div class="card-body">
                    <!--Customer ID-->


                    <!-- Displaying customer data from the backend -->
                    <?php

                    $result = showCustDetails($_SESSION['email']);

                    echo "
                          <br>
                                                  <div class='row'>
                                              <div class='col-md-3 text-right' style='margin-top: 5px;'>
                                                <label for='Customer ID'>
                                                  Customer ID:
                                                </label>
                                                <br>
                                              </div>
                                            <input id='Cust_id' class='form-control col-md-6' type='text' name='Cust_id' disabled='' value='" . $result['cust_id'] . "'>
                                          </div>
                                          <br>

                                          <div class='row'>
                                              <div class='col-md-3 text-right' style='margin-top: 5px;'>
                                                <label for='email'>
                                                  Email:
                                                </label>
                                                <br>
                                              </div>
                                            <input id='email' class='form-control col-md-6' type='email' placeholder='Email' name='email' disabled value='" . $result['email'] . "'/>
                                          </div>
                                          <br>

                                          
                                          <div class='row'>
                                              <div class='col-md-3 text-right' style='margin-top: 5px;'>
                                                <label for='First_name'>
                                                  First Name:
                                                </label>
                                                <br>
                                              </div>
                                            <input id='First_name' class='form-control col-md-6' type='text' placeholder='Enter First Name' name='fName' value='" . $result['first_name'] . "' required>
                                          </div>
                                          <br>

                                          <div class='row'>
                                              <div class='col-md-3 text-right' style='margin-top: 5px;'>
                                                <label for='middleName'>
                                                  Middle Name:
                                                </label>
                                                <br>
                                              </div>
                                            <input id='middleName' class='form-control col-md-6' type='text' placeholder='Enter Middle Name' name='mName' value='" . $result['middle_name'] . "'>
                                          </div>

                                          <br>
                                          
                                          <div class='row'>
                                              <div class='col-md-3 text-right' style='margin-top: 5px;'>
                                                <label for='Last_name'>
                                                  Last Name:
                                                </label>
                                                <br>
                                              </div>
                                            <input id='Last_name' class='form-control col-md-6' type='text' placeholder='Enter Last Name' name='lName' value='" . $result['last_name'] . "' required>
                                          </div>

                                          <br>


                                          <div class='row'>
                                              <div class='col-md-3 text-right' style='margin-top: 5px;'>
                                                <label for='address'>
                                                  Address:
                                                </label>
                                                <br>
                                              </div>
                                            <textarea id='address' class='form-control col-md-6' rows='2' placeholder='Enter Address' name='address' required>" . $result['address'] . "</textarea>
                                          </div>


                                          <br>


                                            <div class='row'>
                                                  <legend class='col-form-label col-md-3 text-right' style='margin-top: 5px;'>Gender:</legend>
                                                  <div class='col-sm-10 col-md-6'>
                                                    <div class='form-check'>
                                                      <input class='form-check-input' type='radio' name='gender' id='male' value='M' " . ($result['gender'] == 'M' ? 'checked' : '') . ">
                                                      <label class='form-check-label' for='male'>
                                                        Male
                                                      </label>
                                                    </div>
                                                    <div class='form-check'>
                                                      <input class='form-check-input' type='radio' name='gender' id='female' value='F' " . ($result['gender'] == 'F' ? 'checked' : '') . ">
                                                      <label class='form-check-label' for='female'>
                                                        Female
                                                      </label>
                                                    </div>
                                                    <div class='form-check'>
                                                      <input class='form-check-input' type='radio' name='gender' id='none' value='' " . ($result['gender'] == '' ? 'checked' : '') . ">
                                                      <label class='form-check-label' for='none'>
                                                        Don't wish to disclose
                                                      </label>
                                                    </div>
                                                  </div>
                                            </div>
                                                <br>  


                                                <div class='row'>
                                                  <legend class='col-form-label col-md-3 text-right' style='margin-top: 5px;'>Marital Status:</legend>
                                                  <div class='col-sm-10 col-md-6'>
                                                    <div class='form-check'>
                                                      <input class='form-check-input' type='radio' name='marital_status' id='married' value='M' " . ($result['marital_status'] == 'M' ? 'checked' : '') . ">
                                                      <label class='form-check-label' for='married'>
                                                        Married
                                                      </label>
                                                    </div>
                                                    <div class='form-check'>
                                                      <input class='form-check-input' type='radio' name='marital_status' id='single' value='S' " . ($result['marital_status'] == 'S' ? 'checked' : '') . ">
                                                      <label class='form-check-label' for='single'>
                                                        Single
                                                      </label>
                                                    </div>
                                                    <div class='form-check'>
                                                      <input class='form-check-input' type='radio' name='marital_status' id='widow' value='W' " . ($result['marital_status'] == 'W' ? 'checked' : '') . ">
                                                      <label class='form-check-label' for='widow'>
                                                        Widow/Widower
                                                      </label>
                                                    </div>
                                                  </div>
                                                </div>
                                                <br>



                                              ";


                    ?>
                    <br>
                    <div class="row text-center">
                      <div class="col-md-3"></div>
                      <a href="" class="col-md-6">
                        <button class="btn btn-success col-xl-12" name="updateButton" type="submit" name="updateDetails">Update Details</button>
                      </a>
                      &nbsp;
                    </div>
                    <br>
                    <div class="row text-center">
                      <div class="col-md-3"></div>
                      <a href="my_details.php" class="col-md-6">
                        <button class="btn btn-danger col-xl-12" type="button">Back</button>
                      </a>
                      &nbsp;
                    </div>
                </form>
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

<?php


if (isset($_POST['updateButton'])) {
  $fname = $_POST['fName'];
  $mname = $_POST['mName'];
  $lname = $_POST['lName'];
  $address = $_POST['address'];
  $gender = $_POST['gender'];
  $marital_status = $_POST['marital_status'];
  $email = $_SESSION['email'];

  updateCustDetails($email, $fname, $mname, $lname, $address, $gender, $marital_status);
}



?>