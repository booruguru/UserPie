<?php
	/*
		UserPie Version: 1.0
		http://userpie.com
		

	*/

	if(is_dir("install/"))
	{
		header("Location: install/");
		die();
	}
	
	require_once("settings.php");

	//Dbal Support - Thanks phpBB ; )
	require_once("db/".$dbtype.".php");
	
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
		die("Unable to connect to the database");
	}
	
	if(!isset($language)) $langauge = "en";

	require_once("lang/".$langauge.".php");
	require_once("class.user.php");
	require_once("class.mail.php");
	require_once("funcs.user.php");
	require_once("funcs.general.php");
	require_once("class.newuser.php");

	session_start();
	
//Global User Object Var
//loggedInUser can be used globally if constructed
if(isset($_SESSION["userPieUser"]) && is_object($_SESSION["userPieUser"]))
$loggedInUser = $_SESSION["userPieUser"];
else if(isset($_COOKIE["userPieUser"])) {
$db->sql_query("SELECT session_data FROM ".$db_table_prefix."sessions WHERE session_id = '".$_COOKIE['userPieUser']."'");
$dbRes = $db->sql_fetchrowset();
if(empty($dbRes)) {
$loggedInUser = NULL;
setcookie("userPieUser", "", -parseLength($remember_me_length));
}
else {
$obj = $dbRes[0];
$loggedInUser = unserialize($obj["session_data"]);
}
}
else {
$db->sql_query("DELETE FROM ".$db_table_prefix."sessions WHERE ".time()." >= (session_start+".parseLength($remember_me_length).")");
$loggedInUser = NULL;
}

?>