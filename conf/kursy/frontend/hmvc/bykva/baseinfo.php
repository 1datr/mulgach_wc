<?php
$settings = array(
	'table'=>'bykva',
	'fields'=>array('id_bukva'=>array('Type'=>'bigint','TypeInfo'=>"20"),'bukva'=>array('Type'=>'text','TypeInfo'=>""),'transcription'=>array('Type'=>'text','TypeInfo'=>""),'sound'=>array('Type'=>'text','TypeInfo'=>""),'type'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id_bukva',
	'constraints'=>array(),	
	'required'=>array('id_bukva','bukva','type'),
	'rules'=>array(),	
	'view'=>'{bukva}',
	'file_fields'=>array(),
	'authdata'=>array(
		'type'=>'db',
		'src'=>'bykva',
		// fields
		'login_field'=>'',
		'passw_field'=>'',
		'hash_tag'=>'',
		'email_field'=>'',
	),
);