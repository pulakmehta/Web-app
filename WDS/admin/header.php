<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();
require_once 'functions.php';
require_once 'bootstrap.php';
if (!isset($_SESSION['admin_email'])) {
    echo "
      <script> 
        window.location.replace('admin_login.php');
      </script>
      ";
}



?>
<!-- This is the header for customer dashboard -->
<!DOCTYPE html>
<html>

<head>
    <title>Admin's Page</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <h5 style="color:white;margin-left: 20px;margin-top: 3px;">Admin's Menu:</h5>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="404.html">Settings</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Statistics</div>
                        <a class="nav-link" href="user_visualization.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-check"></i></div>
                            Customer's Details
                        </a>

                        <a class="nav-link collapsed" href="auto_ins_visualization.php"><i class="fas fa-car-crash"></i> &nbsp;Auto Insurance</a>

                        <a class="nav-link collapsed" href="home_ins_visualization.php"><i class="fas fa-house-damage"></i> &nbsp;Home Insurance</a>

                        <a class="nav-link collapsed" href="home_visualization.php"><i class="fas fa-home"></i> &nbsp;House Details</a>
                        <a class="nav-link collapsed" href="vehicle_visualization.php"><i class="fas fa-car"></i> &nbsp;&nbsp;Vehicle/Driver Details</a>

                        <a class="nav-link collapsed" href="admin_register.php"><i class="fas fa-user-plus"></i> &nbsp;&nbsp;Add Admin</a>
                        
                        <a class="nav-link" href="../index.php">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                Landing Page
                            </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <b>

                        <!-- Getting the name of the user:  -->
                        <?php
                        $result = showAdminDetails($_SESSION['admin_email']);
                        echo $result['name'];
                        ?>


                    </b>
                </div>
            </nav>
        </div>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>