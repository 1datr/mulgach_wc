<?php
$settings = array(
	'table'=>'ucheba',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'id_uchenik'=>array('Type'=>'bigint','TypeInfo'=>"20"),'id_kurs'=>array('Type'=>'bigint','TypeInfo'=>"20"),'dostup'=>array('Type'=>'bigint','TypeInfo'=>"20"),'date_start'=>array('Type'=>'datetime','TypeInfo'=>""),'date_finish'=>array('Type'=>'datetime','TypeInfo'=>"")),
	'primary'=>'id',
	'constraints'=>array('id_uchenik'=>array('model'=>'student','fld'=>'id_uchenik','required'=>true),'id_kurs'=>array('model'=>'kursy','fld'=>'id_kurs','required'=>true),),	
	'required'=>array('id','id_uchenik','id_kurs','dostup','date_start','date_finish'),
	'rules'=>array(),	
	'view'=>'id',
	'file_fields'=>array(),
	
);