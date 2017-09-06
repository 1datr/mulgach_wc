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
		
	public function ActionIndex($cfg=NULL,$ep='frontend')
	{
		if($cfg==NULL)
		{
			
			$cfg= $this->getCurrCFG();
		}
		
		$this->_TITLE="HMVC {$cfg}";
		$this->add_css($this->get_current_dir()."/css/style.css");
		
		$this->add_block('BASE_MENU', 'site', 'menu');
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
			$this->out_view('index',array());
		}		
		
		
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
							
							$this->redirect(as_url('hmvc/make/binds'));
						};break;
			case 'binds': {
						GLOBAL $_BASEDIR;
						require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
						$cfg = new scaff_conf($_SESSION['makeinfo']['conf']);
						$cfg->connect_db_if_exists($this);
						$_hmvc = $cfg->get_triada('frontend', $_SESSION['makeinfo']['table']);
					
						//mul_dbg($_hmvc);
						//$dbparams = $this->ConnectDBIfExists($_SESSION['makeinfo']['conf']);											
						
						$fields = $this->_ENV['_CONNECTION']->get_table_fields($_SESSION['makeinfo']['table']);
						$tables = $this->_ENV['_CONNECTION']->get_tables();					
						$first_table_fields = $this->_ENV['_CONNECTION']->get_table_fields($tables[0]);
						$this->add_js('#js/constraints.js');
						
						if($_hmvc!=null)
						{
							$settings = $_hmvc->getModelInfo();
						}
						else 
							$settings = array();
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
						// подыскать поля
						$fld_login_='';
						$fld_passw_="";
						$fld_hash_="";
						$fld_email_="";
					//	mul_dbg($fields);
						foreach ($fields as $fld => $val)
						{
							if(strstr($fld,'login')!=false)
							{
								$fld_login_=$fld;
							}
							
							if(strstr($fld,'passw')!=false)
							{
								$fld_passw_=$fld;
							}
							
							if( (strstr($fld,'hash')!=false) || (strstr($fld,'token')!=false) )  
							{
								$fld_hash_=$fld;
							}
							
							if( (strstr($fld,'e-mail')!=false) || (strstr($fld,'email')!=false) )
							{
								$fld_email_=$fld;
							}
						}
					
						$table_warnings=array();
						$primary = $this->_ENV['_CONNECTION']->get_primary($fields);
						if($primary!=null)
						{
							//mul_dbg
							if($fields[$primary]['Extra'] != 'auto_increment')
							{
								$table_warnings[]=Lang::__t('Primary key field is not autoincrement');
							}
							/*
							foreach ($fields as $fld => $finfo)
							{
								mul_dbg($fld);
								mul_dbg($finfo);
							}*/
						}
						else 
						{
							$table_warnings[]=Lang::__t('Primary key of this table is empty');
						}
							
						$authcon=$_hmvc->is_auth();
						
						$this->out_view('constraints',array(
								'fields'=>$fields,
								'tables'=>$tables,							
								'first_table_fields'=>$first_table_fields,
								'settings'=>$settings,
								'sbplugin'=>$sbplugin,
								'triads'=>$triads,
								'table'=>$_SESSION['makeinfo']['table'],
								'warnings'=>$table_warnings,
								'fld_login_'=>$fld_login_,
								'fld_passw_'=>$fld_passw_,
								'fld_hash_'=>$fld_hash_,
								'fld_email_'=>$fld_email_,
								'_hmvc'=>$_hmvc,
								'authcon'=>$authcon,
						));
					};break;
			case 'makefiles': {
					
						$_SESSION['makeinfo'] = array_merge($_SESSION['makeinfo'],$_POST);
						
						if(isset($_SESSION['makeinfo']['ep']['install']))
							$_SESSION['makeinfo']['authcon']['install']=$_SESSION['makeinfo']['authcon']['backend'];
						
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