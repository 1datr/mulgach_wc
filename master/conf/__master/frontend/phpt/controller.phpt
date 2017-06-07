<?php 
class {table_uc_first}Controller extends BaseController
{
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="{TABLE_UC}";
	
		$conn = get_connection();

		$ds = $this->_MODEL->findAsPager(array('page_size'=>10),$page);
		echo "<h3>{TABLE_UC} LIST</h3>";
		$this->out_view('index',array('ds'=>$ds));
	}
		
}
?>