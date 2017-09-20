<?php
$settings = array(
	'table'=>'slog',
	'fields'=>array('id_slog'=>array('Type'=>'bigint','TypeInfo'=>"20"),'slog'=>array('Type'=>'text','TypeInfo'=>""),'transcription'=>array('Type'=>'text','TypeInfo'=>""),'sound'=>array('Type'=>'text','TypeInfo'=>""),'type'=>array('Type'=>'bigint','TypeInfo'=>"20"),'picture'=>array('Type'=>'text','TypeInfo'=>"")),
	'primary'=>'id_slog',
	'constraints'=>array(),	
	'required'=>array('id_slog','slog','type'),
	'rules'=>array(),	
	'view'=>'{slog}',
	'file_fields'=>array(),
	'authdata'=>array(
		'type'=>'db',
		'src'=>'slog',
		// fields
		'login_field'=>'',
		'passw_field'=>'',
		'hash_tag'=>'',
		'email_field'=>'',
	),
);