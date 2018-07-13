<?php
$settings = array(
	'table'=>'attachement',
	'fields'=>array('path'=>array('Type'=>'text','TypeInfo'=>""),'comment'=>array('Type'=>'longtext','TypeInfo'=>""),'id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'message_id'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id',
	'constraints'=>array(),	
	'required'=>array('path','comment','id','message_id'),
	'rules'=>array(),	
	'view'=>'{name}',
	'file_fields'=>array(),
	
);