<?php
class ModelLang extends BaseModel
{
	function rules()
	{
		return array(
			'table'=>'langform',
			'fields'=>array('lang'=>array('Type'=>'enum','Typeinfo'=>array(
						'values'=>function(){
							return Lang::get_langs();						
						},
					)),'langkey'=>array('Type'=>'text'),'translation'=>array('Type'=>'text')),	
				
		);
	}
	//$this->getinfo('basemenu');
}