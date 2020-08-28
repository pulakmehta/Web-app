<?php require_once 'functions.php';
require_once '../customer/functions.php';
require_once 'bootstrap.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title>Admin Page</title>

  <?php
  // FOR GENDER DATA
  $sql_gender = "SELECT
        CASE gender
          WHEN 'M' THEN 'Male'
          WHEN 'F' THEN 'Female'
          ELSE 'Not Disclosed'
          END AS gender, count(*) as number FROM cust_details GROUP BY gender";
  $result_gender = mysqli_query($conn, $sql_gender);

  // FOR CUSTOMER TYPE DATA
  $sql_cust_type = "SELECT 
        CASE cust_type
          WHEN 'H' THEN 'Home Insurance'
          WHEN 'A' THEN 'Auto Insurance'
          WHEN 'B' THEN 'Both'
          ELSE 'Neither'
          END AS cust_type, count(*) as number FROM cust_details GROUP BY cust_type";
  $result_cust_type = mysqli_query($conn, $sql_cust_type);



  ?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawGenderChart);
    google.charts.setOnLoadCallback(drawCustTypeChart);
    google.charts.setOnLoadCallback(drawCustAmountChart);

    // Gender chart
    function drawGenderChart() {

      var data = google.visualization.arrayToDataTable([
        ['Gender', 'Number'],
        <?php
        while ($row = mysqli_fetch_array($result_gender)) {
          echo "['" . $row['gender'] . "'," . $row['number'] . "],";
        }
        ?>

      ]);

      var options = {
        title: 'Gender Statistics'
      };

      var chart = new google.visualization.PieChart(document.getElementById('gender'));

      chart.draw(data, options);
    }




    function drawCustTypeChart() {

      var data = google.visualization.arrayToDataTable([
        ['Customer Type', 'Number'],
        <?php
        while ($row = mysqli_fetch_array($result_cust_type)) {
          echo "['" . $row['cust_type'] . "'," . $row['number'] . "],";
        }
        ?>

      ]);

      var options = {
        title: 'Customer Type'
      };

      var chart = new google.visualization.PieChart(document.getElementById('cust_type'));

      chart.draw(data, options);
    }
  </script>

</head>

<body class="sb-nav-fixed">
  <?php
  require_once 'header.php';
  ?>
  <div id="layoutSidenav_content">
    <main>

      <div class="home_ins_content">
        <div class="container-fluid">
          <h1 class="mt-4">Customer's Information</h1>
          <!-- ERROR HANDLING DIV -->

<div id="error" style="display:<?php echo isset($_SESSION['display']) ? $_SESSION['display'] : 'none;';
                               unset($_SESSION['display']); ?> ">
  <div class="<?php echo isset($_SESSION['alert_class']) ? $_SESSION['alert_class'] : 'none;';
               unset($_SESSION['alert_class']); ?>">
    <?php echo isset($_SESSION['errorMsg']) ? $_SESSION['errorMsg'] : 'none;';
     unset($_SESSION['errorMsg']);  ?></div>
</div>

<!-- END OF ERROR HANDLING DIV -->
          <div class="card mb-12">
            <div class="card-header"><i class="fas fa-table mr-1"></i><b>VISUALIZATION</b></div>
            <div class="card-body">
              <div class="col-xl-12">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    Total number of customers served : <b>
                      <?php
                      $query = "SELECT count(cust_id) AS c FROM cust_details";
                      $result = mysqli_query($conn, $query);
                      if ($result) {
                        $sum = mysqli_fetch_array($result);
                        echo $sum['c'];
                        mysqli_free_result($result);
                      }
                      ?> </b>

                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div id="gender" class="col-md-6">

                      </div>
                      <div class="col-md-6" id="cust_type">

                      </div>
                      <div class="table-responsive">
                        <div class="col-md-12" id="amount_spent_by_cust">

                        </div>
                      </div>
                    </div>
                </ul>




              </div>


              <!--Add new houses-->


            </div>
          </div>
          <br><br>

          

          <?php

          $result = getAllCustDetails();
          if($result!=false){
              while($row = mysqli_fetch_array($result)){

              $row = showCustDetailsInCorrectFormat($row);
              
              removeUserModal($row['cust_id']);
            }
          }

          ?>

          <!-- Show user information -->
          <div class="card-mb-12" id="show_user_information">
            <div class="card-header">
              <b><i class="fas fa-user"></i> Customer data:</b>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="thead-light">
                        <tr>
                          <th>Id</th>
                          <th>Email</th>
                          <th>Name</th>
                          <th>Address</th>
                          <th>Gender</th>
                          <th>Marital Status</th>
                          <th>Cust Type</th>
                          <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>


                    
                      
                    <?php
                      
                      $result = getAllCustDetails(); 

                      if($result!=false){
                          while($row = mysqli_fetch_array($result)){

                              $row = showCustDetailsInCorrectFormat($row);

                              echo "
                              <tr>
                                <td>".$row['cust_id']."</td>
                                <td>".$row['email']."</td>
                                <td>".$row['first_name']." ".$row['middle_name']." ".$row['last_name']."</td>
                                <td>".$row['address']."</td>
                                <td>".$row['gender']."</td>
                                <td>".$row['marital_status']."</td>
                                <td>".$row['cust_type']."</td>
                                <td><b><a href='#' data-toggle='modal' data-target='#removeCustModal".$row['cust_id']."'><i class='fas fa-trash'></i></a></b></td>
                              </tr>
                              ";
                          }
                      }
                      else{
                        echo "<tr><td colspan='8'>No customer data found</td></tr>";
                      }

                    ?>



                      
                    </tbody>
                </table>
            </div>
          </div>


          
        </div>
      </div>
  </div>
  </div>

  <br><br>
  </div>
  </main>
  <?php require_once "footer.php"; ?>
  </div> <!-- This is the ending of the header -->
</body>

</html>


<?php

    if(isset($_POST['removeUser'])){
      $cust_id = $_POST['cust_id'];
      $res = removeCustomer($cust_id);

      if($res){
        $_SESSION['display'] = "inline";
        $_SESSION['errorMsg'] = "Successfully removed the user";
        $_SESSION['alert_class'] = "alert alert-success";
        unset($_SESSION['email']);
        echo "<script>window.location.replace('user_visualization.php');</script>";
      }
      else{
        $_SESSION['display'] = "inline";
        $_SESSION['errorMsg'] = "Error in removing the user";
        $_SESSION['alert_class'] = "alert alert-danger";
        echo "<script>window.location.replace('user_visualization.php');</script>";
      }
    }

?>