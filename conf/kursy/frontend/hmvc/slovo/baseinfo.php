<?php
$settings = array(
	'table'=>'slovo',
	'fields'=>array('id_slovo'=>array('Type'=>'bigint','TypeInfo'=>"20"),'ru'=>array('Type'=>'text','TypeInfo'=>""),'zvuk_ru'=>array('Type'=>'text','TypeInfo'=>""),'en'=>array('Type'=>'text','TypeInfo'=>""),'risunok'=>array('Type'=>'blob','TypeInfo'=>""),'zvuk_en'=>array('Type'=>'text','TypeInfo'=>""),'transcription'=>array('Type'=>'text','TypeInfo'=>""),'type'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id_slovo',
	'constraints'=>array(),	
	'required'=>array('id_slovo','ru','zvuk_ru','en','risunok','zvuk_en','transcription','type'),
	'rules'=>array(),	
	'view'=>'{ru}',
	
);