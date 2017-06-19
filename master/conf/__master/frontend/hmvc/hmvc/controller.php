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
						$sbplugin = use_jq_plugin('structblock',$this);
						$this->_TITLE="Bindings and settings";
						
						if(empty($settings['view']))
						{
							
							$settings['view']=$this->SearchViewFld($fields);
						}
						jq_onready($this,"
								$( document ).ready(function() {
									$('#items_block').jqStructBlock();
									$('#fields_block').jqStructBlock();
								});
								");
					//		print_r($_SESSION);						
						$this->out_view('constraints',array(
								'fields'=>$fields,
								'tables'=>$tables,							
								'first_table_fields'=>$first_table_fields,
								'settings'=>$settings,
								'sbplugin'=>$sbplugin,
						));
					};break;
			case 'makefiles': {
					
						$_SESSION['makeinfo'] = array_merge($_SESSION['makeinfo'],$_POST);
						
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
	
	private function gather_fields_captions($tbl_fields)
	{
		foreach ($tbl_fields as $fld => $fldinfo)
		{
			
		}
	}
	
	private function make_hmvc($_params)
	{
		//print_r($_params['constraints']);
		
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
			if(!file_exists($hmvc_dir))
			{
				x_mkdir($hmvc_dir);
			}
			// Контроллер
			$file_controller = url_seg_add( $hmvc_dir,'controller.php'); 
			if(!file_exists($file_controller) || $_params['rewrite_all'])
			{
				$vars=array();
				$vars['table_uc_first']=UcaseFirst($_params['table']);
				$vars['TABLE_UC']=strtoupper($_params['table']);
				$vars['table'] = $_params['table'];				
				file_put_contents($file_controller, parse_code_template(url_seg_add(__DIR__,'../../phpt/controller.phpt'),$vars));
			}
			// Модель
			$file_model = url_seg_add( $hmvc_dir,'model.php');
			if(!file_exists($file_model) || $_params['rewrite_all'])
			{
				$vars=array();
				$vars['table_uc_first']=UcaseFirst($_params['table']);
				$vars['TABLE_UC']=strtoupper($_params['table']);
				$vars['table'] = $_params['table'];
				file_put_contents($file_model, parse_code_template(url_seg_add(__DIR__,'../../phpt/model.phpt'),$vars));
			}
			
			// Файлик
			$file_baseinfo= url_seg_add( $hmvc_dir,'baseinfo.php');			
				
			$vars=array();
			$vars['table']=$_params['table'];
			$tbl_fields = $this->_ENV['_CONNECTION']->get_table_fields($_params['table']);	
			
			$this->gather_fields_captions($tbl_fields);
				
			$fields_code = xx_implode($tbl_fields, ',', "'{idx}'=>array('Type'=>'{Type}','TypeInfo'=>\"{TypeInfo}\")",
						function(&$theval,&$idx,&$thetemplate,&$ctr,&$thedelimeter){
						//	$theval['TypeInfo']=strtr($theval['TypeInfo'],array("'"=>"'"));
						});
			
			$vars['array_fields']="array({$fields_code})";				
			$con_str="";
			if(!empty($_params['constraints']))
				{
					foreach ($_params['constraints'] as $idx => $binding)
					{						
						$required = ((!empty($binding['required'])) ? true : false);
						$con_str = $con_str."'".$binding['field']."'=>array('model'=>'".$binding['table']."','fld'=>'".$binding['field_to']."','required'=>".json_encode($required)."),";
					}
				}
			$constraints="";
				
			$vars['array_constraints']="array($con_str)";
			$vars['array_rules']='array()';
			$_primary = $this->_ENV['_CONNECTION']->get_primary($tbl_fields);
			$vars['primary']=$_primary;
			$vars['view']=$_params['view'];
			//print_r($_params);
			$vars['required']='array('.xx_implode($_params['model_fields'], ',', "'{name}'",function($theval,&$idx,&$thetemplate,&$ctr,&$thedelimeter)
			{
				if(empty($theval['required']))
				{
					$thetemplate='';
					$thedelimeter='';
				}
			}).')';
			file_put_contents($file_baseinfo, parse_code_template(url_seg_add(__DIR__,'../../phpt/baseinfo.phpt'),$vars));
			
				// make views
			$dir_views = url_seg_add($hmvc_dir,'views');
				//echo $dir_views;
			if(!file_exists($dir_views))
			{
				x_mkdir($dir_views);
			}
				
			include $file_baseinfo;
				
			$index_view = url_seg_add($dir_views,'index.php');
			if(!file_exists($index_view) || $_params['rewrite_all'])
			{
				$vars=array();
				$vars['table'] = $_params['table'];
				$vars['primary']=$_primary;
				$vars['TABLE_UC']=strtoupper($_params['table']);
				//	echo $this->parse_code_template('view_index',$vars);
				file_put_contents($index_view, parse_code_template(url_seg_add(__DIR__,'../../phpt/view_index.phpt'),$vars));
			}
				
			$itemform_view = url_seg_add($dir_views,'itemform.php');
			if(!file_exists($itemform_view) || $_params['rewrite_all'])
			{
				$vars=array();
					
				$vars['table'] = $_params['table'];
				$vars['TABLE_UC']=strtoupper($_params['table']);
				$vars['fld_primary']=$_primary;
				$vars['fields']=$tbl_fields;
				$vars['settings']=$settings;
				$vars['constraints']=$_params['constraints'];
// //	$tpl_file= url_seg_add(__DIR__,"../../phpt",$tpl).".phpt";
				file_put_contents($itemform_view, parse_code_template(url_seg_add(__DIR__,'../../phpt/view_itemform.phpt'),$vars));
			}
			// прокачиваем надписи
			if(!empty($_params['captions'][$ep]))
			{
				$thelang=new Lang(NULL, $_SESSION['makeinfo']['conf'],$ep);
				foreach ($_params['captions'][$ep] as $fld_key => $val)
				{
					$thelang->add_key($fld_key,$val);
				}
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
	
	
	
}
?>