<?php
$settings = array(
	'table'=>'users',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'login'=>array('Type'=>'text','TypeInfo'=>""),'password'=>array('Type'=>'text','TypeInfo'=>""),'hash'=>array('Type'=>'text','TypeInfo'=>""),'email'=>array('Type'=>'text','TypeInfo'=>""),'phone'=>array('Type'=>'text','TypeInfo'=>""),'address'=>array('Type'=>'text','TypeInfo'=>""),'web'=>array('Type'=>'text','TypeInfo'=>""),'skype'=>array('Type'=>'text','TypeInfo'=>""),'first_name'=>array('Type'=>'text','TypeInfo'=>""),'last_name'=>array('Type'=>'text','TypeInfo'=>""),'status'=>array('Type'=>'enum','TypeInfo'=>"'student','prep'"),'sostoyanie_dopuska'=>array('Type'=>'enum','TypeInfo'=>"'new','check','permited'")),
	'primary'=>'id',
	'constraints'=>array(),	
	'required'=>array('id','login','password','hash','email','first_name','last_name','status','sostoyanie_dopuska'),
	'rules'=>array(),	
	'view'=>'{login}',
	'file_fields'=>array(),
	'authdata'=>array(
		'type'=>'db',
		'src'=>'users',
		// fields
		'login_field'=>'login',
		'passw_field'=>'password',
		'hash_tag'=>'hash',
		'email_field'=>'email',
	),
);