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
	
	function ActionRegadmin()
	{
	
	}
}
?>