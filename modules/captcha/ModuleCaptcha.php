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
			
			require_once url_seg_add(__DIR__,"/plugins/$plg_name/".ucfirst($plg_name).".php");
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
	// писок капчевых плагинов
	function get_plug_list()
	{
		$plugs = get_files_in_folder( url_seg_add( __DIR__,'plugins'),['dirs'=>true,'basename'=>true,'without_ext'=>true]);
		return $plugs;
	}
	
	function recognize_capcha_plugin($data)
	{
		$plugs = $this->get_plug_list();
		foreach($plugs as $idx => $plg)
		{
			$plg_index_file = url_seg_add(__DIR__,'plugins',$plg,'index.php');
			include $plg_index_file;
			$plg_class="plg_$plg";
			$rec = $plg_class::recognize($data);
			if($rec==true)
			{
				$plg_obj = $this->use_plugin($plg);
				return $plg_obj; 
			}
		}
		return null;
	}
	
	function AfterValidate(&$params)
	{
	//	mul_dbg($params['eparams']['row']);	
		$plug = $this->recognize_capcha_plugin($params['eparams']);
		if($plug!=null)
		{
			$plug->check_captcha($params['eparams']);
		}
		// $params['eparams']['res']['captcha_value']=Lang::__t('Captcha error');
	}
	
	function usecaptcha()
	{
		$plugs = $this->get_plug_list();
		foreach($plugs as $idx => $plg)
		{
			
		}
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