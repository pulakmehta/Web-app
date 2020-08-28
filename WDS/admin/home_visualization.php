<?php
require_once 'functions.php';
require_once 'header.php';
 require 'top-cache.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <title>Admin Page</title>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    ;
    google.charts.load('current', {
      'packages': ['map'],
      // Note: you will need to get a mapsApiKey for your project.
      // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
      'mapsApiKey': 'AIzaSyCXeLZ7h4gxhoBl2sJZv7EDzzSP6EfgEyc'
    });
    google.charts.setOnLoadCallback(drawMap);

    function drawMap() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Location');
      data.addColumn('string', 'Marker')

      data.addRows([
        <?php
        $query1 = "SELECT location from home_details";
        $result = mysqli_query($conn, $query1);

        while ($row = $result->fetch_assoc()) {
          print_r("['" . $row['location'] . "', '".$row['location']."'], ");
        };
        ?>
      ]);
      var url = 'https://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/';

      var options = {
        zoomLevel: 5,
        showTooltip: true,
        showInfoWindow: true,
        useMapTypeControl: true,
        icons: {
          blue: {
            normal: url + 'Map-Marker-Ball-Azure-icon.png',
            selected: url + 'Map-Marker-Ball-Right-Azure-icon.png'
          },
          green: {
            normal: url + 'Map-Marker-Push-Pin-1-Chartreuse-icon.png',
            selected: url + 'Map-Marker-Push-Pin-1-Right-Chartreuse-icon.png'
          },
          pink: {
            normal: url + 'Map-Marker-Ball-Pink-icon.png',
            selected: url + 'Map-Marker-Ball-Right-Pink-icon.png'
          }
        }
      };
      var map = new google.visualization.Map(document.getElementById('map_div'));

      map.draw(data, options);
    }
  </script>



</head>

<body class="sb-nav-fixed">
  <div id="layoutSidenav_content">
    <main>

      <div class="home_ins_content">
        <div class="container-fluid">
          <h1 class="mt-4">Home Dashboard</h1>

          <div class="card mb-12">
            <div class="card-header"><i class="fas fa-table mr-1"></i>VISUALIZATION - Powered by Google Maps</div>
            <br>
            <center><h6><b>Note: </b>You can see the house location of customers below</h6></center>
            <div class="card-body">
              <div class="col-xl-12">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <!-- <div id="chart_div" style="width: 900px; height: 500px;"></div> -->
                    <div id="map_div" style="height: 500px; width: 900px"></div>

                  </li>
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

<?php require_once 'bottom-cache.php'; ?>