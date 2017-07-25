public function ActionRegister()
{
	$this->_TITLE=Lang::__t('User registration');
	$captcha = mul_captcha::use_captcha($this);
	$reg_form_struct = $this->_MODEL->empty_row_form_model();
	$this->out_view('register',array('captcha'=>$captcha,'reg_struct'=>$reg_form_struct));
}
	
public function ActionMakeuser()
{

}

public function BeforeAction(&$params)
{
	if(in_array($params['action'],array('makeuser')))
	{
		$this->_MODEL->scenario("register");
	}	
	elseif($params['action']=='validate')
	{
		mul_dbg($params);
		$this->_MODEL->scenario("register");
	}
}