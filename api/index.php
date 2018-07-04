<?php
define('__module_class_prefix__','mul_');
define('__module_class_suffix__','');

$_MUL_DBG_WORK=true;
$_CURRENT_CONTROLLER=NULL;

//require_once __DIR__."/mullib/mulgach.php";
require_once __DIR__."/mullib/utils.php";
require_once __DIR__."/mullib/mlam.php";

/*
if(empty($_NO_READ_CONFIG))
{
	require_once url_seg_add(__DIR__,"../config.php");
}
if(!empty($_CONFIG))
{
	$_REDIRECT_INSTALL = false;
	require_once url_seg_add($_CONFIGS_AREA,$_CONFIG,"/config.php");
	if($_REDIRECT_INSTALL)
	{
		_redirect('/install');
	}
}
*/
$_CURRENT_SCREEN = "";

require_once __DIR__."/modulebase.php";
require_once __DIR__."/mullib/filepair.php";
//require_once __DIR__."/mullib/basecontroller.php";
//require_once __DIR__."/mullib/modelbase.php";
//require_once __DIR__."/mullib/authmodel.php";
/*
$install_scripts=get_files_in_folder(__DIR__."/mullib/install/");
foreach ($install_scripts as $idx => $scrpt)
{
	require_once $scrpt;
}*/
//require_once __DIR__."/mullib/install/installcontroller.php";
//require_once __DIR__."/mullib/install/installauthcontroller.php";

require_once __DIR__."/mullib/module.php";

$_MLAM = new MLAM();
$_MLAM->load_modules();
//$_MLAM->exe_modules();