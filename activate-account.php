<?php
	/*
		UserPie Version: 1.4
		http://userpie.com
		
		Developed by: Adam Davis
	*/
	require_once("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is already logged in
	if(isUserLoggedIn()) { header("Location: account.php"); die(); }
?>
<?php
	/* 
		Activate a users account
	*/
$errors = array();

//Get token param
if(isset($_GET["token"]))
{
		
		$token = $_GET["token"];
		
		if(!isset($token))
		{
			$errors[] = lang("FORGOTPASS_INVALID_TOKEN");
		}
		else if(!validateactivationtoken($token)) //Check for a valid token. Must exist and active must be = 0
		{
			$errors[] = "Token does not exist / Account is already activated";
		}
		else
		{
			//Activate the users account
			if(!setUseractive($token))
			{
				$errors[] = lang("SQL_ERROR");
			}
		}
}
else
{
	$errors[] = lang("FORGOTPASS_INVALID_TOKEN");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Account Activation</title>
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

		<h1>Account activation</h1>

			<?php
				if(count($errors) > 0)
				{
            ?>
            <div id="errors">
            <?php errorBlock($errors); ?>
            </div>     
            <?php
           		 } else { ?> 
        <div id="success">
        
           <p><?php echo lang("ACCOUNT_NOW_ACTIVE"); ?></p>
           
        </div>
        <? }?>
	 

		</div>
	</div>
</div>
</body>
</html>

