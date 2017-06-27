<?php
$settings = array(
	'table'=>'forum',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'name'=>array('Type'=>'text','TypeInfo'=>""),'description'=>array('Type'=>'text','TypeInfo'=>""),'forum_id'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id',
	'constraints'=>array(),	
	'required'=>array('id','name','description'),
	'rules'=>array(),	
	'view'=>'{name}',
);