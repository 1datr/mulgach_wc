<?php
require_once url_seg_add(__DIR__,"query_manager.php");
require_once url_seg_add(__DIR__,"trait_driver.php");

function get_connection($key=NULL)
{
	GLOBAL $_MLAM;
	$db_module = $_MLAM->find_module('db');
	return $db_module->get_drv($key);
}

function connect_db($params)
{
	GLOBAL $_MLAM;
	$db_module = $_MLAM->find_module('db');
	return $db_module->connect($params);
}

class mul_db extends mul_Module 
{
	VAR $dbparams;
	VAR $drv;
	VAR $connections;
	
	function page_before_out($_PARAMS)
	{
		$mp = get_mulgach_params();
		if(isset($mp['SETTINGS']['db']))
		{
			$this->dbparams = $mp['SETTINGS']['db'];
			$this->connect($this->dbparams);
		}
	}
	
	function get_actions()
	{
		return array('connect');
	}

	function connect($dbparams=NULL)
	{		
		if($dbparams!=NULL)
		{
			$this->dbparams = $dbparams;
		}
		
		//if($this->dbparams['family'])
		if($this->dbparams!='#none')
		{
			$drvname = $this->dbparams['driver'];		
			$drvname = "drv_$drvname";
			$drv = $this->use_plugin($drvname,$this->dbparams);
			if(!empty($this->dbparams['dbkey']))
				$this->connections[$this->dbparams['dbkey']]=$drv;
			else
				$this->connections[]=$drv;
							
		}
		return $drv;
	}
	
	function get_drv($key=NULL)
	{
		if($key==NULL)
		{
			if(!empty($this->connections))
			{
				$keys = array_keys($this->connections);
				return $this->connections[$keys[0]];
			}
			else 
				return NULL;
		}
		return $this->connections[$key];
	}
}