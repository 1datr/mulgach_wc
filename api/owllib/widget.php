<?php
class Widget {
	
	VAR $_JS=array();
	VAR $_CSS=array();
	VAR $_META=array();
	VAR $_PARAMS;
	
	function __construct($_PARAMS=array())
	{
		$this->_PARAMS=$_PARAMS;
	}
	
	function out($params=array())
	{
		
	}
	
	function add_js($js)
	{
		$this->_JS[]=$js;
	}
	
	// add css
	function add_css($css)
	{
		$this->_CSS[]=$css;
	}
	
	// add meta tag
	function add_meta($meta)
	{
		$this->_META[]=$meta;
	}
}