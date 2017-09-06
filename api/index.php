<?php
define('__module_class_prefix__','mul_');
define('__module_class_suffix__','');

$_MUL_DBG_WORK=true;
$_CURRENT_CONTROLLER=NULL;

require_once __DIR__."/mullib/mulgach.php";
require_once __DIR__."/mullib/utils.php";


if(empty($_EP))
	$_EP=NULL;
if(empty($_CONTROLLER))
	$_CONTROLLER=NULL;
if(empty($_ACTION))
	$_ACTION=NULL;
if(empty($_CONFIGS_AREA))
	$_CONFIGS_AREA=url_seg_add($_BASEDIR,"/conf/");
	

if(empty($_NO_READ_CONFIG))
{
	//require_once url_seg_add(__DIR__,"/../config.php");
	//echo __DIR__;
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

require_once __DIR__."/modulebase.php";
require_once __DIR__."/mullib/basecontroller.php";
require_once __DIR__."/mullib/modelbase.php";
require_once __DIR__."/mullib/authmodel.php";

$install_scripts=get_files_in_folder(__DIR__."/mullib/install/");
foreach ($install_scripts as $idx => $scrpt)
{
	require_once $scrpt;
}
//require_once __DIR__."/mullib/install/installcontroller.php";
//require_once __DIR__."/mullib/install/installauthcontroller.php";

require_once __DIR__."/mullib/module.php";

$_MOD_CLASSES=array();

$_MOD_ACTIONS =array();
$_THE_MODULES=array();
if(empty($_MODULES))
{	
	require_once __DIR__."/../modules/conf.php";
	foreach ($_MODULES as $mod => $modparams)
	{
		$_THE_MODULES[$mod]=$modparams;
	}
}
else 
{
	$_THE_MODULES = $_MODULES;
	require_once __DIR__."/../modules/conf.php";
	foreach ($_MODULES as $mod => $modparams)
	{
		if(empty($_THE_MODULES[$mod]))
			$_THE_MODULES[$mod]=$modparams;
	}
}

	// Загрузка всех модулей
	foreach ($_THE_MODULES as $mod => $params)
	{
		try{
			$module_path = __DIR__."/../modules/$mod";
			if(file_exists($module_path))
			{
				require_once "$module_path/index.php";
				$module_class = __module_class_prefix__."$mod".__module_class_suffix__;
				
				$mod =new $module_class($params);
								
				$_MOD_CLASSES[]=$mod;
				$mod_idx = count($_MOD_CLASSES)-1;
				
				// добавляем действия 
				$acts=$_MOD_CLASSES[$mod_idx]->get_actions();
				if(count($acts))
				{
					foreach ($acts as $idx => $act)
					{
						if(is_array($act))
						{
							$need_idx = $act['need_idx'];
							$_PARAMS=$act;
							unset($_PARAMS['action']);
							$_MOD_ACTIONS[] =array('idx'=>$mod_idx,'action'=>$act['action'],'params'=>$_PARAMS);
						}
						else 
							$_MOD_ACTIONS[] =array('idx'=>$mod_idx,'action'=>$act,'params'=>array());
					}
				}
			}
			else 
			{
				throw new Exception("Module not exists");
			}
		//
		}
		catch (Exception $ex)
		{
			echo "<span class=\"exception\">$ex</span>";
		}
	}
	// Все действия
	foreach($_MOD_ACTIONS as $idx => $act)
	{
		$mod_class=$_MOD_CLASSES[$act['idx']];
		$mod_class->$act['action']();
	}
