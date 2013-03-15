<?php
	/*
		UserPie Version: 1.4
		http://userpie.com
		
		Developed by: Adam Davis
	*/
	require_once("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is not logged in
	if(!isUserLoggedIn()) { header("Location: login.php"); die(); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome <?php echo $loggedInUser->display_username; ?></title>
<link href="cakestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">

	<div id="content">
    
        <div id="left-nav">
        <?php include("layout_inc/left-nav.php"); ?>
            <div class="clear"></div>
        </div>
        
        
        <div id="main">
        	<h1>Your Account</h1>
        
        	<p>Welcome to your account page <strong><?php echo $loggedInUser->display_username; ?></strong></p>

            <p>I am a <strong><?php  $group = $loggedInUser->groupID(); echo $group['group_name']; ?></strong></p>
          
            
            <p>You joined on <?php echo date("l \\t\h\e jS Y",$loggedInUser->signupTimeStamp()); ?> </p>
  		</div>
  
	</div>
</div>
</body>
</html>

