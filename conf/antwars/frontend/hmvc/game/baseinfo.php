<?php
$settings = array(
	'table'=>'game',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'owner_id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'creation_date'=>array('Type'=>'datetime','TypeInfo'=>""),'name'=>array('Type'=>'text','TypeInfo'=>""),'charact'=>array('Type'=>'mediumtext','TypeInfo'=>"")),
	'primary'=>'id',
	'constraints'=>array('owner_id'=>array('model'=>'users','fld'=>'id','required'=>false),),	
	'required'=>array('id'),
	'rules'=>array(),	
	'view'=>'{login}',
	'file_fields'=>array(),
	
);