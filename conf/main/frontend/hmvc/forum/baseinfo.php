<?php
$settings = array(
	'table'=>'forum',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'name'=>array('Type'=>'text','TypeInfo'=>""),'description'=>array('Type'=>'text','TypeInfo'=>""),'forum_id'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id',
	'constraints'=>array('id'=>array('model'=>'forum','fld'=>'id'),),	
	'rules'=>array(),	
	'view'=>'{name}',
);