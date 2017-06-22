<?php
require_once url_seg_add(__DIR__,"dataset.php");

class ActionAccessRule {

	VAR $_type;
	VAR $_objects;
	VAR $_roles;
	VAR $_redirect=NULL;
	function __construct($rule_type,$rule_objects,$roles,$redirect_url=NULL)
	{
		$this->_type=$rule_type;
		$this->_objects=$rule_objects;
		$this->_roles=$roles;
		$this->_redirect=$redirect_url;
	}
	
	function is_anonym()
	{
		return empty($_SESSION['user']);
	}

	function calc_for($controller,$action)
	{
		$res = $this->calc_availability($controller,$action);
		
		if($res==false)
		{
			if(is_string($this->_redirect) && (!empty($this->_redirect)))
				$controller->redirect($this->_redirect);
		}
		return $res;
	}
	
	function calc_availability($controller,$action)
	{
		if($this->_roles=='anonym')
		{
			if(! $this->is_anonym() )
			{
				return true;
			}
		}
		switch($this->_type)
		{
		
			case 'deny':{
				if(in_array($action, $this->_objects))
				{
					return false;
				}
				else 
				{
					return true;
				}
			} break;
			case 'allow':{
				if(in_array($action, $this->_objects))
				{
					return true;
				}
				else
				{
					return false;
				}
			} break;
		}
		return true;
	}
}

class AuthModel extends BaseModel
{
	function load_auth_data()
	{
		if(!empty($this->_SETTINGS['authdata']))
		{
			switch($this->_SETTINGS['authdata']['type'])
			{
				case 'info':
						$data = $this->_ENV['_CONTROLLER']->getinfo($this->_SETTINGS['authdata']['src']);
						
					break;
				case 'db': 
					
					break;
				
			}
		}
		return array('data'=>$data,'type'=>$this->_SETTINGS['authdata']['type']);
	}
	
	function auth($user,$passw)
	{
		$the_data = $this->load_auth_data();
		
		if($the_data['type']=='info')
		{
			
			foreach ($the_data['data'] as $idx => $userobj)
			{
				if(($userobj['login']==$user) && ($userobj['password']==$passw))
				{
					return true;
				}
			}
			
		}
		return false;
	}
	
	function auth_db($user,$passw,$auth_info)
	{
		
	}
	
	function CreateNew($row)
	{
		$real_row = $row;
		$real_row['password']=md5(md5(trim($real_row['password'])));
		$dr = parent::CreateNew($real_row);		
		return $dr;
	}
}