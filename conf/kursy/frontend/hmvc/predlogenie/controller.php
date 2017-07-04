<?php 
class PredlogenieController extends BaseController
{

	public function Rules()
	{
		return array(
			'action_args'=>array(
				'index'=>['page'=>'integer'],	
				'edit'=>['id'=>'integer'],	
				'delete'=>['id'=>'integer'],
			),			
				
		);
	}
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="PREDLOGENIE";
	
		$conn = get_connection();
		
		$this->add_block("BASE_MENU", "users", "menu");

		$ds = $this->_MODEL->findAsPager(array('page_size'=>10),$page);
		
		
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
		$this->add_block("BASE_MENU", "users", "menu");
		$this->_TITLE="CREATE PREDLOGENIE";
		$this->out_view('itemform',array());
	}
	
	public function ActionEdit($id)
	{
		$this->_TITLE="EDIT PREDLOGENIE";
		$this->add_block("BASE_MENU", "users", "menu");
		$predlogenie = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id"); 
		$this->out_view('itemform',array('predlogenie'=>$predlogenie));
	}
	
	public function ActionSave()
	{
		$newitem = $this->_MODEL->GetRow($_POST['predlogenie']);
		$newitem->save();
		
		if(!empty($_POST['back_url']))
			$this->redirect($_POST['back_url']);
		else 
			$this->redirect('/?r=predlogenie');
		
	}
	
	public function ActionDelete($id)
	{
		$this->_MODEL->Delete($this->_MODEL->_SETTINGS['primary']."=".$id);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	
}
?>