<?php 
class OtdelController extends BaseController
{
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="OTDEL";
	
		$conn = get_connection();

		$ds = $this->_MODEL->findAsPager(array('page_size'=>10),$page);
		echo "<h3>OTDEL LIST</h3>";
		$this->out_view('index',array('ds'=>$ds));
	}
	
	public function ActionCreate()
	{
		$this->_TITLE="CREATE OTDEL";
		$this->out_view('itemform',array());
	}
		
}
?>