<?php
class EmakerController extends BaseController
{
	public function Rules()
	{
		return array(
				'action_access'=>array(
						new ActionAccessRule('deny',$this->getActions(),'anonym','?r=site/login')
				),
		);
	}
	
	public function ActionIndex($cfg=NULL)
	{
		$this->out_view('index',[]);
	}
	
	public function BeforeAction(&$params)
	{
		$this->add_block('SIDEBAR_LEFT', 'configs', 'conflist');
		$this->add_block('BASE_MENU', 'site', 'menu');
	}
}