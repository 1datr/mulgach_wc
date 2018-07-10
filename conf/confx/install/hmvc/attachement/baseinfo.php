<?php
$settings = array(
	'table'=>'attachement',
	'fields'=>array('file_path'=>array('Type'=>'text','TypeInfo'=>""),'comment'=>array('Type'=>'text','TypeInfo'=>""),'message_id'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'',
	'constraints'=>array(),	
	'required'=>array('id','file_path','comment','message_id'),
	'rules'=>array(),	
	'view'=>'{name}',
	'file_fields'=>array(),
	
);