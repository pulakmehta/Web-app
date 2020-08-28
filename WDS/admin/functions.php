<?php 
	require_once '../db.php';
	if ( session_status() != PHP_SESSION_ACTIVE ) session_start();
	function autoLogout(){
		if(isset($_SESSION['admin_email'])){
			$mins = 30;
			if((time() - $_SESSION['admin_last_login_time'])>(60*$mins)){
				echo "<script>window.location.replace('logout.php');</script>";
			}
		}
	}
	autoLogout();
	

	function login($email, $password){
		global $conn;

		$password = md5($password);

		$query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
		$result = mysqli_query($conn,$query);
		$rows = mysqli_num_rows($result);
		if($rows > 0){
			return 1;
		}
		else{
			return 0;
		}
	}

	function registerAdmin($email,$password, $name){

		global $conn;


		$password = md5($password); 	//encrypting.

		$query = "SELECT * FROM admin WHERE email='$email'";
		$result = mysqli_query($conn,$query);
		$rows = mysqli_num_rows($result);
		if($rows > 0){
			// user already present with the email address, don't allow
			return -1;
		}
		else{
			$stmt = $conn->prepare("INSERT INTO admin (email, name, password) VALUES (?, ?, ?)");
			$stmt->bind_param("sss",$email, $name, $password);			

				
			$res = $stmt->execute();
			if($res){
				return 1;
			}
			else{
				return 0;
			}
		}


		

	}

	
	//START OF ADMIN DETAILS

	function showAdminDetails($email){

		global $conn;

		$sql = "SELECT * FROM admin WHERE email='$email'";
		$result = mysqli_query($conn,$sql);
		$array = mysqli_fetch_array($result);

	    if(isset($array)){
	    	return $array;
	    }
	    else{
	    	return 0;
	    }
	}

	function updateAdminDetails($email, $name){
		global $conn;
		

		// prepare and bind
		$stmt = $conn->prepare("UPDATE admin set name=? where email=?");
		$stmt->bind_param("ss", $name, $email);

		$res = $stmt->execute();

		if($res){
			$_SESSION['display'] = "inline";
          	$_SESSION['errorMsg'] = "Successfully updated House details";
          	$_SESSION['alert_class'] = "alert alert-success";
          	echo "<script>window.location.replace('my_details.php');</script>";
		}
		else{
			$_SESSION['display'] = "inline";
          	$_SESSION['errorMsg'] = "Error in updating house! <br> Please try again after some time.";
          	$_SESSION['alert_class'] = "alert alert-danger";
          	echo "<script>window.location.replace('my_details.php');</script>";
		}

		$stmt->close();

	}

	// END OF ADMIN DETAILS




	// DATA VISUALIZATION

	function showData(){
		global $conn;
		$result = mysqli_query($conn, "SELECT * from cust_details"); 
        

        // Maritial Status of the customers
        $single = mysqli_fetch_array(mysqli_query($conn, "SELECT count(marital_status) FROM cust_details WHERE marital_status='S'"));
        $married = mysqli_fetch_array(mysqli_query($conn, "SELECT count(marital_status) FROM cust_details WHERE marital_status='M'"));
        $widow = mysqli_fetch_array(mysqli_query($conn, "SELECT count(marital_status) FROM cust_details WHERE marital_status='W'"));

        // Below is for customer type
        $auto = mysqli_fetch_array(mysqli_query($conn, "SELECT count(cust_type) FROM cust_details WHERE cust_type='A'"));
        $home = mysqli_fetch_array(mysqli_query($conn, "SELECT count(cust_type) FROM cust_details WHERE cust_type='H'"));
        $both = mysqli_fetch_array(mysqli_query($conn, "SELECT count(cust_type) FROM cust_details WHERE cust_type='B'"));
	}

	function showGenderData(){
		// Below is for gender graph - male, female, dont know

		global $conn;

		$sql = "SELECT gender, count(*) as number FROM cust_details GROUP BY gender";
		$result = mysqli_query($conn, $sql);

		return $result;
	}



?>