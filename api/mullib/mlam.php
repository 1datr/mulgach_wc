<?php
define('__module_class_prefix__','mul_');
define('__module_class_suffix__','');
define('__module_file_prefix__',"Module");
define('__module_file_suffix__',"");

define('__AM_ASSOC__',"ASSOC");
define('__AM_IDX__',"IDX");

class MLAM 
{
	VAR $_MOD_CLASSES=[];
	VAR $_SETTINGS;
	VAR $_MODULES_DIR;
	VAR $_ARRAY_MODE;
	
	function __construct($params=[])
	{
		GLOBAL $_BASEDIR;
		def_options(['_ARRAY_MODE'=>__AM_ASSOC__], $params);
			
		$this->_ARRAY_MODE  = $params["_ARRAY_MODE"];
		
		$this->_MODULES_DIR = url_seg_add($_BASEDIR,'modules');
			
		$fp_settings  = new FilePair( url_seg_add($this->_MODULES_DIR,"conf.php"));		
		$this->_SETTINGS = $fp_settings->get_settings();
	}
	
	function load_modules()
	{
		foreach($this->_SETTINGS['_MODULES'] as $mod => $modparams)
		{
			$this->load_module($mod);
		}
		
		foreach ($this->_MOD_CLASSES as $idx => $_mod)
		{
			$_mod->OnLoad();
		}
		//print_r($this->_MOD_CLASSES);
	}
	
	function module_loaded($modname)
	{
		$_mod_ = $this->find_module($modname);
		if($_mod_===null) return false;
		return true;
	}
	
	// обращение прямое к функции модуля
	public function exe_module($modname,$method,&$params)
	{
		if(isset($this->_MODULES_OBJS[$modname]))
		{
			return $this->_MODULES_OBJS[$modname]->$method($params);
		}
		else
		{
			$this->err_log("Module not exists");
			return null;
		}
	}
	
	function module_exists($modname)
	{
		return file_exists( url_seg_add($this->_MODULES_DIR,$modname."/index.php"));
	}
	
	function find_module($modname)
	{
		
		switch($this->_ARRAY_MODE)
		{
			case __AM_ASSOC__:
				{
					if(isset($this->_MOD_CLASSES[$modname]))
						return $this->_MOD_CLASSES[$modname];
				};break;
			case __AM_IDX__:
				{
				foreach($this->_MOD_CLASSES as $idx => $mod)
					{
						if($mod->get_mod_name()==$modname)
							return $this->_MOD_CLASSES[$idx];
					}
				};break;
		}
		
		
		return null;
	}
	// загрузить модуль
	function load_module($mod)
	{
		if($this->module_loaded($mod)) 
			return;
		
		$mod_path = url_seg_add($this->_MODULES_DIR,$mod);
		$_settings_file = url_seg_add($mod_path ,"settings.php");
		if(FilePair::exists($_settings_file))	// удовлетворяем необходимые зависимости
		{
			$fp_mod_settings  = new FilePair($_settings_file);
			$mod_settings = $fp_mod_settings->get_settings(); 
			if(isset($mod_settings['required']))
			{
				foreach($mod_settings['required'] as $idx => $_mod)
				{
					$this->load_module($_mod);
				}
			}
		}
		// коннектим сам модуль		
		$mod_file_path = url_seg_add($mod_path,__module_file_prefix__.strtr(ucfirst($mod),'.','_').__module_file_suffix__.".php");
		require_once $mod_file_path;
		
		$params=['MLAM'=>$this];
		
		$module_class = __module_class_prefix__."".strtr($mod,'.','_')."".__module_class_suffix__;
		
		$mod_obj =new $module_class($params);

		switch($this->_ARRAY_MODE)
		{
			case __AM_ASSOC__:
			{
				$this->_MOD_CLASSES[$mod]=$mod_obj;
			};break;
			case __AM_IDX__:
			{
					$this->_MOD_CLASSES[]=$mod_obj;
			};break;
		}
		
	}
		
	
	function call_modules($module,$eventname,$args=[],$eopts=[])
	{
		def_options(array('src'=>'module'), $eopts);
	
		$called_list=array();
		foreach ($this->_MOD_CLASSES as $idx => $mod)
		{
			if(($mod->get_mod_name()!=$module)&&(!in_array($mod,$called_list)))
			{
				$this->call_event($mod,$eventname,$module,$called_list,$args, $eopts);
			}
		}
		return $args;
	}

	function call_event($mod,$eventname,$event_src,&$called_list,&$res_of_module, $eopts=[])
	{
		def_options(array('src'=>'module'), $eopts);
		
		//$mod = $this->find_module($mod);
		
		$waits = $mod->wait_events();
		if(count($waits))
		{
			foreach($waits as $w)
			{
				if(is_array($w))
				{
					if($w['event']==$eventname)
					{
						$req_mod = $this->find_module($w['module']);
					}
				}
				else 
				{
					$req_mod = $this->find_module($w);
				}
				if(!in_array($req_mod, $called_list))
				{
					
					$this->call_event($req_mod, $eventname,$event_src,$called_list,$res_of_module); // вызвать событие от модуля
					
					$called_list[]=$req_mod;
				}
			}
		}
		
		switch($eopts['src'])
		{
			case 'module':
				$metodname = strtr($event_src,['.'=>'_'])."_{$eventname}";
				if(method_exists($mod, $metodname))
				{
					$mod_res=array();
					//$mod->$metodname($mod_res);
					$mod->$metodname($res_of_module);
					$res_of_module[$mod->get_mod_name()]=$res_of_module;//$mod_res; // записали полученный от модуля результат
				
					$args[$mod->get_mod_name()]=$res_of_module;
					$called_list[]=$mod;
				}
				break;
			case 'controller':
				$metodname = "{$eventname}";
				if(method_exists($mod, $metodname))
				{
					$mod_res=array();
					//$mod->$metodname($mod_res);
					$mod->$metodname($res_of_module);
					$res_of_module[$mod->get_mod_name()]=$res_of_module;//$mod_res; // записали полученный от модуля результат
						
					$args[$mod->get_mod_name()]=$res_of_module;
					$called_list[]=$mod;
				}
				break;
		}
		
		
		
	}
	
	function err_log($err)
	{
		echo "<span class=\"exception\">$err</span>";
	}
	
	function exe_modules()
	{
		// добавляем действия
		foreach($this->_MOD_CLASSES as $mod_idx => $mod)
		{
			$acts = $mod->get_actions();
			if(count($acts))
			{
				foreach($acts as $act)
				{
					$mod->$act();
				}
			}
		}
		
	}
}