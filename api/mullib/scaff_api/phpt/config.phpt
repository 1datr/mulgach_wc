<#php
if($_EP=='install')
{
	$dbparams="#none";
}
else 
{
	if(file_exists(__DIR__."/dbconf.php"))
	{
		require_once __DIR__."/dbconf.php";
	}
	else 
	{
		_redirect("install");
	}
}
//$_CACHE_JS=true;
//$_CACHE_CSS=true;


$_MODULES=array(
		"db"=>$dbparams,		
)
				
#>