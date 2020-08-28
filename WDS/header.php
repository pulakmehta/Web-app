<?php require_once 'db.php';
require_once 'bootstrap.php';
require_once 'functions.php';
if ( session_status() != PHP_SESSION_ACTIVE ) session_start();
$login = 'block;';
$dashboard = 'none;';
if (isset($_SESSION['email'])) {
    $login = 'none;';
    $dashboard = 'block;';
}
else{
    $login = 'block;';
    $dashboard = 'none;';
}
?>


<link href="stylesheets/bootstrap.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="stylesheets/header_style.css">
<link href="assets/css/login_register_style.css" rel="stylesheet" />
<script src="scripts/login_register_script.js" type="text/javascript"></script>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php" id="wds_logo">
                    <img src="images/wds_logo">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#about">ABOUT</a></li>
                    <li><a href="#products">PRODUCTS</a></li>
                    <li><a href="#contact">CONTACT</a></li>
                    <!-- Register button -->
                    <li style="display:<?php echo $login; ?>"><a data-toggle="modal" href="javascript:void(0)" onclick="openRegisterModal();"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <!-- Login button -->
                    <li style="display:<?php echo $login; ?>"><a data-toggle="modal" href="javascript:void(0)" onclick="openLoginModal();"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    <!-- Dashboard Button -->
                    <li style="display:<?php echo $dashboard; ?>">
                        <a href="customer/index.php"><span class="glyphicon glyphicon-log-in"></span> My Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- MOdals for register and login -->
    <div class="modal fade login" id="loginModal">
        <div class="modal-dialog login animated">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Login:</h4>
                </div>
                <div class="modal-body">
                    <div class="box">
                        <div class="content">
                            <div class="form loginBox">
                                <form method="POST" action="" accept-charset="UTF-8" style="color:black;">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="email">
                                                Email:
                                            </label>
                                        </div>
                                        <input class="col-md-9" id="email" class="form-control" type="email" placeholder="Email" name="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="format: a@a.az">
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="password">
                                                Password:
                                            </label>
                                        </div>
                                        <input class="col-md-9" id="password" class="form-control" type="password" placeholder="Password" name="password" required pattern=".{6,10}" title="Between 6-12 characters">
                                    </div>
                                    <br>
                                    <div class="row text-center">
                                        <div class="col-md-2"></div>
                                        <center>
                                            <input class="btn btn-default btn-login col-md-9" style="background: #00c696;color:white; font-weight: bold;" type="submit" value="LOGIN" name="loginButton" id="loginButton">
                                        </center>
                                    </div>
                                </form>
                                <?php if (isset($script)) {
                                    echo '<script>alert($script)<script>';
                                } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="box">
                    <!-- For registering -->
                    <div class="content registerBox" style="display:none;">
                        <div class="form">
                            <form method="POST" action="" accept-charset="UTF-8" style="color:black;">
                                <div class="row text-right">
                                    <div class="col-md-4">
                                        <label for="email">
                                            Email:
                                        </label>
                                    </div>
                                    <input class="col-md-7" id="email" class="form-control" type="email" placeholder="Email" name="rEmail" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="format: a@a.az">
                                </div>
                                <br>
                                <div class="row text-right">
                                    <div class="col-md-4">
                                        <label for="password">
                                            Password:
                                        </label>
                                    </div>
                                    <input class="col-md-7" id="password" class="form-control" type="password" placeholder="Password" name="rPassword" required pattern=".{6,10}" title="Between 6-12 characters">
                                </div>
                                <br>
                                <div class="row text-right">
                                    <div class="col-md-4">
                                        <label for="fname">
                                            First Name:
                                        </label>
                                    </div>
                                    <input class="col-md-7" id="fname" class="form-control" type="text" placeholder="First Name" name="rFname" required>
                                </div>
                                <br>
                                <div class="row text-right">
                                    <div class="col-md-4">
                                        <label for="lname">
                                            Last Name:
                                        </label>
                                    </div>
                                    <input class="col-md-7" id="lname" class="form-control" type="text" placeholder="Last Name" name="rLname" required>
                                </div>
                                <br>
                                <div class="row text-center">
                                    <div class="col-md-4"></div>
                                    <center>
                                        <input class="btn btn-default btn-login col-md-7" style="background: #00c696;color:white; font-weight: bold;" type="submit" name="registerButton" value="REGISTER">
                                    </center>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="forgot login-footer">
                        <span>Looking to
                            <a href="javascript: showRegisterForm();">create an account</a>
                            ?</span>
                    </div>
                    <div class="forgot register-footer" style="display:none">
                        <span>Already have an account?</span>
                        <a href="javascript: showLoginForm();">Login</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    <?php

    // Login code
    if (isset($_POST["loginButton"])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $status = login($email, $password);
        if ($status == 0) {
            $display = "inline;";
            $errorMsg = "Invalid Credentials. <br> Please Login Again!";
            $alert_class = "alert alert-danger";
        } else {
            $_SESSION['email'] = $email;
            $_SESSION['last_login_time'] = time();
            echo "
        <script> 
            window.location.replace('customer/index.php');
        </script>
        ";
        }
    }


    // Register code
    if (isset($_POST["registerButton"])) {
        $email = $_POST['rEmail'];
        $password = $_POST['rPassword'];
        $fname = $_POST['rFname'];
        $lname = $_POST['rLname'];

        $status = register($email, $password, $fname, $lname);
        if ($status == 0) {
            $display = "inline;";
            $errorMsg = "Error in registering! <br> Please try again after some time.";
            $alert_class = "alert alert-danger";
        } else if ($status == -1) {
            $display = "inline;";
            $errorMsg = "Error in registering! <br> Email already registered <br> Try with different Email";
            $alert_class = "alert alert-danger";
        } else {
            $display = "inline;";
            $errorMsg = "Successfully registered! <br> Log in using your Credentials!";
            $alert_class = "alert alert-success";
        }
    }



    ?>