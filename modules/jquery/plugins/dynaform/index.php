<?php

class plg_dynaform extends mod_plugin 
{
	use dbDriver;
	VAR $connection;
	VAR $parent_module;
	VAR $_DB_PARAMS;
	
	// Параметры :
	// controller - контроллер, к которому подключаешь плагин 
	function __construct($_PARAMS=array())
	{
		if(!empty($_PARAMS['controller']))
		{
			$js_files = get_files_in_folder( url_seg_add(__DIR__,'js') );
			//echo $_SERVER['DOCUMENT_ROOT'];
			foreach ($js_files as $js_script)
			{
				$_PARAMS['controller']->add_js($js_script);
			}
		}
		
	}
	
	
}