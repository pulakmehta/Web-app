<?php 
	require_once '../db.php';
	if ( session_status() != PHP_SESSION_ACTIVE ) session_start();
	

	
	//START OF CUSTOMER DETAILS

	function showCustDetailsInCorrectFormat($row){
		if($row['cust_type']==''){
			$row['cust_type'] = '<i>None</i>';                                  
		}
		
		if($row['address']==''){
		  $row['address'] = '<i>Not Set</i>';                                  
		}

		if($row['gender']==''){
			$row['gender'] = '<i>Not Set</i>';                                  
		}
		else if($row['gender']=='M'){
		  $row['gender'] = 'Male';
		}
		else if($row['gender']=='F'){
		  $row['gender']='Female';
		}

		if($row['marital_status']=='S'){
		  $row['marital_status'] = 'Single';
		}
		else if($row['marital_status']=='M'){
		  $row['marital_status'] = 'Married';
		}
		else if($row['marital_status']=='W'){
		  $row['marital_status'] = 'Widow/Widower';
		}

		if($row['cust_type']=='A'){
		  $row['cust_type'] = 'Auto Ins';
		}
		if($row['cust_type']=='H'){
		  $row['cust_type'] = 'Home Ins';
		}
		if($row['cust_type']=='B'){
		  $row['cust_type'] = 'Both Ins';
		}
		return $row;
	}

	function removeUserModal($cust_id){
		echo "
		<!-- Modal -->
		<div class='modal fade' id='removeCustModal".$cust_id."' tabindex='-1' role='dialog' aria-labelledby='removeCustModal".$cust_id."Label' aria-hidden='true'>
		  <div class='modal-dialog' role='document'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<h5 class='modal-title' id='removeCustModal".$cust_id."Label'>Remove User</h5>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				  <span aria-hidden='true'>&times;</span>
				</button>
			  </div>
			  <div class='modal-body'>
				Removing a user will also delete all the associated insurances.
				<br> <b>Proceed?</b>
			  </div>
			  <div class='modal-footer'>
			  <form method='POST'>
			  	<input type='hidden' name='cust_id' value='".$cust_id."' />
				<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
				<button type='submit' name='removeUser' class='btn btn-danger'>Remove User</button>
			  </form>
			  </div>
			</div>
		  </div>
		</div>
		
		<!-- End of Modal -->
		";
	}


	function removeCustomer($cust_id){
		global $conn;

		$cust_id = mysqli_real_escape_string($conn, $cust_id);// sanitizing


		$sql = "DELETE FROM home_ins_payments WHERE hinsid=(
				SELECT hinsid FROM home_ins WHERE cust_id='$cust_id'
			);
			DELETE FROM auto_ins_payments WHERE ainsid=(
				SELECT ainsid FROM auto_ins WHERE cust_id='$cust_id'
			);
			DELETE FROM drivers WHERE vin=(
				SELECT vin FROM vehicles WHERE cust_id='$cust_id'
			);
			DELETE FROM vehicles WHERE cust_id='$cust_id';
			DELETE FROM home_details WHERE cust_id='$cust_id';
			DELETE FROM home_ins WHERE cust_id='$cust_id';
			DELETE FROM auto_ins WHERE cust_id='$cust_id';
			DELETE FROM cust_details WHERE cust_id='$cust_id';
		";
		$result = mysqli_multi_query($conn,$sql);

	    if($result){
	    	return true;
	    }
	    else{
			echo "error: ".mysqli_error($conn);
	    	return false;
	    }
	}

	function getAllCustDetails(){
		global $conn;

		$sql = "SELECT * FROM cust_details";
		$result = mysqli_query($conn,$sql);

	    if($result){
	    	return $result;
	    }
	    else{
	    	return false;
	    }
	}

	function showCustDetails($email){

		global $conn;

		// Sanitizing to prevent XSS Attacks.
		$email = mysqli_real_escape_string($conn, $email);

		$sql = "SELECT * FROM cust_details WHERE email='$email'";
		$result = mysqli_query($conn,$sql);
		$array = mysqli_fetch_array($result);

	    if(isset($array)){
	    	return $array;
	    }
	    else{
	    	return 0;
	    }
	}

	function updateCustDetails($email, $first_name,$middle_name, $last_name, $address, $gender, $marital_status){
		global $conn;

		// Sanitizing to prevent XSS Attacks.
		
		$email = mysqli_real_escape_string($conn, $email);// sanitizing
		$first_name = mysqli_real_escape_string($conn, $first_name);// sanitizing
		$middle_name = mysqli_real_escape_string($conn, $middle_name);// sanitizing
		$last_name = mysqli_real_escape_string($conn, $last_name);// sanitizing
		$address = mysqli_real_escape_string($conn, $address);// sanitizing
		$gender = mysqli_real_escape_string($conn, $gender);// sanitizing
		$marital_status = mysqli_real_escape_string($conn, $marital_status);// sanitizing

		// prepare and bind to prevent SQL Injections.
		$stmt = $conn->prepare("UPDATE cust_details set first_name=?,middle_name=?, last_name=?, address=?, gender=?, marital_status=? where email=?");
		$stmt->bind_param("sssssss", $first_name,$middle_name, $last_name, $address, $gender, $marital_status, $email);			// sss indicate format is in string.

		$res = $stmt->execute();

		if($res){
			// $_SESSION['display'] = "inline";
          	// $_SESSION['errorMsg'] = "Successfully removed the house";
          	// $_SESSION['alert_class'] = "alert alert-success";
          	echo "<script>window.location.replace('my_details.php');</script>";
		}
		else{
			// $_SESSION['display'] = "inline";
          	// $_SESSION['errorMsg'] = "Error in removing house! <br> Please try again after some time.";
          	// $_SESSION['alert_class'] = "alert alert-danger";
          	echo "<script>window.location.replace('my_details.php');</script>";
		}

		$stmt->close();

	}

	// END OF CUSTOMER DETAILS







	//HOUSE DETAILS 	home_ins_houses.php

	function insertHome($cust_id, $location, $purchase_date, $purchase_value, $area_sq_feet, $home_type, $auto_fire_noti, $home_security, $swimming_pool, $basement, $hinsid){

		global $conn;

		// prepare and bind
		$stmt = $conn->prepare("INSERT INTO home_details (cust_id, location, purchase_date, purchase_value, area_sq_feet, home_type, auto_fire_noti, home_security, swimming_pool, basement, hinsid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssssssssss", $cust_id, $location, $purchase_date, $purchase_value, $area_sq_feet, $home_type, $auto_fire_noti, $home_security, $swimming_pool, $basement, $hinsid);			// sss indicate format is in string.
		
		
		
		if($stmt->execute()){
			$home_id = mysqli_insert_id($conn);
			$stmt->close();
			return $home_id;
		}
		else{
			$stmt->close();
			return 0;
		}
	}

	function showHomeDetails($email){

		global $conn;

		$sql = "SELECT * from home_details where cust_id=(select cust_id from cust_details where email='$email')";
		$res = mysqli_query($conn,$sql);
		$num_rows = mysqli_num_rows($res);
	    if($num_rows>0){
	    	return $res;
	    }
	    else{
	    	return false;
	    }
	}

	function showUnInsuredHomes($email){
		global $conn;

		$sql = "SELECT * from home_details where hinsid='0' AND cust_id=(select cust_id from cust_details where email='$email')";
		$res = mysqli_query($conn,$sql);
        $num_rows = mysqli_num_rows($res);
	    if($num_rows>0){
	    	return $res;
	    }
	    else{
	    	return false;
	    }
	}

	function showHomeDetailsFromId($home_id){

		global $conn;

		$sql = "SELECT * from home_details where home_id='$home_id'";
		$res = mysqli_query($conn,$sql);
        
	    if($res){
	    	return $res;
	    }
	    else{
	    	return false;
	    }
	}

	function removeHouse($home_id){
		global $conn;
		//remove the house
		//prepare and bind
		$stmt = $conn->prepare("DELETE FROM home_details WHERE home_id=?");
		$stmt->bind_param("s", $home_id);				// sss indicate format is in string.
		$res = $stmt->execute();
		echo mysqli_error($conn);
		if($res){
			$stmt->close();
			return 1;
		}
		else{
			$stmt->close();
			return 0;
		}
	}

	function createHomeDetailsModal($result){



		echo "
			<!-- Modal -->
			<div class='modal fade' id='homeModal".$result['home_id']."' tabindex='-1' role='dialog' aria-labelledby='homeModal".$result['home_id']."' aria-hidden='true'>
			<div class='modal-dialog' role='document'>
				<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title' id='homeModal".$result['home_id']."'>More Details</h5>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
					</button>
				</div>
				<div class='modal-body text-center'>
					<h5>Auto Fire Notification: <b style='color:green;'>".$result['auto_fire_noti']."</b></h5>
					<h5>Home Type: <b style='color:orange;'>".$result['home_type']."</b></h5>
					<h5>Home Security System: <b style='color:red;'>".$result['home_security']."</b></h5>
					<h5>Swimming Pool: <b style='color:blue;'>".$result['swimming_pool']."</b></h5>
					<h5>Basement: <b style='color:brown;'>".$result['basement']."</b></h5>
				</div>
				</div>
			</div>
			</div>
		";
	}

	function createInsDetailsModal($hinsid){

		global $conn;

		$sql = "SELECT * FROM home_ins WHERE hinsid = '$hinsid'";
		$query = mysqli_query($conn,$sql);
		$result = "";

		if($query){
			$result = mysqli_fetch_array($query);


			echo "
			<!-- Modal -->
			<div class='modal fade' id='insModal".$result['hinsid']."' tabindex='-1' role='dialog' aria-labelledby='insModal".$result['hinsid']."' aria-hidden='true'>
			<div class='modal-dialog' role='document'>
				<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title' id='insModal".$result['hinsid']."label'>More Details</h5>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
					</button>
				</div>
				<div class='modal-body text-center'>
					<h5> Insurance Id: <b style='color:brown;'>".$result['hinsid']."</b></h5>
					<h5> Start Date: <b style='color:darkgray;'>".$result['start_date']."</b></h5>
					<h5>End Date: <b style='color:grey;'>".$result['end_date']."</b></h5>
					<h5>Total Amount: <b style='color:blue;'>".$result['total_amount']."</b></h5>";

					if($result['status']=='C'){
						$result['status'] = 'Current';
					}
					else{
						$result['status'] = 'Expired';
					}

				echo "<h5>Status: <b style='color:green;'>".$result['status']."</b></h5>
				</div>
				</div>
			</div>
			</div>
		";
		}
		
	}

	function createDeleteModal($result){
		echo "
			<!-- Modal -->
			<div class='modal fade' id='showDeleteModal".$result['home_id']."' tabindex='-1' role='dialog' aria-labelledby='showDeleteModal".$result['home_id']."' aria-hidden='true'>
			<div class='modal-dialog' role='document'>
				<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title' id='showDeleteModal".$result['home_id']."label'>Delete House: <b>".$result['home_id']."</b>--location: <b>".$result['location']."</b></h5>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
					</button>
				</div>
				<div class='modal-body text-center'>
					<form method='POST'>
						<input type='hidden' name='home_id' value='".$result['home_id']."'>
						<button type='submit' class='btn btn-danger' name='deleteHome'><b>DELETE ASSET</b></button>
						<button type='button' class='btn btn-secondary' name='dismiss' class='close' data-dismiss='modal' aria-label='Close'><b>CANCEL</b></button> 
					</form>
				</div>
			 </div>
			</div>
			</div>
		";
	}


	function convertHomeProperFormat($result){

		//Displaying date in proper format.
		$time = strtotime($result["purchase_date"]);
        $day = date("d", $time);
        $month = date("M", $time);
		$year = date("Y", $time);
		$result["purchase_date"] = $day."th ".$month." ".$year;

		$result['purchase_value'] = "$".number_format($result['purchase_value']);
		$result['area_sq_feet'] = number_format($result['area_sq_feet'])." ft<sup>2";
		
		 if($result['hinsid']=='0' || $result['hinsid']==0){
			$result['hinsid'] = 'No';
		 }	
		// Displaying data in correct format.
		 if($result['home_type']=="S"){
		 	$result['home_type']='Single Family';
		 }
		 else if($result['home_type']=="M"){
		 	$result['home_type']='Multi Family';
		 }
		 else if($result['home_type']=="C"){
		 	$result['home_type']='Condominium';
		 }
		 else{
		 	$result['home_type']='Condominium'; 
		 }

		 // Display appropriate response for binary input for auto fire notifications
		 if($result['auto_fire_noti']=="1"){
		 	$result['auto_fire_noti']='Yes';
		 }
		 else{
		 	$result['auto_fire_noti']='No'; 
		 }

		 // Display appropriate response for binary input for home security 
		 if($result['home_security']=="1"){
		 	$result['home_security']='Yes';
		 }
		 else{
		 	$result['home_security']='No'; 
		 }

		 // Display appropriate response for binary input for swimming pool
		 if($result['swimming_pool']=="U"){
		 	$result['swimming_pool']='Underground';
		 }
		 else if($result['swimming_pool']=="O"){
		 	$result['swimming_pool']='Overground';
		 }
		 else if($result['swimming_pool']=="I"){
		 	$result['swimming_pool']='Indoor';
		 }
		 else if($result['swimming_pool']=="M"){
		 	$result['swimming_pool']='Multiple';
		 }
		 else{
		 	$result['swimming_pool']='No swimming_pool'; 
		 }

		 // Display appropriate response for binary input for basement 
		 if($result['basement']=="1"){
		 	$result['basement']='Yes';
		 }
		 else{
		 	$result['basement']='No'; 
		 }

		 return $result;
	}

	


	function getHouseCount($email){
		$res = showHomeDetails($_SESSION['email']);
        if($res==false){
			return 0;
		}
		else{
			return mysqli_num_rows($res);
		}
	}


	// END OF HOUSE DETAILS







	//start of NEW INSURANCE

	function getInsuranceCount($email){
		global $conn;
		$sql = "SELECT * FROM home_ins WHERE cust_id=(
			SELECT cust_id FROM cust_details WHERE email='$email')";

		$query = mysqli_query($conn, $sql);
		if($query){
			$rows = mysqli_num_rows($query);
			if($rows>0){
				return $rows;
			}
			else{
				return 0;
			}
		}
		else{
			return 0;
		}
		
	}
	function getAutoInsuranceCount($email){
		global $conn;
		$sql = "SELECT * FROM auto_ins WHERE cust_id=(
			SELECT cust_id FROM cust_details WHERE email='$email')";

		$query = mysqli_query($conn, $sql);
		if($query){
			$rows = mysqli_num_rows($query);
			if($rows>0){
				return $rows;
			}
			else{
				return 0;
			}
		}
		else{
			return 0;
		}
		
	}


	function createQuoteModal($getAmountDetails, $duration, $homeIds){


		$row = $getAmountDetails;

		echo "
		<div class='modal fade' id='quoteModal' tabindex='-1' role='dialog' aria-labelledby='quoteModal' aria-hidden='true'>
			<div class='modal-dialog' role='document'>
				<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title' id=''>Your Quote is calculated as:</h5>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
					</button>
				</div>
				<div class='modal-body text-center'>
			<div class='table-responsive'>
				<table class='table table-bordered' id='quoteTable'>
					<tr>
					<th>Purchase Value cost: </th>
					<td>$".$row['purchase_value']."</td>
					</tr>
					<tr>
					<th>Area Percent cost: </th>
					<td>$".$row['area']."</td>
					</tr>
					<tr>
					<th>Auto Fire Notification Discount: </th>
					<td>$".$row['autoFireDiscount']."</td>
					</tr>
					<tr>
					<th>Home Security System Discount: </th>
					<td>$".$row['homeSecurityDiscount']."</td>
					</tr>
					<tr>
					<th>Swimming Pool Charges: </th>
					<td>$".$row['swimmingCharges']."</td>
					</tr>
					<tr>
					<th>Basement Discount: </th>
					<td>$".$row['basementDiscount']."</td>
					</tr>
					<tr>
					<th><b>TOTAL AMOUNT:</b> </th>
					<td><b>$".$row['totalAmount']."</b></td>
					</tr>
				</table>
			</div>
		</div>
		<div class='modal-footer'>
		<form method='POST'>
			<input type='hidden' name='total_amount' value='".$row['totalAmount']."'>
			<input type='hidden' name='insDuration' value='".$duration."'>";

		foreach($homeIds as $i){
			echo "<input type='hidden' name='homeIds[]' value='".$i."'>";
		}


		echo "<button type='submit' name='getInsurance' class='btn btn-primary'>Get My insurance</button>
			<button type='submit' name='dismissIns' class='btn btn-danger'>Not interested</button>
		</form>
		</div>
			</div>
		</div>
		</div>
		";
	}

	function calculateHomeInsAmount($home_id){
		$row = showHomeDetailsFromId($home_id);
		$result = mysqli_fetch_array($row);
		
		$amount = 0;

		/*Formula: 
		1% of purchase value
				+
		10% of area value
				+
		5% discount : Home Security enabled
				+
		5% discount :AUTO FIRE NOTI
				+
		5% discount : NO BASEMENT
				+
		(
		5% discount : NO SWIMMING POOL
				OR
		6% increment : Underground Swimming pool
				OR
		5% increment : Overground Swimming Pool
				OR
		8% increment : Indoor Swimming Pool
				OR
		10% increment : Multiple Swimming Pools
		)
		
		*/

		// Based on formula above, we will calculate the amount below:
		
		$purchase_value = $result['purchase_value'];
		$purchase_value = ($purchase_value*0.01);
		$amount += $purchase_value;

		$area = $result['area_sq_feet'];
		$area = $area*0.1;
		$amount += $area;

		if($result['auto_fire_noti']=="1"){
			$autoFireDiscount = ($amount*0.095)/10;
			$amount += $autoFireDiscount;
		}
		else{
			$autoFireDiscount = 0;
		}
		
		if($result['home_security']=="1"){
			$homeSecurityDiscount = $amount*0.095;
			$amount += $homeSecurityDiscount;
		}
		else{
			$homeSecurityDiscount = 0;
		}

		if($result['swimming_pool']=="U"){
			$swimmingCharges = ($amount*1.06)/100;
			$amount += $swimmingCharges;
		}
		else if($result['swimming_pool']=="O"){
			$swimmingCharges = ($amount*1.05)/100;
			$amount += $swimmingCharges;
		}
		else if($result['swimming_pool']=="I"){
			$swimmingCharges = ($amount*1.08)/100;
			$amount += $swimmingCharges;
		}
		else if($result['swimming_pool']=="M"){
			$swimmingCharges = ($amount*1.10)/100;
			$amount += $swimmingCharges;
		}
		else{
			$swimmingCharges = ($amount*0.095)/100;
			$amount += $swimmingCharges;
		}

		if($result['basement']=="0"){
			$basementDiscount = ($amount*0.095)/10;
			$amount += $basementDiscount;
		}
		else{
			$basementDiscount = 0;
		}

		$toSend=array("purchase_value"=>$purchase_value,"area"=>$area,"autoFireDiscount"=>$autoFireDiscount,"homeSecurityDiscount"=>$homeSecurityDiscount,"swimmingCharges"=>$swimmingCharges,"basementDiscount"=>$basementDiscount, "totalAmount"=>round($amount));

		return $toSend;

	}


	function newHomeIns($cust_id, $start_date, $end_date, $total_amount, $status){

		global $conn;

		$start_date = date('Y-m-d', $start_date);
		$end_date = date('Y-m-d', $end_date);


		if(!isset($cust_id) || !isset($start_date) || !isset($end_date) || !isset($total_amount) || !isset($status)){
			// Validate first before entering data
			return 0;
		}
		else{
			$stmt = $conn->prepare("INSERT INTO home_ins (cust_id, start_date, end_date, total_amount, status) VALUES (?, ?, ?, ?, ?)");
			$stmt->bind_param("sssss", $cust_id, $start_date, $end_date, $total_amount, $status);			

			$query = $stmt->execute();
				
			if($query){
				$hinsid = mysqli_insert_id($conn);

				$cust_type = getCustType($cust_id);
				if($cust_type=='H'){
					$cust_type = 'H';
				}
				else if($cust_type=='A'){
					$cust_type = 'B';
				}
				else if($cust_type=='NULL'){
					$cust_type='H';
				}
				else{
					$cust_type = 'B';
				}

				$sql_cust_type = "UPDATE cust_details SET cust_type='$cust_type' WHERE cust_id='$cust_id'";
				$res_cust_type = mysqli_query($conn, $sql_cust_type);
				if($res_cust_type){
					return $hinsid;
				}
				else{
					return -1;
				}				
			}
			else{
				return -1;
			}
		}
	}

	function getCustType($cust_id){
		global $conn;

		$sql = "SELECT IFNULL(cust_type,'NULL') as cust_type FROM cust_details WHERE cust_id='$cust_id'";
		$query = mysqli_query($conn, $sql);
		$res = mysqli_fetch_array($query);
		return $res['cust_type'];
	}

	function insureHouse($home_id, $hinsid){

		global $conn;

		$stmt = $conn->prepare("UPDATE home_details SET hinsid=? WHERE home_id=?");
		$stmt->bind_param("ss", $hinsid, $home_id);			

		$query = $stmt->execute();

		if($query){
			return true;
		}
		else{
			return false;
		}
		
	}

	function createPayments($hinsid, $total_amount, $duration, $start_date){
		
		global $conn;

		//Duration will be in years. Convert it in months.
		$duration = $duration;
		$total_amount = $total_amount/$duration;
		$due_date = "";

		$i = 1;
		while($i<=$duration){

			$due_date =  strtotime("+".$i."Year", $start_date);
			$due_date = date('Y-m-d', $due_date);
			$stmt = $conn->prepare("INSERT INTO home_ins_payments (due_date, amount, hinsid) VALUES (?, ?, ?)");
			$stmt->bind_param("sss", $due_date, $total_amount, $hinsid);			

			$query = $stmt->execute();
			if($query){
				$success = true;
			}
			else{
				return false;
			}


			$i++;
		}
		if($success == true){
			return true;
		}
		
	}

	function getFormattedDate($time){
        $day=date("d",$time);
        $month=date("M",$time);
        $year=date("Y",$time);

        return ($day." ".$month." ".$year);

	}

	// NEW INSURANCES END



	// CURRENT INSURANCES START



	function showHomeInsDetails($email){

		global $conn;

		$sql = "SELECT * FROM home_ins WHERE cust_id=(SELECT cust_id FROM cust_details WHERE email='$email')";

		$query = mysqli_query($conn, $sql);
		
		$num_rows = mysqli_num_rows($query);

		if($num_rows > 0){
			return $query;
		}
		else{
			return false;
		}

	}

	function createHomeModal($hinsid){

		global $conn;

		$sql = "SELECT * FROM home_details WHERE hinsid='$hinsid'";
		$query = mysqli_query($conn, $sql);
		$rows = mysqli_num_rows($query);

		if($rows>0){
			echo "
			<!-- Modal -->
			<div class='modal fade' id='homeDetailsModall" . $hinsid . "' tabindex='-1' role='dialog' aria-labelledby='homeDetailsModall".$hinsid."' aria-hidden='true'>
				<div class='modal-dialog modal-lg' role='document'>
					<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title' id='homeDetailsModall" . $hinsid . "Label'>Houses under insurance: <b>" . $hinsid . "</b></h5>
							<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
							</button>
						</div>
						<div class='modal-body text-center'>
							<div class='table-responsive'>
								<table class='table table-bordered table-hover'>
									<thead class='thead-light'>
										<th>H No</th>
										<th>Location</th>
										<th>PurDate</th>
										<th>Value</th>
										<th>Area</th>
										<th>Type</th>
									</thead>
									<tbody>";

			while($result = mysqli_fetch_array($query)){

				$result['purchase_date'] = getFormattedDate(strtotime($result['purchase_date']));
				echo "<tr>
						<td>" . $result['home_id'] . "</td>
						<td>" . $result['location'] . "</td>
						<td>" . $result['purchase_date'] . "</td>
						<td>" . $result['purchase_value'] . "</td>
						<td>" . $result['area_sq_feet'] . "</td>
						<td>" . $result['home_type'] . "</td>
					</tr>
				";
			}
			echo "</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
				<!-- End of modal -->
				";	
			return $result;
		}
		else{
			return false;
		}

	}


	function addAssetModal($hinsid){

		global $conn;


		$email = $_SESSION['email'];
		$res = showUnInsuredHomes($email);
		



		echo "
		<div class='modal fade' id='addAssetModal".$hinsid."' tabindex='-1' role='dialog' aria-labelledby='addAssetModal1Label' aria-hidden='true'>
		<div class='modal-dialog modal-lg' role='document'>
		  <div class='modal-content'>
			<div class='modal-header'>
			  <h5 class='modal-title' id='addAssetModal".$hinsid."Label'>Add Assets here</h5>
			  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
			  </button>
			</div>
			<div class='modal-body modal-lg'>
			  <!--Add new houses-->
			  <div class='col-xl-12 col-md-12'>
					<div class='card mb-12'>
						<div class='card-header'>
							<i class='fas fa-circle mr-1'></i>Select from existing houses
						</div>
						<div class='card-body'>

							<!-- Show uninsured homes -->

							<form method='POST'>
							<input type='hidden' value='".$hinsid."' name='hinsid'>
							<div class='table-responsive'>
							<table class='table table-bordered table-hover text-center'>
							<thead class='thead-light'>
								<tr>
									<th>H No.</th>
									<th>Loc</th>
									<th>Pur Date</th>
									<th>Pur Val</th>
									<th>Area</th>
									<th>Select</th>
								</tr>
							</thead>
							<tbody>
								";
								if ($res == false) {
									echo " 
									<tr>
									  <td colspan='7'>No Houses found. &nbsp;&nbsp;Add some from my houses portal.</td>
									</tr>
								  ";
								} else {
									while ($result = mysqli_fetch_array($res)) {
			  
									  $result = convertHomeProperFormat($result);
			  
									  createHomeDetailsModal($result);
										
									  echo "
									  <input type='hidden' value='".$result['home_id']."' name='home_id'> 
									  <tr>
										<td>" . $result['home_id'] . "</td>
										<td>" . $result['location'] . "</td>
										<td>" . $result['purchase_date'] . "</td>
										<td>" . $result['purchase_value'] . "</td>
										<td>" . $result['area_sq_feet'] . "</td>
										
										<td><input type='checkbox' name='addHouseToIns[]' value='" . $result['home_id'] . "' style='zoom: 1.5;'></td>
									  </tr>
										";
									}
								}
							

							echo "
							</tbody>
							</table>
							</div>
							<center><button type='submit' name='addAssetExisting' class='btn btn-primary'><b>Add House</b></button></center>
							</form>
						</div>
					</div>
					<div class='row text-left'>
						<div class='col-md-6'></div>
						<h4>OR</h4>
					</div>
					<div class='card mb-12'>
					  <div class='card-header'><i class='fas fa-plus mr-1'></i>Add a new house</div>
					  <div class='card-body'>
						<form method='POST' action='' accept-charset='UTF-8'>
						  <input type='hidden' value='".$hinsid."' name='hinsid'>
						  <div class='row'>
                      <div class='col-md-3 text-right' style='margin-top:5px;'>
                        <label for='location'>
                          Location:
                        </label>
                        <br>
                      </div>
                      <div class='col-md-5 text-left'> "; require_once 'us_states_dropDown.php';  echo "</div>
                    </div>
                    <br>
                    <div class='row'>
                      <div class='col-md-3 text-right' style='margin-top:5px;'>
                        <label for='pdate'>
                          Purchase Date:
                        </label>
                        <br>
                      </div>
                      <input id='pdate' class='form-control col-md-5 text-left' type='date' placeholder='Purchase Date:' name='purchase_date' required value='2000-01-01' min='1965-01-01' max='2020-05-08'>
                    </div>
                    <br>
                    <div class='row'>
                      <div class='col-md-3 text-right' style='margin-top:5px;'>
                        <label for='pvalue'>
                          Purchase Value:
                        </label>
                        <br>
                      </div>
                      <input id='pvalue' class='form-control col-md-5 text-left' type='number' placeholder='Purchase Value: (in $)' name='purchase_value' required min='10000' max='500000'>
                    </div>
                    <br>
                    <div class='row text-center'>
                      <div class='col-md-3 text-right' style='margin-top:5px;'>
                        <label for='Area'>
                          Area:
                        </label>
                        <br>
                      </div>
                      <input id='Area' class='form-control col-md-5 text-left' type='number' placeholder='Area in square feet' name='area_sq_feet' required min='800' max='3000'>
                    </div>
                    <br>

                    <div class='row'>
                      <legend class='col-form-label col-md-3 text-right' style='margin-top:20px;'>Home Type:</legend>
                      <div class='col-sm-10 col-md-5'>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='home_type' id='single_family' value='S' checked>
                          <label class='form-check-label' for='single_family'>
                            Single Family
                          </label>
                        </div>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='home_type' id='multi_family' value='M'>
                          <label class='form-check-label' for='multi_family'>
                            Multi Family
                          </label>
                        </div>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='home_type' id='condo' value='C'>
                          <label class='form-check-label' for='condo'>
                            Condominium
                          </label>
                        </div>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='home_type' id='town_house' value='T'>
                          <label class='form-check-label' for='town_house'>
                            Town House
                          </label>
                        </div>
                      </div>
                    </div>
                    <br>
                    <!-- Auto Fire Notification -->
                    <div class='row'>
                      <legend class='col-form-label col-md-3 text-right'>Auto Fire Notification:</legend>
                      <div class='col-sm-10  col-md-5'>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='auto_fire_noti' id='fire_noti_yes' value='1' checked>
                          <label class='form-check-label' for='fire_noti_yes'>
                            Yes
                          </label>
                        </div>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='auto_fire_noti' id='fire_noti_no' value='0'>
                          <label class='form-check-label' for='fire_noti_no'>
                            No
                          </label>
                        </div>
                      </div>
                    </div>
                    <br>
                    <!-- Home Security System -->
                    <div class='row'>
                      <legend class='col-form-label col-md-3 text-right'>Home Security System:</legend>
                      <div class='col-sm-10 col-md-5'>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='home_security' id='home_sec_yes' value=1 checked>
                          <label class='form-check-label' for='home_sec_yes'>
                            Yes
                          </label>
                        </div>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='home_security' id='home_sec_no' value=0>
                          <label class='form-check-label' for='home_sec_no'>
                            No
                          </label>
                        </div>
                      </div>
                    </div>
                    <br>
                    <!-- Swimming -->
                    <div class='row'>
                      <legend class='col-form-label col-md-3 text-right' style='margin-top:20px;'>Swimming Pool:</legend>
                      <div class='col-sm-10 col-md-5'>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='swimming_pool' id='swim_under' value='U' checked>
                          <label class='form-check-label' for='swim_under'>
                            Underground
                          </label>
                        </div>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='swimming_pool' id='swim_over' value='O'>
                          <label class='form-check-label' for='swim_over'>
                            Overground
                          </label>
                        </div>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='swimming_pool' id='swim_indoor' value='I'>
                          <label class='form-check-label' for='swim_indoor'>
                            Indoor
                          </label>
                        </div>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='swimming_pool' id='swim_multi' value='M'>
                          <label class='form-check-label' for='swim_multi'>
                            Multiple
                          </label>
                        </div>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='swimming_pool' id='swim_none' value=null>
                          <label class='form-check-label' for='swim_none'>
                            Null
                          </label>
                        </div>
                      </div>
                    </div>
                    <br>
                    <!-- Basement -->
                    <div class='row'>
                      <legend class='col-form-label col-md-3 text-right'>Basement:</legend>
                      <div class='col-sm-10  col-md-5'>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='basement' id='basement_yes' value=1 checked>
                          <label class='form-check-label' for='basement_yes'>
                            Yes
                          </label>
                        </div>
                        <div class='form-check'>
                          <input class='form-check-input' type='radio' name='basement' id='basement_no' value=0>
                          <label class='form-check-label' for='basement_no'>
                            No
                          </label>
                        </div>
                      </div>
                    </div>
                    <!-- Submit button -->
                    <br>
                    <div class='row text-center'>
                      <div class='col-md-3'></div>
                      <input class='btn btn-primary col-md-2' id='newHouse' class='form-control' type='submit' name='newHouse'>
                    </div>
						</form>
					  </div>
					</div>
				  </div>
			</div>
		  </div>
		</div>
	  </div>
		";

	}


	function addAssetToIns($hinsid, $total_amount, $today){

		global $conn;

		$sql = "UPDATE home_ins SET total_amount = total_amount + ? WHERE hinsid=? AND status='C'";

		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ss", $total_amount, $hinsid);
		$res = $stmt->execute();

		$stmt->close();

		$sql2 = "SELECT TIMESTAMPDIFF(YEAR, start_date, end_date) AS difference FROM home_ins WHERE hinsid='$hinsid'";

		$query2 = mysqli_query($conn,$sql2);
		$duration = 1;
		if($query2){
			$row2 = mysqli_fetch_array($query2);
			$duration = $row2['difference'];
		}

		$total_amount = $total_amount/$duration;

		$sql1 = "UPDATE home_ins_payments SET amount = amount + ? WHERE hinsid=? AND status='0' AND due_date>?";

		$stmt1 = $conn->prepare($sql1);
		$stmt1->bind_param("sss", $total_amount, $hinsid, $today);
		$res1 = $stmt1->execute();

		$stmt1->close();

		if($res && $res1){
			return true;
		}
		else{
			return false;
		}
		

	}




	// CURRENT INSURANCES END




	// Start of HOME INS PAYMENTS

	

	function getCurrentMonthPaymentCount($email){
		global $conn;

		

		$sql = "SELECT * FROM home_ins_payments WHERE status = '0' AND hinsid IN(
			SELECT hinsid FROM home_ins WHERE cust_id=(
				SELECT cust_id FROM cust_details WHERE email='$email')
		) ORDER BY hinsid asc";

		$query = mysqli_query($conn, $sql);
		$rows = mysqli_num_rows($query);
		if($rows>0){
			return $rows;
		}
		else{
			return 0;
		}
	}

	function getPaymentCountForHins($hinsid){
		global $conn;

		$hinsid = mysqli_real_escape_string($conn, $hinsid);	

		$sql = "SELECT * FROM home_ins_payments WHERE status = '0' AND hinsid='$hinsid'";

		$query = mysqli_query($conn, $sql);
		$rows = mysqli_num_rows($query);
		if($rows>0){
			return $rows;
		}
		else{
			return 0;
		}
	}

	function getPaymentCountForAins($ainsid){
		global $conn;

		$ainsid = mysqli_real_escape_string($conn, $ainsid);	

		$sql = "SELECT * FROM auto_ins_payments WHERE status = '0' AND ainsid='$ainsid'";

		$query = mysqli_query($conn, $sql);
		$rows = mysqli_num_rows($query);
		if($rows>0){
			return $rows;
		}
		else{
			return 0;
		}
	}

	function showCurrentMonthPayment($hinsid, $date, $status){


		global $conn;

		$sql = "SELECT * FROM home_ins_payments WHERE hinsid='$hinsid' AND status = '$status' ORDER BY hinsid asc";

		$query = mysqli_query($conn, $sql);
		$rows = mysqli_num_rows($query);
		if($rows>0){
			return $query;
		}
		else{
			return false;
		}


	}

	function createPaymentsModal($row){

		$today = date("Y-m-d",strtotime("today"));


		echo "		<!-- Modal -->
		<div class='modal fade' id='payNowModal".$row['payment_id']."' tabindex='-1' role='dialog' aria-labelledby='payNowModal".$row['payment_id']."Label' aria-hidden='true'>
		  <div class='modal-dialog' role='document'>
		  <form method='POST'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<h5 class='modal-title' id='payNowModal".$row['payment_id']."Label'>Pay Now For Ins: <b>".$row['hinsid'],"</b></h5>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				  <span aria-hidden='true'>&times;</span>
				</button>
			  </div>
			  <div class='modal-body'>
					<input type='hidden' value='".$row['payment_id']."' name='payment_id'>
					
						<table class='table table-bordered'>
							<tbody>
								<tr>
									<th class='text-center'>Due Date: </th>
									<td class='text-left' style='color:red;'><b>".getFormattedDate(strtotime($row['due_date']))."</b></td>
								</tr>
								<tr>
									<th class='text-center'>Payment Date: </th>
									<td class='text-left' style='color:green;'><b>".getFormattedDate(strtotime($today))."</b></td>
								</tr>
								<tr>
									<th class='text-center'>Amount: </th>
									<td class='text-left' style='color:brown;'><b>$".$row['amount']."</b></td>
								</tr>
								<tr>
									<th class='text-center'>Payment Type: </th>
									<td class='text-left'>
										<select name='payment_type' id='payment_type' style='width: 100%;'>
											<option value='Paypal'>PayPal</option>
											<option value='Debit'>Debit</option>
											<option value='Credit'>Credit</option>
											<option value='Check'>Check</option>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
					
				
			  </div>
			  <div class='modal-footer'>
				<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
				<button type='submit' name='paynow' class='btn btn-primary'><b>Pay Now!</b></button>
			  </div>

			</div>
			</form>
			</div>
		  </div>";

	}


	function makePayment($payment_id, $payment_type){
		

		global $conn;

		$stmt = $conn->prepare("UPDATE home_ins_payments SET status='1', payment_date=SYSDATE(), payment_type=? WHERE payment_id=?");
		$stmt->bind_param("ss", $payment_type, $payment_id);			// sss indicate format is in string.

		$res = $stmt->execute();

		if($res){
			$stmt->close();
			return 1;
		}
		else{
			$stmt->close();
			return 0;
		}
	}


	function showPaymentHistory($email){
		
		global $conn;

		$sql = "SELECT * FROM home_ins_payments WHERE hinsid IN(
			SELECT hinsid FROM home_ins WHERE cust_id =(
				SELECT cust_id FROM cust_details WHERE email='$email'
			)) AND status='1'";

		$query = mysqli_query($conn, $sql);
		$rows = mysqli_num_rows($query);

		if($rows>0){
			return $query;
		}
		else{
			return false;
		}


	}






	// END OF HOME INS PAYMENTS





	// AUTO INSURANCES START


	// VEHICLES

	function addVehicle($vin, $vtype, $vmake, $vmodel, $vyear, $vstatus, $email){

		global $conn;


		if(isset($vin) && isset($vtype) && isset($vmake) && isset($vmodel) && isset($vyear) && isset($vstatus) && isset($email)){
			// All values are present

			$sql = "SELECT * FROM vehicles WHERE vin='$vin'";
			$query = mysqli_query($conn, $sql);
			$rows = mysqli_num_rows($query);
			if($rows>0){
				return -1;			// VIN already exists
			}
			else{
				// Proceed with insertion of data for vehicle

				//Getting the cust_id first.

				$sql1 = "SELECT cust_id from cust_details WHERE email='$email'";
				$query1 = mysqli_query($conn, $sql1);

				$result1 = mysqli_fetch_array($query1);

				$cust_id = $result1['cust_id'];

				$stmt = $conn->prepare("INSERT INTO vehicles (vin, vehicle_type, make, model, year, status, cust_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
				
				$stmt->bind_param("sssssss", $vin, $vtype, $vmake, $vmodel, $vyear, $vstatus, $cust_id);			

				$res = $stmt->execute();

				if($res){
					$stmt->close();
					return 1;			// Successfully inserted the data	
				}
				else{
					$stmt->close();
					return 2;			// Error in adding the vehicle
				}
			}
		}
		else{
			return 0;			// Fields cannot be empty.
		}
	}

	function showVehicleDetails($email){

		global $conn;

		$sql = "SELECT * from vehicles where cust_id=(select cust_id from cust_details where email='$email')";
		$res = mysqli_query($conn,$sql);
		$num_rows = mysqli_num_rows($res);
	    if($num_rows>0){
	    	return $res;
	    }
	    else{
	    	return false;
	    }
	}

	function showUnInsuredVehicles($email){
		global $conn;

		$sql = "SELECT * from vehicles where ainsid='0' AND cust_id=(select cust_id from cust_details where email='$email')";
		$res = mysqli_query($conn,$sql);
        $num_rows = mysqli_num_rows($res);
	    if($num_rows>0){
	    	return $res;
	    }
	    else{
	    	return false;
	    }
	}

	function showVehicleDetailsFromId($vin){

		global $conn;

		$sql = "SELECT * from vehicles where vin='$vin'";
		$res = mysqli_query($conn,$sql);
        
	    if($res){
	    	return $res;
	    }
	    else{
	    	return false;
	    }
	}

	function getDriverCountForVehicle($vin){
		global $conn;

		$sql = "SELECT * FROM drivers WHERE vin='$vin'";
		$query = mysqli_query($conn, $sql);
		$rows = mysqli_num_rows($query);
		if($rows>0){
			return $rows;
		}
		else{
			return 0;
		}
	}

	function getFormattedStatus($status){
		if($status=='O'){
			$status = 'Owned';
		}
		else if($status=='L'){
			$status = 'Leased';
		}
		else{
			$status = 'Financed';
		}
		return $status;
	}

	function removeVehicle($vin){
		global $conn;
		//remove the house
		//prepare and bind
		$stmt = $conn->prepare("DELETE FROM vehicles WHERE vin=?");
		$stmt->bind_param("s", $vin);
		$res = $stmt->execute();
		$stmt->close();

		$stmt1 = $conn->prepare("DELETE FROM drivers WHERE vin=?");
		$stmt1->bind_param("s", $vin);
		$res1 = $stmt1->execute();
		$stmt1->close();
		if($res && $res1){
			return 1;
		}
		else{
			return 0;
		}
	}


	function createVehicleDeleteModal($result){
		echo "
			<!-- Modal -->
			<div class='modal fade' id='removeVehicle".$result['vin']."' tabindex='-1' role='dialog' aria-labelledby='removeVehicle".$result['vin']."' aria-hidden='true'>
			<div class='modal-dialog' role='document'>
				<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title' id='removeVehicle".$result['vin']."label'>Delete Vehicle: <b>".$result['vin']."</b><b>--".$result['vehicle_type']."--".$result['make']."--".$result['model']."</b></h5>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
					</button>
				</div>
				<div class='modal-body text-center'>
					<form method='POST'>
						<input type='hidden' name='vin' value='".$result['vin']."'>
						<button type='submit' class='btn btn-danger' name='deleteVehicle'><b>DELETE ASSET</b></button>
						<button type='button' class='btn btn-secondary' name='dismiss' class='close' data-dismiss='modal' aria-label='Close'><b>CANCEL</b></button> 
					</form>
				</div>
			 </div>
			</div>
			</div>
		";
	}


	// DRIVERS

	function showDriverDetails($email){
		global $conn;

		$sql = "SELECT * FROM drivers d JOIN vehicles v ON d.vin=v.vin WHERE v.cust_id=( SELECT cust_id FROM cust_details WHERE email='$email') AND d.vin=v.vin ORDER BY v.vin ASC
		";
		$res = mysqli_query($conn,$sql);
		$num_rows = mysqli_num_rows($res);
	    if($num_rows>0){
	    	return $res;
	    }
	    else{
	    	return false;
	    }
	}


	function showDriverDetailsByVehicle($vin){
		global $conn;

		$sql = "SELECT * FROM drivers WHERE vin='$vin'";
		$res = mysqli_query($conn,$sql);
		$num_rows = mysqli_num_rows($res);
	    if($num_rows>0){
	    	return $res;
	    }
	    else{
	    	return false;	
	    }
	}

	function removeDriver($license_no){
		global $conn;
		//remove the house
		//prepare and bind
		$stmt = $conn->prepare("DELETE FROM drivers WHERE license_no=?");
		$stmt->bind_param("s", $license_no);
		$res = $stmt->execute();
		echo mysqli_error($conn);
		if($res){
			$stmt->close();
			return 1;
		}
		else{
			$stmt->close();
			return 0;
		}
	}

	function createDriverDeleteModal($result){
		echo "
			<!-- Modal -->
			<div class='modal fade' id='removeDriver".$result['license_no']."' tabindex='-1' role='dialog' aria-labelledby='removeDriver".$result['license_no']."' aria-hidden='true'>
			<div class='modal-dialog' role='document'>
				<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title' id='removeDriver".$result['license_no']."label'>Delete Driver with: <b>".$result['license_no']."</b><b>--".$result['name']."</b></h5>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
					</button>
				</div>
				<div class='modal-body text-center'>
					<form method='POST'>
						<input type='hidden' name='license_no' value='".$result['license_no']."'>
						<button type='submit' class='btn btn-danger' name='deleteDriver'><b>DELETE ASSET</b></button>
						<button type='button' class='btn btn-secondary' name='dismiss' class='close' data-dismiss='modal' aria-label='Close'><b>CANCEL</b></button> 
					</form>
				</div>
			 </div>
			</div>
			</div>
		";
	}


	function addNewDriver($dl, $vin, $dname, $dob, $email){
		global $conn;

		if(isset($dl) && isset($vin) && isset($dname) && isset($dob) && isset($email)){
		// All values are present

			$sql = "SELECT * FROM drivers WHERE license_no='$dl'";
			$query = mysqli_query($conn, $sql);
			$rows = mysqli_num_rows($query);
			if ($rows > 0) {
				return -1;			// Driver with license already exists
			} else {
				// Proceed with insertion of data for driver

				$stmt = $conn->prepare("INSERT INTO drivers (license_no, vin, name, birth_date) VALUES (?, ?, ?, ?)");

				$stmt->bind_param("ssss", $dl, $vin, $dname, $dob);

				$res = $stmt->execute();

				if ($res) {
					$stmt->close();
					return 1;			// Successfully inserted the data	
				} else {
					$stmt->close();
					return 2;			// Error in adding the vehicle
				}
			}
	} else {
		return 0;			// Fields cannot be empty.
	}



	}


	function showDriverForVehicleModal($vin, $delete){


		echo " 

		<!-- Modal -->
		<div class='modal fade' id='showDrivers".$vin."' tabindex='-1' role='dialog' aria-labelledby='showDrivers".$vin."Label' aria-hidden='true'>
		<div class='modal-dialog' role='document'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h5 class='modal-title' id='showDrivers".$vin."Label'>Drivers for VIN : ".$vin."</h5>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
				</button>
			</div>
			<div class='modal-body'>

			<!-- MODAL BODY START --> 
			<!-- VIEW ALL DRIVERS -->
		
		<div class='viewAllDrivers' id='viewAllDrivers'>
			<br>
			<div class='table-responsive'>
				<table class='table table-bordered table-hover text-center'>
					<thead class='thead-active'>
						<tr>
							<th>License No.</th>
							<th>Name</th>
							<th>Birth Date</th>
							<th>Remove</th>
						</tr>
					</thead>
					<tbody>";

						$res = 	showDriverDetailsByVehicle($vin);
						if ($res != false) {
							while ($row = mysqli_fetch_array($res)) {

								createDriverDeleteModal($row);

								echo "
									<tr>
										<td>" . $row['license_no'] . "</td>
										<td>" . $row['name'] . "</td>
										<td>" . $row['birth_date'] . "</td>
										";
								if($delete==1 || $delete=='1'){
									echo "
											<td><a href='#' data-toggle='modal' data-target='#removeDriver" . $row['license_no'] . "'><i style='color:red;' class='fas fa-trash mr-1'></i></a></td>
											
										";
								}
								else{
									echo "
											<td>NotA</td>
											
										";
								}
								
								echo
									"</tr>";
							}
						} else {
							echo "<tr><td colspan='7'>No Drivers found.<br> Try Adding some from 'Add New Driver' Portal.</td></tr>";
						}


				echo "	</tbody>
				</table>
			</div>
		</div>


		<!-- END OF VIEW ALL DRIVERS -->
		";

			



			echo "<!-- MODAL BODY END -->

			</div>
			</div>
		</div>
		</div>";

		


	}



	// AUTO INSURANCES
	function createAutoQuoteModal($getAmountDetails, $duration, $vins){


		$row = $getAmountDetails;

		echo "
		<div class='modal fade' id='autoQuoteModal' tabindex='-1' role='dialog' aria-labelledby='autoQuoteModal' aria-hidden='true'>
			<div class='modal-dialog' role='document'>
				<div class='modal-content'>
				<div class='modal-header'>
					<h5 class='modal-title' id=''>Your Quote is calculated as:</h5>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
					</button>
				</div>
				<div class='modal-body text-center'>
			<div class='table-responsive'>
				<table class='table table-bordered' id='quoteTable'>
					<tr>
					<th>Vehicle Type Cost: </th>
					<td>$".$row['vehicle_type']."</td>
					</tr>
					<tr>
					<th> Vehicle Status Cost: </th>
					<td>$".$row['status']."</td>
					</tr>
					<tr>
					<th>Driver Count Discount: </th>
					<td>$".$row['driverCount']."</td>
					</tr>
					<tr>
					<th>Year Manufactured Cost: </th>
					<td>$".$row['year']."</td>
					</tr>
					<tr>
					<th>Vehicle Make Discount: </th>
					<td>$".$row['make']."</td>
					</tr>
					<tr>
					<th><b>TOTAL AMOUNT:</b> </th>
					<td><b>$".$row['totalAmount']."</b></td>
					</tr>
				</table>
			</div>
		</div>
		<div class='modal-footer'>
		<form method='POST'>
			<input type='hidden' name='total_amount' value='".$row['totalAmount']."'>
			<input type='hidden' name='insDuration' value='".$duration."'>";

		foreach($vins as $i){
			echo "<input type='hidden' name='vins[]' value='".$i."'>";
		}


		echo "<button type='submit' name='getInsurance' class='btn btn-primary'>Get My insurance</button>
			<button type='submit' name='dismissIns' class='btn btn-danger'>Not interested</button>
		</form>
		</div>
			</div>
		</div>
		</div>
		";
	}

	function calculateAutoInsAmount($vin){
		$row = showVehicleDetailsFromId($vin);
		$result = mysqli_fetch_array($row);
		
		$amount = 0;

		/*Formula: 
		
		Vehicle Type: CAR : Base Amount : 700
					  TRUCK: BA : 		  1000
					  BIKE : BA : 		  500
		
		Vehicle STATUS : 		OWNED: 		+10%;
								LEASED: 	+15%;
								FINANCED:	+20%
		
		DRIVER Count: 			>2 Drivers:		-5%;
								>5 Drivers:		-7%;
								>5 Drivers: 	-10%;
		
		YEAR:				>2018:		+5% charge
							>2010:		+10% charge
							<2010:		+15% charge
		
		MAKE:				TOYOTA: 	-5%
							FORD:		-2%
		
		*/

		// Based on formula above, we will calculate the amount below:
		
		$vehicle_type = $result['vehicle_type'];
		if($vehicle_type=='Car'){
			$vehicle_type = 700;
			$amount += $vehicle_type;
		}
		else if($vehicle_type=='Truck'){
			$vehicle_type = 1000;
			$amount += $vehicle_type;
		}
		else{
			$vehicle_type = 500;
			$amount += $vehicle_type;
		}
		

		$status = $result['status'];
		if($status=='O'){
			$status1 = $amount*1.10;
			$status = $status1-$amount;
			$amount = $status1;
		}
		else if($status=='L'){
			$status1 = $amount*1.15;
			$status = $status1-$amount;
			$amount = $status1;
		}
		else{
			$status1 = $amount*1.20;
			$status = $status1-$amount;
			$amount = $status1;
		}



		$driverCount = getDriverCountForVehicle($vin);
		if($driverCount>0 && $driverCount<=2){
			$driverCount1 = $amount*0.95;
			$driverCount = $driverCount1 - $amount;
			$amount = $driverCount1;
		}
		if($driverCount>2 && $driverCount<=5){
			$driverCount1 = $amount*0.93;
			$driverCount = $driverCount1 - $amount;
			$amount = $driverCount1;
		}
		if($driverCount>5){
			$driverCount1 = $amount*0.90;
			$driverCount = $driverCount1 - $amount;
			$amount = $driverCount1;
		}



		$year = (int) $result['year'];
		if($year > 2018){
			$year1 = $amount*1.05;
			$year = $year1 - $amount;
			$amount = $year1;
		}
		if($year < 2018 && $year>2010){
			$year1 = $amount*1.10;
			$year = $year1 - $amount;
			$amount = $year1;
		}
		if($year < 2010){
			$year1 = $amount*1.15;
			$year = $year1 - $amount;
			$amount = $year1;
		}
		$make = $result['make'];
		if($result['make']=="Toyota" || $result['make']=='toyota' || $result['make']=='TOYOTA'){
			$make1 = $amount*0.95;
			$make = $make1 - $amount;
			$amount = $make1;
		}
		else if($result['make']=="Ford" || $result['make']=='ford' || $result['make']=='FORD'){
			$make1 = $amount*0.98;
			$make = $make1 - $amount;
			$amount = $make1;
		}
		else{
			$make = 0;
		}
		

		$toSend=array("vehicle_type"=>$vehicle_type,"status"=>$status,"driverCount"=>$driverCount,"year"=>$year,"make"=>$make, "totalAmount"=>round($amount));

		return $toSend;

	}


	function newAutoIns($cust_id, $start_date, $end_date, $total_amount, $status){

		global $conn;

		$start_date = date('Y-m-d', $start_date);
		$end_date = date('Y-m-d', $end_date);


		if(!isset($cust_id) || !isset($start_date) || !isset($end_date) || !isset($total_amount) || !isset($status)){
			// Validate first before entering data
			return 0;
		}
		else{
			$stmt = $conn->prepare("INSERT INTO auto_ins (cust_id, start_date, end_date, total_amount, status) VALUES (?, ?, ?, ?, ?)");
			$stmt->bind_param("sssss", $cust_id, $start_date, $end_date, $total_amount, $status);			

			$query = $stmt->execute();
				
			if($query){
				$ainsid = mysqli_insert_id($conn);


				$cust_type = getCustType($cust_id);
				
				if($cust_type=='H'){
					$cust_type = 'B';
				}
				else if($cust_type=='A'){
					$cust_type = 'A';
				}
				else if($cust_type=='NULL'){
					$cust_type = 'A';
				}
				else{
					$cust_type = 'B';
				}

				$sql_cust_type = "UPDATE cust_details SET cust_type='$cust_type' WHERE cust_id='$cust_id'";
				$res_cust_type = mysqli_query($conn, $sql_cust_type);
				if($res_cust_type){
					return $ainsid;
				}
				else{
					return -1;
				}
			}
			else{
				return -1;
			}
		}
	}

	function insureVehicle($vin, $ainsid){

		global $conn;

		$stmt = $conn->prepare("UPDATE vehicles SET ainsid=? WHERE vin=?");
		$stmt->bind_param("ss", $ainsid, $vin);			

		$query = $stmt->execute();

		if($query){
			return true;
		}
		else{
			return false;
		}
		
	}

	function createAutoPayments($ainsid, $total_amount, $duration, $start_date){
		
		global $conn;

		//Duration will be in years. Convert it in months.
		$duration = $duration;
		$total_amount = $total_amount/$duration;
		$due_date = "";

		$i = 1;
		while($i<=$duration){

			$due_date =  strtotime("+".$i."Year", $start_date);
			$due_date = date('Y-m-d', $due_date);
			$stmt = $conn->prepare("INSERT INTO auto_ins_payments (due_date, amount, ainsid) VALUES (?, ?, ?)");
			echo "<br><br><br><br>amount: ".$total_amount."<br>";
			echo "due_date:".$due_date;
			echo "<br> ainsid: ".$ainsid; 
			$stmt->bind_param("sss", $due_date, $total_amount, $ainsid);			

			$query = $stmt->execute();
			if($query){
				$success = true;
			}
			else{
				return false;
			}


			$i++;
		}
		if($success == true){
			return true;
		}
		
	}


	// START OF AUTO PAYMENTS




	function getAutoPaymentCount($email){
		global $conn;

		

		$sql = "SELECT * FROM auto_ins_payments WHERE status = '0' AND ainsid IN(
			SELECT ainsid FROM auto_ins WHERE cust_id=(
				SELECT cust_id FROM cust_details WHERE email='$email')
		) ORDER BY ainsid asc";

		$query = mysqli_query($conn, $sql);
		$rows = mysqli_num_rows($query);
		if($rows>0){
			return $rows;
		}
		else{
			return 0;
		}
	}

	function showAutoPayment($ainsid, $date, $status){


		global $conn;

		$sql = "SELECT * FROM auto_ins_payments WHERE ainsid='$ainsid' AND status = '$status' ORDER BY ainsid asc";

		$query = mysqli_query($conn, $sql);
		$rows = mysqli_num_rows($query);
		if($rows>0){
			return $query;
		}
		else{
			return false;
		}


	}

	function createAutoPaymentsModal($row){

		$today = date("Y-m-d",strtotime("today"));


		echo "		<!-- Modal -->
		<div class='modal fade' id='payNowModal".$row['payment_id']."' tabindex='-1' role='dialog' aria-labelledby='payNowModal".$row['payment_id']."Label' aria-hidden='true'>
		  <div class='modal-dialog' role='document'>
		  <form method='POST'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<h5 class='modal-title' id='payNowModal".$row['payment_id']."Label'>Pay Now For Ins: <b>".$row['ainsid'],"</b></h5>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				  <span aria-hidden='true'>&times;</span>
				</button>
			  </div>
			  <div class='modal-body'>
					<input type='hidden' value='".$row['payment_id']."' name='payment_id'>
					
						<table class='table table-bordered'>
							<tbody>
								<tr>
									<th class='text-center'>Due Date: </th>
									<td class='text-left' style='color:red;'><b>".getFormattedDate(strtotime($row['due_date']))."</b></td>
								</tr>
								<tr>
									<th class='text-center'>Payment Date: </th>
									<td class='text-left' style='color:green;'><b>".getFormattedDate(strtotime($today))."</b></td>
								</tr>
								<tr>
									<th class='text-center'>Amount: </th>
									<td class='text-left' style='color:brown;'><b>$".$row['amount']."</b></td>
								</tr>
								<tr>
									<th class='text-center'>Payment Type: </th>
									<td class='text-left'>
										<select name='payment_type' id='payment_type' style='width: 100%;'>
											<option value='Paypal'>PayPal</option>
											<option value='Debit'>Debit</option>
											<option value='Credit'>Credit</option>
											<option value='Check'>Check</option>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
					
				
			  </div>
			  <div class='modal-footer'>
				<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
				<button type='submit' name='paynow' class='btn btn-primary'><b>Pay Now!</b></button>
			  </div>

			</div>
			</form>
			</div>
		  </div>";

	}


	function makeAutoPayment($payment_id, $payment_type){
		

		global $conn;

		$stmt = $conn->prepare("UPDATE auto_ins_payments SET status='1', payment_date=SYSDATE(), payment_type=? WHERE payment_id=?");
		$stmt->bind_param("ss", $payment_type, $payment_id);			// sss indicate format is in string.

		$res = $stmt->execute();

		if($res){
			$stmt->close();
			return 1;
		}
		else{
			$stmt->close();
			return 0;
		}
	}


	function showAutoPaymentHistory($email){
		
		global $conn;

		$sql = "SELECT * FROM auto_ins_payments WHERE ainsid IN(
			SELECT ainsid FROM auto_ins WHERE cust_id =(
				SELECT cust_id FROM cust_details WHERE email='$email'
			)) AND status='1'";

		$query = mysqli_query($conn, $sql);
		$rows = mysqli_num_rows($query);

		if($rows>0){
			return $query;
		}
		else{
			return false;
		}


	}





	// CURRENT INS 
	function showAutoInsDetails($email){

		global $conn;

		$sql = "SELECT * FROM auto_ins WHERE cust_id=(SELECT cust_id FROM cust_details WHERE email='$email')";

		$query = mysqli_query($conn, $sql);
		
		$num_rows = mysqli_num_rows($query);

		if($num_rows > 0){
			return $query;
		}
		else{
			return false;
		}

	}

	function createVehicleModal($ainsid){

		global $conn;

		$sql = "SELECT * FROM vehicles WHERE ainsid='$ainsid'";
		$query = mysqli_query($conn, $sql);
		$rows = mysqli_num_rows($query);

		if($rows>0){
			echo "
			<!-- Modal -->
			<div class='modal fade' id='vehicleDetailsModall" . $ainsid . "' tabindex='-1' role='dialog' aria-labelledby='vehicleDetailsModall".$ainsid."' aria-hidden='true'>
				<div class='modal-dialog modal-lg' role='document'>
					<div class='modal-content'>
						<div class='modal-header'>
							<h5 class='modal-title' id='vehicleDetailsModall" . $ainsid . "Label'>Vehicles under insurance: <b>" . $ainsid . "</b></h5>
							<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
							</button>
						</div>
						<div class='modal-body text-center'>
							<div class='table-responsive'>
								<table class='table table-bordered table-hover'>
									<thead class='thead-light'>
									<tr>
										<th>V No.</th>
										<th>Type</th>
										<th>Model-Make-Year</th>
										<th>Status</th>
									</tr>
									</thead>
									<tbody>";

		while ($result = mysqli_fetch_array($query)) {

			$result = convertVehicleProperFormat($result);

			echo "
					<tr>
						<td>" . $result['vin'] . "</td>
						<td>" . $result['vehicle_type'] . "</td>
						<td>" . $result['make'] . "-" . $result['model'] . "-" . $result['year'] . "</td>
						<td>" . $result['status'] . "</td>
					</tr>
			";
		}
			echo "</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
				<!-- End of modal -->
				";	
			return $result;
		}
		else{
			return false;
		}

	}


	function addAutoAssetModal($ainsid){

		global $conn;


		$email = $_SESSION['email'];
		$res = showUnInsuredVehicles($email);
		
		

		echo "
		<div class='modal fade' id='addAutoAssetModal".$ainsid."' tabindex='-1' role='dialog' aria-labelledby='addAutoAssetModal' aria-hidden='true'>
		<div class='modal-dialog modal-lg' role='document'>
		  <div class='modal-content'>
			<div class='modal-header'>
			  <h5 class='modal-title' id='addAutoAssetModal".$ainsid."Label'>Add Assets here!</h5>
			  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
			  </button>
			</div>
			<div class='modal-body modal-lg'>
			  <!--Add new vehicles-->
			  <div class='col-xl-12 col-md-12'>
					<div class='card mb-12'>
						<div class='card-header'>
							<i class='fas fa-circle mr-1'></i>Select from existing vehicles
						</div>
						<div class='card-body'>

							<!-- Show uninsured vehicles -->

							<form method='POST'>
							<input type='hidden' value='".$ainsid."' name='ainsid'>
							<div class='table-responsive'>
							<table class='table table-bordered table-hover'>
							<thead class='thead-light'>
								<tr>
									<th>V No.</th>
									<th>Type</th>
									<th>M-M-Y</th>
									<th>Status</th>
									<th>Select</th>
								</tr>
							</thead>
							<tbody>
								";
								if ($res == false) {
									echo " 
									<tr>
									  <td colspan='5'>No Vehicles found. &nbsp;&nbsp;Add some from my 'Vehicles And Drivers' portal.</td>
									</tr>
								  ";
								} else {
									while ($result = mysqli_fetch_array($res)) {
			  
									  $result = convertVehicleProperFormat($result);
								$driverCount = getDriverCountForVehicle($result['vin']);
									  if($driverCount>0){
										echo "
										<input type='hidden' value='".$result['vin']."' name='vin'> 
										<tr>
											<td>" . $result['vin'] . "</td>
											<td>" . $result['vehicle_type'] . "</td>
											<td>" . $result['make'] ."-". $result['model'] . "-". $result['year']. "</td>
											<td>" . $result['status'] . "</td>
											
											<td><input type='checkbox' name='addVehicleToIns[]' value='" . $result['vin'] . "' style='zoom: 1.5;'></td>
										</tr>
											";
									  }
									}
								}
							

							echo "
							</tbody>
							</table>
							</div>
							<center><button type='submit' name='addAssetExisting' class='btn btn-primary'><b>Add Vehicle</b></button></center>
							</form>
						</div>
					</div>
					
				  </div>
			</div>
		  </div>
		</div>
	  </div>
		";

	}


	function addAssetToAutoIns($ainsid, $total_amount, $today){

		global $conn;

		$sql = "UPDATE auto_ins SET total_amount = total_amount + ? WHERE ainsid=? AND status='C'";

		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ss", $total_amount, $ainsid);
		$res = $stmt->execute();

		$stmt->close();

		$sql2 = "SELECT TIMESTAMPDIFF(YEAR, start_date, end_date) AS difference FROM auto_ins WHERE ainsid='$ainsid'";

		$query2 = mysqli_query($conn,$sql2);
		$duration = 1;
		if($query2){
			$row2 = mysqli_fetch_array($query2);
			$duration = $row2['difference'];
		}

		$total_amount = $total_amount/$duration;

		$sql1 = "UPDATE auto_ins_payments SET amount = amount + ? WHERE ainsid=? AND status='0' AND due_date>?";

		$stmt1 = $conn->prepare($sql1);
		$stmt1->bind_param("sss", $total_amount, $ainsid, $today);
		$res1 = $stmt1->execute();

		$stmt1->close();

		if($res && $res1){
			return true;
		}
		else{
			return false;
		}
		

	}


	function convertVehicleProperFormat($result){

		 // Display appropriate response for binary input for swimming pool
		 if($result['status']=="L"){
		 	$result['status']='Leased';
		 }
		 else if($result['status']=="O"){
			$result['status']='Owned';
		 }
		 else{
			$result['status']='Financed';
		 }
		 

		 return $result;
	}

	


	function getVehicleCount($email){
		$res = showVehicleDetails($email);
        if($res==false){
			return 0;
		}
		else{
			return mysqli_num_rows($res);
		}
	}









	// START OF SAMPLE FUNCTIONS
	// function closeConnection(){
	// 	if(isset($conn)){
	// 		$conn.close();
	// 	}
	// }

	// function selectData(){
	// 	$stmt = $conn->prepare("SELECT id, firstname, lastname FROM MyGuests");
	//     $stmt->execute();

	//     // set the resulting array to associative
	//     $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	//     foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
	//         echo $v;
	//     }
	// }

	// function insertData(){
	// 	 prepare and bind
	// 	$stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (?, ?, ?)");
	// 	$stmt->bind_param("sss", $firstname, $lastname, $email);			// sss indicate format is in string.

	// 	// set parameters and execute
	// 	$firstname = "John";
	// 	$lastname = "Doe";
	// 	$email = "john@example.com";
	// 	$stmt->execute();

	// 	$firstname = "Mary";
	// 	$lastname = "Moe";
	// 	$email = "mary@example.com";
	// 	$stmt->execute();

	// 	$firstname = "Julie";
	// 	$lastname = "Dooley";
	// 	$email = "julie@example.com";
	// 	$stmt->execute();

	// 	echo "New records created successfully";

	// 	$stmt->close();
	// }

	// END OF SAMPLE FUNCTIONS





	
