<!-- This page shows current auto insurances -->
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
				 <br><br>
	 		<center>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="vehicles.php" class="btn btn-secondary btn-lg"><b>Vehicles</b></a>
                    <a href="drivers.php" class="btn btn-info btn-lg"><b>Drivers</b></a>

                </div>
            </center>
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