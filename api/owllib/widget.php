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
	
	function get_attr_str($attrlist)
	{
		return xx_implode($attrlist,' ','{idx}="{%val}"',
				function(&$val,&$idx,&$thetemplate,&$ctr){
	
				});
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
	
	function usewidget($wid_object,$params=array())
	{
		//	ob_start();
		$wid_object->out($params);
		//	$html = ob_end_clean();
	
		$this->_JS = array_merge($this->_JS,$wid_object->_JS);
		$this->_CSS = array_merge($this->_CSS,$wid_object->_CSS);
		$this->_META = array_merge($this->_META,$wid_object->_META);
		//	echo $html;
	}
}