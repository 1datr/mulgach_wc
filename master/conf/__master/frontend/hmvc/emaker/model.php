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
					//	'table'=>'frm_makenew',
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
			case 'efield':{
				$this->_SETTINGS=array(
					//	'table'=>'frm_makenew',
						'domen'=>'entity',
						//	'name'=>'makenew',
						'fields'=>[
								'cfg'=>['Type'=>'text'],
								'ename'=>['Type'=>'text'],
								'fieldlist'=>new \ModelInfo([
									'domen'=>'field',
									'fields'=>[
										'fldname'=>['Type'=>'text'],
										'type'=>['Type'=>'text'],
										'primary'=>['Type'=>'boolean'],
										'required'=>['Type'=>'boolean'],
										'file'=>['Type'=>'boolean'],
										'filetype'=>['Type'=>'text','dependency'=>['fld'=>'file','type'=>'iftrue']],
									],
									'required'=>['fldname','type']
										
								])
						],
						'required'=>['ename',]
				
				);
				};break;
		}
	}
	
}
