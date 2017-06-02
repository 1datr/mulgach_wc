<?php
require_once url_seg_add(__DIR__,"query_manager.php");

function get_connection($key=NULL)
{
	$db_module = find_module('db');
	return $db_module->get_drv($key);
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

	function connect()
	{
		if($this->dbparams['family'])
		{
			$drv = $this->use_plugin("drv_mysql",$this->dbparams);
			if(!empty($this->dbparams['dbkey']))
				$this->connections[$this->dbparams['dbkey']]=$drv;
			else
				$this->connections[]=$drv;
		}
	//	$res = mysql_pconnect();
	}
	
	function get_drv($key=NULL)
	{
		if($key==NULL)
		{
			$keys = array_keys($this->connections);
			return $this->connections[$keys[0]];
		}
		return $this->connections[$key];
	}
}