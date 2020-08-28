<?php
    if (session_status() != PHP_SESSION_ACTIVE) session_start();
    
?>
<main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Home Insurances</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">All details about your home insurances can be found here.</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4" style="font-weight: bold;">
                                    <div class="card-body">My houses <b>(<?php 
                                            //Showing number of houses here
                                        echo getHouseCount($_SESSION['email']);
                                     ?>)</b></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="home_ins_houses.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4" style="font-weight: bold;">
                                    <div class="card-body">New Insurance </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="new_home_ins.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4" style="font-weight: bold;">
                                    <div class="card-body">Payments <b style="color:red;">(<?php echo getCurrentMonthPaymentCount($_SESSION['email']); ?>)</b></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="home_ins_payments.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4" style="font-weight: bold;">
                                    <div class="card-body">Current Insurances <b>(<?php echo getInsuranceCount($_SESSION['email']); ?>)</b> </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="current_ins.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
<!-- ERROR HANDLING DIV -->

<div id="error" style="display:<?php echo isset($_SESSION['display']) ? $_SESSION['display'] : 'none;';
                               unset($_SESSION['display']); ?> ">
  <div class="<?php echo isset($_SESSION['alert_class']) ? $_SESSION['alert_class'] : 'none;';
               unset($_SESSION['alert_class']); ?>">
    <?php echo isset($_SESSION['errorMsg']) ? $_SESSION['errorMsg'] : 'none;';
     unset($_SESSION['errorMsg']);  ?></div>
</div>

<!-- END OF ERROR HANDLING DIV -->