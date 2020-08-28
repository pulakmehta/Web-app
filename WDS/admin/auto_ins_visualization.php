<?php 
    require_once 'functions.php';
    require_once 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            $sql_amount_by_cust = "
            SELECT 
              c.cust_id, c.email,sum(ap.amount) as autott FROM cust_details c JOIN auto_ins a ON a.cust_id=c.cust_id JOIN auto_ins_payments ap ON ap.ainsid=a.ainsid WHERE ap.status='1' AND ap.ainsid=a.ainsid GROUP BY c.cust_id
            ";

            $result_amount_by_cust = mysqli_query($conn, $sql_amount_by_cust);  


            $sql_amount_by_cust1 = "
            SELECT 
              c.cust_id, c.email,sum(ap.amount) as autott FROM cust_details c JOIN auto_ins a ON a.cust_id=c.cust_id JOIN auto_ins_payments ap ON ap.ainsid=a.ainsid WHERE ap.status='1' AND ap.ainsid=a.ainsid GROUP BY c.cust_id
            ";

            $result_amount_by_cust1 = mysqli_query($conn, $sql_amount_by_cust1);  
        ?>
        
        <title>Admin Page</title>

            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
              google.charts.load('current', {'packages':['corechart']});
              google.charts.setOnLoadCallback(drawAmountChart);
              google.charts.setOnLoadCallback(drawAmountPieChart);

              function drawAmountChart() {

                var data = google.visualization.arrayToDataTable([
                  ['CEmail', 'Amt'],
                  <?php 

                      while($row = mysqli_fetch_array($result_amount_by_cust)){
                        echo "['".$row['email']."',".$row['autott']."],";
                      }

                    ?>
                ]);

                var options = {
                  title: 'Amount Spent on Auto Insurance By each customer'
                };

                var chart = new google.visualization.BarChart(document.getElementById('amount_by_each_cust'));

                chart.draw(data, options);
              }



              function drawAmountPieChart() {

                var data = google.visualization.arrayToDataTable([
                  ['Customers Email', 'Amount'],
                  <?php 

                      while($row = mysqli_fetch_array($result_amount_by_cust1)){
                        echo "['".$row['email']."',".$row['autott']."],";
                      }

                    ?>
                ]);

                var options = {
                  title: 'Amount Spent on Auto Insurance By each customer'
                };

                var chart = new google.visualization.PieChart(document.getElementById('amount_pie_by_each_cust'));

                chart.draw(data, options);
              }
            </script>



        
    </head>
    <body class="sb-nav-fixed">
            <div id="layoutSidenav_content">
                <main>
                    
                    <div class="home_ins_content">
                        <div class="container-fluid">
                        <h1 class="mt-4">Auto Insurance Dashboard</h1>
                        
                        <div class="card mb-12">
                            <div class="card-header"><i class="fas fa-table mr-1"></i>VISUALIZATION</div>
                            <div class="card-body">
                                <div class="col-xl-12">
                                            <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                Net amount collected over lifetime is <b>$  
                                                <?php 
                                                        $query = "SELECT SUM(amount) AS tsum FROM auto_ins_payments WHERE status='1'"; 
                                                        $result = mysqli_query($conn, $query);
                                                        if ($result) 
                                                        {   
                                                            $sum = mysqli_fetch_array($result);
                                                            echo $sum['tsum']; 
                                                            mysqli_free_result($result); 
                                                        }  
                                                ?> </b>

                                            </li>
                                            <li class="list-group-item">
                                                <?php 
                                                        $query1 = "SELECT * FROM auto_ins";
                                                        $query2 = "SELECT * FROM auto_ins WHERE STATUS = 'C'";  
                                                        $num = mysqli_query($conn, $query1);
                                                        $cur = mysqli_query($conn, $query2);
                                                        if ($num) 
                                                        {   
                                                            $sum = mysqli_num_rows($num);
                                                            printf("Total number of users who have used auto insurance product is <b> %d</b>\n",$sum);  
                                                            printf ("<br>");
                                                            printf ("&nbsp; &nbsp;");
                                                            $sum2 = mysqli_num_rows($cur);
                                                            printf("- Total number of current users of the auto insurance is <b> %d</b>\n",$sum2);
                                                            printf ("<br>");
                                                            printf ("&nbsp; &nbsp;");  
                                                            $sum3 = mysqli_num_rows($num) - mysqli_num_rows($cur);
                                                            printf("- Total number of past users of the auto insurance is <b> %d</b>\n",$sum3);
                                                        }
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12" id="amount_by_each_cust">
                                                        
                                                    </div>
                                                    <div class="col-md-12" id="amount_pie_by_each_cust">
                                                        
                                                    </div>
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
         </div>      <!-- This is the ending of the header --> 
    </body>
</html>
