<?php
class mul_mulgach extends mul_Module
{
	VAR $_CONF;
	VAR $_EP;
	VAR $_CONFIGS_AREA;
	VAR $_NO_READ_CONFIG;
	VAR $_CURR_CONF_DIR;
	VAR $_CONF_PATH;
	VAR $_SETTINGS;
	
	function OnLoad()
	{
		$this->dbparams = $_PARAMS;
		GLOBAL $_CONFIG;
		GLOBAL $_EP;
		GLOBAL $_BASEDIR;
		GLOBAL $_CONFIGS_AREA;
		GLOBAL $_NO_READ_CONFIG;
		if(!$_NO_READ_CONFIG)
		{
			require_once url_seg_add($_BASEDIR,'config.php');
		}
		
		if(empty($_EP))		
		{
			$this->_EP="frontend";
		}		
		else
		{
			$this->_EP=$_EP;
		}
		if(empty($_CONFIGS_AREA))
		{
			$this->_CONFIGS_AREA = url_seg_add($_BASEDIR,'conf');
		}
		else 
		{
			$this->_CONFIGS_AREA = $_CONFIGS_AREA;
		}			
		
		$this->_CURR_CONF_DIR = url_seg_add($this->_CONFIGS_AREA,$_CONFIG);
		
		$this->_NO_READ_CONFIG = $_NO_READ_CONFIG;
					
		$this->_CONF_PATH = url_seg_add($this->_CURR_CONF_DIR,'config.php');
		
		include $this->_CONF_PATH;
		
		$this->_SETTINGS = $_SETTINGS;
		
		$args=[];
		$opts=[];
		$this->call_modules('onload',$args,$opts);
	}
}

function get_mulgach_params()
{
	$mulgach = find_module('mulgach');
	return ['curr_cfg_dir'=>$mulgach->_CURR_CONF_DIR,
			'EP'=>$mulgach->_EP,
			'SETTINGS'=>$mulgach->_SETTINGS
	];
}