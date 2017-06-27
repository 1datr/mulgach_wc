<?php
$settings = array(
	'table'=>'forum',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'name'=>array('Type'=>'text','TypeInfo'=>""),'descr'=>array('Type'=>'text','TypeInfo'=>""),'forum_id'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id',
	'constraints'=>array('forum_id'=>array('model'=>'forum','fld'=>'id','required'=>true),),	
	'required'=>array('id','name','descr','forum_id'),
	'rules'=>array(),	
	'view'=>'{name}',
);