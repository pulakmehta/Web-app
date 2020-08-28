<?php 
	if ( session_status() != PHP_SESSION_ACTIVE ) session_start();
  unset($_SESSION['admin_email']);
  if(isset($_SESSION['display'])){
    unset($_SESSION['display']);
  }
  if(isset($_SESSION['alert_class'])){
      unset($_SESSION['alert_class']);
  }
  if(isset($_SESSION['errorMsg'])){
      unset($_SESSION['errorMsg']);
  }
	// session_destroy();
	echo "
          <script> 
            window.location.replace('admin_login.php');
          </script>
          ";
 ?>