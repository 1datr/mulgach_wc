<?php
require_once url_seg_add(__DIR__,"query_manager.php");
require_once url_seg_add(__DIR__,"trait_driver.php");

function get_connection($key=NULL)
{
	$db_module = find_module('db');
	return $db_module->get_drv($key);
}

function connect_db($params)
{
	$db_module = find_module('db');
	return $db_module->connect($params);
}

class owl_db extends owl_Module 
{
	VAR $dbparams;
	VAR $drv;
	VAR $connections;
	function __construct($_PARAMS)
	{
		$this->dbparams = $_PARAMS;
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
		if($this->dbparams['family'])
		{
			$drv = $this->use_plugin("drv_mysql",$this->dbparams);
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