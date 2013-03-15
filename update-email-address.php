<?php
	/*
		UserPie Version: 1.4
		http://userpie.com
		
		Developed by: Adam Davis
	*/
	include("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is not logged in
	if(!isUserLoggedIn()) { header("Location: login.php"); die(); }
?>
<?php
	/* 
		Below is a very simple example of how to process a login request.
		Some simple validation (ideally more is needed).
	*/

//Forms posted
if(!empty($_POST))
{
		$errors = array();
		$email = $_POST["email"];

		//Perform some validation
		//Feel free to edit / change as required
		
		if(trim($email) == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
		}
		else if(!isValidemail($email))
		{
			$errors[] = lang("ACCOUNT_INVALID_EMAIL");
		}
		else if($email == $loggedInUser->email)
		{
				$errors[] = lang("NOTHING_TO_UPDATE");
		}
		else if(emailExists($email))
		{
			$errors[] = lang("ACCOUNT_EMAIL_TAKEN");	
		}
		
		//End data validation
		if(count($errors) == 0)
		{
			$loggedInUser->updateemail($email);
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Contact Details</title>
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

            <h1>Update your email address</h1>
    
            <?php
                if(!empty($_POST))
                {
                    if(count($errors) > 0)
                    {
                ?>
                <div id="errors">
                <?php errorBlock($errors); ?>
                </div>     
                <?php
                     } else { ?> 
            <div id="success">
            
               <p><?php echo lang("ACCOUNT_DETAILS_UPDATED"); ?></p>
               
            </div>
            <? } }?>

    
            <div id="regbox">
                <form name="changePass" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            
                <p>
                    <label>email:</label>
                    <input type="text" name="email" value="<?php echo $loggedInUser->email; ?>" />
                </p>
        
                <p>
                    <label>&nbsp;</label>
                    <input type="submit" value="Update email" class="submit" />
                </p>
                
                </form>
            </div>
            <div class="clear"></div>
        </div>
	</div>
</div>
</body>
</html>

