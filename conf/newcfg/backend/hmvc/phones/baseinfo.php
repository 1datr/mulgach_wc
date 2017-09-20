<?php
$settings = array(
	'table'=>'phones',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'user_id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'name'=>array('Type'=>'text','TypeInfo'=>""),'phone'=>array('Type'=>'text','TypeInfo'=>"")),
	'primary'=>'id',
	'constraints'=>array('user_id'=>array('model'=>'users','fld'=>'id','required'=>false),),	
	'required'=>array('id','user_id','name'),
	'rules'=>array(),	
	'view'=>'{name}',
	'file_fields'=>array(),
	
);