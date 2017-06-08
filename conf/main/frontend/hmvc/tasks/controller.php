<?php 


class TasksController extends BaseController
{
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="Tasks";
		$this->add_css($this->get_current_dir()."/css/style.css");
		$this->add_block('LEFT', 'site', 'Blockx');
		$this->add_keyword('tasks');
			
		//print_r($_REQUEST);
		$ds = $this->_MODEL->findAsPager(array('page_size'=>10),$page);
		
		//echo "<h3>tasks</h3>";
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