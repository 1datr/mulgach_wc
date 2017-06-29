<?php
$settings = array(
	'table'=>'forum',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'name'=>array('Type'=>'text','TypeInfo'=>""),'description'=>array('Type'=>'text','TypeInfo'=>""),'forum_id'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id',
	'constraints'=>array('forum_id'=>array('model'=>'forum','fld'=>'id','required'=>false),),	
	'required'=>array('id','name','description'),
	'rules'=>array(),	
	'view'=>'{name}',
	
);