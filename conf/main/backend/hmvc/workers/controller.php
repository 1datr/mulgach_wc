<?php 
class WorkersController extends BaseController
{
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="WORKERS";
	
		$conn = get_connection();

		$ds = $this->_MODEL->findAsPager(array('page_size'=>10),$page);
		echo "<h3>WORKERS LIST</h3>";
		
		$this->inline_script("
		    $( document ).ready(function() {
        		$('.ref_delete').click(function() 
        		{
        			if(confirm('������� ������?'))
        			{
        				return true;
        			}
        			return false;
        		});
    		});
		");
		
		$this->out_view('index',array('ds'=>$ds));
	}
	
	public function ActionCreate()
	{
		$this->_TITLE="CREATE WORKERS";
		$this->out_view('itemform',array());
	}
	
	public function ActionEdit($id)
	{
		$this->_TITLE="EDIT WORKERS";
		$workers = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id"); 
		$this->out_view('itemform',array('workers'=>$workers));
	}
	
	public function ActionSave()
	{
		$newitem = $this->_MODEL->CreateNew($_POST['workers']);
		$newitem->save();
		
		if(!empty($_POST['back_url']))
			$this->redirect($_POST['back_url']);
		else 
			$this->redirect('/?r=workers');
		
	}
	
	public function ActionDelete($id)
	{
		$this->_MODEL->Delete($this->_MODEL->_SETTINGS['primary']."=".$id);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
}
?>