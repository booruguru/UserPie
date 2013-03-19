<html>
<head>
<title>UserPie - Database Setup</title>
<style type="text/css">
<!--
html, body {
	margin-top:15px;
	background: #fff;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size:0.85em;
	color:#4d4948;
	text-align:center;
}

a {
 color:#4d4948;
}
-->
</style>
</head>
<body>
<?php
	/*
		UserPie Version: 1.0
		http://userpie.com
		

	*/

	//  Primitive installer
	
	
	require_once("../models/settings.php");
	
	//Dbal Support - Thanks phpBB ; )
	require_once("../models/db/".$dbtype.".php");
	require_once("../models/funcs.user.php");
	
	//Construct a db instance
	$db = new $sql_db();
	if(is_array($db->sql_connect(
							$db_host, 
							$db_user,
							$db_pass,
							$db_name, 
							$db_port,
							false, 
							false
	))) {
		echo "<strong>Unable to connect to the database, check your settings.</strong>";	
		
		echo "<p><a href=\"?install=true\">Try again</a></p>";
	}
	else
	{
	
	if(returns_result("SELECT * FROM ".$db_table_prefix."groups LIMIT 1") > 0)
	{
		echo "<strong>UserPie has already been installed.<br /> Please remove / rename the install directory.</strong> <p>Continue...</p>";	
	}
	else
	{
		if(isset($_GET["install"]))
		{
	
				$db_issue = false;
			
				$groups_sql = "
					CREATE TABLE IF NOT EXISTS `".$db_table_prefix."groups` (
					`group_id` int(11) NOT NULL auto_increment,
					`group_name` varchar(225) NOT NULL,
					 PRIMARY KEY  (`group_id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
				";
				
				$group_entry = "
					INSERT INTO `".$db_table_prefix."groups` (`group_id`, `group_name`) VALUES
					(1, 'Standard User');
				";
				
				$users_sql = "
					 CREATE TABLE IF NOT EXISTS `".$db_table_prefix."users` (
					`user_id` int(11) NOT NULL auto_increment,
					`username` varchar(150) NOT NULL,
					`username_clean` varchar(150) NOT NULL,
					`password` varchar(225) NOT NULL,
					`email` varchar(150) NOT NULL,
					`activationtoken` varchar(225) NOT NULL,
					`last_activation_request` int(11) NOT NULL,
					`LostpasswordRequest` int(1) NOT NULL default '0',
					`active` int(1) NOT NULL,
					`group_id` int(11) NOT NULL,
					`sign_up_date` int(11) NOT NULL,
					 `last_sign_in` int(11) NOT NULL,
					 PRIMARY KEY  (`user_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
				";
				
				$sessions_sql = "
			    		 CREATE TABLE IF NOT EXISTS `". $db_table_prefix."sessions` (
					`session_start` int(11) NOT NULL,
					`session_data` text NOT NULL,
					`session_id` varchar(255) NOT NULL,
					PRIMARY KEY (`session_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1;
				";				

				if($db->sql_query($groups_sql))
				{
					echo "<p>".$db_table_prefix."groups table created.....</p>";
				}
				else
				{
					echo "<p>Error constructing ".$db_table_prefix."groups table.</p><br /><br /> DBMS said: ";
					
					echo print_r($db->_sql_error());
					$db_issue = true;
				}
				
				if($db->sql_query($group_entry))
				{
					echo "<p>Inserted Standard User group into ".$db_table_prefix."groups table.....</p>";
				}
				else
				{
					echo "<p>Error constructing groups table.</p><br /><br /> DBMS said: ";
					
					echo print_r($db->_sql_error());
					$db_issue = true;
				}
				
				if($db->sql_query($users_sql))
				{
					echo "<p>".$db_table_prefix."users table created.....</p>";
				}
				else
				{
					echo "<p>Error constructing user table.</p><br /><br /> DBMS said: ";
					
					echo print_r($db->_sql_error());
					$db_issue = true;
				}

				if($db->sql_query($sessions_sql))
				{
					echo "<p>".$db_table_prefix."sessions table created.....</p>";
				}
				else
				{
					echo "<p>Error constructing sessions table.</p><br /><br /> DBMS said: ";
					
					echo print_r($db->_sql_error());
					$db_issue = true;
				}
				
				if(!$db_issue)
				echo "<p><strong>Database setup complete, please delete the install folder.</strong></p><p>Continue...</p>";
				else
				echo "<p><a href=\"?install=true\">Try again</a></p>";
				
			
				
		}
		else
		{
	?>
			<a href="?install=true">Install UserPie</a>
	
	
	<?php } } }
	?>
</body>
</html>