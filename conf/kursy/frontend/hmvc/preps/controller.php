<?php 
namespace Kursy\Frontend;

class PrepsController extends \AuthController
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
						new \ActionAccessRule('deny',_array_diff($this->getActions(),array('login','auth','register','makeuser','regsuccess')),'anonym','preps/login')
				),	
		);
	}
		
	public function ActionIndex($page=1)
	{
		$this->_TITLE="PREPS";
	
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
		$this->_TITLE="CREATE PREPS";
		$this->out_view('itemform',array('preps'=>$this->_MODEL->CreateNew()));
	}
	
	public function ActionEdit($id)
	{		
		$this->add_block("BASE_MENU", "users", "menu");
		$preps = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id");
		$this->_TITLE=$preps->getView()." #{EDIT}"; 
		$this->out_view('itemform',array('preps'=>$preps));
	}
	
	public function ActionSave()
	{
		$newitem = $this->_MODEL->findByPrimary($_POST['preps']);
		
		if($newitem!=null)
		{
			
		}
		else 
		{
			$newitem = $this->_MODEL->empty_row_form_model();

		}	
		$newitem->FillFromArray($_POST['preps']);		
		
		$newitem->save();
		
		if(!empty($_POST['back_url']))
			$this->redirect($_POST['back_url']);
		else 
			$this->redirect(as_url('preps'));		
	}
			
	public function ActionDelete($id)
	{
		$this->_MODEL->Delete($this->_MODEL->_SETTINGS['primary']."=".$id);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function ActionView($id)
	{
		$this->add_block("BASE_MENU", "users", "menu");
		$preps = $this->_MODEL->findOne('*.'.$this->_MODEL->getPrimaryName()."=$id"); 
		$this->_TITLE=$preps->getView()." #{VIEW}"; 
		$this->out_view('itemview',array('preps'=>$preps));
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
				$this->redirect(as_url('preps'));
		}
		else 
			$this->redirect_back();

		//$this->out_view('loginform',array());
	}
	
	
	
	public function ActionLogout()
	{
		$this->logout();
		$this->redirect(as_url('preps/login'));
	}public function ActionRegister()
{
	$this->_TITLE=Lang::__t('User registration');
	$reg_form_struct = $this->_MODEL->empty_row_form_model();
	$this->out_view('register',array('captcha'=>$captcha,'reg_struct'=>$reg_form_struct));
}
	
public function ActionMakeuser()
{
	$this->_MODEL->reguser($_POST['preps']);
	$this->redirect(as_url('preps/regsuccess'));
}

public function ActionRegsuccess()
{
	$this->out_view('regsuccess',[]);
}

public function BeforeAction(&$params)
{
	if(in_array($params['action'],array('makeuser')))
	{
		$this->_MODEL->scenario("register");
	}	
	elseif($params['action']=='validate')
	{
		$req = $this->getRequest();
		if($req->_args[0]=="makeuser")
		{
			$this->_MODEL->scenario('register');			
		}
	}
}
}
?>