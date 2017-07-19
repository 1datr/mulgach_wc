<?php

class mul_captcha extends mul_Module 
{
	VAR $dbparams;
	VAR $drv;
	VAR $connections;
	function __construct($_PARAMS)
	{
		$this->dbparams = $_PARAMS;
	}
	
	static function use_captcha($_controller,$plg_name='simple')
	{
		$this->use_plugin($plg_name,[]);
	}
	
}