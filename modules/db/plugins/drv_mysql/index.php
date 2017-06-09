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
	//print_r($_PARAMS);
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
	
	public function get_tables()
	{
		$res = $this->query("SHOW FULL TABLES");
		$arr=array();
		while($row = $this->get_row($res))
		{
			$keys = array_keys($row);
			$tablename = $row[$keys[0]];
			$tablename = substr($tablename,strlen($this->_DB_PARAMS['prefix']));
			$arr[]= $tablename;
		}
		return $arr;
	}
	
	public function query($sql)
	{
		$sql = QueryMaker::prepare_query($sql, $this->_DB_PARAMS['prefix']);
		
//		echo ">> $sql >>";
	
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
	
	public function get_table_fields($tbl)
	{
		$res = $this->query("SHOW FULL COLUMNS FROM `@+{$tbl}`");
		$arr=array();
		while($col = $this->get_row($res)){
			//	print_r($col);
			$Field = $col['Field'];
		//	unset($col['Field']);
			
			$matches = array();
			$col['TypeInfo']=NULL;
			if(preg_match_all('/(.+)\((.+)\)/Uis', $col['Type'],$matches))
			{
				//print_r($matches);
				$col['Type']=$matches[1][0];
				$col['TypeInfo']=$matches[2][0];
				/*
				try
				{
					$intval = (int)$col['TypeInfo'];
					$col['TypeInfo']=$intval;
				}
				catch (Exception $ex){}
				*/
				
			}
			
			$arr[$Field]=$col;			
			//print_r($col); print "<br>\n";
		}
		return $arr;
	}
	
	public function get_primary($var)
	{
		if(is_string($var))
		{
			$var = $this->get_table_fields($var);
		}
	
		foreach($var as $fld => $fld_info )
		{
			if($fld_info['Key']=="PRI")
			{
				return $fld;
			}
		}
	}
	
	public function get_constraints($table)
	{
		
	}
	
	// row count in result
	public function rowcount($res)
	{
		return mysql_num_rows($res);
	}
}