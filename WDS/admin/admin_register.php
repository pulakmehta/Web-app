<!DOCTYPE html>
<html lang="en">

<head>

    <title>Admin Page</title>

</head>

<body class="sb-nav-fixed">
    <?php
    require_once 'header.php';
    ?>
    <div id="layoutSidenav_content">
        <main>
            <br><br>

<!-- ERROR HANDLING DIV -->

<div id="error" style="display:<?php echo isset($_SESSION['display']) ? $_SESSION['display'] : 'none;';
                               unset($_SESSION['display']); ?> ">
  <div class="<?php echo isset($_SESSION['alert_class']) ? $_SESSION['alert_class'] : 'none;';
               unset($_SESSION['alert_class']); ?>">
    <?php echo isset($_SESSION['errorMsg']) ? $_SESSION['errorMsg'] : 'none;';
     unset($_SESSION['errorMsg']);  ?></div>
</div>

<!-- END OF ERROR HANDLING DIV -->

            <!-- ADMIN REGISTER -->
            <div class="card mb-10">
                <div class="card-header">
                    <center style='font-weight: bold;'><i class="fas fa-plus"></i>Add another admin</center>
                </div>
                <div class="card-body">
                    <form name="admin_login" id="admin_login" align="center" method="POST">
                        <label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text p-10" id="basic-addon1">Email ID &nbsp; &nbsp; </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Email ID" required name="email">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text p-10" id="basic-addon1">Password &nbsp;</span>
                                </div>
                                <input type="password" class="form-control" placeholder="Password" required name="password">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text p-10" id="basic-addon1">Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                </div>
                                <input type="text" class="form-control" placeholder="First Name" required name="name">
                            </div>
                            <button class="btn btn-success col-md-12" type="submit" name="registerAdmin"><b>Register Admin</b></button>
                        </label>

                    </form>
                </div>
            </div>


        </main>
        <?php require_once "footer.php"; ?>
    </div>
    </div> <!-- This is the ending of the header -->
</body>

</html>

<?php

// Register code
if (isset($_POST["registerAdmin"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    $status = registerAdmin($email, $password, $name);
    if ($status == 0) {
        $_SESSION['display'] = "inline";
        $_SESSION['errorMsg'] = "Error in registering <br> Please try again after some time.";
        $_SESSION['alert_class'] = "alert alert-danger";
        echo "<script>window.location.replace('admin_register.php');</script>";
    } else if ($status == -1) {
        $_SESSION['display'] = "inline";
        $_SESSION['errorMsg'] = "Error in registering admin! <br> Email already exists.";
        $_SESSION['alert_class'] = "alert alert-danger";
        echo "<script>window.location.replace('admin_register.php');</script>";
    } else {
        $_SESSION['display'] = "inline";
        $_SESSION['errorMsg'] = "Successfully registered admin!";
        $_SESSION['alert_class'] = "alert alert-success";
        echo "<script>window.location.replace('admin_register.php');</script>";
    }
}

?>