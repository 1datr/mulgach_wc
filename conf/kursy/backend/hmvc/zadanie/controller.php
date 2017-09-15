<?php 
namespace Kursy\Backend;

class ZadanieController extends \AuthController
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
						new \ActionAccessRule('deny',_array_diff($this->getActions(),array('login','auth')),'anonym','zadanie/login')
				),	
		);
	}
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="ZADANIE";
	
		$conn = get_connection();
		
		$this->add_block("BASE_MENU", "bykva", "menu");

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
		$this->add_block("BASE_MENU", "bykva", "menu");
		$this->_TITLE="CREATE ZADANIE";
		$this->out_view('itemform',array('zadanie'=>$this->_MODEL->CreateNew()));
	}
	
	public function ActionEdit($id)
	{		
		$this->add_block("BASE_MENU", "bykva", "menu");
		$zadanie = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id");
		$this->_TITLE=$zadanie->getView()." #{EDIT}"; 
		$this->out_view('itemform',array('zadanie'=>$zadanie));
	}
	
	public function ActionSave()
	{
		$newitem = $this->_MODEL->findByPrimary($_POST['zadanie']);
		
		if($newitem!=null)
		{
			
		}
		else 
		{
			$newitem = $this->_MODEL->empty_row_form_model();

		}	
		$newitem->FillFromArray($_POST['zadanie']);		
		
		$newitem->save();
		
		if(!empty($_POST['back_url']))
			$this->redirect($_POST['back_url']);
		else 
			$this->redirect(as_url('zadanie'));		
	}
			
	public function ActionDelete($id)
	{
		$this->_MODEL->Delete($this->_MODEL->_SETTINGS['primary']."=".$id);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function ActionView($id)
	{
		$this->add_block("BASE_MENU", "bykva", "menu");
		$zadanie = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id"); 
		$this->_TITLE=$zadanie->getView()." #{VIEW}"; 
		$this->out_view('itemview',array('zadanie'=>$zadanie));
	}
	
	
	public function ActionLogin()
	{
		$this->_TITLE=\Lang::__t('Authorization');
		$this->use_layout('layout_login');
		$this->out_view('loginform',array());
	}
	
	public function ActionAuth()
	{
		$auth_res = $this->_MODEL->auth($_POST[''],$_POST['']);
		if($auth_res)
		{
			$_SESSION[$this->get_ep_param('sess_user_descriptor')]=array(''=>$_POST['']);
			
			if(!empty($_POST['url_required']))
				$this->redirect($_POST['url_required']);
			else
				$this->redirect(as_url('zadanie'));
		}
		else 
			$this->redirect_back();

		//$this->out_view('loginform',array());
	}
	
	
	
	public function ActionLogout()
	{
		$this->logout();
		$this->redirect(as_url('zadanie/login'));
	}
}
?>