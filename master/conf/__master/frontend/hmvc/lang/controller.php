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
		$this->_TITLE= Lang::__t("Search");
		
		$this->add_block('BASE_MENU', 'site', 'menu');
	//	$this->add_keyword('xxx');
		$this->out_view('index',array());
	}
	
	public function ActionSearch($lng,$srch_key,$srch_val)
	{
		$this->_TITLE= Lang::__t("Search result by ").$srch_key;
		
		$this->add_block('BASE_MENU', 'site', 'menu');
	//	$this->add_keyword('xxx');
		$this->out_view('index',array());
	}
	
}
?>