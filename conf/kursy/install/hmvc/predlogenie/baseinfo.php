<?php
$settings = array(
	'table'=>'predlogenie',
	'fields'=>array('id_predlogenie'=>array('Type'=>'bigint','TypeInfo'=>"20"),'ru'=>array('Type'=>'text','TypeInfo'=>""),'zvuk_ru'=>array('Type'=>'text','TypeInfo'=>""),'en'=>array('Type'=>'text','TypeInfo'=>""),'zvuk_en'=>array('Type'=>'text','TypeInfo'=>""),'transcription'=>array('Type'=>'text','TypeInfo'=>""),'sound'=>array('Type'=>'text','TypeInfo'=>""),'type'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id_predlogenie',
	'constraints'=>array(),	
	'required'=>array('id_predlogenie','ru','type'),
	'rules'=>array(),	
	'view'=>'{ru}',
	'file_fields'=>array('zvuk_ru'=>array('type'=>'audio/*'),'zvuk_en'=>array('type'=>'audio/*'),'sound'=>array('type'=>'audio/*'),),
	
);