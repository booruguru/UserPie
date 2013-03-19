<?php
	/*
		UserPie Version: 1.0
		http://userpie.com
		

	*/
	
	function sanitize($str)
	{
		return strtolower(strip_tags(trim(($str))));
	}
	
	function isValidemail($email)
	{
		return preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",trim($email));
	}
	
	function minMaxRange($min, $max, $what)
	{
		if(strlen(trim($what)) < $min)
		   return true;
		else if(strlen(trim($what)) > $max)
		   return true;
		else
		   return false;
	}
	
	//@ Thanks to - http://phpsec.org
	function generateHash($plainText, $salt = null)
	{
		if ($salt === null)
		{
			$salt = substr(md5(uniqid(rand(), true)), 0, 25);
		}
		else
		{
			$salt = substr($salt, 0, 25);
		}
	
		return $salt . sha1($salt . $plainText);
	}
	
	function replaceDefaultHook($str)
	{
		global $default_hooks,$default_replace;
	
		return (str_replace($default_hooks,$default_replace,$str));
	}
	
	function getUniqueCode($length = "")
	{	
		$code = md5(uniqid(rand(), true));
		if ($length != "") return substr($code, 0, $length);
		else return $code;
	}
	
	function errorBlock($errors)
	{
		if(!count($errors) > 0)
		{
			return false;
		}
		else
		{
			echo "<ul>";
			foreach($errors as $error)
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
		}
	}
	
	function lang($key,$markers = NULL)
	{
		global $lang;
		
		if($markers == NULL)
		{
			$str = $lang[$key];
		}
		else
		{
			//Replace any dyamic markers
			$str = $lang[$key];

			$iteration = 1;
			
			foreach($markers as $marker)
			{
				$str = str_replace("%m".$iteration."%",$marker,$str);
				
				$iteration++;
			}
		}
		
		//Ensure we have something to return
		if($str == "")
		{
			return ("No language key found");
		}
		else
		{
			return $str;
		}
	}
	
// Destroy the session data
// Remember-Me Hack v0.03
// <http://rememberme4uc.sourceforge.net/>
function destorySession($name)
{
	global $remember_me_length,$loggedInUser,$db,$db_table_prefix;
		
	   if($loggedInUser->remember_me == 0) { 
		if(isset($_SESSION[$name]))
		{
			$_SESSION[$name] = NULL;
			unset($_SESSION[$name]);
			$loggedInUser = NULL;
		}
	}
	else if($loggedInUser->remember_me == 1) {
		if(isset($_COOKIE[$name]))
		{
			$db->sql_query("DELETE FROM ".$db_table_prefix."sessions WHERE session_id = '".$loggedInUser->remember_me_sessid."'");
			setcookie($name, "", time() - parseLength($remember_me_length));
			$loggedInUser = NULL;
		}
	} 
}

// Update the session data
// Remember-Me Hack v0.03
// <http://rememberme4uc.sourceforge.net/>

function updateSessionObj()
{
	global $loggedInUser,$db,$db_table_prefix;

	$newObj = serialize($loggedInUser);
	$db->sql_query("UPDATE ".$db_table_prefix."sessions SET session_data = '".$newObj."' WHERE session_id = '".$loggedInUser->remember_me_sessid."'");
}

// Remember-Me Hack v0.03
// <http://rememberme4uc.sourceforge.net/>

function parseLength($len) {
$user_units = strtolower(substr($len, -2));
$user_time = substr($len, 0, -2);
$units = array("mi" => 60,
"hr" => 3600,
"dy" => 86400,
"wk" => 604800,
"mo" => 2592000);
if(!array_key_exists($user_units, $units))
die("Invalid unit of time.");
else if(!is_numeric($user_time))
die("Invalid length of time.");
else
return (int)$user_time*$units[$user_units];
}

?>