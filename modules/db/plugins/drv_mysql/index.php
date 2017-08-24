<?php

class plg_drv_mysql extends mod_plugin 
{
	use dbDriver;
	VAR $connection;
	VAR $parent_module;
	VAR $_DB_PARAMS;
	VAR $_CONNECTION_EMPTY=FALSE;
	function __construct($_PARAMS)
	{
		if($_PARAMS=='#none')
		{
			$this->_CONNECTION_EMPTY=true;
			return ;
		}
		def_options(['connectable'=>true], $_PARAMS);
		$this->_DB_PARAMS = $_PARAMS;		
	//print_r($_PARAMS);
	//	mysql_ping();
		if($this->_DB_PARAMS['connectable']) 
			$this->connect();		
	}
	
	public function must_connect()
	{
		return $this->_DB_PARAMS['connectable'];	
	}
	
	public function get_db_list()
	{
		$res = $this->query("show databases");
		$res_array=array();
		while($row = $this->get_row($res))
		{
			
		}
		return $res_array;
	}
	
	function connect()
	{
		if($this->_CONNECTION_EMPTY) return ;
		
		$this->connection = @mysql_pconnect($this->_DB_PARAMS['host'], $this->_DB_PARAMS['user'], $this->_DB_PARAMS['passw'],MYSQL_CLIENT_INTERACTIVE);
		if (!($this->connection === false))
		{
			// select database
			if(!empty($this->_DB_PARAMS['dbname']))
			{
				if (mysql_select_db($this->_DB_PARAMS['dbname'], $this->connection) === false)
				{
					echo('Could not select database: ' . mysql_error());
					die();
				}
			}
		}
		else
		{
			echo('Could not connect mysql host: ' . mysql_error());
			die();
		}
		
		mysql_set_charset($this->_DB_PARAMS['charset']);
	}
	
	public function escape_val($value,$type='text')
	{
		return mysql_real_escape_string($value);
	}
	
	public function escape_sql_string($sql_text)
	{
		return mysql_real_escape_string($sql_text);
	}
	
	public function get_tables()
	{
		$sql="SHOW FULL TABLES LIKE '".$this->_DB_PARAMS['prefix']."%'";
		//mul_dbg($sql);
		$res = $this->query($sql);
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
	
	public function Typelist()
	{
		return array('INT','BIGINT','TINYINT','SMALLINT','MEDIUMINT','FLOAT','DOUBLE','DECIMAL', // integer types
				'DATE','DATETIME','TIMESTAMP','TIME','YEAR', // date types
						'CHAR','VARCHAR','TEXT','TINYTEXT','MEDIUMTEXT','LONGTEXT',// text types
				'BLOB','TINYBLOB','MEDIUMBLOB','LONGBLOB',// blob types
				'ENUM','SET' // set types
				
		);
	}
	
	public function class_map()
	{
		return array(
				'int'=>array('INT','BIGINT','TINYINT','SMALLINT','MEDIUMINT'),
				'float'=>array('FLOAT','DOUBLE','DECIMAL','REAL'),
				'datetime'=>array('DATE','DATETIME','TIMESTAMP','TIME','YEAR'),
				'text'=>array('CHAR','VARCHAR','TEXT','TINYTEXT','MEDIUMTEXT','LONGTEXT'),
				'binary'=>array('BLOB','TINYBLOB','MEDIUMBLOB','LONGBLOB'),
				'enums'=>array('ENUM','SET'),
		);
	}
	
	public function GetTypeClass($type)
	{
		$map = $this->class_map();
		$matches=array();
		foreach ($map as $class => $typelist)
		{
			if(in_array(strtoupper($type),$typelist))
			{
				return $class;
			}
		}
		return null;
		//preg_match_all('/(.+)\((.*)\)/Uis', $type,$matches);
		
		//mul_dbg($matches);
		
		//ucwords($type);
	}
	
	public function query($sql)
	{
		$sql = QueryMaker::prepare_query($sql, $this->_DB_PARAMS['prefix']);
		
//		echo ">> $sql >>";
	
		$res = mysql_query($sql);
		if($res===false)
		{
			if($this->error_number()==2006)
			{
				$this->connect();
				$res = mysql_query($sql);
			}
		}
		return $res;
	}
	
	public function error_number()
	{
		return mysql_errno();
	}
	// get new row
	public function get_row($res,$idx=NULL)
	{
		return mysql_fetch_assoc($res);		
	}
	
	public function last_insert_id(){
		return mysql_insert_id($this->connection);
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
	
	function get_enum_field_values($table,$column)
	{
		$result = $this->query("SHOW COLUMNS FROM `@+$table`  LIKE '$column'");
		if ($result)
		{
			$row = $this->get_row($result);
			$option_array = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2", $row['Type']));
			return $option_array;
		}
		return null;
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
	
	// Ìועמהû הכÿ נאבמעû ס ןאנאלוענאלט הנאיגונמג
	public function getModel()
	{
		$drv_base = $this->base_driver_settings();
		$drv_base['fields']['host']=array('Type'=>'text','TypeInfo'=>"20",'defval'=>'localhost');
		$drv_base['fields']['user']=array('Type'=>'text','TypeInfo'=>"20",'defval'=>'root');
		$drv_base['fields']['password']=array('Type'=>'text','TypeInfo'=>"20");
		$drv_base['fields']['dbname']=array('Type'=>'text','TypeInfo'=>"20");
		$drv_base['fields']['prefix']=array('Type'=>'text','TypeInfo'=>"20");
		
		$drv_base['required']= array_merge($drv_base['required'], array('host','user','password','dbname'));
		return $drv_base;
	}
	
	// row count in result
	public function rowcount($res)
	{
		return mysql_num_rows($res);
	}
	
	
}