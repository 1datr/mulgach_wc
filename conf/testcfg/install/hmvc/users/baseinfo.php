<?php
$settings = array(
	'table'=>'users',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'login'=>array('Type'=>'text','TypeInfo'=>""),'password'=>array('Type'=>'text','TypeInfo'=>""),'email'=>array('Type'=>'text','TypeInfo'=>""),'token'=>array('Type'=>'text','TypeInfo'=>""),'avatar'=>array('Type'=>'text','TypeInfo'=>""),'status'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id',
	'constraints'=>array(),	
	'required'=>array('id','login','password','email'),
	'rules'=>array(),	
	'view'=>'{login}',
	'file_fields'=>array(),
	'authdata'=>array(
		'type'=>'db',
		'src'=>'users',
		// fields
		'login_field'=>'login',
		'passw_field'=>'password',
		'hash_tag'=>'token',
		'email_field'=>'email',
	),
);