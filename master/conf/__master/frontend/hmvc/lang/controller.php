<?php 
class LangController extends BaseController
{
	public function Rules()
	{
		return array(
			'action_access'=>array(
					new ActionAccessRule('deny',$this->getActions(),'anonym','site/login')
			),
		);
	}
		
	public function ActionIndex()
	{
		$this->_TITLE="Master";
		$this->add_css($this->get_current_dir()."/css/style.css");
		
		$this->add_block('BASE_MENU', 'site', 'menu');
		$this->add_keyword('xxx');
		$this->out_view('index',array());
	}
	
}
?>