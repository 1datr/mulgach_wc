<?php
$settings = array(
	'table'=>'lifearea',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'title_ru'=>array('Type'=>'text','TypeInfo'=>""),'title_eng'=>array('Type'=>'text','TypeInfo'=>"")),
	'primary'=>'id',
	'constraints'=>array(),	
	'required'=>array('id','title_ru'),
	'rules'=>array(),	
	'view'=>'{title_ru}',
	'file_fields'=>array(),
	'authdata'=>array(
		'type'=>'db',
		'src'=>'lifearea',
		// fields
		'login_field'=>'',
		'passw_field'=>'',
		'hash_tag'=>'',
		'email_field'=>'',
	),
);