<?php
namespace __master\Frontend;

class EmakerController extends \BaseController
{
	public function Rules()
	{
		return array(
				'action_access'=>array(
						new \ActionAccessRule('deny',$this->getActions(),'anonym','site/login')
				),
		);
	}
	
	public function ActionIndex($cfg=NULL)
	{
		//$this->_MODEL->
		$this->_MODEL->scenario('makenew');
		$newrow = $this->_MODEL->empty_row_form_model();
		$newrow->setfield('cfg',$cfg);
		$newrow->setfield('ename','');
	//	$newrow->setfield('auth_entity',false);
		$this->_TITLE=\Lang::__t('Entity manager');
		
		use_scaff_api();
		$_cfg = new \scaff_conf($cfg);
		
		$dbparams = $_cfg->connect_db_if_exists($this);
		
		$entities_table = $_cfg->get_entities($this->_CONNECTION,$_cfg);
		$this->add_js('#/js/emaker.js');
		
		$this->out_view('index',['newrow'=>$newrow,'cfg'=>$cfg,'entities_table'=>$entities_table]);
	}
	
	public function ActionDrop($cfg,$ename)
	{
		// ������������ � ���� � ��������
	
		use_scaff_api();
		$_cfg = new \scaff_conf($cfg);
		$dbparams = $_cfg->connect_db_if_exists($this);
		$_cfg->_DRV = $this->_CONNECTION;
		$_cfg->delete_entity($ename);
		$this->redirect_back();
	}
	
	private function make_from_existsing_table($_cfg,$table,&$newentity,&$fieldlist)
	{
		$entity = $_cfg->get_entity($table,$_cfg); 
		
		$tr_auth = $_cfg->get_auth_con();
		
		$elist = $_cfg->get_entities($this->_CONNECTION, $_cfg, true);
		$elist = array_diff($elist, [$curr_entity]);
		
		$entity->SetDrv($this->_CONNECTION);
		
		$fields = $entity->get_fields();
		
		$menu_con = ['frontend'=>$_cfg->find_menu_triada('frontend'),
				'backend'=>$_cfg->find_menu_triada('backend'),
		];
		//mul_dbg($_POST);
		
		
		if(isset($entity->_MODEL_INFO['view']))
		{
			$newentity->setField('view', $entity->_MODEL_INFO['view']);
		}
		
		$ref_fld_info = [
				'domen'=>'',//'refentity',
				'fields'=>[
						'entity_to'=>['Type'=>'text'],
						'fld_to'=>['Type'=>'text'],
						'fieldlist'=>['Type'=>'array'],
				],
				'required'=>['entity_to','fld_to']
		];
		//	mul_dbg($fields);
		$idx = 0;
		$fieldlist=[];
		
		/*if($entity->is_auth())
		{
			$auth_info = $entity->get_auth_fields();
			$newentity->setField('auth_fld_login',$auth_info['login_field']);
			$newentity->setField('auth_fld_passw',$auth_info['passw_field']);
			$newentity->setField('auth_fld_hash',$auth_info['hash_tag']);
			$newentity->setField('auth_fld_email',$auth_info['email_field']);
		}*/
		
		foreach ($fields as $fld =>$fld_params)
		{
			$thefld = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
			$thefld->setField('fldname', $fld);
			$thefld->setField('fldname_old', $fld);
			$fieldlist[]=$fld;
				
			if(isset($entity->_MODEL_INFO['constraints']) && isset($entity->_MODEL_INFO['constraints'][$fld]) )
			{
				$thefld->setField('type', '_ref');
					
				$ref_fld_info['domen']= "entity[fieldlist][".$idx."][typeinfo]";
				$typemodel = new \BaseModel('',$this->_MODEL->_ENV,new \ModelInfo($ref_fld_info));
				$typeinfo_row = $typemodel->empty_row_form_model();
					
				$typeinfo_row->setField('entity_to',$entity->_MODEL_INFO['constraints'][$fld]['model']);
				$typeinfo_row->setField('fld_to',$entity->_MODEL_INFO['constraints'][$fld]['fld']);
		
				$model_entity = $_cfg->get_entity($entity->_MODEL_INFO['constraints'][$fld]['model']);
				$model_entity->SetDrv($this->_CONNECTION);
		
				$typeinfo_row->setField('fieldlist',assoc_array_cut($model_entity->get_fields(),'Field'));
					
				$thefld->setField('typeinfo', $typeinfo_row,$typemodel);
				//$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($thefld->getField('type')));
				//$typeinfo_row =  $typemodel->empty_row_form_model();
			}
			else
			{
				$thefld->setField('type', $fld_params['Type']);
		
				$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($thefld->getField('type')));
				$typeinfo_row = $typemodel->empty_row_form_model();
				$thefld->setField('typeinfo', $typeinfo_row,$typemodel);
		
			}
				
				
			$thefld->setField('primary', ($fld_params['Key']=='PRI'));
			$thefld->setField('deletable', ($fld_params['Key']!='PRI'));
			$thefld->setField('required',($fld_params['Null']=='NO'));
				
			if($fld==$entity->get_primary_fld())
			{
				$thefld->setField('file_enabled',false);
			}
			else
			{
				$thefld->setField('file_enabled',true);
			}
				
			if(isset($entity->_MODEL_INFO['file_fields'][$fld]))
			{
				$thefld->setField('file_enabled',true);
				$thefld->setField('file',true);
				$thefld->setField('filetype',$entity->_MODEL_INFO['file_fields'][$fld]['type']);
			}
				
			$thefld->setField('defval', $fld_params['Default']);
		
				
				
				
			$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $thefld));
				
			$idx = $idx+1;
		}
	}
	
	private function make_base_authcon(&$newentity,&$fieldlist)
	{
		if(!in_array('login', $fieldlist))
		{
			$fld_login = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
			$fld_login->setField('fldname', 'login');
			$fld_login->setField('type', $this->_CONNECTION->get_basic_type('text'));
			$fld_login->setField('required', true);
			$fld_login->setField('file_enabled',false);
			$fld_login->setField('deletable', false);
			$fieldlist[]='login';
				
			//$fld_login->fldEnabled('type',false);
			$fld_login->fldEnabled('primary',false);
			$fld_login->fldEnabled('required',false);
			
			$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($fld_login->getField('type')));
			$typeinfo_row = $typemodel->empty_row_form_model();
			$fld_login->setField('typeinfo', $typeinfo_row,$typemodel);
			
			$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $fld_login));
		}
		// password field
		if(!in_array('password', $fieldlist))
		{
			$fld_passw = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
			$fld_passw->setField('fldname', 'password');
			$fld_passw->setField('type', $this->_CONNECTION->get_basic_type('text'));
			$fld_passw->setField('required', true);
			$fld_passw->setField('file_enabled',false);
			$fld_passw->setField('deletable', false);
			$fieldlist[]='password';
			
			$fld_passw->fldEnabled('primary',false);
			$fld_passw->fldEnabled('required',false);
		
		
			$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($fld_passw->getField('type')));
			$typeinfo_row = $typemodel->empty_row_form_model();
			$fld_passw->setField('typeinfo', $typeinfo_row,$typemodel);
		
		
			$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $fld_passw));
		}
		// email field
		if(!in_array('email', $fieldlist))
		{
			$fld_email = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
			$fld_email->setField('fldname', 'email');
			$fld_email->setField('type', $this->_CONNECTION->get_basic_type('text'));
			$fld_email->setField('required', true);
			$fld_email->setField('file_enabled',false);
			$fld_email->setField('deletable', false);
			
			$fieldlist[]='email';
			
			//$fld_email->fldEnabled('type',false);
			$fld_email->fldEnabled('primary',false);
			$fld_email->fldEnabled('required',false);
			
			$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($fld_email->getField('type')));
			$typeinfo_row = $typemodel->empty_row_form_model();
			$fld_email->setField('typeinfo', $typeinfo_row,$typemodel);
			
			$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $fld_email));
		}
		// hash field
		if(!in_array('email', $fieldlist))
		{
			$fld_token = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
			$fld_token->setField('fldname', 'token');
			$fld_token->setField('type', $this->_CONNECTION->get_basic_type('text'));
			$fld_token->setField('required', true);
			$fld_token->setField('file_enabled',false);
			
			//$fld_token->fldEnabled('type',false);
			$fld_token->fldEnabled('primary',false);
			$fld_token->fldEnabled('required',false);
			$fld_token->setField('deletable', false);
			$fieldlist[]='token';
			
			$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($fld_token->getField('type')));
			$typeinfo_row = $typemodel->empty_row_form_model();
			$fld_token->setField('typeinfo', $typeinfo_row,$typemodel);
			
			$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $fld_token));
		}
		
		
		$newentity->setField('auth_fld_login','login');
		$newentity->setField('auth_fld_passw','password');
		$newentity->setField('auth_fld_hash','token');
		$newentity->setField('auth_fld_email','email');
	}
	
	public function ActionCreationform()
	{
		if(isset($_POST['makenew']))
		{
			$sbplugin = use_jq_plugin('structblock',['controller'=>$this,'onadd'=>""]);
			$this->_MODEL->scenario("efield");
			$newentity = $this->_MODEL->empty_row_form_model();
			//mul_dbg($_POST);
			$newentity->setField('cfg', $_POST['makenew']['cfg']);
			$newentity->setField('ename', $_POST['makenew']['ename']);
			$newentity->setField('fieldlist', array());
			$newentity->setField('view', '{login}');
			$newentity->setField('build',true);
			
			use_scaff_api();
			// ������������ � ���� � ��������		
			$_cfg = new \scaff_conf($_POST['makenew']['cfg']);
			
			$tr_auth = $_cfg->get_auth_con();
			//mul_dbg($tr_auth);
			$newentity->setField('auth_con',$tr_auth);
			
			$dbparams = $_cfg->connect_db_if_exists($this);
			
			$typelist = $this->_CONNECTION->Typelist();
			$typelist['_ref']=\Lang::__t('Entity reference');
			
			$emptyfld = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
			
			$this->add_js('#/js/emaker.js');
			
			$elist = $_cfg->get_entities($this->_CONNECTION, $_cfg, true);
			
								
			
			$fieldlist=[];
			
			if(isset($_POST['makenew']['existing_table']))
			{
				$this->make_from_existsing_table($_cfg,$_POST['makenew']['existing_table'],$newentity,$fieldlist);
			}
			
			if(!in_array('id', $fieldlist))
			{
				$primaryfld = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
				$primaryfld->setField('fldname', 'id');
				$primaryfld->setField('type',  $this->_CONNECTION->get_basic_type('int'));
				$primaryfld->setField('deletable', false);
				
				// add typeinfo
				$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($primaryfld->getField('type')));
				$typeinfo_row = $typemodel->empty_row_form_model();
				$primaryfld->setField('typeinfo', $typeinfo_row,$typemodel);
					
				$primaryfld->setField('primary', true);
				$primaryfld->setField('required', true);
					
				$primaryfld->fldEnabled('type',false);
				$primaryfld->fldEnabled('primary',false);
				$primaryfld->fldEnabled('required',false);
					
				$newentity->setField('fieldlist', array_merge([$primaryfld],$newentity->getField('fieldlist')));
					
				$newentity->setField('is_auth',isset($_POST['makenew']['auth_entity']));
			}
			
			if(isset($_POST['makenew']['auth_entity']))	// �������� �����������
			{
				// login field				
				$this->make_base_authcon($newentity,$fieldlist);
				
			}
			
			$emptyfld = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
			
			$this->_TITLE = \Lang::__t('New entity creation');
			
			$newentity->setField('menusettings',[]);
			
			$menu_con = ['frontend'=>$_cfg->find_menu_triada('frontend'),
					'backend'=>$_cfg->find_menu_triada('backend'),
			];
			
			foreach (['frontend','backend'] as $_ep)
			{
				$_is_menu = false;
				$ep_row = $this->_MODEL->nested('menusettings')->empty_row_form_model();
				if(($tr_auth==null) && (isset($_POST['makenew']['auth_entity'])))
				{
					$_is_menu=true;
				}
				$ep_row->setField('is_menucon',$_is_menu);
				$ep_row->setField('menucon',$menu_con[$_ep]);
				$newentity->setField('menusettings', x_array_push($newentity->getField('menusettings'), $ep_row));
			}
			$this->out_view('frm_editentity',['sbplugin'=>$sbplugin,'elist'=>$elist,'fieldlist'=>$fieldlist,'typelist'=>$typelist,'mode'=>'create','newentity'=>$newentity,'emptyfld'=>$emptyfld,'primaryfld'=>$primaryfld]);
		}				
	}

	
	public function ActionEdit($cfg,$_ename)
	{
		$sbplugin = use_jq_plugin('structblock',['controller'=>$this,'onadd'=>""]);
		$this->_MODEL->scenario("efield");
		
		// ������������ � ���� � ��������	
		use_scaff_api();

		$_cfg = new \scaff_conf($cfg);
		
		$dbparams = $_cfg->connect_db_if_exists($this);
		
		$entity = $_cfg->get_entity($_ename,$_cfg);
		
		$tr_auth = $_cfg->get_auth_con();		
		
		$elist = $_cfg->get_entities($this->_CONNECTION, $_cfg, true);
		$elist = array_diff($elist, [$curr_entity]);
		
		$entity->SetDrv($this->_CONNECTION);
		
		$fields = $entity->get_fields();
		
		$editing_entity = $this->_MODEL->empty_row_form_model();
		
		$menu_con = ['frontend'=>$_cfg->find_menu_triada('frontend'),
				'backend'=>$_cfg->find_menu_triada('backend'),
		];
		//mul_dbg($_POST);
		$editing_entity->setField('cfg', $cfg);
		$editing_entity->setField('ename', $_ename);
		$editing_entity->setField('oldname', $_ename);
		$editing_entity->setField('fieldlist', array());
		$editing_entity->setField('is_auth',$entity->is_auth());
		$editing_entity->setField('auth_con',$tr_auth);
		$editing_entity->setField('build',true);
		$editing_entity->setField('redirect_here',isset($_SESSION['redirect_here']));
		
		if(isset($entity->_MODEL_INFO['view']))
		{
			$editing_entity->setField('view', $entity->_MODEL_INFO['view']);
		}
		
		$ref_fld_info = [
				'domen'=>'',//'refentity',
				'fields'=>[
						'entity_to'=>['Type'=>'text'],
						'fld_to'=>['Type'=>'text'],
						'fieldlist'=>['Type'=>'array'],
				],
				'required'=>['entity_to','fld_to']
		];
	//	mul_dbg($fields);
		$idx = 0;
		$fieldlist=[];
		
		if($entity->is_auth())
		{
			$auth_info = $entity->get_auth_fields();
			$editing_entity->setField('auth_fld_login',$auth_info['login_field']);
			$editing_entity->setField('auth_fld_passw',$auth_info['passw_field']);
			$editing_entity->setField('auth_fld_hash',$auth_info['hash_tag']);
			$editing_entity->setField('auth_fld_email',$auth_info['email_field']);
		}
		foreach ($fields as $fld =>$fld_params)
		{			
			$thefld = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
			$thefld->setField('fldname', $fld);
			$thefld->setField('fldname_old', $fld);
			$fieldlist[]=$fld;
			
			if(isset($entity->_MODEL_INFO['constraints']) && isset($entity->_MODEL_INFO['constraints'][$fld]) )
			{
				$thefld->setField('type', '_ref');
					
				$ref_fld_info['domen']= "entity[fieldlist][".$idx."][typeinfo]";
				$typemodel = new \BaseModel('',$this->_MODEL->_ENV,new \ModelInfo($ref_fld_info));
				$typeinfo_row = $typemodel->empty_row_form_model();
					
				$typeinfo_row->setField('entity_to',$entity->_MODEL_INFO['constraints'][$fld]['model']);
				$typeinfo_row->setField('fld_to',$entity->_MODEL_INFO['constraints'][$fld]['fld']);
				
				$model_entity = $_cfg->get_entity($entity->_MODEL_INFO['constraints'][$fld]['model']);
				$model_entity->SetDrv($this->_CONNECTION);
				
				$typeinfo_row->setField('fieldlist',assoc_array_cut($model_entity->get_fields(),'Field'));
					
				$thefld->setField('typeinfo', $typeinfo_row,$typemodel);
				//$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($thefld->getField('type')));
				//$typeinfo_row =  $typemodel->empty_row_form_model();							
			}
			else
			{
				$thefld->setField('type', $fld_params['Type']);
				
				$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($thefld->getField('type')));
				$typeinfo_row = $typemodel->empty_row_form_model();
				$thefld->setField('typeinfo', $typeinfo_row,$typemodel);
				
			}
			
			
			$thefld->setField('primary', ($fld_params['Key']=='PRI'));
			$thefld->setField('deletable', ($fld_params['Key']!='PRI'));
			$thefld->setField('required',($fld_params['Null']=='NO'));
			
			if($fld==$entity->get_primary_fld())
			{
				$thefld->setField('file_enabled',false);
			}
			else 
			{
				$thefld->setField('file_enabled',true);
			}
			
			if(isset($entity->_MODEL_INFO['file_fields'][$fld]))
			{
				$thefld->setField('file_enabled',true);
				$thefld->setField('file',true);
				$thefld->setField('filetype',$entity->_MODEL_INFO['file_fields'][$fld]['type']);
			}
			
			$thefld->setField('defval', $fld_params['Default']);
				
			
			
			
			$editing_entity->setField('fieldlist', x_array_push($editing_entity->getField('fieldlist'), $thefld));
			
			$idx = $idx+1;
		} 
		
		$emptyfld = $this->_MODEL->nested('fieldlist')->empty_row_form_model();

		
		$this->add_js('#/js/emaker.js');
		$this->_TITLE = \Lang::__t('Edit entity '.$_ename);
		
		$typelist = $this->_CONNECTION->Typelist();
		$typelist['_ref']=\Lang::__t('Entity reference');
		
		$ep_set=['frontend','backend',/*'install','rest'*/];
		$editing_entity->setField('menusettings',[]);
		foreach ($ep_set as $idx => $_ep)
		{
			$ep_row = $this->_MODEL->nested('menusettings')->empty_row_form_model();
			
				$ep_row->setField('ep',$_ep);
				
				$_ep_triada = $_cfg->get_triada($_ep, $_ename);
				$_is_menu = ($_ep_triada->has_menu());
				$ep_row->setField('is_menucon',$_is_menu);
				$ep_row->setField('menucon',$menu_con[$_ep]);
				$editing_entity->setField('menusettings', x_array_push($editing_entity->getField('menusettings'), $ep_row));
				
		}
	
		$this->out_view('frm_editentity',['sbplugin'=>$sbplugin,'elist'=>$elist,'fieldlist'=>$fieldlist,
				'typelist'=>$typelist,'newentity'=>$editing_entity,'mode'=>'save','emptyfld'=>$emptyfld]);
		
	}
	
	public function ActionTypeinfo($cfg,$fldtype,$fld_name,$curr_entity)
	{
	//	mul_dbg($cfg." - ".$fldtype." - ".$fld_name);
		// ������������ � ���� � ��������
		use_scaff_api();
		$_cfg = new \scaff_conf($cfg);
		$dbparams = $_cfg->connect_db_if_exists($this);
				
		switch($fldtype)
		{
			case '_ref': 
				{
					$matches =[];
					preg_match_all('/^(.+)\[(\w+)\]$/Uis', $fld_name,$matches);
					$fld_prefix = $matches[1][0].'[typeinfo]';
					
					$this->UseModel(new \ModelInfo([
						'domen'=>$fld_prefix,//'refentity',
						'fields'=>[						
								'entity_to'=>['Type'=>'text'],
								'fld_to'=>['Type'=>'text']				
						],
						'required'=>['entity_to','fld_to']
				]));

					$_row = $this->_MODEL->empty_row_form_model();

					$fld_prefix = $fld_name;
					
					$_elist = $_cfg->get_entities($this->_CONNECTION, $_cfg);
					$elist = assoc_array_cut($_elist,'NAME');
					$elist = array_diff($elist, [$curr_entity]);					
					//mul_dbg($elist);
					//mul_dbg($curr_entity);
					$_keys = array_keys($elist);
					$_def_entity_key = $_keys[0];
					$def_entity = $elist[$_def_entity_key];
					
					$def_entity = $_cfg->get_entity($def_entity, $_cfg);
					//mul_dbg($_entity);
					$def_entity->SetDrv($this->_CONNECTION);
					$_fields = assoc_array_cut($def_entity->get_fields(),'Field');					
					//mul_dbg($_fields);
					
					$this->out_ajax_block('eref',['cfg'=>$cfg,'elist'=>$elist,'_fields'=>$_fields,'type'=>$fldtype,'row'=>$_row,'prefix'=>$fld_prefix]);
				};break;
			default: 
				{
					$this->UseModel($this->_CONNECTION->type_model($fldtype));
				//	mul_dbg($this->_MODEL);
					$_row = $this->_MODEL->empty_row_form_model();
			//		mul_dbg($_row);
					$fld_prefix = $fld_name;
					$matches =[];
					preg_match_all('/^(.+)\[(\w+)\]$/Uis', $fld_name,$matches);
					$fld_prefix = $matches[1][0].'[typeinfo]';
					$this->out_ajax_block('fldtype_base',['cfg'=>$cfg,'type'=>$fldtype,'row'=>$_row,'prefix'=>$fld_prefix,'nameroot'=>$nameroot]);
				}
		}
	}
	
	public function ActionEfields($cfg,$entity_name)
	{
		$res_array=['items'=>[]];
		
		use_scaff_api();
		$_cfg = new \scaff_conf($cfg);
		$dbparams = $_cfg->connect_db_if_exists($this);
		
		$_entity = $_cfg->get_entity($entity_name, $_cfg);
		$_entity->SetDrv($this->_CONNECTION);
		$fldinfo = $_entity->get_fields();
	//	mul_dbg($fldinfo);
		$res_array['items'] = assoc_array_cut($fldinfo,'Field');
		
		$this->out_json($res_array);
	}
	
	public function ActionSave()
	{
		// ������������ � ���� � ��������
		use_scaff_api();
		$_cfg = new \scaff_conf($_POST['entity']['cfg']);
			
		$dbparams = $_cfg->connect_db_if_exists($this);
		
		$the_entity = new \scaff_entity($_POST['entity'], $_cfg);
		$the_entity->DATA_DRV = $this->_CONNECTION;
		
		$build=(isset($_POST['entity']['build']));
		
		$the_entity->make($this,$build);
		
		
		if(!empty($_POST['entity']['redirect_here']))
		{
			$_SESSION['redirect_here']=true;
			if($_POST['entity']['ename']!=$_POST['entity']['oldname'])
			{
				$addr = $_SERVER['HTTP_REFERER'];
				$addr = str_replace($_POST['entity']['oldname'], $_POST['entity']['ename'], $addr);
				$this->redirect($addr);
			}
			else 
			{
				$this->redirect_back();
			}
		}
		else
		{
			unset($_SESSION['redirect_here']);
			$this->redirect(as_url('emaker/'.$_POST['entity']['cfg']));
		}
	}
	
	public function BeforeValidate(&$bv_params)
	{
		//mul_dbg($_POST);
		
		if(isset($_POST['makenew']))
		{
			$this->_MODEL->scenario('makenew');
			//mul_dbg($this->_MODEL);
		}
		elseif(isset($_POST['entity'])) // ��� �������� ������������������ ��������
		{
			// ������������ � ���� � ��������
			use_scaff_api();
			$_cfg = new \scaff_conf($_POST['entity']['cfg']);
				
			$dbparams = $_cfg->connect_db_if_exists($this);
			
			$this->_MODEL->scenario('efield');
		}
	}
	
	public function BeforeAction(&$params)
	{
		//mul_dbg($params);
		if(!in_array($params['action'], ['typeinfo']))
		{
			$this->add_block('SIDEBAR_LEFT', 'configs', 'conflist');
			$this->add_block('BASE_MENU', 'site', 'menu');
		}
	}
}