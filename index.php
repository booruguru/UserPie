<?php

	/*
		UserCake Version: 1.0
		http://usercake.com
		

	*/

require_once("models/config.php");

if(!isUserLoggedIn())
{ 
 include('landing-page.php'); 
	
 } else { 

header("Location: userpage.php"); 	 

} ?>