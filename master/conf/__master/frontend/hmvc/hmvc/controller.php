<?php 
class HmvcController extends BaseController
{
		
	private function ConnectDBIfExists($cfg)
	{
		GLOBAL $_BASEDIR;
		$conffile=url_seg_add($_BASEDIR,"conf",$cfg,"config.php");
		include $conffile;
		
		if(!empty($_MODULES['db']))	// конфа подключена к базе
		{
			
			$this->connect_db($_MODULES['db']);
			
			return $_MODULES['db'];
		}
		return NULL;
	}
	
	private function getExistingModelInfo($cfg,$triada,$ep="frontend")
	{
		GLOBAL $_BASEDIR;
		$baseinfo_file=url_seg_add($_BASEDIR,"conf",$cfg,$ep,"hmvc",$triada,"baseinfo.php");
		//echo $baseinfo_file;
		if(file_exists($baseinfo_file))
		{
			include $baseinfo_file;
			return $settings;
		}
		
		return NULL;
	}
	
	public function ActionIndex($cfg='main',$ep='frontend')
	{
		$this->_TITLE="HMVC";
		$this->add_css($this->get_current_dir()."/css/style.css");
		
		$this->add_block('BASE_MENU', 'site', 'menu');
		$this->add_keyword('xxx');
		
		$dbparams = $this->ConnectDBIfExists($cfg);
		if($dbparams!=NULL)	// конфа подключена к базе
		{

			$tables = $this->_ENV['_CONNECTION']->get_tables();
			
			$this->out_view('tables',array('tables'=>$tables,'config'=>$cfg));
		}	
		else 
		{
			$this->out_view('index',array());
		}		
		
		
	}
	
	public function ActionFields($cfg='main',$table)
	{
		$dbparams = $this->ConnectDBIfExists($cfg);
		if($dbparams!=NULL)	// конфа подключена к базе
		{		
			$fields = $this->_ENV['_CONNECTION']->get_table_fields($table);
			$this->out_json($fields);
		}
	}
	
	private function SearchViewFld($fieldlist)
	{
		foreach ($fieldlist as $fld => $fldinfo)
		{
			if( ($fldinfo['Type']=='text') || (strstr($fldinfo['Type'],"varchar")!=false) )
			{
				return "{".$fld."}";
			}			
		}
		$primary = $this->_ENV['_CONNECTION']->get_primary($fieldlist);
		return "#{".$primary."}";
	}
		
	public function ActionMake($step='begin')
	{
		$this->add_block('BASE_MENU', 'site', 'menu');

		switch($step){
		case 'begin': {
						$_SESSION['makeinfo']=array();				
						$_SESSION['makeinfo'] = array_merge($_SESSION['makeinfo'],$_POST);
						
						$this->redirect('?r=hmvc/make/binds');
					};break;
		case 'binds': {			
					$dbparams = $this->ConnectDBIfExists($_SESSION['makeinfo']['conf']);
					
					$fields = $this->_ENV['_CONNECTION']->get_table_fields($_SESSION['makeinfo']['table']);
					$tables = $this->_ENV['_CONNECTION']->get_tables();					
					$first_table_fields = $this->_ENV['_CONNECTION']->get_table_fields($tables[0]);
					$this->add_js('#js/constraints.js');
					$settings = $this->getExistingModelInfo($_SESSION['makeinfo']['conf'],$_SESSION['makeinfo']['table']);	
					
					
					if(empty($settings['view']))
					{
						
						$settings['view']=$this->SearchViewFld($fields);
					}
					
					$this->out_view('constraints',array(
							'fields'=>$fields,
							'tables'=>$tables,
							'first_table_fields'=>$first_table_fields,
							'settings'=>$settings,
					));
				};break;
		case 'makefiles': {
					$_SESSION['makeinfo'] = array_merge($_SESSION['makeinfo'],$_POST);
				//	print_r($_SESSION['makeinfo']);
					$this->make_hmvc($_SESSION['makeinfo']);
					unset($_SESSION['makeinfo']);
					echo "MAKE SUCCESSED ";
					
			//		$this->redirect('?r=configs');
				};break;
		}
		/*
		 ALTER TABLE crm_projects 
ADD CONSTRAINT `fk_worker` 
FOREIGN KEY (`creator_id`)
REFERENCES `crm_workers` (`id`)
ON DELETE SET NULL
ON UPDATE SET NULL;
		 * */
	}
	
	
	private function make_hmvc($_params)
	{
		GLOBAL $_BASEDIR;
		$conf_dir= url_seg_add($_BASEDIR,"conf");
		
		$cur_conf_dir = url_seg_add($conf_dir,$_params['conf']);
		if(!file_exists($cur_conf_dir))
			mkdir($cur_conf_dir);
	//	print_r($_params);
		$dbparams = $this->ConnectDBIfExists($_params['conf']);
		//print_r($_params);
		foreach($_params['ep'] as $ep => $offon)
		{
			$hmvc_dir=url_seg_add($conf_dir,$_params['conf'],$ep,'hmvc',$_params['table']);
			//создаем папку триады
			if(!file_exists($hmvc_dir) || !is_dir($hmvc_dir))
			{
				mkdir($hmvc_dir);
			}
			// Контроллер
			$file_controller = url_seg_add( $hmvc_dir,'controller.php'); 
			if(!file_exists($file_controller))
			{
				$vars=array();
				$vars['table_uc_first']=UcaseFirst($_params['table']);
				$vars['TABLE_UC']=strtoupper($_params['table']);
				file_put_contents($file_controller, $this->parse_code_template('controller',$vars));
			}
			// Модель
			$file_model = url_seg_add( $hmvc_dir,'model.php');
			if(!file_exists($file_model))
			{
				$vars=array();
				$vars['table_uc_first']=UcaseFirst($_params['table']);
				$vars['TABLE_UC']=strtoupper($_params['table']);
				file_put_contents($file_model, $this->parse_code_template('model',$vars));
			}
			
			// Файлик
			$file_baseinfo= url_seg_add( $hmvc_dir,'baseinfo.php');			
				
				$vars=array();
				$vars['table']=$_params['table'];
				$tbl_fields = $this->_ENV['_CONNECTION']->get_table_fields($_params['table']);	
				
				//print_r($tbl_fields);
				$fields_code = xx_implode($tbl_fields, ',', "'{idx}'=>array('Type'=>'{Type}','TypeInfo'=>\"{TypeInfo}\")",
						function(&$theval,&$idx,&$thetemplate,&$ctr){
						//	$theval['TypeInfo']=strtr($theval['TypeInfo'],array("'"=>"'"));
						});
				//echo $fields_code;
				
				$vars['array_fields']="array({$fields_code})";				
				$con_str="";
				if(!empty($_params['constraints']))
				{
					foreach ($_params['constraints']['field'] as $idx => $fld)
					{
						$con_str = $con_str."'{$fld}'=>array('model'=>'".$_params['constraints']['table'][$idx]."','fld'=>'".$_params['constraints']['field_to'][$idx]."'),";
					}
				}
				$constraints="";
				
				$vars['array_constraints']="array($con_str)";
				$vars['array_rules']='array()';
				$_primary = $this->_ENV['_CONNECTION']->get_primary($tbl_fields);
				$vars['primary']=$_primary;
				$vars['view']=$_params['view'];
				file_put_contents($file_baseinfo, $this->parse_code_template('baseinfo',$vars));
			
				// make views
				$dir_views = url_seg_add($hmvc_dir,'views');
				//echo $dir_views;
				if(!file_exists($dir_views))
				{
					mkdir($dir_views);
				}
				
				include $file_baseinfo;
				
				$index_view = url_seg_add($dir_views,'index.php');
				if(!file_exists($index_view))
				{
					$vars=array();
					$vars['table'] = $_params['table'];
					$vars['TABLE_UC']=strtoupper($_params['table']);
				//	echo $this->parse_code_template('view_index',$vars);
					file_put_contents($index_view, $this->parse_code_template('view_index',$vars));
				}
				
				$itemform_view = url_seg_add($dir_views,'itemform.php');
				if(!file_exists($itemform_view))
				{
					$vars=array();
					
					$vars['table'] = $_params['table'];
					$vars['TABLE_UC']=strtoupper($_params['table']);
					$vars['fld_primary']=$_primary;
					$vars['fields']=$tbl_fields;
					$vars['settings']=$settings;
					//	echo $this->parse_code_template('view_index',$vars);
					file_put_contents($itemform_view, $this->parse_code_template('view_itemform',$vars));
				}
		}
	}
	
	function get_constraints($table)
	{
		$res = $this->_ENV['_CONNECTION']->query(" SELECT * FROM USER_CONSTRAINTS WHERE TABLE_NAME = \"@+{$table}\"");
		$arr=array();
		while($col = $this->_ENV['_CONNECTION']->get_row($res)){
			//	print_r($col);
			
			$arr[$col['Field']]=$col;
			//print_r($col); print "<br>\n";
		}
		return $arr;
	}
	
	function get_primary($var)
	{
		if(is_string($var))
		{
			$var = get_table_fields($var);
		}
		
		foreach($var as $fld => $fld_info )
		{
			if($fld_info['Key']=="PRI")
			{
				return $fld;
			}
		}
	}
	
	function parse_code_template($tpl,$var_array)
	{
		$tpl_file= url_seg_add(__DIR__,"../../phpt",$tpl).".phpt";
		
		
		foreach ($var_array as $var => $val)
		{
			$$var=$val;
		}
		
		ob_start();
		if(file_exists($tpl_file))
			include $tpl_file;
		$code = ob_get_clean();
		// php tags
		$code = strtr($code,array('<#'=>'<?','#>'=>'?>'));
		
		$var_array2=array();
		foreach ($var_array as $var => $val)
		{
			$var_array2['{'.$var.'}']=$val;
		}
		return strtr($code,$var_array2);
	}
	
}
?>