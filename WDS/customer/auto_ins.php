<?php 
	require_once 'header.php';
?>
<!-- This page will display current auto insurances of the user. -->
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Auto Insurance</title>
 	<style type="text/css">
 		#tableHouse tr td,th{
 			text-align: center;
 			padding:10px;
 		}
 	</style>

 </head>
 <body class="sb-nav-fixed">
 	<?php 
		require_once 'header.php';
	 ?>
 	<div id="layoutSidenav_content">
                <?php 
                	require_once 'auto_ins_header.php';
                 ?>

                 
                 <div class="home_ins_content">
                        <div class="card mb-4">
                            <div class="card-header"><i class="fas fa-table mr-1"></i> MY HOUSES</div>
                            <div class="card-body">
                                <div class="row">
		                            <div class="col-xl-8">
		                                <div class="card mb-4">
		                                    <div class="card-header"><i class="fas fa-home mr-1"></i>Current Houses</div>
		                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas>
		                                    	<table border="1" id="tableHouse">
		                                    		<thead>
		                                    			<tr>
		                                    				<!-- 1. --> <th>H. No</th>
			                                    			<!-- 2. --> <th>Location</th>
			                                    			<!-- 3. --> <th>Purchase Date</th>
			                                    			<!-- 4. --> <th>Area(sqFt)</th>
			                                    			<!-- 5. --> <th>Type</th>
			                                    			<!-- 6. --> <th>Rented?</th>
		                                    			</tr>
		                                    		</thead>
		                                    		<tbody>
		                                    			<tr>
		                                    				<td>1</td>
		                                    				<td>New York</td>
		                                    				<td>24th Apr 2020</td>
		                                    				<td>1000</td>
		                                    				<td>Apartment</td>
		                                    				<td>Yes</td>
		                                    			</tr>
		                                    			<tr>
		                                    				<td>2</td>
		                                    				<td>New J</td>
		                                    				<td>24th Apr 2020</td>
		                                    				<td>2000</td>
		                                    				<td>Apartment</td>
		                                    				<td>No</td>
		                                    			</tr>
		                                    		</tbody>
		                                    	</table>
		                                    </div>
		                                </div>
		                            </div>
		                            <div class="col-xl-4">
		                                <div class="card mb-4">
		                                    <div class="card-header"><i class="fas fa-plus mr-1"></i>Add a new house</div>
		                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas>
		                                    	<form method="POST" action="" accept-charset="UTF-8" style="color:black;margin-top: -50px;">
			                                        <div class="row">
			                                            <div>
			                                                <label for="email">
			                                                   Location:
			                                                </label>
			                                                <br>
			                                            </div>
			                                            <input id="Location" class="form-control" type="text" placeholder="Location" name="Location">
			                                        </div>
			                                        <br>
			                                        <div class="row">
			                                            <div>
			                                                <label for="pdate">
			                                                   Purchase Date:
			                                                </label>
			                                                <br>
			                                            </div>
			                                            <input id="pdate" class="form-control" type="date" placeholder="Purchase Date:" name="pdate">
			                                        </div>
			                                        <br>
			                                        <div class="row text-center">
			                                            <div>
			                                                <label for="Area">
			                                                   Area:
			                                                </label>
			                                                <br>
			                                            </div>
			                                            <input id="Area" class="form-control" type="text" placeholder="Area in square feet" name="Area">
			                                        </div>
			                                        <br>
			                                        <div class="row text-center">
			                                            <div>
			                                                <label for="Type">
			                                                   Type:
			                                                </label>
			                                                <br>
			                                            </div>
			                                            <input id="Type" class="form-control" type="text" placeholder="Type" name="Type">
			                                        </div>
			                                        <br>
			                                        <div class="row text-center">
			                                            <input class="btn btn-primary col-md-12" id="newHouse" class="form-control" type="submit" name="newHouse">
			                                        </div>
			                                    </form>

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
         </div>      <!-- This is the ending of the header -->
 </body>
 </html>