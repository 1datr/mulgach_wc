<?php
$settings = array(
	'table'=>'primeneniye',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'id_predlogenie'=>array('Type'=>'bigint','TypeInfo'=>"20"),'id_lifearea'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id',
	'constraints'=>array('id_predlogenie'=>array('model'=>'predlogenie','fld'=>'id_predlogenie','required'=>true),'id_lifearea'=>array('model'=>'lifearea','fld'=>'id','required'=>true),),	
	'required'=>array('id','id_predlogenie','id_lifearea'),
	'rules'=>array(),	
	'view'=>'id',
	'file_fields'=>array(),
	
);