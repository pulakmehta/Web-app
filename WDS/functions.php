<?php 
	require_once 'db.php';

	function login($email, $password){
		global $conn;

		$password = md5($password);

		$query = "SELECT * FROM cust_details WHERE EMAIL='$email' AND password='$password'";
		$result = mysqli_query($conn,$query);
		$rows = mysqli_num_rows($result);
		if($rows > 0){
			return 1;
		}
		else{
			return 0;
		}
	}

	function register($email,$password, $fname, $lname){

		global $conn;


		$password = md5($password); 	//encrypting.

		$query = "SELECT * FROM cust_details WHERE EMAIL='$email'";
		$result = mysqli_query($conn,$query);
		$rows = mysqli_num_rows($result);
		if($rows > 0){
			// user already present with the email address, don't allow
			return -1;
		}
		else{
			$stmt = $conn->prepare("INSERT INTO cust_details (email, first_name, last_name, password) VALUES (?, ?, ?, ?)");
			$stmt->bind_param("ssss",$email, $fname, $lname, $password);			

				
			$res = $stmt->execute();
			if($res){
				return 1;
			}
			else{
				return 0;
			}
		}


		

	}

 ?>