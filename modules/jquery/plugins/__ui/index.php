<?php

class plg___ui extends mod_plugin 
{
	use dbDriver;
	VAR $connection;
	VAR $parent_module;
	VAR $_DB_PARAMS;
	
	
	// Параметры :
	// controller - контроллер, к которому подключаешь плагин 
	function __construct($_PARAMS=array())
	{
		if(is_object($_PARAMS))
		{
			$this->add_js_css($_PARAMS);
		}
		elseif(!empty($_PARAMS['controller']))
		{
			$this->add_js_css($_PARAMS['controller']);
			
		}
		else 
		{
			
		}
	}
	
	function add_js_css($controller_obj)
	{
		
		$controller_obj->add_js(filepath2url(url_seg_add(__DIR__,'/js/jquery-ui.min.js')));
		
		
		$controller_obj->add_css(filepath2url(url_seg_add(__DIR__,'/css/jquery-ui.min.css')));
		$controller_obj->add_css(filepath2url(url_seg_add(__DIR__,'/css/jquery-ui.theme.min.css')));
		
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
	
}