<?php
class scaff_conf 
{
	VAR $_PATH;
	
	function __construct($conf,$opts=array())
	{
		GLOBAL $_BASEDIR;
		def_options(array($conf_dir=>'conf'), $opts);
		$this->_PATH = url_seg_add($_BASEDIR,$conf_dir,$conf);
	}
	
	function get_triada($ep,$hmvc_name)
	{
		
	}
	
	function create_triada($ep,$hmvc_name)
	{
		
	}
}