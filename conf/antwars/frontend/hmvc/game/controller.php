<?php 
namespace Antwars\Frontend;

class GameController extends \BaseController
{

	public function Rules()
	{
		return array(
			'action_args'=>array(
				'index'=>['page'=>'integer'],	
				'edit'=>['id'=>'integer'],	
				'delete'=>['id'=>'integer'],
			),			
			'action_access'=>array(
						new \ActionAccessRule('deny',$this->getActions(),'anonym','/login')
				),	
		);
	}
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="GAME";
	
		$conn = get_connection();
		
		$this->add_block("BASE_MENU", "", "menu");

		$ds = $this->_MODEL->findAsPager(array('page_size'=>10),$page,1,$this->getRequest()->getArg('ord'));
		
		
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
		$this->add_block("BASE_MENU", "", "menu");
		$this->_TITLE="CREATE GAME";
		$this->out_view('itemform',array('game'=>$this->_MODEL->CreateNew()));
	}
	
	public function ActionEdit($id)
	{		
		$this->add_block("BASE_MENU", "", "menu");
		$game = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id");
		$this->_TITLE=$game->getView()." #{EDIT}"; 
		$this->out_view('itemform',array('game'=>$game));
	}
	
	public function ActionSave()
	{
		$newitem = $this->_MODEL->findByPrimary($_POST['game']);
		
		if($newitem!=null)
		{
			
		}
		else 
		{
			$newitem = $this->_MODEL->empty_row_form_model();

		}	
		$newitem->FillFromArray($_POST['game']);		
		
		$newitem->save();
		
		if(!empty($_POST['back_url']))
			$this->redirect($_POST['back_url']);
		else 
			$this->redirect(as_url('game'));		
	}
			
	public function ActionDelete($id)
	{
		$this->_MODEL->Delete($this->_MODEL->_SETTINGS['primary']."=".$id);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function ActionView($id)
	{
		$this->add_block("BASE_MENU", "", "menu");
		$game = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id"); 
		$this->_TITLE=$game->getView()." #{VIEW}"; 
		$this->out_view('itemview',array('game'=>$game));
	}
	
	
}
?>