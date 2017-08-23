<?php
$_NO_READ_CONFIG=true;
if(file_exists(__DIR__."/dbconf.php"))
	require_once __DIR__."/dbconf.php";
//$_CACHE_JS=true;
//$_CACHE_CSS=true;


$_MODULES=array(
		"db"=>array(
				"family"=>"mysql",
				"host"=>$_db_server,
				"user"=>$_db_user,
				"passw"=>$_db_passw,
				"dbname"=>$_db_name,
				"prefix"=>$_db_prefix,
				"charset"=>$_db_charset,
				"dbkey"=>"main",
		),		
)
				
?>