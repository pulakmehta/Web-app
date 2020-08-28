 <!DOCTYPE html>
 <html>

 <head>
   <title>Home Insurance</title>
   <style type="text/css">
     #tableHouse tr td,
     th {
       text-align: center;
       padding: 10px;
     }

     .package_input {
       text-align: center;
       background: white;
       color: black;
     }
   </style>

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
         <div class="card-header"><i class="fas fa-table mr-1"></i> New Home Insurance</div>

         <div class="card-body">
           <div id="directions">
             <center>Select the houses from below which you want to insure,
               <br>
               Then Select the duration of insurance you want to avail.
               <br>
               Then click to proceed to receive a quote.
             </center>
           </div>


           <!-- Show Table Data here -->
           <form method="POST" action="" accept-charset="UTF-8">
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
                     <th>More Details</th>
                     <th>Insure this</th>
                   </tr>
                 </thead>
                 <tbody id="show_home_details_table">

                   <?php

                    $email = $_SESSION['email'];
                    $res = showUnInsuredHomes($email);


                    if ($res == false) {
                      echo " 
                      <tr>
                        <td colspan='7'>No Houses found. &nbsp;&nbsp;Add some from my houses portal.</td>
                      </tr>
                    ";
                    } else {
                      $count = 1;
                      while ($result = mysqli_fetch_array($res)) {

                        $result = convertHomeProperFormat($result);

                        createHomeDetailsModal($result);

                        echo " 
                        <tr>
                          <td>" . $result['home_id'] . "</td>
                          <td>" . $result['location'] . "</td>
                          <td>" . $result['purchase_date'] . "</td>
                          <td>" . $result['purchase_value'] . "</td>
                          <td>" . $result['area_sq_feet'] . "</td>";

                        echo "<td> <a href='#' data-toggle='modal' data-target='#homeModal" . $result['home_id'] . "'>Details</a></td>
                          
                          <td><input type='checkbox' name='addHouseToIns[]' value='" . $result['home_id'] . "' style='zoom: 1.5;'></td>
                        </tr>
                      ";
                        $count++;
                      }
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


  if (isset($_POST['getQuote'])) {
    // Calculates quotes from fields, and then displays the billed modal.
    $home_id = 0;     // Gives me the home id which I wanna insure.
    $amount = 0;

    $duration = $_POST['insDuration'];

    $homeIds = "";

    $totalAmountDetails = array("purchase_value" => 0, "area" => 0, "autoFireDiscount" => 0, "homeSecurityDiscount" => 0, "swimmingCharges" => 0, "basementDiscount" => 0, "totalAmount" => 0);

    if (!empty($_POST['addHouseToIns'])) {
      $homeIds =  $_POST['addHouseToIns'];
      // Loop to store and display values of individual checked checkbox.
      foreach ($_POST['addHouseToIns'] as $selected) {
        $home_id = $selected;
        $getAmountDetails = calculateHomeInsAmount($home_id);

        foreach ($getAmountDetails as $k => $v) {
          $totalAmountDetails[$k] += $v;
        }
      }
      createQuoteModal($totalAmountDetails, $duration, $homeIds);
      echo "<script>$('#quoteModal').modal('show')</script>";
    }
    else{
      echo "<script>alert('Please select the house and duration!');</script>";
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


    $hinsid = newHomeIns($cust_id, $start_date, $end_date, $total_amount, $status);

    $res = createPayments($hinsid, $total_amount, $duration, $start_date);

    $success = false;
    
    if($hinsid!=0 || $hinsid!='0'){
      foreach ($_POST['homeIds'] as $i) {

        $result = insureHouse($i, $hinsid);
        if($result){
            //Successfully created insurance and set home ids
            $success = true;
        }
        else{
            // Trouble in insuring the house.
            $success = false;
            $_SESSION['display'] = "inline";
            $_SESSION['errorMsg'] = "Error in insuring house! <br> Please try again with all fields filled.";
            $_SESSION['alert_class'] = "alert alert-danger";
            echo "<script>window.location.replace('new_home_ins.php');</script>";
        }
      }
    }
    else if($hinsid =='-1' || $hinsid==-1){
      $success = false;
    }
    else{
      $_SESSION['display'] = "inline";
      $_SESSION['errorMsg'] = "Fields cannot be empty! <br> Please try again with all fields filled.";
      $_SESSION['alert_class'] = "alert alert-danger";
      echo "<script>window.location.replace('new_home_ins.php');</script>";
    }

    if($success == true && $res == true){
      // Successfully registered with houses.
      $_SESSION['display'] = "inline";
      $_SESSION['errorMsg'] = "Successfully added the insurance for your houses. <br> You can see them below.";
      $_SESSION['alert_class'] = "alert alert-success";
      echo "<script>window.location.replace('current_ins.php');</script>";
    }
    else{
        // error in registering.
        $_SESSION['display'] = "inline";
        $_SESSION['errorMsg'] = "Error in creating your insurance! <br> Please try again after some time.";
        $_SESSION['alert_class'] = "alert alert-danger";
        echo "<script>window.location.replace('new_home_ins.php');</script>";
    }
  }



  ?>