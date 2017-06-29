<?php 
class ForumController extends BaseController
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
		$this->_TITLE="FORUM";
	
		$conn = get_connection();
		
		$this->add_block("BASE_MENU", "forum", "menu");

		$ds = $this->_MODEL->findAsPager(array('page_size'=>10),$page);
		
		
		$this->inline_script("
		    $( document ).ready(function() {
        		$('.ref_delete').click(function() 
        		{
        			if(confirm('Удалить объект?'))
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
		$this->add_block("BASE_MENU", "forum", "menu");
		$this->_TITLE="CREATE FORUM";
		$this->out_view('itemform',array());
	}
	
	public function ActionEdit($id)
	{
		$this->_TITLE="EDIT FORUM";
		$this->add_block("BASE_MENU", "forum", "menu");
		$forum = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id"); 
		$this->out_view('itemform',array('forum'=>$forum));
	}
	
	public function ActionSave()
	{
		$newitem = $this->_MODEL->GetRow($_POST['forum']);
		$newitem->save();
		
		if(!empty($_POST['back_url']))
			$this->redirect($_POST['back_url']);
		else 
			$this->redirect('/?r=forum');
		
	}
	
	public function ActionDelete($id)
	{
		$this->_MODEL->Delete($this->_MODEL->_SETTINGS['primary']."=".$id);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	
}
?>