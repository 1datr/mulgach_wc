<?php
$settings = array(
	'table'=>'attachement',
	'fields'=>array('path'=>array('Type'=>'text','TypeInfo'=>""),'comment'=>array('Type'=>'longtext','TypeInfo'=>""),'message_id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'id'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id',
	'constraints'=>array(),	
	'required'=>array('path','comment','message_id','id'),
	'rules'=>array(),	
	'view'=>'{name}',
	'file_fields'=>array(),
	
);