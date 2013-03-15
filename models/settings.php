<?php
	/*
		UserPie Version: 1.4
		http://userpie.com
		
		Developed by: Adam Davis
	*/

	//General Settings
	//--------------------------------------------------------------------------
	
	//Database Information
	$dbtype = "mysql"; 
	$db_host = "localhost";
	$db_user = "userpiec_dbuser";
	$db_pass = "xDr)UnN+ZJ(G";
	$db_name = "userpiec_devgit";
	$db_port = "";
	$db_table_prefix = "userpie_";

	$langauge = "en";
	
	//Generic website variables
	$websiteName = "User Pie Test";
	$websiteUrl = "http://dev.userpie.com/"; //including trailing slash

	//Do you wish UserPie to send out emails for confirmation of registration?
	//We recommend this be set to true to prevent spam bots.
	//False = instant activation
	//If this variable is falses the resend-activation file not work.
	$emailActivation = false;

	//In hours, how long before UserPie will allow a user to request another account activation email
	//Set to 0 to remove threshold
	$resend_activation_threshold = 1;
	
	//Tagged onto our outgoing emails
	$emailAddress = "noreply@iloveUserPie.com";
	
	//Date format used on email's
	$emailDate = date("l \\t\h\e jS");
	
	//Directory where txt files are stored for the email templates.
	$mail_templates_dir = "models/mail-templates/";
	
	$default_hooks = array("#WEBSITENAME#","#WEBSITEURL#","#DATE#");
	$default_replace = array($websiteName,$websiteUrl,$emailDate);
	
	//Display explicit error messages?
	$debug_mode = false;

	//Remember me - amount of time to remain logged in.
	$remember_me_length = "1wk";
	
	//---------------------------------------------------------------------------
?>