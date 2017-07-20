<?php
require_once url_seg_add(__DIR__,"dataset.php");

class ActionAccessRule {

	VAR $_type;
	VAR $_objects;
	VAR $_roles;
	VAR $_redirect=NULL;
	VAR $_controller;
	function __construct($rule_type,$rule_objects,$roles,$redirect_url=NULL)
	{
		$this->_type=$rule_type;
		$this->_objects=$rule_objects;
		$this->_roles=$roles;
		$this->_redirect=$redirect_url;
	}
	
	function is_anonym()
	{
		$descr = $this->_controller->get_ep_param('sess_user_descriptor');
		return empty($_SESSION[$descr]);
	}

	function calc_for($controller,$action)
	{
		//print_r($controller->_ENV);
		
		$res = $this->calc_availability($controller,$action);
		
		if($res==false)
		{
			if(is_string($this->_redirect) && (!empty($this->_redirect)))
				$controller->redirect(as_url($this->_redirect));
			elseif(is_callable($this->redirect))
			{
				$this->redirect();
			}
		}
		return $res;
	}
	
	function calc_availability($controller,$action)
	{
		$this->_controller = $controller;
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
	function rules()
	{
		$this->read_base_info();
		switch($this->scenario())
		{
			case 'default': 
				return array();
			case 'register': {
				//mul_dbg($this->_SETTINGS);
				$adata = $this->load_auth_data();
				$passw_fld = $adata['data']['passw_field'];
				$passw_fld2 = $passw_fld."_re";
				//mul_dbg($adata);
				$settings=$this->_SETTINGS;
				$settings['fields'][$passw_fld2]=$settings['fields'][$passw_fld];
				return $settings;
			};break;
		}
		return array();
	}
	
	function load_auth_data()
	{
		if(!empty($this->_SETTINGS['authdata']))
		{
			def_options(array('type'=>'db','src'=>$this->_SETTINGS['table'],'ADDITON_WHERE'=>'1'), $this->_SETTINGS['authdata']);
			
			switch($this->_SETTINGS['authdata']['type'])
			{
				case 'info':
						$data = $this->_ENV['_CONTROLLER']->getinfo($this->_SETTINGS['authdata']['src']);
						$auth_settings = array();
					break;
				case 'db': 
						$data = $this->_SETTINGS['authdata'];
						$auth_settings = $this->_SETTINGS['authdata'];
					break;
				
			}
		}
		else 
		{
			$auth_settings = array();
		//	return array('data'=>$this->_SETTINGS['table'],'type'=>'db','settings'=>$auth_settings);
		}
		return array('data'=>$data,'type'=>$this->_SETTINGS['authdata']['type'],'settings'=>$auth_settings);
	}
	
	function auth($user,$passw)
	{
		$the_data = $this->load_auth_data();
		
		if($the_data['type']=='info')	// авторизация из инфо-файла
		{
			
			foreach ($the_data['data'] as $idx => $userobj)
			{
				//mul_dbg($user." : ".$passw);
				//mul_dbg($userobj);
				if(($userobj['login']==$user) && ($userobj['password']==$passw))
				{
					return true;
				}
			}
			
		}
		else // авторизация из бд
		{
			$row = $this->auth_db($user, $passw, $the_data);
			return $row;
		}
		return false;
	}
	
	function auth_db($user,$passw,$auth_info)
	{
		$user = $this->_ENV['_CONNECTION']->escape_val(trim($user));
		$passw = $this->_ENV['_CONNECTION']->escape_val(trim($passw));
	//	echo md5(md5($passw));
		$ADDITON_WHERE='1';
		//print_r($auth_info);
		$sql="SELECT * FROM @+".$auth_info['data']['src']." WHERE `".$auth_info['data']['login_field']."`='{$user}' AND 
		`".$auth_info['data']['passw_field']."`='".md5(md5($passw))."' AND ".$auth_info['data']['ADDITON_WHERE'];
	
		$res = $this->db_query($sql);
		// SELECT * FROM crm_workers WHERE `login`='adm' AND `password`='32ddd9055fd7f497d2a9c386e4775032'
		if($res!=NULL)
		{
			$row = $this->_ENV['_CONNECTION']->get_row($res);
			unset($row[$auth_info['data']['passw_field']]);
			return $row;
		}
		return NULL;
	}
	
	function validate($data)
	{
		$the_action = $this->_ENV['page_module']->_REQUEST->_args[0];
		if($the_action=='auth')
		{
			$res = array();
			$res_auth = $this->auth($data['login'], $data['password']);
			if($res_auth==false)
			{
				add_keypair($res,'auth',Lang::__t('Wrong login or password'));
			}
			$this->OnValidate($_POST, $res);
			return $res;
		}
		else 
			return parent::validate($data);
	}
	
	function getFldInfo($fld)
	{
		$res = parent::getFldInfo($fld);
		$auth_data = $this->load_auth_data();
		$res['password'] = ($auth_data['settings']['passw_field']==$fld);
		$res['login'] = ($auth_data['settings']['login_field']==$fld);
		return $res;		
	}
	
	function OnSave(&$object)
	{		
		$the_data = $this->load_auth_data();
		//print_r($object);
		$passw = $object->getField($the_data['settings']['passw_field']);
		echo $passw;
		$object->set_field($the_data['settings']['passw_field'], md5(md5($passw)) );
	}
	
	function CreateNew($row=NULL)
	{
		$real_row = $row;
		if(isset($real_row['password']))
			$real_row['password']=md5(md5(trim($real_row['password'])));
		$dr = parent::CreateNew($real_row);		
		return $dr;
	}
}