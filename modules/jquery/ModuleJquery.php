<?php
// модуль страница

class mul_jquery extends mul_Module 
{
	VAR $dbparams;
	VAR $drv;
	
	
	function __construct($_PARAMS)
	{
		
	}
	
	
	function page_before_html(&$args)
	{
		$args['JS']=array($this->get_module_dir()."/assets/js/jquery.min.js");;
	}

}

function use_jq_plugin($plg,$params=array())
{
	try{
		$modname="jquery.$plg";
		module_exists($modname);
		require_once url_seg_add(__DIR__,"/plugins/$plg/".ucfirst($plg).".php");
		$plg_class_name ="plg_{$plg}";
		$plg_class = new $plg_class_name($params);
		return $plg_class;
	}
	catch (Exception $ex)
	{
		$ex->getMessage();
		return NULL;
	}
}

function _use_jq_plugin($plg,$params=array(),$modname='jquery')
{
	try{
		
		if(!module_exists($modname))
		{
			$exc = new Exception();
			throw $exc; 			
		}
		
		$mod = find_module($modname);
		/*
		require_once url_seg_add(__DIR__,"/plugins/$plg/".ucfirst($plg).".php");
		$plg_class_name ="plg_{$plg}";
		$plg_class = new $plg_class_name($params);*/
		$plg = $mod->get_plugin($plg,$params);
		return $plg;
		
	}
	catch (Exception $ex)
	{
		$ex->getMessage();
		return NULL;
	}
}

function jq_onready($_controller,$code) {
	$_controller->inline_script("
	$( document ).ready(function() {
		{$code}
	});
	");
}