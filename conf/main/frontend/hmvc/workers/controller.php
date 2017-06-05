<?php 
class WorkersController extends BaseController
{
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="Workers";
		$this->add_css($this->get_current_dir()."/css/style.css");
		$this->add_block('LEFT', 'site', 'Blockx');
		$this->add_keyword('workers');
			
		//print_r($_REQUEST);
		if(empty($_REQUEST['page'])) $_REQUEST['page']=1;
		$ds = $this->_MODEL->findAsPager(array('page_size'=>4),$_REQUEST['page']);
		
		echo "<h3>workers</h3>";
		$this->out_view('index',array('ds'=>$ds));
	}
	
	public function ActionBlockx()
	{
		$this->out_view('blocks/block1',array('i'=>'xXXXx'));
	}
	
	public function ActionWorkers()
	{
		
	}
}
?>