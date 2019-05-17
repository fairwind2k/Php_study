<meta charset="utf-8">

<?php  

ini_set('display_errors', 1); 
date_default_timezone_set ('Europe/Amsterdam' );

	$host = 'localhost'; 
	$user = 'root'; 
	$password = ''; 
	$db_name = 'myTest';               

	if(!mysql_connect("$HOST", "$USER", "$PASS")) exit(mysql_error()); 
	else {echo "";} 
	 
	$r = mysql_query("CREATE DATABASE $DB"); 
	if(!$r)exit(mysql_error()); 

	if (!mysql_select_db($DB)) exit(mysql_error()); 
	else{echo "";} 
	     
	mysql_query('utf8_general_ci'); 
	echo "Database created successfully"; 
?>