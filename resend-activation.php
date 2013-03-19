<?php
	/*
		UserPie Version: 1.0
		http://userpie.com
		

	*/
	require_once("models/config.php");
	
	//Prevent the user visiting the lost password page if he/she is already logged in
	if(isUserLoggedIn()) { header("Location: account.php"); die(); }
?>
<?php
	/* 
		Below process a new activation link for a user, as they first activation email may have never arrived.
	*/
	
$errors = array();
$success_message = "";

//Forms posted
//----------------------------------------------------------------------------------------------
if(!empty($_POST) && $emailActivation)
{
		$email = $_POST["email"];
		$username = $_POST["username"];
		
		//Perform some validation
		//Feel free to edit / change as required
		
		if(trim($email) == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
		}
		//Check to ensure email is in the correct format / in the db
		else if(!isValidemail($email) || !emailExists($email))
		{
			$errors[] = lang("ACCOUNT_INVALID_EMAIL");
		}
		
		if(trim($username) == "")
		{
			$errors[] =  lang("ACCOUNT_SPECIFY_USERNAME");
		}
		else if(!usernameExists($username))
		{
			$errors[] = lang("ACCOUNT_INVALID_USERNAME");
		}
		
		
		if(count($errors) == 0)
		{
			//Check that the username / email are associated to the same account
			if(!emailusernameLinked($email,$username))
			{
				$errors[] = lang("ACCOUNT_USER_OR_EMAIL_INVALID");
			}
			else
			{
				$userdetails = fetchUserDetails($username);
			
				//See if the user's account is activation
				if($userdetails["active"]==1)
				{
					$errors[] = lang("ACCOUNT_ALREADY_ACTIVE");
				}
				else
				{
					$hours_diff = round((time()-$userdetails["last_activation_request"]) / (3600*$resend_activation_threshold),0);

					if($resend_activation_threshold!=0 && $hours_diff <= $resend_activation_threshold)
					{
						$errors[] = lang("ACCOUNT_LINK_ALREADY_SENT",array($resend_activation_threshold));
					}
					else
					{
						//For security create a new activation url;
						$new_activation_token = generateactivationtoken();
						
						if(!updatelast_activation_request($new_activation_token,$username,$email))
						{
							$errors[] = lang("SQL_ERROR");
						}
						else
						{
							$mail = new userPieMail();
							
							$activation_url = $websiteUrl."activate-account.php?token=".$new_activation_token;
						
							//Setup our custom hooks
							$hooks = array(
								"searchStrs" => array("#ACTIVATION-URL","#USERNAME#"),
								"subjectStrs" => array($activation_url,$userdetails["username"])
							);
							
							if(!$mail->newTemplateMsg("resend-activation.txt",$hooks))
							{
								$errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
							}
							else
							{
								if(!$mail->sendMail($userdetails["email"],"Activate your UserPie Account"))
								{
									$errors[] = lang("MAIL_ERROR");
								}
								else
								{
									//Success, user details have been updated in the db now mail this information out.
									$success_message = lang("ACCOUNT_NEW_ACTIVATION_SENT");
								}
							}
						}
					}
				}
			}
		}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Resend Activation email | <?php echo $websiteName; ?> </title>
<?php require_once("head_inc.php"); ?>
</head>
<body>

<div class="modal-ish">
  <div class="modal-header">
 	 <h2>Resend Activation E-mail</h2>
  </div>
  <div class="modal-body"> 
 
    <?php
    if(!empty($_POST) || !empty($_GET["confirm"]) || !empty($_GET["deny"]) && $emailActivation)
    {     
	
			if(count($errors) > 0)
            {
		?>
        	<div id="errors">
            	<?php errorBlock($errors); ?>
            </div> 
        <?
            }
			else
			{
		?>
            <div id="success">
            
                <p><?php echo $success_message; ?></p>
            
            </div>
        <?
			}
        }
        ?> 
    
	
	<?php 
    
    if(!$emailActivation)
    { 
        echo lang("FEATURE_DISABLED");
    }
	else
	{
    ?>
        <form name="resendActivation" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        
        
        <p>
            <label>username:</label>
            <input type="text" name="username" />
        </p>     
            
         <p>
            <label>email:</label>
            <input type="text" name="email" />
         </p>    
    
    <p><input type="submit" class="btn btn-primary btn-large" name="activate" id="newfeedform" value="Resend" /></p>

            
        </form>

	 <? } ?> 
	       </div>           
      </div>


  
  
                
                </form>
            </div>

			<div class="clear"></div>
            <p style="margin-top:30px; text-align:center;"><a href="register.php">Register</a> / <a href="login.php">Login</a> / <a href="forgot-password.php">Forgot Password?</a> / <a href="<?php echo $websiteUrl; ?>">Home Page</a></p>


</body>
</html>


