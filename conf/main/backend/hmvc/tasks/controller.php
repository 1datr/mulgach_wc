<?php 
class TasksController extends BaseController
{
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="TASKS";
	
		$conn = get_connection();

		$ds = $this->_MODEL->findAsPager(array('page_size'=>10),$page);
		echo "<h3>TASKS LIST</h3>";
		$this->out_view('index',array('ds'=>$ds));
	}
		
}
?>