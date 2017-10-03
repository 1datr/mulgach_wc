<?php

class plg_zip extends mod_plugin 
{

	// Параметры :
	// controller - контроллер, к которому подключаешь плагин 	
	function __construct($_PARAMS=array())
	{
		
		if(is_object($_PARAMS))
		{
			$this->_controller = $_PARAMS;

			$this->add_js_css($this->_controller);
		}
		elseif(!empty($_PARAMS['controller']))
		{
			$this->_controller = $_PARAMS['controller'];

			$this->add_js_css($this->_controller);
			
		}		
	}
	
	function get_arc_man($params=[])
	{
		
	}

}