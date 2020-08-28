<?php
require_once 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <title>Admin Page</title>
  <?php
  $result1 = mysqli_query($conn, "SELECT * from vehicles");
  // Below is for car type
  $car = mysqli_fetch_array(mysqli_query($conn, "SELECT count(vehicle_type) FROM vehicles WHERE vehicle_type='Car'"));
  $truck = mysqli_fetch_array(mysqli_query($conn, "SELECT count(vehicle_type) FROM vehicles WHERE vehicle_type='Truck'"));
  $bike = mysqli_fetch_array(mysqli_query($conn, "SELECT count(vehicle_type) FROM vehicles WHERE vehicle_type='Bike'"));

  // Vehicle status
  $owned = mysqli_fetch_array(mysqli_query($conn, "SELECT count(status) FROM vehicles WHERE status='O'"));
  $finance = mysqli_fetch_array(mysqli_query($conn, "SELECT count(status) FROM vehicles WHERE status='F'"));
  $lease = mysqli_fetch_array(mysqli_query($conn, "SELECT count(status) FROM vehicles WHERE status='L'"));


  ?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawCarChart);
    google.charts.setOnLoadCallback(drawVehicleChart);

    function drawCarChart() {

      var data = google.visualization.arrayToDataTable([
        ['Vehicle', 'Type'],
        ['Car', <?php print_r($car[0]); ?>],
        ['Truck', <?php print_r($truck[0]); ?>],
        ['Bike', <?php print_r($bike[0]); ?>],
      ]);

      var options = {
        title: 'Vehicle Type'
      };

      var chart = new google.visualization.PieChart(document.getElementById('type'));

      chart.draw(data, options);
    }

    function drawVehicleChart() {

      var data = google.visualization.arrayToDataTable([
        ['Status', 'Number of People'],
        ['Owned', <?php print_r($owned[0]); ?>],
        ['Lease', <?php print_r($lease[0]); ?>],
        ['Financed', <?php print_r($finance[0]); ?>],
      ]);

      var options = {
        title: 'Vehicle Status'
      };

      var chart = new google.visualization.PieChart(document.getElementById('vehicle_status'));

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
          <h1 class="mt-4">Vehicle Dashboard</h1>

          <div class="card mb-12">
            <div class="card-header"><i class="fas fa-table mr-1"></i>VISUALIZATION</div>
            <div class="card-body">
              <div class="col-xl-12">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    Lifetime number of vehicles insured <b>
                      <?php
                      $query = "SELECT count(vin) AS veh FROM vehicles";
                      $result = mysqli_query($conn, $query);
                      if ($result) {
                        $sum = mysqli_fetch_array($result);
                        echo $sum['veh'];
                        mysqli_free_result($result);
                      }
                      ?> </b>

                  </li>
                  <li class="list-group-item">
                    Total Number of Driver in the system <b>
                      <?php
                      $query = "SELECT COUNT(license_no) AS v FROM drivers";
                      $result = mysqli_query($conn, $query);
                      if ($result) {
                        $sum = mysqli_fetch_array($result);
                        echo $sum['v'];
                        mysqli_free_result($result);
                      }
                      ?> </b>
                  </li>
                  <li class="list-group-item">

                  <div class="row">
                      <div class="col-md-6" id="type"></div>
                      <div class="col-md-6" id="vehicle_status"></div>
                  </div>
                    
                </ul>




              </div>


              <!--Add new houses-->


            </div>
          </div>


          
        </div>
      </div>
  </div>
  </div>

  </main>
  <?php require_once "footer.php"; ?>
  </div>
  </div> <!-- This is the ending of the header -->
</body>

</html>