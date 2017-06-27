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
						GLOBAL $_BASEDIR;
						require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
						$cfg = new scaff_conf($_SESSION['makeinfo']['conf']);
						$cfg->connect_db_if_exists($this);
						//$dbparams = $this->ConnectDBIfExists($_SESSION['makeinfo']['conf']);											
						
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
	
	private function make_hmvc_frontend($_params,$opts)
	{
		GLOBAL $_BASEDIR;
		
		$conf_obj=$opts['conf_obj'];
	
		$rewrite_all=false;
		if(isset($_params['rewrite_all']))
			$rewrite_all=true;
		$ep='frontend';
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
		
	
		// make views
	//	$dir_views = url_seg_add($hmvc_dir,'views');
		//echo $dir_views;

	//	include $the_triada->_BASEFILE_PATH;
		
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
			
			
			// make views
			//	$dir_views = url_seg_add($hmvc_dir,'views');
			//echo $dir_views;
			
			//	include $the_triada->_BASEFILE_PATH;
			
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
	
	private function make_hmvc($_params)
	{
		//print_r($_params['constraints']);
		
		GLOBAL $_BASEDIR;
		$conf_dir= url_seg_add($_BASEDIR,"conf");
		
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$conf_obj = new scaff_conf($_params['conf']);
		//print_r($conf_obj);
		/*
		$cur_conf_dir = url_seg_add($conf_dir,$_params['conf']);
		if(!file_exists($cur_conf_dir))
			mkdir($cur_conf_dir);
		*/
	//	print_r($_params);
		$dbparams = $conf_obj->connect_db_if_exists($this); 
		
		//print_r($_params);
		if(!empty($_params['ep']['frontend']))
		{
			$this->make_hmvc_frontend($_params,array('conf_obj'=>$conf_obj));
		}
		
		if(!empty($_params['ep']['backend']))
		{
			$this->make_hmvc_backend($_params,array('conf_obj'=>$conf_obj));
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