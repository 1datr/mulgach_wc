<?php 
class KursyController extends BaseController
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
		$this->_TITLE="KURSY";
	
		$conn = get_connection();
		
		$this->add_block("BASE_MENU", "kursy", "menu");

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
		$this->add_block("BASE_MENU", "kursy", "menu");
		$this->_TITLE="CREATE KURSY";
		$this->out_view('itemform',array());
	}
	
	public function ActionEdit($id)
	{
		$this->_TITLE="EDIT KURSY";
		$this->add_block("BASE_MENU", "kursy", "menu");
		$kursy = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id"); 
		$this->out_view('itemform',array('kursy'=>$kursy));
	}
	
	public function ActionSave()
	{
		$newitem = $this->_MODEL->GetRow($_POST['kursy']);
		$newitem->save();
		
		if(!empty($_POST['back_url']))
			$this->redirect($_POST['back_url']);
		else 
			$this->redirect('/?r=kursy');
		
	}
	
	public function ActionDelete($id)
	{
		$this->_MODEL->Delete($this->_MODEL->_SETTINGS['primary']."=".$id);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function ActionMenu()
	{
		$menu = $this->getinfo('basemenu');
		//print_r($menu);
		$this->out_view('menu',array('menu'=>$menu));
	}
}
?>