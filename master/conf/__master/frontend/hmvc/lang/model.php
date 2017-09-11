<?php
namespace __master\Frontend;

class ModelLang extends \BaseModel
{
	function rules()
	{
		/*
		switch ($this->_SCENARIO)
		{
		case 'default':
			return array(
				'table'=>'langform',
				'fields'=>array(
						'config'=>array('Type'=>'text'),
						'ep'=>array('Type'=>'text'),
						'lang'=>array('Type'=>'enum','Typeinfo'=>array(
							'values'=>function(){
								return Lang::get_langs();						
							},
						)),
						'langkey'=>array('Type'=>'text'),
						'translation'=>array('Type'=>'text')),	
				'required'=>array('config','ep','lang'),
			);
			break;
		}
		*/
		return array(
				'table'=>'langform',
				'domen'=>'lang',
				'fields'=>array(
						'config'=>array('Type'=>'text'),
						'ep'=>array('Type'=>'text'),
						'lang'=>array('Type'=>'enum','Typeinfo'=>array(
								'values'=>function(){
								return Lang::get_langs();
								},
								)),
						'langkey'=>array('Type'=>'text'),
						'translation'=>array('Type'=>'text')),
				'required'=>array('config','ep','lang'),
				);
	}
	//$this->getinfo('basemenu');
}