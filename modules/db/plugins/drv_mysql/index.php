<?php

class plg_drv_mysql extends mod_plugin 
{
	use dbDriver;
	VAR $connection;
	VAR $_controller;
	VAR $parent_module;
	VAR $_DB_PARAMS;
	VAR $_CONNECTION_EMPTY=FALSE;
	function __construct($_PARAMS)
	{
		if($_PARAMS==='#none')
			$_PARAMS=array();
		
		if(count($_PARAMS)==0)
		{
			$this->_CONNECTION_EMPTY=true;
			return ;
		}
		def_options(['connectable'=>true], $_PARAMS);
		$this->_DB_PARAMS = $_PARAMS;		
	//print_r($_PARAMS);
	//	mysql_ping();
		$con = find_module('page')->getController();
		if($con!=NULL)
			$con->add_js( filepath2url(url_seg_add(__DIR__,'js/dbutils.js')) );
		
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
	
	public function SrvDblist()
	{
		//mul_dbg($_POST);
		
		$this->_DB_PARAMS=$_POST['dbinfo'];
		$dbname = $this->_DB_PARAMS['dbname'];
		$this->_DB_PARAMS['dbname']=NULL;
		$this->_CONNECTION_EMPTY=false;
		$this->connect(false);
		
		$str_query = "show databases where `Database` like '%".$_GET['term']."%'";
		$res = $this->query($str_query);
		
	//	mul_dbg($str_query);
		
		$res_array=array();
		while($row = $this->get_row($res))
		{
			
			
			$res_array[]=$row[ array_keys($row)[0] ];	
		}
		
		mul_dbg($res_array);
		echo json_encode($res_array);
	}
	
	public function dbconfig_code($_params)
	{
		$str="<?php 
		\$dbparams = array(
			'driver'=>'mysql',
			'host'=>'".$_params['host']."',
			'user'=>'".$_params['user']."',
			'password'=>'".$_params['password']."',
			'dbname'=>'".$_params['dbname']."',
			'prefix'=>'".$_params['prefix']."',
			'charset'=>'cp1251_general_ci',
			'dbkey'=>'main',
);
?>";
		return $str;
	}
	
	function test_conn($conn_params)
	{
		$conn = @mysql_pconnect($conn_params['host'], $conn_params['user'], $conn_params['password'],MYSQL_CLIENT_INTERACTIVE);
		$res_arr=array();
		if(!($conn === false))		
		{
			if(!empty($conn_params['dbname']))
			{
				if(mysql_select_db($conn_params['dbname'], $conn) === false)
				{
					$res_arr['database'] = mysql_error().". ".\Lang::__t('Create this database?');
					return $res_arr;
				}
				return true;
			}
		}
		else 
			$res_arr['server'] = mysql_error();
		
		if(count($res_arr)>0)
			return $res_arr;
			
		return true;
	}
	
	function connect($die=true)
	{
		if($this->_CONNECTION_EMPTY) return ;
		
		$this->connection = @mysql_pconnect($this->_DB_PARAMS['host'], $this->_DB_PARAMS['user'], $this->_DB_PARAMS['password'],MYSQL_CLIENT_INTERACTIVE);
		if (!($this->connection === false))
		{
			// select database
			if(!empty($this->_DB_PARAMS['dbname']))
			{
				if (mysql_select_db($this->_DB_PARAMS['dbname'], $this->connection) === false)
				{
					if($die)
					{
						echo('Could not select database: ' . mysql_error());
						die();
					}
				}
			}
		}
		else
		{
			if($die)
			{
				echo('Could not connect mysql host: ' . mysql_error());
				die();
			}
		}
		
		@mysql_set_charset($this->_DB_PARAMS['charset']);
	}
	
	public function create_db($db_name)
	{
		$sql = QueryMaker::query_makedb($db_name);		
		return $this->query($sql);
	}
	
	public function table_exists($tablename)
	{
		$sql="SHOW FULL TABLES LIKE '".$this->_DB_PARAMS['prefix']."$tablename'";
		//mul_dbg($sql);
		$res = $this->query($sql);
		if($this->rowcount($res)>0) 
			return true;
		return false;
	}
	
	public function make_table($table_info)
	{
		if(!$this->table_exists($table_info['table']))
		{
			$this->create_table($table_info);
		}
		else 
		{
			$tinfo = get_table_fields($table_info['table']);
		}
	}
	
	public function create_table($table_info)
	{
		// DROP TABLE IF EXISTS `@+{table}`
		$sql = "CREATE TABLE `@+".$table_info['table']."` ";
		$table_fields = $table_info['fields'];
		$str_fields = xx_implode($table_fields, ',', '`{idx}` {Type}',function(&$theval,&$idx,&$thetemplate,&$ctr,$thedelimeter) use($table_info)
			{
				if(in_array($idx,$table_info['required']) || ($table_info['primary']==$idx) )				
					$thetemplate=$thetemplate." not null";
				else 
					$thetemplate=$thetemplate." null";
				
				// 					
				if( !in_array($this->GetTypeClass($theval['Type']),['text','datetime','binary'] ))
				{
					$theval['Type']=$theval['Type']."(".$theval['TypeInfo'].")";
				}				
					
				//	
				if($table_info['primary']==$idx)
				{
					$thetemplate=$thetemplate." PRIMARY KEY";
				//	mul_dbg($table_fields);
					if(!eql_ife($table_fields, 'not_a_i', true))
					{
						$thetemplate=$thetemplate." AUTO_INCREMENT";
					}
				}
			}
		);
		$sql = $sql."( $str_fields )";
		
		//mul_dbg($sql);
		
		return $this->query($sql);
	}
	
	public function type_model($_type)
	{
		//mul_dbg($this->GetTypeClass($_type));
		if($this->GetTypeClass($_type)=='enums')
		{
			return new ModelInfo([
					'domen'=>'finfo',
					'fields'=>[
						'valueset'=>new ModelInfo(
						[
							'domen'=>'valueset',
							'fields'=>['Type'=>'text']				
						]),
					]
			]);
		}
		else 
		{
			return new ModelInfo([
					'domen'=>'finfo',
					'fields'=>[
						'size'=>['Type'=>'int','defval'=>20],
					]
			]);
		}
	}
	
	public function make_fld_info_from_data($data)
	{
		if($this->GetTypeClass($data['type'])=='int')
		{
			return "".$data['typeinfo']['size']."";
		}
		return "";
	}
	
	public function SrvMakedb($params=[])
	{
		//mul_dbg($_POST);
		$this->_DB_PARAMS=$_POST['dbinfo'];
		$dbname = $this->_DB_PARAMS['dbname'];
		$this->_DB_PARAMS['dbname']=NULL;		
		$this->_CONNECTION_EMPTY=false;
		$this->connect(false);
		$res = $this->create_db($dbname);
		
		$arr_result=array('success'=>true);
		
		if($res===false)
		{
			$arr_result['success']=false;
			$arr_result['message']="Error #".$this->error_number()." ".$this->error_text();
		}	
		
		echo json_encode($arr_result);
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
	
	public function get_basic_type($type_class)	// основной тип поля по классу
	{
		switch ($type_class)
		{
			case 'int': return 'BIGINT';break;
			case 'text': return 'TEXT';break;
			case 'datetime': return 'DATETIME';break;
			case 'float': return 'DOUBLE';break;
		}
		$cmap = $this->class_map();
		if(!isset($cmap[$type_class]))
			return null;
		return $cmap[$type_class][0]; 
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
	
		$res = @mysql_query($sql);
		if($res===false)
		{
			if($this->error_number()==2006)
			{
				$this->connect();
				$res = @mysql_query($sql);
				if($res===false)
					return false;
			}
		}
		return $res;
	}
	
	public function error_number()
	{
		return mysql_errno();
	}
	
	public function error_text()
	{
		return mysql_error();
	}
	// get new row
	public function get_row($res,$idx=NULL)
	{
		if($idx==NULL)
			return mysql_fetch_assoc($res);
		else 
			return mysql_result($res,$idx); 
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
	
	private function OK_button_code()
	{
		$str = '&nbsp;<button class="btn btn-sm btn-xs" onclick="make_db(this);return false;">'.\Lang::__t('OK').'</button>';
		return $str;
	}
	// Методы для работы с параметрами драйверов
	public function getModel($params=[])
	{
		$drv_base = $this->base_driver_settings($params);
		$drv_base['fields']['host']=array('Type'=>'text','TypeInfo'=>"20",'defval'=>'localhost');
		$drv_base['fields']['user']=array('Type'=>'text','TypeInfo'=>"20",'defval'=>'root');
		$drv_base['fields']['password']=array('Type'=>'text','TypeInfo'=>"20",'password'=>true);
		// index.php?srv=db.drv_mysql.dblist&term=i
		$drv_base['fields']['dbname']=array('Type'=>'text','TypeInfo'=>"20",
				'fldparams'=>[
						//index.php?srv=db.drv_mysql.dblist
						/*
						 $('#acInput').autocomplete({
                source: flowers
            })
						 * */
						'htmlattrs'=>['id'=>'dbname']
						]);
		$cntrlr = find_module('page')->getController();
		use_jq_plugin('__ui',$cntrlr);
		$cntrlr->inline_script("
\$('#dbname').on('input', function () {
    var term = \$(this).val();
    var db_list_url = '/index.php?srv=db.drv_mysql.dblist&term='+term;
	the_form = \$(this).parents('form');
	the_data=new FormData(the_form[0]);
	\$.ajax({
        url: db_list_url,
        type: 'POST',
        data: the_data,
        mimeType:'multipart/form-data',
        contentType: false,
        cache: false,
        processData:false,
        dataType: 'json',
		success: function(data, textStatus, jqXHR)
	    {	    
			$('#dbname').autocomplete({
                source: data,
            })
	    //	console.log(data);	
	    },
		error: function(jqXHR, textStatus, errorThrown) 
	    {	    	
	    //	console.log(jqXHR);	    	
	    },
	});
});");
		// $('#dbname').autocomplete({ source: '/index.php?srv=db.drv_mysql.dblist' });
		$drv_base['fields']['prefix']=array('Type'=>'text','TypeInfo'=>"20");
		
		$drv_base['required']= array_merge($drv_base['required'], array('host','user','dbname'));
		
		$drv_base['validate_proc']=function($row,&$res)
		{
			$module_db = find_module('db');
			$plg="drv_".$row['driver'];
			if($module_db!=NULL)
			{
				$plg = $module_db->use_plugin($plg,['connectable'=>false]);
				$test_res = $plg->test_conn($row);
			}

			if($test_res!==true)
			{	
				if(isset($test_res['server']))	
				{
					$test_res_str = $test_res['server'];					
				}
				if(isset($test_res['database']))
				{
					$test_res_str = $test_res['database'];
					$test_res_str = $test_res_str.$this->OK_button_code();
				}
				$res['dbinfo[dbname]']=$test_res_str;
			}
		};
		return $drv_base;
	}
	
	function add_js_css($controller_obj)
	{
		$js_files = $this->js_files();
		foreach ($js_files as $str_js)
		{
			$controller_obj->add_js($str_js);
		}
	
		$css_files = $this->css_files();
		foreach ($css_files as $str_css)
		{
			$controller_obj->add_css($str_css);
		}
	}
	
	function js_files()
	{
		$js_array=array();
		GLOBAL $_BASEDIR;
		$js_files = get_files_in_folder( url_seg_add(__DIR__,'js') );
			
		//echo $_SERVER['DOCUMENT_ROOT'];
		foreach ($js_files as $js_script)
		{
			//echo $js_script;
			$str_js = filepath2url($js_script);
			$js_array[] = $str_js;
		}
		return $js_array;
	}
	
	function css_files()
	{
		$css_array=array();
		GLOBAL $_BASEDIR;
		$css_files = get_files_in_folder( url_seg_add(__DIR__,'css') );
			
		//echo $_SERVER['DOCUMENT_ROOT'];
		foreach ($css_files as $css_file)
		{
			//echo $js_script;
			$str_css = filepath2url($css_file);
			$css_array[] = $str_css;
		}
		return $css_array;
	}
	
	// row count in result
	public function rowcount($res)
	{
		return mysql_num_rows($res);
	}
	
	
}