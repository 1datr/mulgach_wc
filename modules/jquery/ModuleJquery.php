<?php
// ������ ��������

class mul_jquery extends mul_Module 
{
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
		require_once url_seg_add(__DIR__,"/plugins/$plg/index.php");
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

function jq_onready($_controller,$code) {
	$_controller->inline_script("
	$( document ).ready(function() {
		{$code}
	});
	");
}