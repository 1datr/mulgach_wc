<?php
$settings = array(
	'table'=>'message',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'topic'=>array('Type'=>'text','TypeInfo'=>""),'message'=>array('Type'=>'longtext','TypeInfo'=>""),'user_from'=>array('Type'=>'bigint','TypeInfo'=>"20"),'user_to'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id',
	'constraints'=>array('user_from'=>array('model'=>'users','fld'=>'id','required'=>false),'user_to'=>array('model'=>'users','fld'=>'id','required'=>false),),	
	'required'=>array('id'),
	'rules'=>array(),	
	'view'=>'{topic}',
	'file_fields'=>array(),
	
);