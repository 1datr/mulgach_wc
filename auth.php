<?php 
session_start();
include __DIR__."/dbconf.php";
require_once __DIR__.'/xlib/utils.php';

include __DIR__."/dbconnect.php";

if($_POST['auth'])
{
	//print_r($_USERS);
	$res = auth_user_db($_POST['login'],$_POST['passw']);
	
	?>
	<script>
		document.location = "<?php echo $_SERVER['HTTP_REFERER']; ?>"
	</script>
	<?php
	
	/*
	if(!empty($_USERS[$_POST['login']]))
	{
		if($_USERS[$_POST['login']]==$_POST['passw'])
		{
			$_SESSION['auth']=TRUE;
			
		}
		else 
		{
			$_SESSION['err_msg']="Неверное имя пользователя или пароль";	
		}
	}
	else 
	{
		$_SESSION['err_msg']="Неверное имя пользователя или пароль";
	}*/
	 
}
?>