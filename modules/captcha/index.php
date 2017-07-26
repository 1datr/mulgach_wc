<?php

require_once url_seg_add(__DIR__,"trait_captcha.php");

class mul_captcha extends mul_Module 
{
	VAR $dbparams;
	VAR $drv;
	VAR $connections;
	VAR $_MODEL=NULL;
	VAR $_FORM=NULL;
	
	function __construct($_PARAMS)
	{
		$this->dbparams = $_PARAMS;
	}
	
	static function use_captcha(&$_controller,$opts=[],$plg_name='simple')
	{
		try{
			def_options(['controller'=>$_controller], $opts);
			
			
			
			require_once url_seg_add(__DIR__,"/plugins/$plg_name/index.php");
			$plg_class_name ="plg_{$plg_name}";
			$plg_class = new $plg_class_name($opts);
			
			return $plg_class;
		}
		catch (Exception $ex)
		{
			$ex->getMessage();
			return NULL;
		}
				
	}
		
	function get_actions()
	{
		return array('usecaptcha');
	}
	
	function AfterValidate($params=[])
	{
		mul_dbg('After validate');
	}
	
	function usecaptcha()
	{
		if($this->get_srv()==='captcha_pic')
		{
			$plg = $this->get_request('mode','simple');
			$plg_obj = $this->use_plugin($plg);
			$plg_obj->picture();
			//echo $plg;
		}
		else 
		{
			
		}
	}
}