<?php
// модуль страница

class mul_jquery_structblock extends mul_Module 
{
	VAR $name;
	
	function __construct($_PARAMS)
	{
		
	}
	
	
	function page_before_html(&$args)
	{
		$args['JS']=array($this->get_module_dir()."/assets/js/jquery.min.js");;
	}

	
	function get_plugin($plg,$params=array())
	{
		try{
			//$modname="jquery.$plg";
			//module_exists($modname);
			require_once url_seg_add(__DIR__,"/plugins/$plg/".$plg.".php");
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
}


