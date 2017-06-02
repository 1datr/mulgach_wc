<?php
// модуль страница

class owl_jquery extends owl_Module 
{
	function __construct($_PARAMS)
	{
		
	}
	
	
	function page_before_html(&$args)
	{
		$args['JS']=array($this->get_module_dir()."/assets/js/jquery.min.js");;
	}

}