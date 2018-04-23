<?php
$settings = array(
	'table'=>'articles',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'name'=>array('Type'=>'text','TypeInfo'=>""),'text'=>array('Type'=>'longtext','TypeInfo'=>""),'author'=>array('Type'=>'date','TypeInfo'=>"")),
	'primary'=>'id',
	'constraints'=>array('author'=>array('model'=>'','fld'=>'id','required'=>false),),	
	'required'=>array('id','name'),
	'rules'=>array(),	
	'view'=>'{name}',
	'file_fields'=>array(),
	
);