<?php 
class SiteController extends BaseController
{
	public function Rules()
	{
		return array(
			'action_access'=>array(
				new ActionAccessRule('deny',_array_diff($this->getActions(),array('login','auth')),'anonym','?r=site/login')	
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
	//	print_r($_POST);
		$auth_res = $this->_MODEL->auth($_POST['login'],$_POST['passw']);
		if($auth_res)
		{
			$_SESSION['user']=array('login'=>$_POST['login']);
			//echo "xxx";
			$this->redirect('?r=site');
		}
		else 
			$this->redirect_back();
		//echo $res;
		//$this->out_view('loginform',array());
	}
	
	
	
	public function ActionLogout()
	{
		unset($_SESSION['user']);
		$this->redirect('?r=site/login');
	}
}
?>