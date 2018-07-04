<?php
$settings = array(
	'table'=>'ant',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'race'=>array('Type'=>'bigint','TypeInfo'=>"20"),'number'=>array('Type'=>'bigint','TypeInfo'=>"20"),'owner_id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'game_id'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id',
	'constraints'=>array('race'=>array('model'=>'ant_race','fld'=>'id','required'=>false),'owner_id'=>array('model'=>'users','fld'=>'id','required'=>false),'game_id'=>array('model'=>'game','fld'=>'id','required'=>false),),	
	'required'=>array('id'),
	'rules'=>array(),	
	'view'=>'{login}',
	'file_fields'=>array(),
	
);