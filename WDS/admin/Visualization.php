<html>
  <head>
  	<?php 
		$connection = new mysqli('localhost:3308','root','','db_proj_final');
		$result = mysqli_query($connection, "SELECT * from cust_details"); 
		// Below is for gender graph - male, female, dont know
		$male = mysqli_fetch_array(mysqli_query($connection, "SELECT count(gender) FROM cust_details WHERE gender='M'"));
		$female = mysqli_fetch_array(mysqli_query($connection, "SELECT count(gender) FROM cust_details WHERE gender='F'"));
		$refrain = mysqli_fetch_array(mysqli_query($connection, "SELECT count(gender) FROM cust_details WHERE gender=''"));

		// Maritial Status of the customers
		$single = mysqli_fetch_array(mysqli_query($connection, "SELECT count(marital_status) FROM cust_details WHERE marital_status='S'"));
		$married = mysqli_fetch_array(mysqli_query($connection, "SELECT count(marital_status) FROM cust_details WHERE marital_status='M'"));
		$widow = mysqli_fetch_array(mysqli_query($connection, "SELECT count(marital_status) FROM cust_details WHERE marital_status='W'"));

		// Below is for customer type
		$auto = mysqli_fetch_array(mysqli_query($connection, "SELECT count(cust_type) FROM cust_details WHERE cust_type='A'"));
		$home = mysqli_fetch_array(mysqli_query($connection, "SELECT count(cust_type) FROM cust_details WHERE cust_type='H'"));
		$both = mysqli_fetch_array(mysqli_query($connection, "SELECT count(cust_type) FROM cust_details WHERE cust_type='B'"));
	?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawGenderChart);
      google.charts.setOnLoadCallback(drawMaritalChart);
      google.charts.setOnLoadCallback(drawCustTypeChart);

      // Gender chart
      function drawGenderChart() {

        var data = google.visualization.arrayToDataTable([
          ['Gender', 'People'],
          ['Male',<?php print_r($male[0]);?>],
          ['Female',<?php print_r($female[0]);?>],
          ['Did not disclose',<?php print_r($refrain[0]);?>],
        ]);

        var options = {
          title: 'Gender'
        };

        var chart = new google.visualization.PieChart(document.getElementById('gender'));

        chart.draw(data, options);
      }

      //Marital Status
      function drawMaritalChart() {

        var data = google.visualization.arrayToDataTable([
          ['Marital Status', 'People'],
          ['Married',<?php print_r($married[0]);?>],
          ['Single',<?php print_r($single[0]);?>],
          ['Widow/Widower',<?php print_r($widow[0]);?>],
        ]);

        var options = {
          title: 'Marital Status'
        };

        var chart = new google.visualization.PieChart(document.getElementById('marital_status'));

        chart.draw(data, options);
      }

      //Customer Type
      function drawCustTypeChart() {

        var data = google.visualization.arrayToDataTable([
          ['Customer Type', 'People'],
          ['Automotive Insurance',<?php print_r($auto[0]);?>],
          ['Home Insurance',<?php print_r($home[0]);?>],
          ['Both Insurnace',<?php print_r($both[0]);?>],
        ]);

        var options = {
          title: 'Customer Type'
        };

        var chart = new google.visualization.PieChart(document.getElementById('cust_type'));

        chart.draw(data, options);
      }

    </script>
  </head>
  <body>
    <div id="gender" style="width: 900px; height: 500px;"></div>
    <div id="marital_status" style="width: 900px; height: 500px;"></div>
    <div id="cust_type" style="width: 900px; height: 500px;"></div>
  </body>
</html>