<?php
// модуль страница

class owl_bootstrap extends owl_Module 
{
	function __construct($_PARAMS)
	{
		
	}
	
	function wait_events()
	{
		return array('jquery');
	}
		
	function page_before_html(&$args)
	{
		GLOBAL $_BASEDIR;
		$args['CSS']=array($this->get_module_dir()."/assets/css/bootstrap.min.css");
		$args['JS']=array($this->get_module_dir()."/assets/js/bootstrap.min.js");
	}

}