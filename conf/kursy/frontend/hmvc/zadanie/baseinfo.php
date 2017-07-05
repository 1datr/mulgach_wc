<?php
$settings = array(
	'table'=>'zadanie',
	'fields'=>array('id_zadaniya'=>array('Type'=>'bigint','TypeInfo'=>"20"),'id_urok'=>array('Type'=>'bigint','TypeInfo'=>"20"),'proverka'=>array('Type'=>'tinyint','TypeInfo'=>"1"),'tematika'=>array('Type'=>'text','TypeInfo'=>""),'title'=>array('Type'=>'text','TypeInfo'=>""),'zadanie_text'=>array('Type'=>'longtext','TypeInfo'=>"")),
	'primary'=>'id_zadaniya',
	'constraints'=>array('id_urok'=>array('model'=>'urok','fld'=>'id_urok','required'=>true),),	
	'required'=>array('id_zadaniya','id_urok','proverka','tematika','title','zadanie_text'),
	'rules'=>array(),	
	'view'=>'{tematika}',
	
);