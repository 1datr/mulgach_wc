<?php
namespace __master\Frontend;

class ModelEmaker extends \BaseModel
{
	
	function OnScenarioChange()
	{
		switch($this->scenario())
		{
		case 'makenew':{
			$this->_SETTINGS=array(
					'table'=>'frm_makenew',
					'domen'=>'makenew',
				//	'name'=>'makenew',
					'fields'=>[
							'cfg'=>['Type'=>'text'],
							'ename'=>['Type'=>'text'],							
							'auth_entity'=>['Type'=>'boolean'],							
					],
					'required'=>['ename',]
					
			);	
			}; break;
		}
	}
	
}
