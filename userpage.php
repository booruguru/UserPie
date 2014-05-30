<?php 
	/*
		UserPie Version: 1.0
		http://userpie.com
		

	*/
	require_once("models/config.php");

	/*
	* Uncomment the "else" clause below if e.g. userpie is not at the root of your site.
	*/
	if (!isset($loggedInUser))
		header('Location: login.php');
//	else
//		header('Location: /');
	exit();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UserPie | <?php echo $websiteName; ?> </title>
<?php require_once("head_inc.php"); ?>



</head>
<body>
<?php require_once("navbar.php"); ?>
	<div id="content">
    
        
<h1>Welcome</h1>
        
        	<p>Welcome to your account page <strong><?php echo $loggedInUser->display_username; ?></strong></p>


            <p>You are a <strong><?php  $group = $loggedInUser->groupID(); echo $group['group_name']; ?></strong></p>
          
            
            <p>You joined on <?php echo date("l \\t\h\e jS Y",$loggedInUser->signupTimeStamp()); ?> </p>
            

			<p>This page doesn't really do anything special. It's up to you to create something interesting and useful based on the framework we have provided.</p>
			
            <p>Using UserPie you can build just about anything: a blog, content management system, discussion forum, social network...</p>
            

            
	</div>
</body>
</html>


