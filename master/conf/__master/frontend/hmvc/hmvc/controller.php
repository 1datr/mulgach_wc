<?php 
class HmvcController extends BaseController
{
	public function Rules()
	{
		return array(
				'action_access'=>array(
						new ActionAccessRule('deny',$this->getActions(),'anonym','site/login')
				),
		);
	}
		
	public function ActionIndex($cfg=NULL,$ep='frontend')
	{
		if($cfg==NULL)
		{
			
			$cfg= $this->getCurrCFG();
		}
		
		$this->_TITLE="HMVC {$cfg}";
		$this->add_css($this->get_current_dir()."/css/style.css");
		
	//	$this->add_block('BASE_MENU', 'site', 'menu');
		//$this->add_keyword('xxx');
		
		$sbplugin = use_jq_plugin('structblock',$this);
		
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$_cfg = new scaff_conf($cfg);		
		
		$dbparams = $_cfg->connect_db_if_exists($this);
	
		use_jq_plugin('confirmdelete',$this);
		
		if($dbparams!=NULL)	// конфа подключена к базе
		{

			$tables = $this->_ENV['_CONNECTION']->get_tables();
			
			$triads = $_cfg->get_triads();
			
			$this->out_view('hmvcs',array('tables'=>$tables,'config'=>$cfg,'triads'=>$triads,'_config'=>$_cfg,'sbplugin'=>$sbplugin));
		}	
		else 
		{
			$this->out_view('index',array('config'=>$cfg,));
		}		
	}
	
	public function BeforeAction(&$params)
	{
		$this->add_block('SIDEBAR_LEFT', 'configs', 'conflist');
		$this->add_block('BASE_MENU', 'site', 'menu');
	}
	
	public function ActionDelete($cfg,$ep,$triada)
	{
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$_cfg = new scaff_conf($cfg);
		$tr = $_cfg->get_triada($ep, $triada);
		$tr->delete();
		$this->redirect_back();
	}
	
	public function ActionFields($cfg='main',$table)
	{
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$_cfg = new scaff_conf($cfg);
		
		$dbparams = $_cfg->connect_db_if_exists($this);
		
		//$dbparams = $this->ConnectDBIfExists($cfg);
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
			ser_post('makepure');
			GLOBAL $_BASEDIR;
			require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
			$conf = new scaff_conf($_POST['conf']);
								
			foreach ($_POST['ep'] as $ep => $val)
			{			
				
				$triada = $conf->get_triada($ep, $_POST['triada']);
				if($triada==NULL)
					$triada = $conf->create_triada($ep, $_POST['triada']);
				//mul_dbg($triada);
				$rewrite_all = (isset($_POST['rewrite_all']) ? true : false);
				$triada->make_pure(array('actions'=>$_POST['actions']),$rewrite_all);
				
			}
		}
		//$this->add_block('BASE_MENU', 'site', 'menu');
		$this->redirect_back();
	}
	
	public function ActionConnectdb($cfg=NULL)
	{
		if($cfg==NULL)
		{			
			$cfg= $this->getCurrCFG();
		}
		
		$this->_TITLE = Lang::__t('Database configuration connection');
		$model=array();
		
		//	$model = $this->UseModel(base_driver_model_settings());
		//	$model_row = $model->empty_row_form_model();
		$plugs = $this->GetPlugs();
		//
		
		$this->out_view('dbinfocontainer',array(//'model_row'=>$model_row,
				'plugs'=>$plugs,'drv_first'=>$plugs[0],'config'=>$cfg,));
	}
	
	public function ActionLoadconnform($cfg=NULL,$drv=NULL)
	{
		if($cfg==NULL)
		{
			$cfg= $this->getCurrCFG();
		}	
				
		$plugs = $this->GetPlugs();
		
		if($drv==NULL)
		{
			$params_in_conf = $this->get_db_conf();
			if($params_in_conf==NULL)
				$drv=$plugs[0];
				else
					$drv=$params_in_conf['driver'];
		}
		
		//
		$drv_class = 'drv_'.$drv;
		$drv_obj = $this->get_plug_obj($drv_class);
		$the_model = $this->UseModel($drv_obj->getModel(
				[
					'onchange_url'=> "'".as_url('hmvc/loadconnform/'.$cfg)."'+'/'+$('#the_driver').val()"						
				]));
		
		$this->_MODEL->_SETTINGS['fields']['conf']=['Type'=>'text','hidden'=>true];
		
		$model_row = $the_model->empty_row_form_model();
		$model_row->setField('driver', $drv);
		
		$model_row->setField('conf', $cfg);
		
		if($params_in_conf!=NULL)	// есть конфиг бд
		{
			foreach($params_in_conf as $pkey => $pval)
			{
				
				$model_row->setField($pkey, $pval);
			}
		}
		
		$this->out_ajax_block('dbsettings',array('model_row'=>$model_row,'plugs'=>$plugs,'drv'=>$drv,'drv'=>$drv));
	}
	
	public function ActionSetdbcfg()
	{		
		$conf_dir = url_seg_add();
		
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$conf_obj = new scaff_conf($_POST['dbinfo']['conf']);
		
		$dbconf_file = url_seg_add($conf_dir,'dbconf.php');
		
		$driver = $_POST['dbinfo']['driver'];
		$drv_obj = $this->get_plug_obj("drv_".$driver);
		
		$code = $drv_obj->dbconfig_code($_POST['dbinfo']);
		$conf_obj->set_db_conf_code($code);
		
		$this->redirect(as_url('hmvc/'.$_POST['dbinfo']['conf']));
	}
	
	public function BeforeValidate()
	{
		//mul_dbg($_POST);
		if(isset($_POST['dbinfo']))
		{
			$driver = $_POST['dbinfo']['driver'];
			$drv_obj = $this->get_plug_obj("drv_".$driver);
			$_model = $drv_obj->getModel();
			$this->UseModel($_model);
		}
		//mul_dbg($_model);
	}
	
	public function GetPlugs()
	{
		$plugs = mul_Module::getModulePlugins('db');
		$plugs = filter_array($plugs,function(&$el){
			$matchez=array();
			if( preg_match_all('/^drv_(.+)$/Uis', $el['value'],$matchez))
			{
				$el['value']=$matchez[1][0];
				return true;
			}
			return false;
		});
			
			return $plugs;
	}
	
	public function get_plug_obj($plg)
	{
		$module_db = find_module('db');
		if($module_db!=NULL)
		{
			$plg = $module_db->use_plugin($plg,['connectable'=>false]);
			return $plg;
		}
		return NULL;
	}
			
	public function ActionMake($step='begin')
	{
		
		//print_r($step);
		
		switch($step){
			case 'begin': {
							$_SESSION['makeinfo']=array();				
							$_SESSION['makeinfo'] = array_merge($_SESSION['makeinfo'],$_POST);
							
							$this->redirect(as_url('hmvc/make/binds'));
						};break;
			case 'binds': {
						GLOBAL $_BASEDIR;
						require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
						$cfg = new scaff_conf($_SESSION['makeinfo']['conf']);
						$cfg->connect_db_if_exists($this);
						
						$this->add_js('#js/constraints.js');
						
						$dbw = new DbWatcher($this->_CONNECTION);
						
						$table_info = $dbw->get_basic_table_info($_SESSION['makeinfo']['table']);
						
						$_hmvc = $cfg->get_triada('frontend', $_SESSION['makeinfo']['table']);										
						
						if($_hmvc!=null)
						{
							$settings = $_hmvc->getModelInfo();
						}
						else 
							$settings = array('view'=>$table_info['view']);
						
						//$settings = $this->getExistingModelInfo($_SESSION['makeinfo']['conf'],$_SESSION['makeinfo']['table']);	
						$sbplugin = use_jq_plugin('structblock',$this);
						$this->_TITLE=$_SESSION['makeinfo']['table']." ". Lang::__t("Bindings and settings");
						
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
						/*
						if(empty($settings['view']))
						{
							
							$settings['view']=$this->SearchViewFld($fields);
						}*/
						jq_onready($this,"
								$( document ).ready(function() {
									$('#items_block').jqStructBlock();
									$('#fields_block').jqStructBlock();
								});
								");										
						$table_warnings=array();
						
						if(isset($table_info['primary']))
						{
							if(!$table_info['primary']['ai'])
							{
								$table_warnings[]=Lang::__t('Primary key field is not autoincrement');
							}
						}
						else 
						{
							$table_warnings[]=Lang::__t('Primary key of this table is empty');
						}
						
						$authcon=$_hmvc->is_auth();
						
						$this->out_view('constraints',array(
//								'tables'=>$tables,							
//								'first_table_fields'=>$first_table_fields,
								'settings'=>$settings,
								'sbplugin'=>$sbplugin,
								'triads'=>$triads,
								'table'=>$_SESSION['makeinfo']['table'],
								'warnings'=>$table_warnings,	
								'_hmvc'=>$_hmvc,
								'authcon'=>$authcon,
								
								'table_info'=>$table_info,
						));
					};break;
			case 'makefiles': {
					
						$_SESSION['makeinfo'] = array_merge($_SESSION['makeinfo'],$_POST);
						
						$_SESSION['hmvc_name'] = $_SESSION['makeinfo']['table'];
						
						$this->make_hmvc($_SESSION['makeinfo']);
						unset($_SESSION['makeinfo']);
						
						$this->redirect(as_url('hmvc/make/success'));
					};break;
			case 'success': {
						$this->_TITLE=Lang::__t('HMVC made successed');
						$this->x_out_view('success',array('hmvc_name'=>$_SESSION['hmvc_name']));
					};break;
		}

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
	
	private function make_hmvc_frontend($_params,$opts)
	{
		GLOBAL $_BASEDIR;
	
		$conf_obj=$opts['conf_obj'];
	
		$rewrite_all=false;
		if(isset($_params['rewrite_all']))
			$rewrite_all=true;
		
		$ep='frontend';
		$the_triada = $conf_obj->create_triada($ep,$_params['table']);
	
		$the_triada->frontend_from_table($_params,$this,$opts);			
	}
	
	
	private function make_hmvc_backend($_params,$opts)
	{
		GLOBAL $_BASEDIR;
		
		$conf_obj=$opts['conf_obj'];
		
		$rewrite_all=false;
		if(isset($_params['rewrite_all']))
			$rewrite_all=true;
			
		$ep='backend';
		$the_triada = $conf_obj->create_triada($ep,$_params['table']);
			
			
			// add controller file
		$the_triada->x_make_controller($vars,$rewrite_all);
			
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
			
		// Модель
		$the_triada->make_model($_params,$rewrite_all);
			
		// Файлик
		$the_triada->make_baseinfo($_params,$this);

		// 
		$the_triada->add_std_data_views($_params,$this);
			
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
	
	private function make_hmvc_install($_params,$opts)
	{
		GLOBAL $_BASEDIR;
	
		$conf_obj=$opts['conf_obj'];
	
		$rewrite_all=false;
		if(isset($_params['rewrite_all']))
			$rewrite_all=true;
	
		$ep='install';
		$the_triada = $conf_obj->create_triada($ep,$_params['table']);
	
		$the_triada->install_from_table($_params,$this,$opts);
	}
	
	private function make_hmvc($_params)
	{
		//print_r($_params['constraints']);
		
		GLOBAL $_BASEDIR;
		$conf_dir= url_seg_add($_BASEDIR,"conf");
		
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$conf_obj = new scaff_conf($_params['conf']);

	//	print_r($_params);
		$dbparams = $conf_obj->connect_db_if_exists($this); 
		
		// Авторизация
		if(isset($_params['authcon']['enable']))
		{
			$_SESSION['authhost']=$_params['table'];
		}
		else
			$_SESSION['authhost']=$_params['con_auth'];
		
			
		if(!empty($_params['ep']['frontend']))
		{			
			$ep='frontend';						
				
			// connect the menu from som controller
			if(isset($_params['mainmenu'][$ep]))
			{
				$_SESSION['connect_from'][$ep]=$_params['table'];
			}
			else
				$_SESSION['connect_from'][$ep]=$_params['connect_from'][$ep];
			
			$the_triada = $conf_obj->create_triada($ep,$_params['table']);
			
			$the_triada->frontend_from_table($_params,$this,$opts);
		}
		
		if(!empty($_params['ep']['backend']))
		{
				
			$ep='backend';						
			
			// connect the menu from som controller 
			if(isset($_params['mainmenu'][$ep]))
			{
				$_SESSION['connect_from'][$ep]=$_params['table'];
			}
			else
				$_SESSION['connect_from'][$ep]=$_params['connect_from'][$ep];
			
			$the_triada = $conf_obj->create_triada($ep,$_params['table']);
				
			$the_triada->backend_from_table($_params,$this,$opts);
		}
		
		if(!empty($_params['ep']['install']))
		{
			$ep='install';
			$the_triada = $conf_obj->create_triada($ep,$_params['table']);
			$the_triada->install_from_table($_params,$this,$opts);
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