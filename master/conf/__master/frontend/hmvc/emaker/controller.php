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
				
				//$fld_passw->fldEnabled('type',false);
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
				
				$typemodel = new \BaseModel('',$this->_MODEL->_ENV,$this->_CONNECTION->type_model($fld_token->getField('type')));
				$typeinfo_row = $typemodel->empty_row_form_model();
				$fld_token->setField('typeinfo', $typeinfo_row,$typemodel);
				
				$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $fld_token));
			}
			
			$this->_TITLE = \Lang::__t('New entity creation');
			$this->out_view('frm_editentity',['sbplugin'=>$sbplugin,'typelist'=>$typelist,'newentity'=>$newentity,'emptyfld'=>$emptyfld,'primaryfld'=>$primaryfld]);
		}				
	}
	
	public function ActionTypeinfo($cfg,$fldtype,$fld_name)
	{
	//	mul_dbg($cfg." - ".$fldtype." - ".$fld_name);
		// подключаемся к базе и драйверу
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$_cfg = new \scaff_conf($cfg);
		$dbparams = $_cfg->connect_db_if_exists($this);
		
		//mul_dbg($dbparams);
			
		$this->UseModel($this->_CONNECTION->type_model($fldtype));
	//	mul_dbg($this->_MODEL);
		$_row = $this->_MODEL->empty_row_form_model();
//		mul_dbg($_row);
		$fld_prefix = $fld_name;
		$matches =[];
		preg_match_all('/^(.+)\[(\w+)\]$/Uis', $fld_name,$matches);
		$fld_prefix = $matches[1][0].'[typeinfo]';
		$this->out_ajax_block('fldtype_base',['cfg'=>$cfg,'type'=>$fldtype,'row'=>$_row,'prefix'=>$fld_prefix]);
	}
	
	public function ActionSave()
	{
		// подключаемся к базе и драйверу
		GLOBAL $_BASEDIR;
		require_once url_seg_add($_BASEDIR,'api/mullib/scaff_api/index.php');
		$_cfg = new \scaff_conf($_POST['entity']['cfg']);
			
		$dbparams = $_cfg->connect_db_if_exists($this);
		
		$table_info = array('fields'=>[],'table'=>$_POST['entity']['ename'],'required'=>[],'primary'=>[]);
		
		foreach($_POST['entity']['fieldlist'] as $idx => $element)
		{
			if(isset($element['primary']))
			{
				
				$table_info['primary']=$element['fldname'];
			}
			
			if(isset($element['required']))
			{
			
				$table_info['required'][]=$element['fldname'];
			}
			
			$table_info['fields'][$element['fldname']]=[
					'Type'=>$element['type'],
					'TypeInfo'=>$this->_CONNECTION->make_fld_info_from_data($element)					
			];
		}
		
		$this->_CONNECTION->create_table($table_info);
		$this->redirect('emaker/'.$_POST['entity']['cfg']);
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