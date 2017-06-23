<?php 
class HmvcController extends BaseController
{
	public function Rules()
	{
		return array(
				'action_access'=>array(
						new ActionAccessRule('deny',$this->getActions(),'anonym','?r=site/login')
				),
		);
	}
	private function ConnectDBIfExists($cfg)
	{
		GLOBAL $_BASEDIR;
		try
		{
			$conffile=url_seg_add($_BASEDIR,"conf",$cfg,"config.php");
			include $conffile;
			
			if(!empty($_MODULES['db']))	// конфа подключена к базе
			{
				
				$this->connect_db($_MODULES['db']);
				
				return $_MODULES['db'];
			}
			return NULL;
		}
		catch (Exception $exc)
		{
			echo "<h4>This configuration does not exists</h4>";
			//die();
		}
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
		
		$sbplugin = use_jq_plugin('structblock',$this);
		
		$dbparams = $this->ConnectDBIfExists($cfg);
		if($dbparams!=NULL)	// конфа подключена к базе
		{

			$tables = $this->_ENV['_CONNECTION']->get_tables();
			
			
			
			$this->out_view('tables',array('tables'=>$tables,'config'=>$cfg,'sbplugin'=>$sbplugin));
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
	
	public function ActionMakepure()
	{
		if(!empty($_POST['triada']))
		{
			GLOBAL $_BASEDIR;
			$cur_conf_dir=$opts['cur_conf_dir'];
			$conf_dir= url_seg_add($_BASEDIR,"conf");
			
			foreach ($_POST['ep'] as $ep => $val)
			{			
				
				$hmvc_dir=url_seg_add($conf_dir,$_POST['conf'],$ep,'hmvc',$_POST['triada']);
				//echo $hmvc_dir;
				//создаем папку триады
				if(!file_exists($hmvc_dir))
				{
					x_mkdir($hmvc_dir);
					echo "<p>".$hmvc_dir." created</p>";
				}
				
				$code = parse_code_template(
							url_seg_add(__DIR__,'../../phpt/customcontroller.phpt'), 
							array(
								'triada'=>$_POST['triada'],
								'actions'=>$_POST['actions'],
								));
				$the_file = url_seg_add($hmvc_dir,'controller.php');
				
				foreach ($_POST['actions'] as $act)
				{
					if(!empty($act['automakeview']))
					{
						$the_view = url_seg_add($hmvc_dir,'views',$act['name'].".php");
						if(!empty($_POST['rewrite_all']) || !file_exists($the_view) )
						{
							echo "<p>$the_view rewrited</p>";
							x_file_put_contents($the_view, '');
						}
					}	
				}
				
				if(!empty($_POST['rewrite_all']) || !file_exists($the_file) )
				{
					echo "<p>$the_file rewrited</p>"; 
					x_file_put_contents($the_file, $code);
				}
				
				if(!empty($_POST['actions']))
				{
					
				}
			}
		}
		//$this->add_block('BASE_MENU', 'site', 'menu');
		$this->redirect_back();
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

		//print_r($step);
		
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
						
						$eps=array('frontend','backend');
						$triads=array();
						foreach ($eps as $ep)
						{
							GLOBAL $_BASEDIR;
							$conf_dir= url_seg_add($_BASEDIR,"conf");						
							$hmvcs_dir=url_seg_add($conf_dir,$_SESSION['makeinfo']['conf'],$ep,'hmvc');
							$hmvcs = get_files_in_folder($hmvcs_dir,array('dirs'=>true,'basename'=>true));
							$triads[$ep]=$hmvcs;
							//print_r($files);
						}
//						get_files_in_folder($dir_path);
						//$triads 
						
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
								'triads'=>$triads,
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
	
	public function ActionGenemptycon()
	{
	
	}
	
	private function make_mvc_frontend($_params,$opts)
	{
		GLOBAL $_BASEDIR;
		
		$conf_dir=$opts['conf_dir'];
		$cur_conf_dir=$opts['cur_conf_dir'];
		
		$ep='frontend';
		$hmvc_dir=url_seg_add($conf_dir,$_params['conf'],$ep,'hmvc',$_params['table']);
		//создаем папку триады
		if(!file_exists($hmvc_dir))
		{
			x_mkdir($hmvc_dir);
		}
		
		// коды для меню
		$menu_site_codes=array('menu_method'=>'','menu_block_use'=>'');
		if(!empty($_params['mainmenu']['frontend']))
		{
			$vars_menu=array();
			$menu_site_codes['menu_method']=parse_code_template(url_seg_add(__DIR__,'../../phpt/backend/sitemenu.phpt'),$vars_menu);
				
			$menu_site_codes['menu_block_use'] = '$this->add_block("BASE_MENU", "'.$_params["table"].'", "menu");';
				
			$menu_info_file = parse_code_template(url_seg_add(__DIR__,'../../phpt/backend/menu.phpt'),array());
			x_file_put_contents(url_seg_add($hmvc_dir,'views/menu.php'), $menu_info_file);
				
			$menu_info_file = url_seg_add($hmvc_dir,'../../info/basemenu.php');
			x_file_put_contents($menu_info_file,
					parse_code_template(url_seg_add(__DIR__,'../../phpt/backend/basemenu.phpt'),array('tables'=>$this->_ENV['_CONNECTION']->get_tables()))
					);
		}
		else
		{
			$menu_site_codes['menu_block_use'] = '$this->add_block("BASE_MENU", "'.$_params['connect_from']['frontend'].'", "menu");';
		}
		
		// Контроллер
		$file_controller = url_seg_add( $hmvc_dir,'controller.php');
		if(!file_exists($file_controller) || $_params['rewrite_all'])
		{
			$vars=array();
			$vars['table_uc_first']=UcaseFirst($_params['table']);
			$vars['TABLE_UC']=strtoupper($_params['table']);
			$vars['table'] = $_params['table'];
			$vars['OTHER_METHODS']='';
			$vars['menu_block_use']=$menu_site_codes['menu_block_use'];
			$vars['ParentControllerClass']='BaseController';
			if($_params['authcon']['frontend'])	$vars['ParentControllerClass']='AuthController';
			x_file_put_contents($file_controller, parse_code_template(url_seg_add(__DIR__,'../../phpt/controller.phpt'),$vars));
		}
		// Модель
		$file_model = url_seg_add( $hmvc_dir,'model.php');
		if(!file_exists($file_model) || $_params['rewrite_all'])
		{
			$vars=array();
			$vars['table_uc_first']=UcaseFirst($_params['table']);
			$vars['TABLE_UC']=strtoupper($_params['table']);
			$vars['table'] = $_params['table'];
			x_file_put_contents($file_model, parse_code_template(url_seg_add(__DIR__,'../../phpt/model.phpt'),$vars));
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
		x_file_put_contents($file_baseinfo, parse_code_template(url_seg_add(__DIR__,'../../phpt/baseinfo.phpt'),$vars));
			
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
			x_file_put_contents($index_view, parse_code_template(url_seg_add(__DIR__,'../../phpt/view_index.phpt'),$vars));
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
			x_file_put_contents($itemform_view, parse_code_template(url_seg_add(__DIR__,'../../phpt/view_itemform.phpt'),$vars));
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
	
	private function make_mvc_backend($_params,$opts)
	{
		GLOBAL $_BASEDIR;
		
		$conf_dir=$opts['conf_dir'];
		$cur_conf_dir=$opts['cur_conf_dir'];
		
		$ep='backend';
		$hmvc_dir=url_seg_add($conf_dir,$_params['conf'],$ep,'hmvc',$_params['table']);
		//создаем папку триады
		if(!file_exists($hmvc_dir))
		{
			x_mkdir($hmvc_dir);
		}
		// коды для меню 
		$menu_site_codes=array('menu_method'=>'','menu_block_use'=>'');
		if(!empty($_params['mainmenu']['backend']))
		{
			$vars_menu=array();
			$menu_site_codes['menu_method']=parse_code_template(url_seg_add(__DIR__,'../../phpt/backend/sitemenu.phpt'),$vars_menu);
			
			$menu_site_codes['menu_block_use'] = '$this->add_block("BASE_MENU", "'.$_params["table"].'", "menu");';
			
			$menu_info_file = parse_code_template(url_seg_add(__DIR__,'../../phpt/backend/menu.phpt'),array());
			x_file_put_contents(url_seg_add($hmvc_dir,'views/menu.php'), $menu_info_file);
			
			$menu_info_file = url_seg_add($hmvc_dir,'../../info/basemenu.php');
			x_file_put_contents($menu_info_file, 
						parse_code_template(url_seg_add(__DIR__,'../../phpt/backend/basemenu.phpt'),array('tables'=>$this->_ENV['_CONNECTION']->get_tables()))
					);
		}
		else 
		{
			$menu_site_codes['menu_block_use'] = '$this->add_block("BASE_MENU", "'.$_params['connect_from']['backend'].'", "menu");';
		}
		
		// Контроллер
		$file_controller = url_seg_add( $hmvc_dir,'controller.php');
		if(!file_exists($file_controller) || $_params['rewrite_all'])
		{
			$vars=array();
			$vars['table_uc_first']=UcaseFirst($_params['table']);
			$vars['TABLE_UC']=strtoupper($_params['table']);
			$vars['table'] = $_params['table'];			
			$vars['OTHER_METHODS']=$menu_site_codes['menu_method'];
			$vars['menu_block_use']=$menu_site_codes['menu_block_use'];
			$vars['ParentControllerClass']='BaseController';
			if($_params['authcon']['backend'])	$vars['ParentControllerClass']='AuthController';
			x_file_put_contents($file_controller, parse_code_template(url_seg_add(__DIR__,'../../phpt/controller.phpt'),$vars));
		}
		// Модель
		$file_model = url_seg_add( $hmvc_dir,'model.php');
		if(!file_exists($file_model) || $_params['rewrite_all'])
		{
			$vars=array();
			$vars['table_uc_first']=UcaseFirst($_params['table']);
			$vars['TABLE_UC']=strtoupper($_params['table']);
			$vars['table'] = $_params['table'];
			x_file_put_contents($file_model, parse_code_template(url_seg_add(__DIR__,'../../phpt/model.phpt'),$vars));
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
		x_file_put_contents($file_baseinfo, parse_code_template(url_seg_add(__DIR__,'../../phpt/baseinfo.phpt'),$vars));
			
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
			x_file_put_contents($index_view, parse_code_template(url_seg_add(__DIR__,'../../phpt/view_index.phpt'),$vars));
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
			x_file_put_contents($itemform_view, parse_code_template(url_seg_add(__DIR__,'../../phpt/view_itemform.phpt'),$vars));
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
		if(!empty($_params['ep']['frontend']))
		{
			$this->make_mvc_frontend($_params,array('conf_dir'=>$conf_dir,'cur_conf_dir'=>$cur_conf_dir));
		}
		
		if(!empty($_params['ep']['backend']))
		{
			$this->make_mvc_backend($_params,array('conf_dir'=>$conf_dir,'cur_conf_dir'=>$cur_conf_dir));
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