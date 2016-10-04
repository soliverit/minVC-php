<?php
$_FORM = $_SERVER['DOCUMENT_ROOT']. "/tony/views/main/_form.php";
function __autoload($class){
	if(preg_match("/Controller/", $class) && file_exists("controllers/$class.php")){include "controllers/$class.php"};
	else{
		include "models/$class.php";
		if( get_parent_class($class) == "Record"){ $class::loadDefs();} 
	}
}
function login($user, $pass){
	$res 	= mysql_query("SELECT id, password FROM users WHERE username='". mysql_real_escape_string(strtolower($user)) ."'");
	if(mysql_num_rows($res) == 1)		
		if(mysql_fetch_assoc($res)['password'] == md5($pass)){ $_SESSION['loggedIn'] = true; }
	return $_SESSION['loggedIn'] == true ? "Login successful": "Invalid username and/or password";
}
function logout(){unset($_SESSION['loggedIn']);}
?>