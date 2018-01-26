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
			$emptyfld = $this->_MODEL->empty_row_form_model();
			$primaryfld = $this->_MODEL->empty_row_form_model();
			$primaryfld->setField('fldname', 'id');
			$primaryfld->setField('type', 'integer');
			$primaryfld->setField('primary', true);
			$this->out_view('frm_editentity',['sbplugin'=>$sbplugin,'emptyfld'=>$emptyfld,'primaryfld'=>$primaryfld]);
		}				
	}
	
	public function BeforeAction(&$params)
	{
		$this->add_block('SIDEBAR_LEFT', 'configs', 'conflist');
		$this->add_block('BASE_MENU', 'site', 'menu');
	}
}