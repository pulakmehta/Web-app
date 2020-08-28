<?php 
	
	require_once 'db.php';
	require_once 'header.php';

 ?>
 <!DOCTYPE html>
<html lang="en" manifest="offline.appcache">
<head>
  <!-- Theme Made By www.w3schools.com -->
  <title>WDS</title>
  <link rel="stylesheet" type="text/css" href="stylesheets/index_style.css">
</head>
<body>
<div id="error" style="display: <?php echo isset($display)?$display:'none';  ?>;">
  <br><br>
  <div class="<?php echo isset($alert_class)?$alert_class:'none'; ?>"><?php echo isset($errorMsg)?$errorMsg:'none';  ?></div>
</div>
<div class="jumbotron text-center" id="top">
  <h1>We Do Secure</h1> 
  <p>We specialize in insuring your vehicles and homes.</p> 
  <form>
    <div class="input-group about_us">
      <input type="email" class="form-control" size="50" placeholder="Email Address" required>
      <div class="input-group-btn">
        <button type="button" class="btn btn-danger">Subscribe</button>
      </div>
    </div>
  </form>
</div>

<!-- Container (About Section) -->
<div id="about" class="container-fluid">
  <div class="row">
    <div class="col-sm-8">
      <h2>About Us</h2><br>
      <h4>The founders of WDS insurance have rich experience in developing complex machine learning models. Their sole objective is to make auto and home insurances becomes affordable to the masses </h4><br>
      <p>WDS Insurance is a customer-obsessed, value-adding partner that provides insurance solutions for home and auto needs. We continuously work to improve our offerings and services for our customers along with providing our employees with an opportunity to learn, grow and thrive. </p>
      <br><a href="#contact"><button class="btn btn-default btn-lg">Get in Touch</button></a>
    </div>
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-signal logo"></span>
    </div>
  </div>
</div>

<!-- Container (Services Section) -->
<div id="products" class="container-fluid bg-grey">
  <center><u><h2>Our Products</h2></u></center>
    <br>
  <div class="row">
    <div class="col-sm-1">
      <span class="glyphicon glyphicon-home logo" style="color:black; font-size: 50px;margin-top: 20px;"></span>
    </div>
    <div class="col-sm-11">
      <h2>Home Insurances</h2>
      <h4><strong>Details:</strong> Our mission is to provide affordable home insurance that can be purchased by all and hedge their risks</h4><br>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-1">
      <span class="glyphicon glyphicon-plane logo" style="color:black; font-size: 50px;margin-top: 20px;"></span>
    </div>
    <div class="col-sm-11">
      <h2>Auto Insurances</h2>
      <h4><strong>Details:</strong> Our mission is to provide risk adjusted auto insurance that is affordable to all.</h4><br>
    </div>
  </div>
	
</div>


<!-- Container (Contact Section) -->
<div class="container" id="contact">
	<br><br>
    <div class="row">
        <div class="col-md-6">
            
              <div class="map" id="map1">
                 
                 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3027.347881517445!2d-73.97841098496045!3d40.64426127933941!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25b2f47b37189%3A0x6770070d6353ecf4!2s409%20Church%20Ave%2C%20Brooklyn%2C%20NY%2011218!5e0!3m2!1sen!2sus!4v1587705283202!5m2!1sen!2sus"width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
              </div>
             
  <h4 style="margin-top: 10px;font-size: 22px;"><b>Contact Directory:</b></h4>
  <div class="row" >

    <div class="col-md-12">
        
        <div id="divUSA" style="color:black;">
          <b style="font-size: 18px;color:gray;text-decoration:underline;">USA</b>
          <p style="font-size: 15px;"> 409, Church Ave, <br> Brooklyn, New York, 11218. <br>
          <b>Phone:</b> 123-456-789 <br>
          <b>Email:</b> enquiry@wdc.com <br>
        </div>
        
    </div>
    
  </div>

</div>
        <div class="col-md-6" style="background-color:#f1ebdf; padding:20px;">
            
           <div class="contact-form">
              <h1 class="title" style="margin-top: -5px;">Contact Us</h1>
              <h2 style="font-weight: normal;font-size:14px;">(<i style='color:red;'>*</i> ) Indicates Required Field</h2>

              <form method="POST">
                <div class="row">
                  <div class="col-md-6">
                    <label for="name" class="" style="font-size: 16px;">
                    Name: <i style="color:red">*</i>
                  </label><br>
                      <input class="col-md-11" type="text" name="name" id="name" required style="padding: 10px;border: none;font-size: 15px;color:black;width: 100%;" />
                  </div>
                  <div class="col-md-6">
                     <label for="company"  style="font-size: 16px;margin-left: 8px;">
                    Company Name: <i style="color:red">*</i>
                  </label><br>
                     <input class="col-md-10" type="text" name="company" id="company" required style="padding: 10px;border: none; font-size: 15px;color:black;width: 100%;"/>
                  </div>
                  
                 
                </div><br>

                <div class="row">
                  <div class="col-md-6">
                    <label for="phone" style="font-size: 16px;margin-left: 8px;">
                    	Mobile Number:
                  	</label><br>

                  	<input class="col-md-10" type="tel" name="phone" id="phone" style="padding: 10px;border: none; font-size: 15px;color:black;width: 100%;" required/>
                  </div>
                  <div class="col-md-6">
                   <label for="email"  style="font-size: 16px;">
                    Email: <i style="color:red">*</i>
                  </label><br>
                   <input class="col-md-11" type="email" name="email" id="email"  required style="padding: 10px;border: none; font-size: 15px;color:black;width: 100%;"/><br> 
                  </div>
                  
                </div>

                <div class="row">
                  <label for="name" class="col-md-5 text-left" style="font-size: 16px;">
                    Message: <i style="color:red">*</i>
                  </label>
                  
                </div>

                <div class="row" style="margin-left:0px;margin-right: 0px;margin-bottom: 10px;">
                  <textarea class="col-md-12" name="message" id="message" rows="3" placeholder="Your Message" required style="border: none;font-size: 15px;color:black;"></textarea>
                </div>
                

                
                <button class="btn btn-default" type="submit" name="submitContact" style="padding-bottom: 15px !important;font-size: 15px;font-weight: bold;">Send Enquiry</button>
              </form>
            </div> 
        </div>
  
</div>

<script src="scripts/index_script.js">
</script>

	<?php 
		require_once 'footer.php';
	 ?>

</body>
</html>
