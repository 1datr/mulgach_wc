<?php 
class SiteController extends BaseController
{
	public function Rules()
	{
		return array(
			'actions'=>array(
				'access'=>array(
						
			)),
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
	
	public function ActionMenu()
	{
		$menu = $this->getinfo('basemenu');
		//print_r($menu);
		$this->out_view('menu',array('menu'=>$menu));
	}
	
	public function ActionLogin()
	{
		$this->use_layout('layout_login');
		$this->out_view('loginform',array());
	}
	
	public function ActionAuth()
	{
		//$this->out_view('loginform',array());
	}
	
	
	
	public function Logout()
	{
		unset($_SESSION['user']);
		$this->redirect('login');
	}
}
?>