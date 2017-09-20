<?php
$settings = array(
	'table'=>'znak',
	'fields'=>array('id_znak'=>array('Type'=>'bigint','TypeInfo'=>"20"),'znak'=>array('Type'=>'text','TypeInfo'=>""),'transcription'=>array('Type'=>'text','TypeInfo'=>""),'sound'=>array('Type'=>'text','TypeInfo'=>""),'type'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id_znak',
	'constraints'=>array(),	
	'required'=>array('id_znak','znak','type'),
	'rules'=>array(),	
	'view'=>'{znak}',
	'file_fields'=>array(),
	'authdata'=>array(
		'type'=>'db',
		'src'=>'znak',
		// fields
		'login_field'=>'',
		'passw_field'=>'',
		'hash_tag'=>'',
		'email_field'=>'',
	),
);