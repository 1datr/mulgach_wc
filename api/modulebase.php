<?php
class owl_Module 
{
	function __construct($_PARAMS)
	{
		
	}
	
	function wait_events()
	{
		return array();
	}
	
	function get_mod_name()
	{
		$classname = get_class($this);
		
		$name="";
		list($name) = sscanf( $classname,__module_class_prefix__.'%s'.__module_class_suffix__);		
		return $name;
	}
	
	function use_plugin($plg,$params=array())
	{
		require_once $this->get_module_dir()."/plugins/$plg/index.php";
		$class_name="plg_$plg";
		if(class_exists($class_name))
		{
			$newobj=new $class_name($params);
			return $newobj;
		}
		return null;
	}
	
	function get_module_dir()
	{
		GLOBAL $_BASEDIR;
		return url_seg_add($_BASEDIR,url_seg_add("modules",$this->get_mod_name()));
	}
	
	function get_actions()
	{
		return array();
	}
	
	function get_events()
	{
		return array();
	}
}

class mod_plugin {
	
	function __construct($_PARAMS)
	{
		
	}
}