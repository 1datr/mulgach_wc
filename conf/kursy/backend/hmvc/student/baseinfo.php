<?php
$settings = array(
	'table'=>'student',
	'fields'=>array('id_uchenik'=>array('Type'=>'bigint','TypeInfo'=>"20"),'summ'=>array('Type'=>'bigint','TypeInfo'=>"20"),'login'=>array('Type'=>'text','TypeInfo'=>""),'passw'=>array('Type'=>'text','TypeInfo'=>""),'user_id'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id_uchenik',
	'constraints'=>array('user_id'=>array('model'=>'users','fld'=>'id','required'=>true),),	
	'required'=>array('id_uchenik','summ','login','passw','user_id'),
	'rules'=>array(),	
	'view'=>'{login}',
	
);