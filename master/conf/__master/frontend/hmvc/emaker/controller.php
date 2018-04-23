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
		
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$_cfg = new \scaff_conf($cfg);
		
		$dbparams = $_cfg->connect_db_if_exists($this);
		
		$entities_table = $_cfg->get_entities($this->_CONNECTION,$_cfg);
		$this->add_js('#/js/emaker.js');
		
		$this->out_view('index',['newrow'=>$newrow,'entities_table'=>$entities_table]);
	}
	
	public function ActionDrop($cfg,$ename)
	{
		// подключаемся к базе и драйверу
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$_cfg = new \scaff_conf($cfg);
		$dbparams = $_cfg->connect_db_if_exists($this);
		$_cfg->_DRV = $this->_CONNECTION;
		$_cfg->delete_entity($ename);
		$this->redirect_back();
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
			
			// подключаемся к базе и драйверу
			GLOBAL $_BASEDIR;
			require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
			$_cfg = new \scaff_conf($_POST['makenew']['cfg']);
			
			$dbparams = $_cfg->connect_db_if_exists($this);
			
			$typelist = $this->_CONNECTION->Typelist();
			$typelist['_ref']=\Lang::__t('Entity reference');
			
			$emptyfld = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
			
			$this->add_js('#/js/emaker.js');
			
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
			
			$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $primaryfld));
			if(isset($_POST['makenew']['auth_entity']))	// сущность авторизации
			{
				// login field
				$fld_login = $this->_MODEL->nested('fieldlist')->empty_row_form_model(); 
				$fld_login->setField('fldname', 'login');
				$fld_login->setField('type', $this->_CONNECTION->get_basic_type('text'));				
				$fld_login->setField('required', true);								
				$fld_login->setField('file_enabled',false);
				$fld_login->setField('deletable', false);
				
				//$fld_login->fldEnabled('type',false);
				$fld_login->fldEnabled('primary',false);
				$fld_login->fldEnabled('required',false);
				
				$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($fld_login->getField('type')));
				$typeinfo_row = $typemodel->empty_row_form_model();
				$fld_login->setField('typeinfo', $typeinfo_row,$typemodel);
				
				$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $fld_login));
				// password field
				$fld_passw = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
				$fld_passw->setField('fldname', 'password');
				$fld_passw->setField('type', $this->_CONNECTION->get_basic_type('text'));
				$fld_passw->setField('required', true);
				$fld_passw->setField('file_enabled',false);
				$fld_passw->setField('deletable', false);
				
				$fld_passw->fldEnabled('primary',false);
				$fld_passw->fldEnabled('required',false);
				
				$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($fld_passw->getField('type')));
				$typeinfo_row = $typemodel->empty_row_form_model();
				$fld_passw->setField('typeinfo', $typeinfo_row,$typemodel);
				
				$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $fld_passw));
				// email field
				$fld_email = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
				$fld_email->setField('fldname', 'email');
				$fld_email->setField('type', $this->_CONNECTION->get_basic_type('text'));
				$fld_email->setField('required', true);
				$fld_email->setField('file_enabled',false);
				$fld_email->setField('deletable', false);
				
				//$fld_email->fldEnabled('type',false);
				$fld_email->fldEnabled('primary',false);
				$fld_email->fldEnabled('required',false);
				
				$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($fld_email->getField('type')));
				$typeinfo_row = $typemodel->empty_row_form_model();
				$fld_email->setField('typeinfo', $typeinfo_row,$typemodel);
				
				$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $fld_email));
				// hash field
				$fld_token = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
				$fld_token->setField('fldname', 'token');
				$fld_token->setField('type', $this->_CONNECTION->get_basic_type('text'));
				$fld_token->setField('required', true);
				$fld_token->setField('file_enabled',false);
				
				//$fld_token->fldEnabled('type',false);
				$fld_token->fldEnabled('primary',false);
				$fld_token->fldEnabled('required',false);
				$fld_token->setField('deletable', false);
				
				$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($fld_token->getField('type')));
				$typeinfo_row = $typemodel->empty_row_form_model();
				$fld_token->setField('typeinfo', $typeinfo_row,$typemodel);
				
				$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $fld_token));
			}
			
			$emptyfld = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
			
			$this->_TITLE = \Lang::__t('New entity creation');
			$this->out_view('frm_editentity',['sbplugin'=>$sbplugin,'typelist'=>$typelist,'mode'=>'create','newentity'=>$newentity,'emptyfld'=>$emptyfld,'primaryfld'=>$primaryfld]);
		}				
	}

	
	public function ActionEdit($cfg,$_ename)
	{
		$sbplugin = use_jq_plugin('structblock',['controller'=>$this,'onadd'=>""]);
		$this->_MODEL->scenario("efield");
		
		// подключаемся к базе и драйверу
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$_cfg = new \scaff_conf($cfg);
		
		$dbparams = $_cfg->connect_db_if_exists($this);
		
		$entity = $_cfg->get_entity($_ename,$_cfg);
		
		$entity->SetDrv($this->_CONNECTION);
		
		$fields = $entity->get_fields();
		
		$editing_entity = $this->_MODEL->empty_row_form_model();
		//mul_dbg($_POST);
		$editing_entity->setField('cfg', $cfg);
		$editing_entity->setField('ename', $_ename);
		$editing_entity->setField('oldname', $_ename);
		$editing_entity->setField('fieldlist', array());
		
	//	mul_dbg($fields);
		foreach ($fields as $fld =>$fld_params)
		{
			$thefld = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
			$thefld->setField('fldname', $fld);
			$thefld->setField('fldname_old', $fld);
			$thefld->setField('type', $fld_params['Type']);
			$thefld->setField('primary', ($fld_params['Key']=='PRI'));
			$thefld->setField('deletable', ($fld_params['Key']!='PRI'));
			$thefld->setField('required',($fld_params['Null']=='NO'));
			$thefld->setField('file_enabled',false);
			
			$thefld->setField('defval', $fld_params['Default']);
				
			$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($thefld->getField('type')));
			$typeinfo_row = $typemodel->empty_row_form_model();
			$thefld->setField('typeinfo', $typeinfo_row,$typemodel);
			
			$editing_entity->setField('fieldlist', x_array_push($editing_entity->getField('fieldlist'), $thefld));
			
		} 
		
		$emptyfld = $this->_MODEL->nested('fieldlist')->empty_row_form_model();

		
		$this->add_js('#/js/emaker.js');
		$this->_TITLE = \Lang::__t('Edit entity '.$_ename);
		
		$typelist = $this->_CONNECTION->Typelist();
		$typelist['_ref']=\Lang::__t('Entity reference');
	
		$this->out_view('frm_editentity',['sbplugin'=>$sbplugin,'typelist'=>$typelist,'newentity'=>$editing_entity,'mode'=>'save','emptyfld'=>$emptyfld]);
		
	}
	
	public function ActionTypeinfo($cfg,$fldtype,$fld_name,$curr_entity)
	{
	//	mul_dbg($cfg." - ".$fldtype." - ".$fld_name);
		// подключаемся к базе и драйверу
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
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
					
					$elist = assoc_array_cut($_cfg->get_entities($this->_CONNECTION, $_cfg),'NAME');
					$elist = array_diff($elist, [$curr_entity]);					
					
					$_entity = $_cfg->get_entity($curr_entity, $_cfg);
					$_entity->SetDrv($this->_CONNECTION);
					$_fields = assoc_array_cut($_entity->get_fields(),'Field');					
					
					
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
		
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$_cfg = new \scaff_conf($cfg);
		$dbparams = $_cfg->connect_db_if_exists($this);
		
		$_entity = $_cfg->get_entity($entity_name, $_cfg);
		$_entity->SetDrv($this->_CONNECTION);
		$fldinfo = $_entity->get_fields();
		mul_dbg($fldinfo);
		$res_array['items'] = assoc_array_cut($fldinfo,'Field');
		
		$this->out_json($res_array);
	}
	
	public function ActionSave()
	{
		// подключаемся к базе и драйверу
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$_cfg = new \scaff_conf($_POST['entity']['cfg']);
			
		$dbparams = $_cfg->connect_db_if_exists($this);
		
		$the_entity = new \scaff_entity($_POST['entity'], $_cfg);
		$the_entity->DATA_DRV = $this->_CONNECTION;
		$the_entity->make();
		
		if(!empty($_POST['entity']['redirect_here']))
		{
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
			$this->redirect(as_url('emaker/'.$_POST['entity']['cfg']));
	}
	
	public function BeforeValidate(&$bv_params)
	{
		//mul_dbg($_POST);
		
		if(isset($_POST['makenew']))
		{
			$this->_MODEL->scenario('makenew');
			//mul_dbg($this->_MODEL);
		}
		elseif(isset($_POST['entity'])) // при создании либоредактирование сущности
		{
			// подключаемся к базе и драйверу
			GLOBAL $_BASEDIR;
			require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
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