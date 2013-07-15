<?php

	/*
		UserPie Version: 1.0
		http://userpie.com
		

	*/

require_once("models/config.php");

if(!isUserLoggedIn())
{ 
 include('landing-page.php'); 
	
 } else { 

header("Location: userpage.php"); 	 

} ?>
