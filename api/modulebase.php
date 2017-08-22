<?php
class mul_Module 
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
	
	function get_srv()
	{
		return $this->get_request('srv');
	}
	
	function srv_exists($srv_name)
	{
		$method_name="Srv".UcaseFirst($srv_name);
		return method_exists($this, $method_name);
	}
	
	function call_srv($srv_name)
	{
		$method_name="Srv".UcaseFirst($srv_name);
		mul_dbg($method_name);
		$this->$method_name();
	}
	
	function ExeRequest($req)
	{
		if($req->plugin!=null)
		{
			$plg = $this->use_plugin($req->plugin);

			if($plg->srv_exists($req->method))
			{

				$plg->call_srv($req->method);
			}
		}
		else 
		{
			if($this->srv_exists($req->method))
				$this->call_srv($req->method);
		}
	}
	
	function get_request($reqname,$defval=null)
	{
		if(isset($_REQUEST[$reqname]))
		{
			return $_REQUEST[$reqname];
		}
		else
			return $defval;
	}
	
	static function getModulePlugins($modname)
	{
		$mod = find_module($modname);
		if($mod==NULL)
		{
			$mod = new mul_Module([]);
			return $mod->getplugins();
		}
		return $mod->getplugins();
	}	
	
	public function getplugins()
	{
		$plg_dir = url_seg_add($this->get_module_dir(),"/plugins/");
		$plglist = get_files_in_folder($plg_dir,['dirs'=>true,'basename'=>true]);	
		return $plglist;
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
	
	function js_files()
	{
		$js_array=array();
		GLOBAL $_BASEDIR;
		$js_files = get_files_in_folder( url_seg_add(__DIR__,'js') );
			
		//echo $_SERVER['DOCUMENT_ROOT'];
		foreach ($js_files as $js_script)
		{
			//echo $js_script;
			$str_js = filepath2url($js_script);
			$js_array[] = $str_js;
		}
		return $js_array;
	}
	
	function css_files()
	{
		$css_array=array();
		GLOBAL $_BASEDIR;
		$css_files = get_files_in_folder( url_seg_add(__DIR__,'css') );
			
		//echo $_SERVER['DOCUMENT_ROOT'];
		foreach ($css_files as $css_file)
		{
			//echo $js_script;
			$str_css = filepath2url($css_file);
			$css_array[] = $str_css;
		}
		return $css_array;
	}
	
	function srv_exists($srv_name)
	{
		$method_name="Srv".UcaseFirst($srv_name);
	
		return method_exists($this, $method_name);
	}
	
	function call_srv($srv_name)
	{
		$method_name="Srv".UcaseFirst($srv_name);
		$this->$method_name();
	}
}