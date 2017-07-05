<?php
$settings = array(
	'table'=>'kursy',
	'fields'=>array('id_kurs'=>array('Type'=>'bigint','TypeInfo'=>"20"),'id_prep'=>array('Type'=>'bigint','TypeInfo'=>"20"),'name'=>array('Type'=>'text','TypeInfo'=>""),'full_text'=>array('Type'=>'longtext','TypeInfo'=>""),'small_text'=>array('Type'=>'text','TypeInfo'=>""),'web'=>array('Type'=>'text','TypeInfo'=>""),'sostoyanie_dopuska'=>array('Type'=>'enum','TypeInfo'=>"'new','check','available'")),
	'primary'=>'id_kurs',
	'constraints'=>array('id_prep'=>array('model'=>'preps','fld'=>'id_prep','required'=>true),),	
	'required'=>array('id_kurs','id_prep','name','full_text','small_text','web','sostoyanie_dopuska'),
	'rules'=>array(),	
	'view'=>'{name}',
	'file_fields'=>array(),
	
);