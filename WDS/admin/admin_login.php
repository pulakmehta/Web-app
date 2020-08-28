<!-- This is the header for customer dashboard -->
<?php 
if ( session_status() != PHP_SESSION_ACTIVE ) session_start();
    require_once "functions.php";
    if(isset($_SESSION['admin_email'])){
        echo "
          <script> 
            window.location.replace('index.php');
          </script>
          ";
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
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
	<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark text-center">
            <h5 style="color:white;margin-left: 20px;margin-top: 3px;">Admin Login</h5>
    </nav>

    <div id="error" style="display: <?php echo isset($display)?$display:'none';  ?>;">
  <br><br>
  <div class="<?php echo isset($alert_class)?$alert_class:'none'; ?>"><?php echo isset($errorMsg)?$errorMsg:'none';  ?></div>
</div>

    <form name="admin_login" id="admin_login" align="center" method="POST">
    <label>
        <br>
        <br>
        <br>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text p-10 text-center" id="basic-addon1"><b>Login </b>&nbsp; &nbsp;&nbsp; &nbsp; </span>
            </div>
        <input type="text" class="form-control" placeholder="Email ID" name="email">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text p-10 text-center" id="basic-addon1"><b>Password</b></span>
            </div>
        <input type="password" class="form-control" placeholder="Password" name="password">
        </div>
        <button type="submit" name="loginButton" class="btn btn-success col-md-12"> <b>Login</b></button>
        <br>
        <br>
        <a href="../index.php" class="btn btn-primary col-md-12"> <b>Home Page</b></a>
        &nbsp;       
    </label>

    </form>
        
        
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        
</body>
</html>

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
            $_SESSION['admin_email'] = $email;
            $_SESSION['admin_last_login_time'] = time();
            echo "
          <script> 
            window.location.replace('index.php');
          </script>
          ";
        }
    }

?>