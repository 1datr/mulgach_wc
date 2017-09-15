<?php 
namespace Kursy\Backend;

class SlogController extends \BaseController
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
		$this->_TITLE="SLOG";
	
		$conn = get_connection();
		
		$this->add_block("BASE_MENU", "", "menu");

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
		$this->add_block("BASE_MENU", "", "menu");
		$this->_TITLE="CREATE SLOG";
		$this->out_view('itemform',array('slog'=>$this->_MODEL->CreateNew()));
	}
	
	public function ActionEdit($id)
	{		
		$this->add_block("BASE_MENU", "", "menu");
		$slog = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id");
		$this->_TITLE=$slog->getView()." #{EDIT}"; 
		$this->out_view('itemform',array('slog'=>$slog));
	}
	
	public function ActionSave()
	{
		$newitem = $this->_MODEL->findByPrimary($_POST['slog']);
		
		if($newitem!=null)
		{
			
		}
		else 
		{
			$newitem = $this->_MODEL->empty_row_form_model();

		}	
		$newitem->FillFromArray($_POST['slog']);		
		
		$newitem->save();
		
		if(!empty($_POST['back_url']))
			$this->redirect($_POST['back_url']);
		else 
			$this->redirect(as_url('slog'));		
	}
			
	public function ActionDelete($id)
	{
		$this->_MODEL->Delete($this->_MODEL->_SETTINGS['primary']."=".$id);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function ActionView($id)
	{
		$this->add_block("BASE_MENU", "", "menu");
		$slog = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id"); 
		$this->_TITLE=$slog->getView()." #{VIEW}"; 
		$this->out_view('itemview',array('slog'=>$slog));
	}
	
	
}
?>