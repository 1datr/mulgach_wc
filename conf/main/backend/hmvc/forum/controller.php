<?php 
class ForumController extends BaseController
{
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="FORUM";
	
		$conn = get_connection();

		$ds = $this->_MODEL->findAsPager(array('page_size'=>10),$page);
		echo "<h3>FORUM LIST</h3>";
		$this->out_view('index',array('ds'=>$ds));
	}
		
}
?>