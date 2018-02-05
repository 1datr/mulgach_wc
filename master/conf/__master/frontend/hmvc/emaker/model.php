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
									'validate_proc'=>function($row,&$res,$prefix="")
										{
											//mul_dbg($row);
											if(isset($row['file']))
											{
												$type_class = $this->_ENV['page_module']->_CONTROLLER->_CONNECTION->GetTypeClass($row['type']);
												if(!in_array($type_class, ['text','binary']))
												{
													add_keypair($res,$prefix."[fldname]","#{Field with this type could not be a file}");
												}

											}
										},
									'fields'=>[
										'fldname'=>['Type'=>'text'],
										'type'=>['Type'=>'text'],
										'typeinfo'=>['Type'=>'text'],
										'primary'=>['Type'=>'boolean'],
										'required'=>['Type'=>'boolean'],
										'file_enabled'=>['Type'=>'boolean'],
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
