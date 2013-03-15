<?php 
	/*
		UserPie Version: 1.4
		http://userpie.com
		
		Developed by: Adam Davis
	*/
	require_once("models/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UserPie</title>
<?php	require_once("head_inc.php"); ?>
<style>
#content {width:550px;  margin: 70px auto auto auto; }
</style>


</head>
<body>
 <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container clearfix">
        <a class="brand" id="logo" href="/">UserPie</a>

        
        <ul class="nav pull-right">
<?php if(isUserLoggedIn()) { ?>
            	<li><a href="/">Account Home</a></li>
       			<li><a href="change-password.php">Change password</a></li>
                <li><a href="update-email-address.php">Update email address</a></li>
 				<li><a href="logout.php">Logout</a></li>
<?php } else { ?>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
<?php } ?>
        </ul>
        
      </div>
    </div>
  </div>
<div id="wrapper">
	<div id="content">
    
        
        <div id="main">
   <!-- Carousel
          ================================================== -->
<div id="carousel" class="carousel">

  <div class="carousel-inner">
        <div class="item active">
      <img src="assets/img/01.jpg" alt="Pic 1" />
      <div class="carousel-caption">
        <p>Pic 1</p>
      </div>
    </div>
        <div class="item">
      <img src="assets/img/02.jpg" alt="Pic 2" />
      <div class="carousel-caption">
        <p>Pic 2</p>
      </div>
    </div>
        <div class="item">
      <img src="assets/img/03.jpg" alt="Pic Pic 1" />
      <div class="carousel-caption">
        <p>Pic 3</p>
      </div>
    </div>
      </div>

  <a class="carousel-control left" href="#carousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#carousel" data-slide="next">&rsaquo;</a>

</div>

<script>

$(function() {
  
  $('.carousel').carousel('pause');
    
});

</script>



            
            <hr>
<p style="text-align:center">           <a class="btn btn-success btn-large" href="login.php">Login</a> 
<a class="btn btn-danger btn-large" href="register.php">Register</a></p>
                <br>
                
<p style="text-align:center"><a href="forgot-password.php">Forgot password</a> | <a href="resend-activation.php">Resend Activation email</a></p>
     
            <div class="clear"></div>
        </div>

   </div>
</div>

<script>

$(function() {
  
  $('.carousel').carousel('pause');
    
});

</script>
</body>
</html>


