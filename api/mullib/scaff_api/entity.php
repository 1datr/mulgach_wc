<?php
// Работа с сущностями
class scaff_entity {
	VAR $NAME;
	VAR $TABLE;
	VAR $TABLE_MADE = FALSE;
	VAR $COMPILED=FALSE;
	VAR $DATA_DRV;
	VAR $PARENT_CFG=NULL;
	VAR $_TABLE_INFO=NULL;
	
	function __construct($table,$cfg)
	{
		if(is_string($table))
		{
			$this->TABLE=$table;
			$this->NAME=$table;
			$this->PARENT_CFG = $cfg;
			$this->PARENT_CFG->get_triada('frontend',$this->TABLE);
			$this->DATA_DRV = $this->PARENT_CFG->_DRV;
		}
		else 
		{
			$this->TABLE=$table['ename'];
			$this->NAME=$this->TABLE;
			$this->PARENT_CFG = $cfg;
			$this->_TABLE_INFO = $table;
			$this->DATA_DRV = $this->PARENT_CFG->_DRV;
		}
	}
	
	function compile_table_info($nfo)
	{
		
		$this->_TABLE_INFO = array('fields'=>[],'table'=>$nfo['ename'],'required'=>[],'primary'=>[],'binds'=>[],'auth_con'=>$nfo['auth_con'],'view'=>$nfo['view']);
		
		if(!empty($nfo['oldname']))
			$this->_TABLE_INFO['oldname']=$nfo['oldname'];
		
		foreach($nfo['fieldlist'] as $idx => $element)
		{
			
			if($element['type'] =="_ref")
			{
				$this->_TABLE_INFO['binds'][]=[
						'field'=>$element['fldname'],
						'model'=>$element['typeinfo']['entity_to'],
						'field_to'=>$element['typeinfo']['fld_to']];
				
				$entity_to_obj = new scaff_entity($element['typeinfo']['entity_to'],$this->PARENT_CFG);
				$entity_to_obj->DATA_DRV = $this->DATA_DRV;
					
				$entity_to_fields = $entity_to_obj->get_fields();
			
				$fld_to_info = $entity_to_fields[$element['typeinfo']['fld_to']];				
				
				if(isset($element['required']))
				{
				
					$this->_TABLE_INFO['required'][]=$element['fldname'];
				}
					
				$element2 = $element;
				$element2['typeinfo']=$fld_to_info;
				
				$this->_TABLE_INFO['fields'][$element['fldname']]=[
						'Type'=>$fld_to_info['Type'],
						'TypeInfo'=>$this->DATA_DRV->make_fld_info_from_data($element2),
						'Null'=>($element['required']=='on'),
						'Default'=>$element['defval']
				];
				
				if(!empty($element['fldname_old']))
				{
					$this->_TABLE_INFO['fields'][$element['fldname']]['fldname_old'] = $element['fldname_old'];
				}
			}
			else
			{
				if(isset($element['primary']))
				{
			
					$this->_TABLE_INFO['primary']=$element['fldname'];
				}
					
				if(isset($element['required']))
				{
						
					$this->_TABLE_INFO['required'][]=$element['fldname'];
				}
					
				$this->_TABLE_INFO['fields'][$element['fldname']]=[
						'Type'=>$element['type'],
						'TypeInfo'=>$this->DATA_DRV->make_fld_info_from_data($element),
						'Null'=>($element['required']=='on'),
						'Default'=>$element['defval']
				];
				
				if(!empty($element['fldname_old']))
				{
					$this->_TABLE_INFO['fields'][$element['fldname']]['fldname_old'] = $element['fldname_old'];
				}
			}
		}				
	}
	
	function SetDrv($drv)
	{
		$this->DATA_DRV = $drv;
	}
	
	function watch_model($ep='frontend')
	{
		$tr = $this->PARENT_CFG->get_triads();
	}
	
	function get_fields()
	{
		$fields = $this->DATA_DRV->get_table_fields($this->TABLE);
		$this->COMPILED=false;
		if(!empty($this->PARENT_CFG))
		{
			$triada = $this->PARENT_CFG->get_triada('front',$this->TABLE);
			if($triada!=null)
			{
				$this->COMPILED=true;
			}
			else 
				$this->COMPILED=false;
		}
		
		if($this->COMPILED)
		{
			
		}		
		return $fields;
	}
	
	function make($controller)
	{
		$this->compile_table_info($this->_TABLE_INFO);
		$this->build_table();
		
		$this->build_hmvc($trinfo,$controller);
	}
	
	function build_table()
	{
		$this->DATA_DRV->build_table($this->_TABLE_INFO);
	}
	
	function build_hmvc($trinfo,$controller)
	{
	//	mul_dbg($this->_TABLE_INFO);
		$_trinfo = ['table'=>$this->_TABLE_INFO['table'],
				'required'=>$this->_TABLE_INFO['required'],
				'primary' => $this->_TABLE_INFO['primary'],
				'conf' => $this->PARENT_CFG->_NAME,
				'rewrite_all' => 'on',
				'ignore_existing' => 'on',
				'ep' => [
						'frontend' => 'on',
						'backend' => 'on',
						'install' => 'on',
						'rest' => 'on',
						],
				'constraints'=>$this->_TABLE_INFO['binds'],
				'model_fields'=>[],
				'captions'=>[],
				'view' => $this->_TABLE_INFO['view'],
				'con_auth'=>$this->_TABLE_INFO['auth_con'],
				'connect_from' => [
					'frontend' => $this->_TABLE_INFO['auth_con'],
					'backend' => $this->_TABLE_INFO['auth_con'],
				],
		];
		
		$capts = [];
		foreach ($this->_TABLE_INFO['fields'] as $fld => $fldinfo)
		{
			$newfld = ['name'=>$fld,];
			if( in_array($fld,$_trinfo['required']))
				$newfld['required']='on';
			$_trinfo['model_fields'][] = $newfld;
						
			$capts[$this->_TABLE_INFO['table'].".".$fld]=$fld;
		}
		
		$_trinfo['captions']=['frontend'=>$capts,'backend'=>$capts,'install'=>$capts,];
		
	//	mul_dbg('result info');
	//	mul_dbg($_trinfo);
		
	//	$_SESSION['makeinfo'] = array_merge($_SESSION['makeinfo'],$_POST);
		
	//	$_SESSION['hmvc_name'] = $_SESSION['makeinfo']['table'];
		
		$this->make_hmvc($_trinfo,$controller); 
		
		
	}
	
	private function make_hmvc($_params,$controller)
	{
		//print_r($_params['constraints']);
	
		GLOBAL $_BASEDIR;
		$conf_dir= url_seg_add($_BASEDIR,"conf");
	
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$conf_obj = new \scaff_conf($_params['conf']);
	
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
						
					$the_triada->frontend_from_table($_params,$controller,$opts);
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
	
					$the_triada->backend_from_table($_params,$controller,$opts);
			}
	
			if(!empty($_params['ep']['install']))
			{
				$ep='install';
				$the_triada = $conf_obj->create_triada($ep,$_params['table']);
				$the_triada->install_from_table($_params,$controller,$opts);
			}
	}
	
	
	function delete()
	{
		$this->DATA_DRV->delete_table($this->TABLE);
	}
	
}