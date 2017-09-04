<?php 
class UsersController extends InstallAuthController
{

	function ActionMakeadmin()
	{
		$this->_TITLE=Lang::__t('User registration');
		$this->connect_db_if_exists();
		$reg_form_struct = $this->_MODEL->empty_row_form_model();
		$this->out_view('adduserform',array('reg_struct'=>$reg_form_struct));
	}
	
	public function ActionRegadmin()
	{
		$newitem = $this->_MODEL->findByPrimary($_POST['users']);
	
		if($newitem!=null)
		{
				
		}
		else
		{
			$newitem = $this->_MODEL->empty_row_form_model();
	
		}
		$newitem->FillFromArray($_POST['users']);
	
		$newitem->save();
	
		if(!empty($_POST['back_url']))
			$this->redirect($_POST['back_url']);
			else
				$this->redirect(as_url('users'));
	}
}
?>