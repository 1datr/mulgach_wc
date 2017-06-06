<?php 
class SiteController extends BaseController
{
		
	public function ActionIndex()
	{
		$this->_TITLE="Master";
		$this->add_css($this->get_current_dir()."/css/style.css");
		
		$this->add_block('BASE_MENU', 'site', 'menu');
		$this->add_keyword('xxx');
		$this->out_view('index',array());
	}
	
	public function ActionBlockx()
	{
		echo "<p>12121212
				12212313
				123213</p>";
	}
	
	public function ActionMenu()
	{
		$menu = $this->getinfo('basemenu');
		//print_r($menu);
		$this->out_view('menu',array('menu'=>$menu));
	}
	
	public function ActionWorkers()
	{
		$this->_TITLE="Workers";
		$this->add_css($this->get_current_dir()."/css/style.css");
		$this->add_block('LEFT', 'site', 'Blockx');
		$this->add_keyword('workers');
		echo "<h3>workers</h3>";
	}
}
?>