<?php
	/*
		UserCake Version: 1.0
		http://usercake.com
		

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
		$password = $_POST["password"];
		$password_new = $_POST["passwordc"];
		$password_confirm = $_POST["passwordcheck"];
	
		//Perform some validation
		//Feel free to edit / change as required
		
		if(trim($password) == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
		}
		else if(trim($password_new) == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_NEW_PASSWORD");
		}
		else if(minMaxRange(8,50,$password_new))
		{	
			$errors[] = lang("ACCOUNT_NEW_PASSWORD_LENGTH",array(8,50));
		}
		else if($password_new != $password_confirm)
		{
			$errors[] = lang("ACCOUNT_PASS_MISMATCH");
		}
		
		//End data validation
		if(count($errors) == 0)
		{
			//Confirm the hash's match before updating a users password
			$entered_pass = generateHash($password,$loggedInUser->hash_pw);
			
			//Also prevent updating if someone attempts to update with the same password
			$entered_pass_new = generateHash($password_new,$loggedInUser->hash_pw);
		
			if($entered_pass != $loggedInUser->hash_pw)
			{
				//No match
				$errors[] = lang("ACCOUNT_PASSWORD_INVALID");
			}
			else if($entered_pass_new == $loggedInUser->hash_pw)
			{
				//Don't update, this fool is trying to update with the same password ÃÂ¬ÃÂ¬
				$errors[] = lang("NOTHING_TO_UPDATE");
			}
			else
			{
				//This function will create the new hash and update the hash_pw property.
				$loggedInUser->updatePassword($password_new);
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Password | <?php echo $websiteName; ?> </title>
<?php require_once("head_inc.php"); ?>

</head>
<body>
<?php require_once("navbar.php"); ?>

<div id="content">
<div class="modal-ish">
  <div class="modal-body">

		<?php
            if(!empty($_POST))
            {
				if(count($errors) > 0)
				{
            ?>
            <div id="errors">
            <?php errorBlock($errors); ?>
            </div>     
            <?php } else { ?> 
            <div id="success">
               <p><?php echo lang("ACCOUNT_DETAILS_UPDATED"); ?></p>
            </div>
        <? } }?>

		

            <form name="changePass" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            
                <p>
                    <label>Password:</label>
                    <input type="password" name="password" />
                </p>
                
                <p>
                    <label>New Pass:</label>
                    <input type="password" name="passwordc" />
                </p>
                
                <p>
                    <label>Confirm Pass:</label>
                    <input type="password" name="passwordcheck" />
                </p>
            </div>    


  <div class="modal-footer">
<input type="submit" class="btn btn-primary" name="new" id="newfeedform" value="Update" />
  </div>

  
</div>

                </form>
                
        
            <div class="clear"></div>

  <p style="margin-top:30px; text-align:center;"><a href="/">Home</a></p>
</div>  
</body>
</html>


