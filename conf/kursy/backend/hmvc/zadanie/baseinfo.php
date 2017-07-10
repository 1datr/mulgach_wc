<?php
$settings = array(
	'table'=>'zadanie',
	'fields'=>array('id_zadacha'=>array('Type'=>'bigint','TypeInfo'=>"20"),'id_urok'=>array('Type'=>'bigint','TypeInfo'=>"20"),'s_proverkoy'=>array('Type'=>'tinyint','TypeInfo'=>"1"),'tematika_zadaniya'=>array('Type'=>'text','TypeInfo'=>""),'title'=>array('Type'=>'text','TypeInfo'=>""),'task_text'=>array('Type'=>'longtext','TypeInfo'=>""),'type'=>array('Type'=>'enum','TypeInfo'=>"'zapolnenie','vybor','construct','repeat','vbey_listened','vbey_proove'")),
	'primary'=>'id_zadacha',
	'constraints'=>array('id_urok'=>array('model'=>'urok','fld'=>'id_urok','required'=>true),),	
	'required'=>array('id_zadacha','id_urok','s_proverkoy','type'),
	'rules'=>array(),	
	'view'=>'{tematika}',
	'file_fields'=>array(),
	
);