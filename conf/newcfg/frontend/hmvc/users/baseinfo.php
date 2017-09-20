<?php
$settings = array(
	'table'=>'users',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'login'=>array('Type'=>'text','TypeInfo'=>""),'password'=>array('Type'=>'text','TypeInfo'=>""),'hash'=>array('Type'=>'text','TypeInfo'=>""),'email'=>array('Type'=>'text','TypeInfo'=>""),'fio'=>array('Type'=>'text','TypeInfo'=>"")),
	'primary'=>'id',
	'constraints'=>array(),	
	'required'=>array('id'),
	'rules'=>array(),	
	'view'=>'{login}',
	'file_fields'=>array(),
	
);