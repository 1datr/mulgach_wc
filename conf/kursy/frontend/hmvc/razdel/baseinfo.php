<?php
$settings = array(
	'table'=>'razdel',
	'fields'=>array('id_razdel'=>array('Type'=>'bigint','TypeInfo'=>"20"),'id_kurs'=>array('Type'=>'bigint','TypeInfo'=>"20"),'number'=>array('Type'=>'bigint','TypeInfo'=>"20"),'name'=>array('Type'=>'text','TypeInfo'=>"")),
	'primary'=>'id_razdel',
	'constraints'=>array('id_kurs'=>array('model'=>'kursy','fld'=>'id_kurs','required'=>true),),	
	'required'=>array('id_razdel','id_kurs','number','name'),
	'rules'=>array(),	
	'view'=>'{name}',
	
);