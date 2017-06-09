<?php 
class ProjectsController extends BaseController
{
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="PROJECTS";
	
		$conn = get_connection();

		$ds = $this->_MODEL->findAsPager(array('page_size'=>10),$page);
		echo "<h3>PROJECTS LIST</h3>";
		$this->out_view('index',array('ds'=>$ds));
	}
	
	public function ActionCreate()
	{
		$this->_TITLE="CREATE PROJECTS";
		$this->out_view('itemform',array());
	}
	
	public function ActionEdit($id)
	{
		$this->_TITLE="EDIT PROJECTS";
		$projects = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id"); 
		$this->out_view('itemform',array('projects'=>$projects));
	}
	
	public function ActionSave()
	{
	
	}
		
}
?>