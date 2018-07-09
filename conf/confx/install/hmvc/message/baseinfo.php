<?php
$settings = array(
	'table'=>'message',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'from'=>array('Type'=>'bigint','TypeInfo'=>"20"),'to'=>array('Type'=>'bigint','TypeInfo'=>"20"),'when'=>array('Type'=>'datetime','TypeInfo'=>"")),
	'primary'=>'id',
	'constraints'=>array('from'=>array('model'=>'users','fld'=>'id','required'=>false),'to'=>array('model'=>'users','fld'=>'id','required'=>false),),	
	'required'=>array('id'),
	'rules'=>array(),	
	'view'=>'{login}',
	'file_fields'=>array(),
	
);