<?php
$settings = array(
	'table'=>'lifearea',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'title_ru'=>array('Type'=>'text','TypeInfo'=>""),'title_eng'=>array('Type'=>'text','TypeInfo'=>"")),
	'primary'=>'id',
	'constraints'=>array(),	
	'required'=>array('id'),
	'rules'=>array(),	
	'view'=>'{title_ru}',
	'file_fields'=>array(),
	
);