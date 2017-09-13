<?php
namespace __master\Frontend;

class ModelHmvc extends \BaseModel
{
	
	function OnScenarioChange()
	{
		switch($this->scenario())
		{
		case 'total':{
			$this->_SETTINGS=array(
					'domen'=>'settings_total',
					'fields'=>[
							'cfg'=>['Type'=>'text'],							
							'rewrite_all'=>['Type'=>'boolean'],
							'ignore_existing'=>['Type'=>'boolean'],
							'autofind_auth'=>['Type'=>'boolean','defval'=>true],
					],
					'required'=>['cfg',]
					
			);	
			}; break;
		}
	}
	
}

