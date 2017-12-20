<?php 
namespace Kursy\Install;

class StudentController extends \InstallAuthController
{

	function ActionMakeadmin()
	{
		$this->_TITLE=\Lang::__t('User registration');
		$this->connect_db_if_exists();
		$reg_form_struct = $this->_MODEL->empty_row_form_model();
		$this->out_view('adduserform',array('reg_struct'=>$reg_form_struct));
	}
	
	public function ActionRegadmin()
	{
		$this->connect_db_if_exists();
		$this->_MODEL->reguser($_POST['student']);
		$this->redirect(as_url('student/regsuccess'));
	}
	
	public function BeforeAction(&$params)
	{
		if(in_array($params['action'],array('regadmin')))
		{
			$this->_MODEL->scenario("register");
		}
		elseif($params['action']=='validate')
		{
			$req = $this->getRequest();
			if($req->_args[0]=="regadmin")
			{
				$this->_MODEL->scenario('register');
			}
		}
	}
}
?>