<?php
define('__module_class_prefix__','mul_');
define('__module_class_suffix__','');

$_MUL_DBG_WORK=true;
$_CURRENT_CONTROLLER=NULL;

require_once __DIR__."/mullib/mulgach.php";
require_once __DIR__."/mullib/utils.php";
require_once __DIR__."/mullib/mlam.php";


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

$_CURRENT_SCREEN = "";

require_once __DIR__."/modulebase.php";
require_once __DIR__."/mullib/filepair.php";
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

function rename_mod_file($_old_file,$_new_file)
{
	if(file_exists($_old_file))
	{
		rename($_old_file, $_new_file);
	}
}

	// �������� ���� �������
	foreach ($_THE_MODULES as $mod => $params)
	{
		try{
			$module_path = __DIR__."/../modules/$mod";
			if(file_exists($module_path))
			{
				/*
				$_OLD_FORMAT_FILE = url_seg_add($module_path,"Modeule".ucfirst($mod).".php");
				$_NEW_FORMAT_FILE = url_seg_add($module_path,"Module".ucfirst($mod).".php");
				rename_mod_file($_OLD_FORMAT_FILE, $_NEW_FORMAT_FILE);*/
				
				$_MOD_FILE = url_seg_add($module_path,"Module".ucfirst(strtr($mod,'.','_')).".php");
				require_once $_MOD_FILE;
				$module_class = __module_class_prefix__."".strtr($mod,'.','_')."".__module_class_suffix__;
				
				$mod_obj =new $module_class($params);
								
				$_MOD_CLASSES[]=$mod_obj;
				$mod_idx = count($_MOD_CLASSES)-1;
				
				// ��������� �������� 
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
	// ��� ��������
	foreach($_MOD_ACTIONS as $idx => $act)
	{
		$mod_class=$_MOD_CLASSES[$act['idx']];
		$mod_class->$act['action']();
	}
