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
		$this->out_view('index',['newrow'=>$newrow]);
	}
	
	public function ActionCreationform()
	{
		if(isset($_POST['makenew']))
		{
			$sbplugin = use_jq_plugin('structblock',$this);
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
			
			$emptyfld = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
			
			$this->add_js('#/js/emaker.js');
			
			$primaryfld = $this->_MODEL->nested('fieldlist')->empty_row_form_model();			 
			$primaryfld->setField('fldname', 'id');
			$primaryfld->setField('type',  $this->_CONNECTION->get_basic_type('int'));
			$primaryfld->setField('primary', true);
			$primaryfld->setField('required', true);
			$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $primaryfld));
			if(isset($_POST['makenew']['auth_entity']))	// сущность авторизации
			{
				// login field
				$fld_login = $this->_MODEL->nested('fieldlist')->empty_row_form_model(); 
				$fld_login->setField('fldname', 'login');
				$fld_login->setField('type', $this->_CONNECTION->get_basic_type('text'));
				$fld_login->setField('required', true);
				$fld_login->setField('file_enabled',false);
				$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $fld_login));
				// password field
				$fld_passw = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
				$fld_passw->setField('fldname', 'password');
				$fld_passw->setField('type', $this->_CONNECTION->get_basic_type('text'));
				$fld_passw->setField('required', true);
				$fld_passw->setField('file_enabled',false);
				$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $fld_passw));
				// email field
				$fld_email = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
				$fld_email->setField('fldname', 'email');
				$fld_email->setField('type', $this->_CONNECTION->get_basic_type('text'));
				$fld_email->setField('required', true);
				$fld_email->setField('file_enabled',false);
				$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $fld_email));
				// hash field
				$fld_token = $this->_MODEL->nested('fieldlist')->empty_row_form_model();
				$fld_token->setField('fldname', 'token');
				$fld_token->setField('type', $this->_CONNECTION->get_basic_type('text'));
				$fld_token->setField('required', true);
				$fld_token->setField('file_enabled',false);
				$newentity->setField('fieldlist', x_array_push($newentity->getField('fieldlist'), $fld_token));
			}
			
			$this->_TITLE = \Lang::__t('New entity creation');
			$this->out_view('frm_editentity',['sbplugin'=>$sbplugin,'typelist'=>$typelist,'newentity'=>$newentity,'emptyfld'=>$emptyfld,'primaryfld'=>$primaryfld]);
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
		elseif(isset($_POST['entity']))
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
		$this->add_block('SIDEBAR_LEFT', 'configs', 'conflist');
		$this->add_block('BASE_MENU', 'site', 'menu');
	}
}