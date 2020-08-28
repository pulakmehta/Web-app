<?php 
    if (session_status() != PHP_SESSION_ACTIVE) session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        
        <title>Customer's Page</title>
        
    </head>
    <body class="sb-nav-fixed">
         <?php 
             require_once 'header.php';
         ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">
                            <!-- Getting the name of the user:  -->
                            <?php 
                                    $result = showCustDetails($_SESSION['email']);
                                    echo $result['first_name']."'s Dashboard";
                             ?>
                        </h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">My Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-4 col-md-6"> 
                                <div class="card bg-primary text-white mb-4" style="font-weight: bold;">
                                    <div class="card-body">Home Insurances</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="home_ins_houses.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-warning text-white mb-4" style="font-weight: bold;">
                                    <div class="card-body"> Auto Insurances</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="current_auto_ins.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-danger text-white mb-4" style="font-weight: bold;">
                                    <div class="card-body">My Details</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="my_details.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-md-6"> 
                                <div class="card bg-secondary text-white mb-4" style="font-weight: bold;">
                                    <div class="card-body">My Houses</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="home_ins_houses.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-info text-white mb-4" style="font-weight: bold;">
                                    <div class="card-body">My Vehicles</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="vehicles.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-success text-white mb-4" style="font-weight: bold;">
                                    <div class="card-body">Driver Details</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="drivers.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php require_once 'footer.php'; ?>
            </div>
         </div>      <!-- This is the ending of the header --> 
    </body>
</html>
