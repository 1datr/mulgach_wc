<?php
$settings = array(
	'table'=>'primeneniye',
	'fields'=>array('id'=>array('Type'=>'bigint','TypeInfo'=>"20"),'id_predlogenie'=>array('Type'=>'bigint','TypeInfo'=>"20"),'id_lifearea'=>array('Type'=>'bigint','TypeInfo'=>"20")),
	'primary'=>'id',
	'constraints'=>array(),	
	'required'=>array('id','id_predlogenie','id_lifearea'),
	'rules'=>array(),	
	'view'=>'#{id}',
	'file_fields'=>array(),
	
);