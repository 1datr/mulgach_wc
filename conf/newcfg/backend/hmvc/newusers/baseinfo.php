<?php
$settings = array(
	'table'=>'newusers',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'login'=>array('Type'=>'text','TypeInfo'=>""),'password'=>array('Type'=>'text','TypeInfo'=>""),'email'=>array('Type'=>'text','TypeInfo'=>""),'thehash'=>array('Type'=>'text','TypeInfo'=>"")),
	'primary'=>'id',
	'constraints'=>array(),	
	'required'=>array('id','login','password','email'),
	'rules'=>array(),	
	'view'=>'{login}',
	'file_fields'=>array(),
	'authdata'=>array(
		'type'=>'db',
		'src'=>'newusers',
		// fields
		'login_field'=>'login',
		'passw_field'=>'password',
		'hash_tag'=>'thehash',
		'email_field'=>'email',
	),
);