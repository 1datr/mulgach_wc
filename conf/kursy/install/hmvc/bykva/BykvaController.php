<?php 
namespace Kursy\Install;

class BykvaController extends \BaseController
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
		$this->_TITLE="BYKVA";
	
		$conn = get_connection();
		
		

		$ds = $this->_MODEL->findAsPager(array('page_size'=>10),$page,1,$this->getRequest()->getArg('ord'));
		
		
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
		
		$this->_TITLE="CREATE BYKVA";
		$this->out_view('itemform',array('bykva'=>$this->_MODEL->CreateNew()));
	}
	
	public function ActionEdit($id)
	{		
		
		$bykva = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id");
		$this->_TITLE=$bykva->getView()." #{EDIT}"; 
		$this->out_view('itemform',array('bykva'=>$bykva));
	}
	
	public function ActionSave()
	{
		$newitem = $this->_MODEL->findByPrimary($_POST['bykva']);
		
		if($newitem!=null)
		{
			
		}
		else 
		{
			$newitem = $this->_MODEL->empty_row_form_model();

		}	
		$newitem->FillFromArray($_POST['bykva']);		
		
		$newitem->save();
		
		if(!empty($_POST['back_url']))
			$this->redirect($_POST['back_url']);
		else 
			$this->redirect(as_url('bykva'));		
	}
			
	public function ActionDelete($id)
	{
		$this->_MODEL->Delete($this->_MODEL->_SETTINGS['primary']."=".$id);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function ActionView($id)
	{
		
		$bykva = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id"); 
		$this->_TITLE=$bykva->getView()." #{VIEW}"; 
		$this->out_view('itemview',array('bykva'=>$bykva));
	}
	
	
}
?>