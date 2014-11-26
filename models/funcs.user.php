<?php
	/*
		UserPie Version: 1.0
		http://userpie.com
		

	*/
	
	
	function usernameExists($username)
	{
		global $db,$db_table_prefix;
		
		$sql = "SELECT active
				FROM ".$db_table_prefix."users
				WHERE
				username_clean = '".$db->sql_escape(sanitize($username))."'
				LIMIT 1";
	
		if(returns_result($sql) > 0)
			return true;
		else
			return false;
	}
	
	function emailExists($email)
	{
		global $db,$db_table_prefix;
	
		$sql = "SELECT active FROM ".$db_table_prefix."users
				WHERE
				email = '".$db->sql_escape(sanitize($email))."'
				LIMIT 1";
	
		if(returns_result($sql) > 0)
			return true;
		else
			return false;	
	}
	
	//Function lostpass var if set will check for an active account.
	function validateactivationtoken($token,$lostpass=NULL)
	{
		global $db,$db_table_prefix;
		
		if($lostpass == NULL) 
		{	
			$sql = "SELECT activationtoken
					FROM ".$db_table_prefix."users
					WHERE active = 0
					AND
					activationtoken ='".$db->sql_escape(trim($token))."'
					LIMIT 1";
		}
		else 
		{
			 $sql = "SELECT activationtoken
			 		FROM ".$db_table_prefix."users
					WHERE active = 1
					AND
					activationtoken ='".$db->sql_escape(trim($token))."'
					AND
					LostpasswordRequest = 1 LIMIT 1";
		}
		
		if(returns_result($sql) > 0)
			return true;
		else
			return false;
	}
	
	
	function setUseractive($token)
	{
		global $db,$db_table_prefix;
		
		$sql = "UPDATE ".$db_table_prefix."users
		 		SET active = 1
				WHERE
				activationtoken ='".$db->sql_escape(trim($token))."'
				LIMIT 1";
		
		return ($db->sql_query($sql));
	}
	
	//You can use a activation token to also get user details here
	function fetchUserDetails($username=NULL,$token=NULL)
	{
		global $db,$db_table_prefix; 
		
		if($username!=NULL) 
		{  
			$sql = "SELECT * FROM ".$db_table_prefix."users
					WHERE
					username_clean = '".$db->sql_escape(sanitize($username))."'
					LIMIT
					1";
		}
		else
		{
			$sql = "SELECT * FROM ".$db_table_prefix."users
					WHERE 
					activationtoken = '".$db->sql_escape(sanitize($token))."'
					LIMIT 1";
		}
		 
		$result = $db->sql_query($sql);
		
		$row = $db->sql_fetchrow($result);
		
		return ($row);
	}
	
	function flagLostpasswordRequest($username,$value)
	{
		global $db,$db_table_prefix;
		
		$sql = "UPDATE ".$db_table_prefix."users
				SET LostpasswordRequest = '".$value."'
				WHERE
				username_clean ='".$db->sql_escape(sanitize($username))."'
				LIMIT 1
				";
		
		return ($db->sql_query($sql));
	}
	
	function updatepasswordFromToken($pass,$token)
	{
		global $db,$db_table_prefix;
		
		$new_activation_token = generateactivationtoken();
		
		$sql = "UPDATE ".$db_table_prefix."users
				SET password = '".$db->sql_escape($pass)."',
				activationtoken = '".$new_activation_token."'
				WHERE
				activationtoken = '".$db->sql_escape(sanitize($token))."'";
		
		return ($db->sql_query($sql));
	}
	
	function emailusernameLinked($email,$username)
	{
		global $db,$db_table_prefix;
		
		$sql = "SELECT username,
				email FROM ".$db_table_prefix."users
				WHERE username_clean = '".$db->sql_escape(sanitize($username))."'
				AND
				email = '".$db->sql_escape(sanitize($email))."'
				LIMIT 1
				";
		
		if(returns_result($sql) > 0)
			return true;
		else
			return false;
	}
	
	
	function isUserLoggedIn()
	{
		global $loggedInUser,$db,$db_table_prefix;
		if (!isset($loggedInUser) || $loggedInUser == NULL)
		{
			return false;
		}
		
		if($loggedInUser == NULL){
			return false;
		}else{
			$sql = "SELECT user_id,
				password
				FROM ".$db_table_prefix."users
				WHERE
				user_id = '".$db->sql_escape($loggedInUser->user_id)."'
				AND 
				password = '".$db->sql_escape($loggedInUser->hash_pw)."' 
				AND
				active = 1
				LIMIT 1";
			
		
			//Query the database to ensure they haven't been removed or possibly banned?
			if(returns_result($sql) > 0)
			{
					return true;
			}
			else
			{
				//No result returned kill the user session, user banned or deleted
				$loggedInUser->userLogOut();
			
				return false;
			}
		}
	}
	
	//This function should be used like num_rows, since the PHPBB Dbal doesn't support num rows we create a workaround
	function returns_result($sql)
	{
		global $db;
		
		$count = 0;
		$result = $db->sql_query($sql);
		
		while ($row = $db->sql_fetchrow($result))
		{
		  $count++;
		}
		
		$db->sql_freeresult($result);
		
		return ($count);
	}
	
	//Generate an activation key 
	function generateactivationtoken()
	{
		$gen;
	
		do
		{
			$gen = md5(uniqid(mt_rand(), false));
		}
		while(validateactivationtoken($gen));
	
		return $gen;
	}
	
	function updatelast_activation_request($new_activation_token,$username,$email)
	{
		global $db,$db_table_prefix; 
		
		$sql = "UPDATE ".$db_table_prefix."users
		 		SET activationtoken = '".$new_activation_token."',
				last_activation_request = '".time()."'
				WHERE email = '".$db->sql_escape(sanitize($email))."'
				AND
				username_clean = '".$db->sql_escape(sanitize($username))."'";
		
		return ($db->sql_query($sql));
	}
?>
