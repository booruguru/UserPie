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
		Below is a very simple example of how to process a new user.
		 Some simple validation (ideally more is needed).
		
		The first goal is to check for empty / null data, to reduce workload here
		we let the user class perform it's own internal checks, just in case they are missed.
	*/

//Forms posted
if(!empty($_POST))
{
		$errors = array();
		$email = trim($_POST["email"]);
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		$confirm_pass = trim($_POST["passwordc"]);
	
		//Perform some validation
		//Feel free to edit / change as required
		
		if(minMaxRange(5,25,$username))
		{
			$errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
		}
		if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
		{
			$errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
		}
		else if($password != $confirm_pass)
		{
			$errors[] = lang("ACCOUNT_PASS_MISMATCH");
		}
		if(!isValidemail($email))
		{
			$errors[] = lang("ACCOUNT_INVALID_EMAIL");
		}
		//End data validation
		if(count($errors) == 0)
		{	
				//Construct a user object
				$user = new User($username,$password,$email);
				
				//Checking this flag tells us whether there were any errors such as possible data duplication occured
				if(!$user->status)
				{
					if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
					if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
				}
				else
				{
					//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
					if(!$user->userPieAddUser())
					{
						if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
						if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
					}
				}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration</title>
<?php require_once("head_inc.php"); ?>
</head>
<body>
<div class="modal-ish">
  <div class="modal-header">
<center><img src="../images/klipbook-logo.png"></center>
  </div>
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
            <?php
           		 } else {
          
            	$message = lang("ACCOUNT_REGISTRATION_COMPLETE_TYPE1");
        
            	if($emailActivation)
				{
               		 $message = lang("ACCOUNT_REGISTRATION_COMPLETE_TYPE2");
				}
        ?> 
        <div id="success">
        
           <p><?php echo $message ?></p>
           
        </div>
        <?php } }?>

            <div id="regbox">
                <form name="newUser" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                
                <p>
                    <label>Username:</label>
                    <input type="text" name="username" />
                </p>
                
                <p>
                    <label>Password:</label>
                    <input type="password" name="password" />
                </p>
                
                <p>
                    <label>Confirm:</label>
                    <input type="password" name="passwordc" />
                </p>
                
                <p>
                    <label>Email:</label>
                    <input type="text" name="email" />
                </p>
    
    <p><input type="submit" class="btn btn-primary btn-large" name="new" id="newfeedform" value="Register" /></p>
      </div>           
      </div>


  
  
                
                </form>
            </div>

			<div class="clear"></div>
            <p style="margin-top:30px; text-align:center;"><a href="login.php">Login</a> / <a href="forgot-password.php">Forgot Password?</a> / <a href="<?php echo $websiteUrl; ?>">Home Page</a></p>

</body>
</html>


