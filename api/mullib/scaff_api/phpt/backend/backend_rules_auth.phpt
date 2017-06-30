'action_access'=>array(
						new ActionAccessRule('deny',_array_diff($this->getActions(),array('login','auth')),'anonym','?r={auth_con}/login')
				),