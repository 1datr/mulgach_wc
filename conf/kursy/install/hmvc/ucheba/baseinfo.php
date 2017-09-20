<?php
$settings = array(
	'table'=>'ucheba',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'id_uchenik'=>array('Type'=>'bigint','TypeInfo'=>"20"),'id_kurs'=>array('Type'=>'bigint','TypeInfo'=>"20"),'dostup'=>array('Type'=>'bigint','TypeInfo'=>"20"),'date_start'=>array('Type'=>'datetime','TypeInfo'=>""),'date_finish'=>array('Type'=>'datetime','TypeInfo'=>"")),
	'primary'=>'id',
	'constraints'=>array(),	
	'required'=>array('id','id_uchenik','id_kurs','dostup','date_start','date_finish'),
	'rules'=>array(),	
	'view'=>'#{id}',
	'file_fields'=>array(),
	'authdata'=>array(
		'type'=>'db',
		'src'=>'ucheba',
		// fields
		'login_field'=>'',
		'passw_field'=>'',
		'hash_tag'=>'',
		'email_field'=>'',
	),
);