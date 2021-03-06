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
		$con = find_module('mulgach.hmvc')->getController();
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
		
	//	mul_dbg($res_array);
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
	
	public function delete_table($tbl)
	{
		$sql = "DROP TABLE @+$tbl";
	//	mul_dbg($sql);
		$this->query($sql);
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
		
	}
	
	function delete_field($table,$fld)
	{
		$this->query( "ALTER TABLE `@+$table` DROP `$fld`");
		
	}
	
	function add_field($table,$fld,$fld_info)
	{
		$str_default = "";
		if(!empty($fld_info['Default']))
		{
			$str_default = "DEFAULT '".$fld_info['Default']."'";
		}
		
		$str_null = "NULL";
		
		if($fld_info['Null'])
			$str_null = "NOT NULL";
		
		if($fld_info['TypeInfo']=='()')
			$fld_info['TypeInfo']='';
		
		$type_str = $fld_info['Type'].''.$fld_info['TypeInfo'].'';
		//ALTER TABLE `dbx_attachement` CHANGE `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT;
		$_OPTIONS='';
		/*if(isset($fld_info['autoincrement']))
		{
			$_OPTIONS=$_OPTIONS." AUTO_INCREMENT";
		}*/
		$_sql = "ALTER TABLE `@+".$table."` ADD `$fld` $type_str $str_null $str_default $_OPTIONS AFTER `".$fld_info['fldafter']."`";
	//	mul_dbg($_sql);
		
		
		$this->query($_sql);
		//$this->query( "ALTER TABLE `@+".$table."` ADD `$fld` $type_str $str_null DEFAULT $str_default AFTER `".$fld_info['fldafter']."`");
		// ALTER TABLE `test_zoo` CHANGE `name` `name` TEXT NULL DEFAULT NULL;
	}
	
	function change_field($table,$fld,$fld_info)
	{
		$str_default = "NULL";
		if(!empty($fld_info['Default']))
			$str_default = "'".$fld_info['Default']."'";
		
		$str_null = "NULL";
		if($fld_info['Null'])
			$str_null = "NOT NULL";
		
		$type_str = $fld_info['Type'].''.$fld_info['TypeInfo'].'';
			
		//$this->query("ALTER TABLE `@+$table` CHANGE `".$fld_info['fldname_old']."` `$fld` ".$type_str." $str_null DEFAULT $str_default");
		$after = "";
		if(!empty($fld_info['after'])) 
			$after = "AFTER ".$fld_info['after'];
		
		$a_i='';
		if($fld_info['autoincrement'])
		{
			$a_i="AUTO_INCREMENT";
		}
			
		$_sql = "ALTER TABLE `@+$table` CHANGE `".$fld_info['fldname_old']."` `$fld` ".$type_str." $a_i $str_null DEFAULT $str_default $after";
		$this->query($_sql);
	}
	
	function build_table($table_info)
	{
		function compare_field_settings($fld_existing,$fldinfo)
		{
			$res = ($fld_existing['Type']==$fldinfo['Type']);
			
			if(!$res) return false;
			
			if($fld_existing['after']!=$fldinfo['after'])
				return false;
			
			// default
			if(empty($fldinfo['Default'])&& empty($fld_existing['Default']))
			{
				$res = true;	
			}
			elseif($fldinfo['Default']===$fld_existing['Default'])
			{
				$res = true; 
			}
			else 
				$res = false;
			
			if(!$res) return false;
			
			// null
			$_existing_fld_null = false;
			
			$_existing_fld_null = ($fld_existing['Null']!="NO");
			
			$res = (!($fldinfo['Null'] && $_existing_fld_null));
			if(!$res) return false;
			
			return $res;
		}
		
		$change_name = false;
		
		if( !empty($table_info['oldname']) )
		{
			if($table_info['oldname']!=$table_info['table'])
			{
				$change_name = true;
			}
		}
		
		if($change_name)
		{
			if(!$this->table_exists($table_info['table']))
			{
				$this->rename_table($table_info['oldname'],$table_info['table']);
				$this->change_table($table_info);
			}
			else 
			{
				// Error table with this name alleready exists
			}
		}
		else 
		{
			if(!$this->table_exists($table_info['table']))
			{
				$this->create_table($table_info);
			}
			else
			{
				$this->change_table($table_info);
					
			}
		}
		//mul_dbg($table_info);
		
		$this->create_table($table_info);
	}
	
	public function rename_table($old_table_name,$new_table_name)
	{
		$sql = "RENAME TABLE @+$old_table_name TO @+$new_table_name";
		$this->query($sql);
	}
	
	private function change_table($table_info)
	{
		$exist_table_info = $this->get_table_fields($table_info['table']);
		// ��������� � ������ �����
		$fldold=null;
		foreach ($table_info['fields'] as $fld => $finfo)
		{
			if(isset($exist_table_info[$fld]))
			{
				$finfo['after']=$fldold;
				if(!compare_field_settings($exist_table_info[$fld],$finfo))
				{
					$this->change_field($table_info['table'],$fld,$finfo);
				}
			}
			else
			{
				$finfo['fldafter']=$fldold;
				$this->add_field($table_info['table'],$fld,$finfo);
			}
				
			$fldold = $fld;
		}
						
		$exist_table_info = $this->get_table_fields($table_info['table']);
		// ������� ����� ������� ���
		foreach ($exist_table_info as $fld => $finfo )
		{
			if(!isset($table_info['fields'][$fld]))
			{
				$this->delete_field($table_info['table'],$fld);
			}
		
		}
		
		$current_primary = $this->get_primary($table_info['table']);
		if($current_primary!=$table_info['primary'])
		{
			$this->alter_primary($table_info['table'], $table_info['primary'],$table_info['fields'][$table_info['primary']],$current_primary);
		}
		
		// ALTER TABLE provider DROP PRIMARY KEY, ADD PRIMARY KEY(person, place, thing);
	}
	
	private function alter_primary($table,$pk,$fld_info,$existing_pk=null)
	{
		if($existing_pk!=null)
		{
			$sql = "ALTER TABLE `@+$table` DROP PRIMARY KEY";
			$this->query($sql);
		}
		
		//ALTER TABLE `dbx_attachement` CHANGE `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT;
		
		$sql = "ALTER TABLE `@+$table` ADD PRIMARY KEY(`{$pk}`)";
		$this->query($sql);
		
		$str_null = "NULL";
		if($fld_info['Null'])
			$str_null = "NOT NULL";
		
		if($fld_info['TypeInfo']=='()')
			$fld_info['TypeInfo']='';
		$type_str = $fld_info['Type'].''.$fld_info['TypeInfo'].'';
				
			//$this->query("ALTER TABLE `@+$table` CHANGE `".$fld_info['fldname_old']."` `$fld` ".$type_str." $str_null DEFAULT $str_default");
		$after = "";
		if(!empty($fld_info['after']))
			$after = "AFTER ".$fld_info['after'];
		
		$a_i='';
		if($fld_info['autoincrement'])
		{
			$a_i="AUTO_INCREMENT";
		}
		
		
		$_sql = "ALTER TABLE `@+$table` CHANGE `$pk` `$pk` ".$type_str." $a_i";
		$this->query($_sql);
		//$this->change_field($table,$pk,$fld_info);
		
		/*$fields = $this->get_table_fields($table);
		 
		$sql = "ALTER TABLE `@+$table` MODIFY COLUMN {$pk} $_TYPE auto_increment";*/
		
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
					$theval['Type']=$theval['Type']."".$theval['TypeInfo']."";
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
		$type = get_by_key_case_no_sensitive($data,'type');
		
		$typeinfo = get_by_key_case_no_sensitive($data,'typeinfo');
		
		if(($this->GetTypeClass($type)=='int')||($type=='varchar'))
		{
			return "(".$typeinfo['size'].")";
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
		$types = array('INT','BIGINT','TINYINT','SMALLINT','MEDIUMINT','FLOAT','DOUBLE','DECIMAL', // integer types
				'DATE','DATETIME','TIMESTAMP','TIME','YEAR', // date types
						'CHAR','VARCHAR','TEXT','TINYTEXT','MEDIUMTEXT','LONGTEXT',// text types
				'BLOB','TINYBLOB','MEDIUMBLOB','LONGBLOB',// blob types
				'ENUM','SET' // set types
				
		);
		
		foreach($types as $idx => $val)
		{
			$types[$idx]=strtolower($val);
		}
		
		return $types;
	}
	
	public function class_map()
	{
		$map = array(
				'int'=>array('INT','BIGINT','TINYINT','SMALLINT','MEDIUMINT'),
				'float'=>array('FLOAT','DOUBLE','DECIMAL','REAL'),
				'datetime'=>array('DATE','DATETIME','TIMESTAMP','TIME','YEAR'),
				'text'=>array('CHAR','VARCHAR','TEXT','TINYTEXT','MEDIUMTEXT','LONGTEXT'),
				'binary'=>array('BLOB','TINYBLOB','MEDIUMBLOB','LONGBLOB'),
				'enums'=>array('ENUM','SET'),
		);
		
		foreach($map as $key => $submap)
		{
			foreach ($submap as $idx => $val)
			{
				$map[$key][$idx]=strtolower($val);
			}
		}
		
		return $map;
	}
	
	public function get_basic_type($type_class)	// �������� ��� ���� �� ������
	{
		switch ($type_class)
		{
			case 'int': return 'bigint';break;
			case 'text': return 'text';break;
			case 'datetime': return 'datetime';break;
			case 'float': return 'double';break;
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
			if(in_array(strtolower($type),$typelist))
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
		$fld_old = null;
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
				
			}
			$col['after']=$fld_old;
			$fld_old = $Field;
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
	// ������ ��� ������ � ����������� ���������
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
		$cntrlr = find_module('mulgach.hmvc')->getController();
		use_jq_plugin_x('__ui',$cntrlr,'jquery.ui');
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