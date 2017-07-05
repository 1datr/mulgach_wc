<?php
$settings = array(
	'table'=>'slog',
	'fields'=>array('id_slog'=>array('Type'=>'bigint','TypeInfo'=>"20"),'slog'=>array('Type'=>'text','TypeInfo'=>""),'transcription'=>array('Type'=>'text','TypeInfo'=>""),'sound'=>array('Type'=>'text','TypeInfo'=>""),'type'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id_slog',
	'constraints'=>array(),	
	'required'=>array('id_slog','slog','transcription','sound','type'),
	'rules'=>array(),	
	'view'=>'{slog}',
	'file_fields'=>array('sound'=>array(),),
	
);