<?php
class scaff_triada
{
	VAR $_PATH;
	VAR $_VIEWPATH;
	VAR $_PARENT_CONF;
	VAR $_EP;
	VAR $_CONTROLLER_PATH;
	VAR $_MODEL_PATH;
	VAR $_BASEFILE_PATH;
	VAR $menu_site_codes;

	function __construct(&$conf_obj,$ep,$triada,$create=true)
	{
		$this->_PARENT_CONF = $conf_obj;
		$this->_EP = $ep;
		$this->_PATH = url_seg_add( $conf_obj->_PATH, $ep, 'hmvc', $triada);
	//	echo $this->_PATH;
		if(!file_exists($this->_PATH) || $create)
		{
			x_mkdir($this->_PATH);
		}

		$this->_VIEWPATH = url_seg_add($this->_PATH,'views');
		if(!file_exists($this->_VIEWPATH) || $create)
		{
			x_mkdir($this->_VIEWPATH);
		}

	}
	
	
	function from_template()
	{
		
	}
	
	static function exists(&$obj,$ep,$hmvc)
	{
		$triada_path = url_seg_add($obj->_PATH, $ep, 'hmvc', $hmvc);
		
		//mul_dbg("path > ".$triada_path);
		
		if(file_exists($triada_path))
		{
			return true;
		}
		return false;
	}
	// файл модели
	function make_model($_params,$rewrite_all=true)
	{
		$this->_MODEL_PATH = url_seg_add( $this->_PATH,'model.php');
		if(!file_exists($this->_MODEL_PATH) || $rewrite_all)
		{
			$vars=array();
			$vars['table_uc_first']=UcaseFirst($_params['table']);
			$vars['TABLE_UC']=strtoupper($_params['table']);
			$vars['table'] = $_params['table'];
			$vars['BaseModelClass'] = 'BaseModel';
			if(isset($_params['authcon'][$this->_EP]))				
				$vars['BaseModelClass'] = 'AuthModel';
			x_file_put_contents($this->_MODEL_PATH, parse_code_template(url_seg_add(__DIR__,'/phpt/model.phpt'),$vars));
		}
	}
	
	function add_view($viewname,$_template,$vars=array(),$rewrite_all=true)
	{
		$new_view_path=url_seg_add($this->_VIEWPATH,$viewname.".php");
		
		if(!file_exists($new_view_path) || $rewrite_all)
		{
			x_file_put_contents($new_view_path, parse_code_template(url_seg_add(__DIR__,'/phpt/'.$_template.'.phpt'),$vars));
		}
	}
	
	function has_view($_view)
	{
		$path=url_seg_add($this->_VIEWPATH,$_view);
		return file_exists($path);
	}
	
	function add_std_data_views($_params,$controller)
	{
		include $this->_BASEFILE_PATH;
		
		$tbl_fields = $controller->_ENV['_CONNECTION']->get_table_fields($_params['table']);
		$_primary = $controller->_ENV['_CONNECTION']->get_primary($tbl_fields);
		
		if( !($this->has_view('view_index')) || $_params['rewrite_all'])
		{
			$vars=array();
			$vars['table'] = $_params['table'];
			$vars['primary']=$_primary;
			$vars['TABLE_UC']=strtoupper($_params['table']);
			$this->add_view('index','view_index',$vars,$_params['rewrite_all']);
		}
		
	//	$itemform_view = url_seg_add($dir_views,'itemform.php');
		if( !($this->has_view('view_itemform'))|| $_params['rewrite_all'])
		{
						
			$vars=array();		
			$vars['table'] = $_params['table'];
			$vars['TABLE_UC']=strtoupper($_params['table']);
			$vars['fld_primary']=$_primary;
			$vars['fields']=$tbl_fields;
			$vars['settings']=$settings;
			$vars['constraints']=$_params['constraints'];
			$this->add_view('itemform','view_itemform',$vars,$_params['rewrite_all']);
		}
		
	//	$itemform_view = url_seg_add($dir_views,'itemform.php');
		if($_params['authcon'][$this->_EP]['enable'])
		{
			if( !($this->has_view('loginform'))|| $_params['rewrite_all'])
			{
				
				$vars=array();
				$vars['this_controller'] = $_params['table'];
				$vars['login_fld']=$_params['authcon']['backend']['login'];
				$vars['passw_fld']=$_params['authcon']['backend']['passw'];
			
			//	$vars['settings']=$settings;
			//	$vars['constraints']=$_params['constraints'];
				$this->add_view('loginform','login/form',$vars,$_params['rewrite_all']);
			}
		}
	}
		
	function make_baseinfo($_params,$controller,$template='baseinfo')
	{
		$_template = url_seg_add(__DIR__,'/phpt/',$template.'.phpt');		
	//	$file_baseinfo= url_seg_add( $this->_PATH,'baseinfo.php');
		
		$vars=array();
		$vars['table']=$_params['table'];
		$tbl_fields = $controller->_ENV['_CONNECTION']->get_table_fields($_params['table']);
			
	//	$this->gather_fields_captions($tbl_fields);
		
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
		$_primary = $controller->_ENV['_CONNECTION']->get_primary($tbl_fields);
		$vars['primary']=$_primary;
		$vars['view']=$_params['view'];
		$vars['authparams']='';
	//	mul_dbg($_params['authcon']);
	//	mul_dbg($_params['authcon'][$this->_EP]['enable']);
		if(isset($_params['authcon'][$this->_EP]['enable']))
		{			
			
			$vars['authparams']=parse_code_template(url_seg_add(__DIR__,'phpt/authparams.phpt') , 
					array(
						'src_type'=>'db',
						'src_authdata'=>$_params['table'],
						'login_field'=>$_params['authcon'][$this->_EP]['login'],
						'passw_field'=>$_params['authcon'][$this->_EP]['passw'],
						'hash_field'=>$_params['authcon'][$this->_EP]['hash'],
					));
		}
		
		//print_r($_params);
		$vars['required']='array('.xx_implode($_params['model_fields'], ',', "'{name}'",function($theval,&$idx,&$thetemplate,&$ctr,&$thedelimeter)
		{
			if(empty($theval['required']))
			{
				$thetemplate='';
				$thedelimeter='';
			}
		}).')';
		
		$this->_BASEFILE_PATH=url_seg_add($this->_PATH,'baseinfo.php');
		/*if(!file_exists($this->_CONTROLLER_PATH) || $rewrite)
		{*/
		x_file_put_contents($this->_BASEFILE_PATH, parse_code_template($_template, $vars));
		//}
	}
	
	function make_controller($vars=array(),$rewrite,$template='controller')
	{
		$_template = url_seg_add(__DIR__,'/phpt/',$template.'.phpt');
		$this->_CONTROLLER_PATH=url_seg_add($this->_PATH,'controller.php');
		if(!file_exists($this->_CONTROLLER_PATH) || $rewrite)
		{
			x_file_put_contents($this->_CONTROLLER_PATH, parse_code_template($_template, $vars));
		}
	}
	
	public function frontend_from_table($_params,$controller,$opts)
	{
		GLOBAL $_BASEDIR;
	
		$conf_obj=$opts['conf_obj'];
	
	//	mul_dbg(__LINE__." went");
	//	$dbparams = $this->_PARENT_CONF->connect_db_if_exists($controller);
		
		
		$rewrite_all=false;
		if(isset($_params['rewrite_all']))
			$rewrite_all=true;
			
		$ep='frontend';
	
		//	mul_dbg($vars);
	
			// коды для меню
		$this->menu_site_codes=array('menu_method'=>'','menu_block_use'=>'');
		if(!empty($_params['mainmenu'][$this->_EP]))
		{
			$vars_menu=array('auth_con'=>$_params['con_auth'][$this->_EP]);
			$this->menu_site_codes['menu_method']=parse_code_template(url_seg_add(__DIR__,'/phpt/backend/sitemenu.phpt'),$vars_menu);
	
			$this->menu_site_codes['menu_block_use'] = '$this->add_block("BASE_MENU", "'.$_params["table"].'", "menu");';
	
			if(isset($_params['authcon'][$this->_EP]['enable']))
			{
				$_params['con_auth'][$this->_EP]=$_params['table'];
			}
			
			$this->add_view('menu', 'backend/menu', array('auth_con'=>$_params['con_auth'][$this->_EP]));
				
		//	mul_dbg($this->menu_site_codes);
			/*	$menu_info_file = parse_code_template(url_seg_add(__DIR__,'../../phpt/backend/menu.phpt'),array());
				x_file_put_contents(url_seg_add($hmvc_dir,'views/menu.php'), $menu_info_file);*/
				
		//	$this->add_view('views/menu','backend/menu',array('auth_con'=>$_params['con_auth'][$this->_EP]));
	
			$menu_info_file = url_seg_add($this->_PATH,'../../info/basemenu.php');
			x_file_put_contents($menu_info_file,
					parse_code_template(url_seg_add(__DIR__,'phpt/backend/basemenu.phpt'),array('tables'=>$controller->_ENV['_CONNECTION']->get_tables()))
					);
		}
		else
		{
			$this->menu_site_codes['menu_block_use'] = '$this->add_block("BASE_MENU", "'.$_params['connect_from'][$this->_EP].'", "menu");';
		}
		
		// add controller file
		$this->x_make_controller($_params,$rewrite_all);
		
		// Модель
		$this->make_model($_params,$rewrite_all);
				
		// Файлик		
		$this->make_baseinfo($_params,$controller);
		
		// Стандартные вьюхи
		$this->add_std_data_views($_params,$controller);
	
		// прокачиваем надписи
		if(!empty($_params['captions'][$ep]))
		{
			$thelang=new Lang(NULL, $this->_PARENT_CONF->_NAME,$this->_EP);
			foreach ($_params['captions'][$ep] as $fld_key => $val)
			{
				$thelang->add_key($fld_key,$val);
			}
		}
	
	}
	
	public function backend_from_table($_params,$controller,$opts)
	{
		GLOBAL $_BASEDIR;
	
		$conf_obj=$opts['conf_obj'];
 
	//	$dbparams = $this->_PARENT_CONF->connect_db_if_exists($controller);
	
		$rewrite_all=false;
		if(isset($_params['rewrite_all']))
			$rewrite_all=true;
				
		$ep='backend';		
	
			// коды для меню
		$this->menu_site_codes=array('menu_method'=>'','menu_block_use'=>'');
		if(isset($_params['mainmenu'][$this->_EP]))
		{
			$vars_menu=array();
			$this->menu_site_codes['menu_method']=parse_code_template(url_seg_add(__DIR__,'/phpt/backend/sitemenu.phpt'),$vars_menu);
	
			$this->menu_site_codes['menu_block_use'] = '$this->add_block("BASE_MENU", "'.$_params["table"].'", "menu");';
				
			if(isset($_params['authcon'][$this->_EP]['enable']))
			{
				$_params['con_auth'][$this->_EP]=$_params['table'];
			}
			//	mul_dbg($this->menu_site_codes);
			$this->add_view('menu', 'backend/menu', array('auth_con'=>$_params['con_auth'][$this->_EP]));
	
				/*	$menu_info_file = parse_code_template(url_seg_add(__DIR__,'../../phpt/backend/menu.phpt'),array());
					x_file_put_contents(url_seg_add($hmvc_dir,'views/menu.php'), $menu_info_file);*/
	
			//$this->add_view('views/menu','backend/menu',array());
	
			$menu_info_file = url_seg_add($this->_PATH,'../../info/basemenu.php');
			x_file_put_contents($menu_info_file,
						parse_code_template(url_seg_add(__DIR__,'phpt/backend/basemenu.phpt'),array('tables'=>$controller->_ENV['_CONNECTION']->get_tables()))
						);
		}
		else
		{
			$this->menu_site_codes['menu_block_use'] = '$this->add_block("BASE_MENU", "'.$_params['connect_from'][$this->_EP].'", "menu");';
		}
			
		//mul_dbg($this->menu_site_codes);
	
		$this->x_make_controller($_params,$rewrite_all);
		//	mul_dbg($vars);
	
		// Модель
		$this->make_model($_params,$rewrite_all);
	
		// Файлик
		$this->make_baseinfo($_params,$controller);
		// Стандартные вьюхи
		$this->add_std_data_views($_params,$controller);
	
		// прокачиваем надписи
		if(!empty($_params['captions'][$ep]))
		{
			$thelang=new Lang(NULL, $this->_PARENT_CONF->_NAME,$this->_EP);
			foreach ($_params['captions'][$ep] as $fld_key => $val)
			{
				$thelang->add_key($fld_key,$val);
			}
		}
	
	}
	
	
	function x_make_controller($_params,$rewrite_all,$template='controller')
	{
		$vars=array();
		$vars['table_uc_first']=UcaseFirst($_params['table']);
		$vars['TABLE_UC']=strtoupper($_params['table']);
		$vars['table'] = $_params['table'];
		$vars['OTHER_METHODS']='';
		$vars['ADV_RULES']='';
		
	//	mul_dbg('menu site codes');
	//	mul_dbg($this->menu_site_codes);
		
		$vars['menu_block_use']=$this->menu_site_codes['menu_block_use'];
		$vars['OTHER_METHODS']=$vars['OTHER_METHODS'].$this->menu_site_codes['menu_method'];
		
		$vars['ParentControllerClass']='BaseController';

		// add controller file
		if(isset($_params['authcon'][$this->_EP]['enable']))
		{
			$vars['ParentControllerClass']='AuthController';
			
			if( !($this->has_view('loginform'))|| $_params['rewrite_all'])
			{
				$vars['this_controller'] = $_params['table'];
				$vars['login_fld']=$_params['authcon']['backend']['login'];
				$vars['passw_fld']=$_params['authcon']['backend']['passw'];
					
				//	$vars['settings']=$settings;
				//	$vars['constraints']=$_params['constraints'];
				$vars['OTHER_METHODS']= $vars['OTHER_METHODS'] . parse_code_template( url_seg_add(__DIR__,'phpt/login/action.phpt' ), array(
						'login_fld' => $_params['authcon']['backend']['login'],
						'passw_fld' => $_params['authcon']['backend']['passw'],
						'this_controller' => $_params['table'],
				));
				
				if($this->_EP=='backend')
				{
					$vars['ADV_RULES']=$vars['ADV_RULES']. parse_code_template( url_seg_add(__DIR__,'phpt/backend/backend_rules_auth.phpt' ), array(		
						'auth_con' => $_params['table'],
					));
				}
				
			//	$this->add_view('loginform','login/action',$vars,$_params['rewrite_all']);
			}
		}
		else 
		{
			if($this->_EP=='backend')
			{
				$vars['ADV_RULES']=$vars['ADV_RULES']. parse_code_template( url_seg_add(__DIR__,'phpt/backend/backend_rules.phpt' ), array(
						'auth_con' => $_params['con_auth'][$this->_EP],
				));
			}
		}
	//	mul_dbg($vars);
	//	mul_dbg($_params);
		$this->make_controller($vars,$rewrite_all,$template);
	}
	
	
	
	function getModelInfo()
	{
		$this->_BASEFILE_PATH=url_seg_add($this->_PATH,'baseinfo.php');
		if(file_exists($this->_BASEFILE_PATH))
		{
			include $this->_BASEFILE_PATH;
			return $settings;
		}
		
		return NULL;
	}
	
	function getExistingModelInfo($triada,$ep="frontend")
	{
		GLOBAL $_BASEDIR;
		$baseinfo_file=url_seg_add($this->_PATH,$ep,"hmvc",$triada,"baseinfo.php");
		//echo $baseinfo_file;
		if(file_exists($baseinfo_file))
		{
			include $baseinfo_file;
			return $settings;
		}
	
		return NULL;
	}
}