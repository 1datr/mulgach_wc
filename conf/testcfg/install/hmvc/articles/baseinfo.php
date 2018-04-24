<?php
$settings = array(
	'table'=>'articles',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'name'=>array('Type'=>'text','TypeInfo'=>""),'text'=>array('Type'=>'longtext','TypeInfo'=>""),'author'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id',
	'constraints'=>array('author'=>array('model'=>'','fld'=>'id','required'=>false),),	
	'required'=>array('id'),
	'rules'=>array(),	
	'view'=>'{name}',
	'file_fields'=>array(),
	
);