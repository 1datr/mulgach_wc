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
	
	function __construct($_PARAMS)
	{
		parent::__construct($_PARAMS);
		$this->load_api();
		
	}
	
	function load_api()
	{
		require_once url_seg_add($this->get_module_dir(),'api/basecontroller.php');
		require_once url_seg_add($this->get_module_dir(),'api/modelbase.php');
		require_once url_seg_add($this->get_module_dir(),'api/authmodel.php');
		require_once url_seg_add($this->get_module_dir(),'api/widget.php');
		require_once url_seg_add($this->get_module_dir(),'api/dataset.php');
		require_once url_seg_add($this->get_module_dir(),'api/install/installcontroller.php');
		require_once url_seg_add($this->get_module_dir(),'api/install/installtablecontroller.php');
		require_once url_seg_add($this->get_module_dir(),'api/install/x_installauthcontroller.php');
	/*	$api_scripts=get_files_in_folder(url_seg_add($this->get_module_dir(),'api'));
		foreach ($api_scripts as $idx => $scrpt)
		{
			if(is_dir($scrpt))
			{
				$nested_scripts=get_files_in_folder($scrpt);
				foreach ($nested_scripts as $idx => $_scrpt)
				{
					require_once $_scrpt;
				}
			}
			else
				require_once $scrpt;
		}*/
	}
	
	function OnLoad()
	{
		//
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
	
	public function use_scaff_api()
	{
		require_once url_seg_add($this->get_module_dir(),'scaff_api/index.php');
	}
}

function use_scaff_api()
{
	$mulgach = find_module('mulgach');
	$mulgach->use_scaff_api();
}

function get_mulgach_params()
{
	$mulgach = find_module('mulgach');
	return ['curr_cfg_dir'=>$mulgach->_CURR_CONF_DIR,
			'EP'=>$mulgach->_EP,
			'SETTINGS'=>$mulgach->_SETTINGS
	];
}