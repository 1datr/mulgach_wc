<?php

class plg_drv_mysql extends mod_plugin 
{
	use dbDriver;
	VAR $connection;
	VAR $parent_module;
	VAR $_DB_PARAMS;
	function __construct($_PARAMS)
	{
		$this->_DB_PARAMS = $_PARAMS;
	//	print_r($_PARAMS);
		$this->connection = mysql_pconnect($_PARAMS['host'], $_PARAMS['user'], $_PARAMS['passw']);
		if (!($this->connection === false))
		{
			// select database
			if (mysql_select_db($_PARAMS['dbname'], $this->connection) === false)
			{
				echo('Could not select database: ' . mysql_error());
				die();
			}
		}
		else
		{
			echo('Could not connect mysql host: ' . mysql_error());
			die();
		}  
		//print_r($_PARAMS);
		
		mysql_query("SET SESSION character_set_results = '".$_PARAMS['charset']."'");
		mysql_set_charset($_PARAMS['charset']);
		
	}
	
	public function query($sql)
	{
		$sql = QueryMaker::prepare_query($sql, $this->_DB_PARAMS['prefix']);
	//	var_dump($sql);
		$res = mysql_query($sql);
		return $res;
	}
	// get new row
	public function get_row($res,$idx=NULL)
	{
		return mysql_fetch_assoc($res);		
	}
	
	public function list_rows($res,$function_on_row)
	{
		$rownumber = 0;
		while($row = $this->get_row($res))
		{
			$function_on_row($row,$rownumber);
			$rownumber++;
		}
	}
	
	// row count in result
	public function rowcount($res)
	{
		return mysql_num_rows($res);
	}
}