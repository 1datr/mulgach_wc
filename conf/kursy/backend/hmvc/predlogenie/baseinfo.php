<?php
$settings = array(
	'table'=>'predlogenie',
	'fields'=>array('id_predlogenie'=>array('Type'=>'bigint','TypeInfo'=>"20"),'ru'=>array('Type'=>'text','TypeInfo'=>""),'zvuk_ru'=>array('Type'=>'text','TypeInfo'=>""),'en'=>array('Type'=>'text','TypeInfo'=>""),'zvuk_en'=>array('Type'=>'text','TypeInfo'=>""),'transcription'=>array('Type'=>'text','TypeInfo'=>""),'sound'=>array('Type'=>'text','TypeInfo'=>""),'type'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'',
	'constraints'=>array(),	
	'required'=>array('id_predlogenie','ru','zvuk_ru','en','zvuk_en','transcription','sound','type'),
	'rules'=>array(),	
	'view'=>'{ru}',
	
);