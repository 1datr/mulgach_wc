<?php
namespace __master\Frontend;

class ModelModules extends \BaseModel
{
	
	function OnScenarioChange()
	{
		switch($this->scenario())
		{
			case 'makemod':{
				$this->_SETTINGS=array(
					//	'table'=>'frm_makenew',
						'domen'=>'makenew',
					//	'name'=>'makenew',
						'fields'=>[
								'cfg'=>['Type'=>'text'],
								'modname'=>['Type'=>'text'],
								'modparent'=>['Type'=>'text'],
								'settings'=>['Type'=>'boolean'],							
						],
						'required'=>['modname',]
						
				);	
				}; break;
			case 'makeplg':{
				$this->_SETTINGS=array(
					//	'table'=>'frm_makenew',
						'domen'=>'entity',
						//	'name'=>'makenew',						
						'fields'=>[
								'cfg'=>['Type'=>'text'],
								'ename'=>['Type'=>'text'],
								'oldname'=>['Type'=>'text'],
								'view'=>['Type'=>'text'],
								'auth_con'=>['Type'=>'text'],	
								],							
						'required'=>['ename',]
				
				);
				};break;
		}
	}
	
}
